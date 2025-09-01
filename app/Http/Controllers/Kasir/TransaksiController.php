<?php

namespace App\Http\Controllers\Kasir;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Produk;
use App\Models\Transaksi;
use App\Models\DetailTransaksi;

class TransaksiController extends Controller
{
    public function index()
    {
        // Menampilkan daftar transaksi kasir (bisa digabung riwayat)
        $transaksis = Transaksi::latest()->paginate(10);
        return view('kasir.transaksi.index', compact('transaksis'));
    }

    public function create(Request $request)
    {
        $produk_id = $request->input('produk_id');
        $produk = null;

        if ($produk_id) {
            $produk = Produk::find($produk_id);
        }

        // Ambil semua produk untuk dropdown
        $produks = Produk::all();

        return view('kasir.transaksi.create', compact('produk', 'produks'));
    }

    public function show($id)
    {
        $transaksi = Transaksi::with('detailTransaksi.produk')->findOrFail($id);
        return view('kasir.transaksi.show', compact('transaksi'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'produk_id' => 'required|array',
            'jumlah'    => 'required|array',
            'bayar'     => 'required|numeric',
        ]);

        // Hitung total harga
        $total = 0;
        foreach ($request->produk_id as $index => $id) {
            $produk = Produk::findOrFail($id);
            $jumlah = $request->jumlah[$index];
            $total += $produk->harga_jual * $jumlah;
        }

        // Simpan transaksi
        $transaksi = Transaksi::create([
            'kode_transaksi' => 'TRK' . time(),
            'total_bayar'    => $total,
            'bayar'          => $request->bayar,
            'kembalian'      => $request->bayar - $total,
            'kasir_id'       => auth()->id(), // simpan siapa kasir yang input
        ]);

        // Simpan detail transaksi
        foreach ($request->produk_id as $index => $id) {
            $produk = Produk::findOrFail($id);

            DetailTransaksi::create([
                'transaksi_id' => $transaksi->id,
                'produk_id'    => $id,
                'jumlah'       => $request->jumlah[$index],
                'harga'        => $produk->harga_jual,
            ]);

            // Update stok
            $produk->decrement('stok', $request->jumlah[$index]);
        }

        return redirect()->route('kasir.struk', $transaksi->id);
    }

    public function riwayat()
    {
        $transaksis = Transaksi::where('kasir_id', auth()->id())->latest()->paginate(10);
        return view('kasir.transaksi.riwayat', compact('transaksis'));
    }

    public function struk($id)
    {
        $transaksi = Transaksi::with('detailTransaksi.produk')->findOrFail($id);
        return view('kasir.transaksi.struk', compact('transaksi'));
    }

    public function addToCart(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:produks,id',
            'quantity' => 'required|integer|min:1'
        ]);

        $product = Produk::findOrFail($request->product_id);

        // Cek stok
        if ($product->stok < $request->quantity) {
            return redirect()->back()->with('error', 'Stok tidak mencukupi!');
        }

        // Ambil cart dari session
        $cart = session()->get('cart', []);

        // Jika produk sudah ada di cart, update quantity
        if (isset($cart[$request->product_id])) {
            $cart[$request->product_id]['quantity'] += $request->quantity;
            $cart[$request->product_id]['subtotal'] = $cart[$request->product_id]['quantity'] * $cart[$request->product_id]['harga'];
        } else {
            // Tambah produk baru ke cart
            $cart[$request->product_id] = [
                'id' => $product->id,
                'nama' => $product->nama,
                'harga' => $product->harga,
                'quantity' => $request->quantity,
                'subtotal' => $product->harga * $request->quantity
            ];
        }

        // Simpan cart ke session
        session()->put('cart', $cart);

        return redirect()->back()->with('success', 'Produk berhasil ditambahkan ke keranjang!');
    }

    public function removeFromCart($id)
    {
        $cart = session()->get('cart', []);

        if (isset($cart[$id])) {
            unset($cart[$id]);
            session()->put('cart', $cart);
        }

        return redirect()->back()->with('success', 'Produk berhasil dihapus dari keranjang!');
    }

    public function checkout(Request $request)
    {
        $cart = session()->get('cart', []);

        if (empty($cart)) {
            return redirect()->back()->with('error', 'Keranjang belanja kosong!');
        }

        $request->validate([
            'bayar' => 'required|numeric'
        ]);

        // Hitung total
        $total = 0;
        foreach ($cart as $item) {
            $total += $item['subtotal'];
        }

        // Cek apakah pembayaran cukup
        if ($request->bayar < $total) {
            return redirect()->back()->with('error', 'Pembayaran tidak mencukupi!');
        }

        // Simpan transaksi
        $transaksi = Transaksi::create([
            'kode_transaksi' => 'TRK' . time(),
            'total_bayar' => $total,
            'bayar' => $request->bayar,
            'kembalian' => $request->bayar - $total,
            'kasir_id' => auth()->id()
        ]);

        // Simpan detail transaksi dan update stok
        foreach ($cart as $item) {
            DetailTransaksi::create([
                'transaksi_id' => $transaksi->id,
                'produk_id' => $item['id'],
                'jumlah' => $item['quantity'],
                'harga' => $item['harga']
            ]);

            // Update stok
            $product = Produk::find($item['id']);
            $product->decrement('stok', $item['quantity']);
        }

        // Kosongkan cart
        session()->forget('cart');

        return redirect()->route('kasir.riwayat')->with('success', 'Transaksi berhasil diselesaikan!');
    }
}

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
}

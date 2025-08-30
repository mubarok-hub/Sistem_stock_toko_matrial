<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Produk;
use App\Models\Transaksi;
use App\Models\DetailTransaksi;


class KasirController extends Controller
{
    public function index()
    {
        $produks = Produk::all();
        return view('kasir.index', compact('produks'));
    }
    
    public function riwayat()
    {
        $transaksis = Transaksi::latest()->paginate(10); // atau where kasir_id kalau pakai login
        return view('kasir.riwayat', compact('transaksis'));
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
            'jumlah' => 'required|array',
            'bayar' => 'required|numeric',
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
            'total_bayar' => $total,
            'bayar' => $request->bayar,
            'kembalian' => $request->bayar - $total,
        ]);

        // Simpan detail transaksi
        foreach ($request->produk_id as $index => $id) {
            DetailTransaksi::create([
                'transaksi_id' => $transaksi->id,
                'produk_id' => $id,
                'jumlah' => $request->jumlah[$index],
                'harga' => Produk::findOrFail($id)->harga_jual,
            ]);
        }

        return redirect()->route('kasir.struk', $transaksi->id);

    }

}

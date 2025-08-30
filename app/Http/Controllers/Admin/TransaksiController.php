<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Transaksi;

class TransaksiController extends Controller
{
    public function index()
    {
        $transaksis = Transaksi::latest()->paginate(15);
        return view('admin.kasir.index', compact('transaksis'));
    }

    public function show($id)
    {
        $transaksi = Transaksi::with('detailTransaksi.produk')->findOrFail($id);
        return view('admin.kasir.show', compact('transaksi'));
    }

    public function destroy($id)
    {
        $transaksi = Transaksi::findOrFail($id);
        $transaksi->delete();

        return redirect()->route('admin.kasir.index')->with('success', 'Transaksi berhasil dihapus');
    }
}

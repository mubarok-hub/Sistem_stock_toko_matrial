<?php

namespace App\Http\Controllers;

use App\Models\Produk;
use App\Models\Transaksi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    /**
     * Menampilkan dashboard utama
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // Menghitung total produk
        $totalProduk = Produk::count();

        // Menghitung total stok semua produk
        $totalStok = Produk::sum('stok');

        // Menghitung total transaksi hari ini
        $totalTransaksiHariIni = Transaksi::whereDate('created_at', now()->format('Y-m-d'))->count();

        // Menghitung total pendapatan hari ini
        $totalPendapatanHariIni = Transaksi::whereDate('created_at', now()->format('Y-m-d'))->sum('total_bayar');

        // Mendapatkan produk dengan stok terbatas (kurang dari 10)
        $produkStokTerbatas = Produk::where('stok', '<', 10)->orderBy('stok', 'asc')->take(5)->get();

        // Mendapatkan transaksi terbaru
        $transaksiTerbaru = Transaksi::with('detailTransaksi.produk')->latest()->take(5)->get();

        // Mendapatkan produk terlaris
        $produkTerlaris = DB::table('transaksi_details')
            ->select('produk_id', DB::raw('SUM(jumlah) as total_terjual'))
            ->groupBy('produk_id')
            ->orderBy('total_terjual', 'desc')
            ->take(5)
            ->get()
            ->map(function ($item) {
                $produk = Produk::find($item->produk_id);
                return [
                    'nama_produk' => $produk ? $produk->nama_produk : 'Produk tidak ditemukan',
                    'total_terjual' => $item->total_terjual
                ];
            });

        return view('dashboard', compact(
            'totalProduk',
            'totalStok',
            'totalTransaksiHariIni',
            'totalPendapatanHariIni',
            'produkStokTerbatas',
            'transaksiTerbaru',
            'produkTerlaris'
        ));
    }
}

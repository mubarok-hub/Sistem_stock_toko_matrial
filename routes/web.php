<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\ProdukController;
use App\Http\Controllers\Admin\AdminTransaksiController;
use App\Http\Controllers\Kasir\ProdukController as KasirProdukController;
use App\Http\Controllers\Kasir\TransaksiController as KasirTransaksiController;

// Redirect root ke login
Route::get('/', function () {
    return redirect('/login');
});

// ==================== ADMIN ====================
Route::prefix('admin')->middleware(['auth', 'isAdmin'])->name('admin.')->group(function () {
    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    // Route::resource('/admin/produk', App\Http\Controllers\Admin\ProdukController::class);s
    // Produk (CRUD)
    Route::resource('produk', ProdukController::class);

    // Transaksi / Kasir untuk admin (lihat & hapus transaksi)
    Route::resource('transaksi', AdminTransaksiController::class)->only(['index', 'show', 'destroy']);
});

// ==================== KASIR ====================
Route::prefix('kasir')->middleware(['auth', 'isKasir'])->name('kasir.')->group(function () {
    // Produk (kasir bisa lihat daftar produk, tambah ke transaksi)
    Route::resource('produk', KasirProdukController::class);

    // Transaksi (buat transaksi, lihat detail, riwayat, cetak struk)
    Route::resource('transaksi', KasirTransaksiController::class)->only(['index', 'store', 'show']);
    Route::get('riwayat', [KasirTransaksiController::class, 'riwayat'])->name('riwayat');
    Route::get('struk/{id}', [KasirTransaksiController::class, 'struk'])->name('struk');
});

require __DIR__.'/auth.php';

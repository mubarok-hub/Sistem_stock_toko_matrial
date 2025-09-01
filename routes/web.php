<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\ProdukController;
use App\Http\Controllers\Admin\TransaksiController;
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
    Route::resource('transaksi', TransaksiController::class)->only(['index', 'show', 'destroy']);

});

// ==================== KASIR ====================
Route::prefix('kasir')->middleware(['auth', 'isKasir'])->name('kasir.')->group(function () {
    // Produk (kasir bisa lihat daftar produk, tambah ke transaksi)
    Route::resource('produk', KasirProdukController::class);

    // Transaksi (buat transaksi, lihat detail, riwayat, cetak struk)
    Route::resource('transaksi', KasirTransaksiController::class)->only(['index', 'create', 'store', 'show']);
    Route::get('riwayat', [KasirTransaksiController::class, 'riwayat'])->name('riwayat');
    Route::get('struk/{id}', [KasirTransaksiController::class, 'struk'])->name('struk');
    Route::post('transaksi/add-to-cart', [KasirTransaksiController::class, 'addToCart'])->name('transaksi.addToCart');
    Route::get('transaksi/remove-from-cart/{id}', [KasirTransaksiController::class, 'removeFromCart'])->name('transaksi.removeFromCart');
    Route::post('transaksi/checkout', [KasirTransaksiController::class, 'checkout'])->name('transaksi.checkout');
});

require __DIR__.'/auth.php';

<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\ProdukController;
use App\Http\Controllers\Admin\KasirController;

// Redirect root ke login
Route::get('/', function () {
    return redirect('/login');
});

// Group route khusus admin
Route::prefix('admin')->middleware(['auth', 'is_admin'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('admin.dashboard');

    // Produk
    Route::resource('/produk', ProdukController::class);
    Route::get('/produk/create', [ProdukController::class, 'create'])->name('admin.produk.create');
    Route::get('/produk/{id}/edit', [ProdukController::class, 'edit'])->name('admin.produk.edit');

    // Kasir
    Route::resource('/kasir', KasirController::class);
});


require __DIR__.'/auth.php';
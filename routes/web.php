<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProdukController;
use App\Http\Controllers\KasirController;

Route::resource('produk', ProdukController::class);

Route::get('/kasir', [KasirController::class, 'index'])->name('kasir.index');
Route::post('/kasir', [KasirController::class, 'store'])->name('kasir.store');
Route::get('/kasir/riwayat', [KasirController::class, 'riwayat'])->name('kasir.riwayat');
Route::get('/kasir/struk/{id}', [KasirController::class, 'struk'])->name('kasir.struk');

Route::get('/', function () {
    return view('welcome');
});

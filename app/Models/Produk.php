<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Produk extends Model
{
    protected $fillable = [
    'nama_produk',
    'kode_produk',
    'kategori',
    'satuan',
    'stok',
    'harga_beli',
    'harga_jual',
];
}

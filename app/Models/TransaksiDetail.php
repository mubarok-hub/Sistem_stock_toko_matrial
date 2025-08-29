<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class TransaksiDetail extends Model
{
    use HasFactory;

    protected $fillable = [
        'transaksi_id',
        'produk_id',
        'jumlah',
        'harga_satuan',
        'subtotal',
    ];

    public function transaksi()
    {
        return $this->belongsTo(Transaksi::class, 'transaksi_id');
    }

    public function produk()
    {
        return $this->belongsTo(Produk::class, 'produk_id');
    }
}

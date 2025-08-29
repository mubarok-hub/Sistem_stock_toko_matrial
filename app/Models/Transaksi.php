<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Transaksi extends Model
{
    use HasFactory;

    protected $fillable = [
        'kode_transaksi',
        'tanggal',
        'total_harga',
        'total_bayar',
        'bayar',
        'kembalian',
    ];

    protected $casts = [
        'tanggal' => 'datetime',
    ];

    public function detailTransaksi()
    {
        return $this->hasMany(TransaksiDetail::class, 'transaksi_id');
    }
}

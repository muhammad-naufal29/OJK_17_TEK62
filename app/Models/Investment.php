<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Investment extends Model
{
    protected $fillable = [
        'nama_produk',
        'jenis_reksa_dana',
        'manajer_investasi',
        'tanggal_pembelian',
        'jumlah_unit',
        'harga_per_unit',
        'total_investasi',
    ];

    protected function casts(): array
    {
        return [
            'tanggal_pembelian' => 'date',
            'jumlah_unit' => 'decimal:4',
            'harga_per_unit' => 'decimal:2',
            'total_investasi' => 'decimal:2',
        ];
    }
}

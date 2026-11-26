<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Investment extends Model
{
    protected $fillable = [
        'user_id',
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
            'jumlah_unit' => 'decimal:2',
            'harga_per_unit' => 'decimal:2',
            'total_investasi' => 'decimal:2',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}

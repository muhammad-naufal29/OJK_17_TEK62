<?php

namespace Database\Seeders;

use App\Models\Investment;
use Illuminate\Database\Seeder;

class InvestmentSeeder extends Seeder
{
    public function run(): void
    {
        $data = [
            [
                'nama_produk'       => 'Sucorinvest Money Market Fund',
                'jenis_reksa_dana'  => 'Pasar Uang',
                'manajer_investasi' => 'PT Sucorinvest Asset Management',
                'tanggal_pembelian' => '2026-01-15',
                'jumlah_unit'       => 1500.5000,
                'harga_per_unit'    => 1850,
            ],
            [
                'nama_produk'       => 'BRI Seruni Pasar Uang II',
                'jenis_reksa_dana'  => 'Pasar Uang',
                'manajer_investasi' => 'PT BRI Manajemen Investasi',
                'tanggal_pembelian' => '2026-02-10',
                'jumlah_unit'       => 2000.0000,
                'harga_per_unit'    => 1620,
            ],
            [
                'nama_produk'       => 'Eastspring IDR Fixed Income Fund',
                'jenis_reksa_dana'  => 'Pendapatan Tetap',
                'manajer_investasi' => 'PT Eastspring Investments Indonesia',
                'tanggal_pembelian' => '2026-04-12',
                'jumlah_unit'       => 850.0000,
                'harga_per_unit'    => 2450,
            ],
            [
                'nama_produk'       => 'Manulife Obligasi Unggulan',
                'jenis_reksa_dana'  => 'Pendapatan Tetap',
                'manajer_investasi' => 'PT Manulife Aset Manajemen Indonesia',
                'tanggal_pembelian' => '2026-05-18',
                'jumlah_unit'       => 1100.7500,
                'harga_per_unit'    => 2890,
            ],
            [
                'nama_produk'       => 'Sucorinvest Equity Fund',
                'jenis_reksa_dana'  => 'Saham',
                'manajer_investasi' => 'PT Sucorinvest Asset Management',
                'tanggal_pembelian' => '2026-07-08',
                'jumlah_unit'       => 750.5000,
                'harga_per_unit'    => 2680,
            ],
            [
                'nama_produk'       => 'BNP Paribas Pesona',
                'jenis_reksa_dana'  => 'Saham',
                'manajer_investasi' => 'PT BNP Paribas Asset Management',
                'tanggal_pembelian' => '2026-08-14',
                'jumlah_unit'       => 420.0000,
                'harga_per_unit'    => 31200,
            ],
            [
                'nama_produk'       => 'Schroder Dana Kombinasi',
                'jenis_reksa_dana'  => 'Campuran',
                'manajer_investasi' => 'PT Schroder Investment Management Indonesia',
                'tanggal_pembelian' => '2026-10-11',
                'jumlah_unit'       => 950.0000,
                'harga_per_unit'    => 4320,
            ],
            [
                'nama_produk'       => 'Panin Dana Maksima',
                'jenis_reksa_dana'  => 'Campuran',
                'manajer_investasi' => 'PT Panin Asset Management',
                'tanggal_pembelian' => '2026-11-02',
                'jumlah_unit'       => 250.0000,
                'harga_per_unit'    => 74500,
            ],
        ];

        foreach ($data as $item) {
            $item['total_investasi'] = $item['jumlah_unit'] * $item['harga_per_unit'];
            Investment::create($item);
        }
    }
}
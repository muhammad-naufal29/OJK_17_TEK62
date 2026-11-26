<?php

namespace Database\Seeders;

use App\Models\Investment;
use App\Models\User;
use Illuminate\Database\Seeder;

class InvestmentSeeder extends Seeder
{
    public function run(): void
    {
        // Semua data demo dimiliki admin
        $admin = User::where('email', 'admin@ojk17.test')->first();

        if (!$admin) {
            return;
        }

        // 8 data asli tetap dipertahankan
        $baseData = [
            [
                'nama_produk'       => 'Sucorinvest Money Market Fund',
                'jenis_reksa_dana'  => 'Pasar Uang',
                'manajer_investasi' => 'PT Sucorinvest Asset Management',
                'tanggal_pembelian' => '2026-01-15',
                'jumlah_unit'       => 1500.50,
                'harga_per_unit'    => 1850,
            ],
            [
                'nama_produk'       => 'BRI Seruni Pasar Uang II',
                'jenis_reksa_dana'  => 'Pasar Uang',
                'manajer_investasi' => 'PT BRI Manajemen Investasi',
                'tanggal_pembelian' => '2026-02-10',
                'jumlah_unit'       => 2000.00,
                'harga_per_unit'    => 1620,
            ],
            [
                'nama_produk'       => 'Eastspring IDR Fixed Income Fund',
                'jenis_reksa_dana'  => 'Pendapatan Tetap',
                'manajer_investasi' => 'PT Eastspring Investments Indonesia',
                'tanggal_pembelian' => '2026-04-12',
                'jumlah_unit'       => 850.00,
                'harga_per_unit'    => 2450,
            ],
            [
                'nama_produk'       => 'Manulife Obligasi Unggulan',
                'jenis_reksa_dana'  => 'Pendapatan Tetap',
                'manajer_investasi' => 'PT Manulife Aset Manajemen Indonesia',
                'tanggal_pembelian' => '2026-05-18',
                'jumlah_unit'       => 1100.75,
                'harga_per_unit'    => 2890,
            ],
            [
                'nama_produk'       => 'Sucorinvest Equity Fund',
                'jenis_reksa_dana'  => 'Saham',
                'manajer_investasi' => 'PT Sucorinvest Asset Management',
                'tanggal_pembelian' => '2026-07-08',
                'jumlah_unit'       => 750.50,
                'harga_per_unit'    => 2680,
            ],
            [
                'nama_produk'       => 'BNP Paribas Pesona',
                'jenis_reksa_dana'  => 'Saham',
                'manajer_investasi' => 'PT BNP Paribas Asset Management',
                'tanggal_pembelian' => '2026-08-14',
                'jumlah_unit'       => 420.00,
                'harga_per_unit'    => 31200,
            ],
            [
                'nama_produk'       => 'Schroder Dana Kombinasi',
                'jenis_reksa_dana'  => 'Campuran',
                'manajer_investasi' => 'PT Schroder Investment Management Indonesia',
                'tanggal_pembelian' => '2026-10-11',
                'jumlah_unit'       => 950.00,
                'harga_per_unit'    => 4320,
            ],
            [
                'nama_produk'       => 'Panin Dana Maksima',
                'jenis_reksa_dana'  => 'Campuran',
                'manajer_investasi' => 'PT Panin Asset Management',
                'tanggal_pembelian' => '2026-11-02',
                'jumlah_unit'       => 250.00,
                'harga_per_unit'    => 74500,
            ],
        ];

        foreach ($baseData as $item) {
            $item['user_id'] = $admin->id;
            $item['total_investasi'] = $item['jumlah_unit'] * $item['harga_per_unit'];
            Investment::create($item);
        }

        // Generate 62 data dummy tambahan agar total 70
        $jenisList = ['Pasar Uang', 'Pendapatan Tetap', 'Saham', 'Campuran'];

        $manajerList = [
            'PT Sucorinvest Asset Management',
            'PT BRI Manajemen Investasi',
            'PT Eastspring Investments Indonesia',
            'PT Manulife Aset Manajemen Indonesia',
            'PT BNP Paribas Asset Management',
            'PT Schroder Investment Management Indonesia',
            'PT Panin Asset Management',
            'PT Bahana TCW Investment Management',
            'PT Mandiri Investasi',
            'PT CIMB-Principal Asset Management',
            'PT Trimegah Asset Management',
            'PT Reliance Asset Management',
        ];

        $namaAwalan = [
            'Sucorinvest', 'BRI', 'Eastspring', 'Manulife', 'BNP Paribas',
            'Schroder', 'Panin', 'Bahana', 'Mandiri', 'CIMB-Principal',
            'Trimegah', 'Reliance', 'Danareksa', 'Sinarmas', 'AVR',
        ];

        $namaAkhiran = [
            'Money Market Fund', 'Fixed Income Fund', 'Equity Fund',
            'Dana Kombinasi', 'Dana Maksima', 'Obligasi Unggulan',
            'Pasar Uang', 'Saham Unggulan', 'Dana Campuran',
            'Syarariah Equity', 'Dana Likuid', 'Dana Berimbang',
            'Dana Stabil', 'Dana Dinamis', 'Dana Prima',
        ];

        for ($i = 1; $i <= 62; $i++) {
            $jenis = $jenisList[array_rand($jenisList)];
            $manajer = $manajerList[array_rand($manajerList)];
            $nama = $namaAwalan[array_rand($namaAwalan)] . ' ' . $namaAkhiran[array_rand($namaAkhiran)] . ' ' . $i;

            // Tanggal acak sepanjang tahun 2026
            $tanggal = '2026-' . str_pad(rand(1, 12), 2, '0', STR_PAD_LEFT) . '-' . str_pad(rand(1, 28), 2, '0', STR_PAD_LEFT);

            // Jumlah unit & harga acak sesuai jenis
            $jumlahUnit = round(rand(100, 5000) + (mt_rand() / mt_getrandmax()), 2);
            $hargaPerUnit = match ($jenis) {
                'Pasar Uang'       => rand(1000, 2500),
                'Pendapatan Tetap' => rand(2000, 5000),
                'Saham'            => rand(2500, 35000),
                'Campuran'         => rand(3000, 75000),
            };

            $total = $jumlahUnit * $hargaPerUnit;

            Investment::create([
                'user_id'           => $admin->id,
                'nama_produk'       => $nama,
                'jenis_reksa_dana'  => $jenis,
                'manajer_investasi' => $manajer,
                'tanggal_pembelian' => $tanggal,
                'jumlah_unit'       => $jumlahUnit,
                'harga_per_unit'    => $hargaPerUnit,
                'total_investasi'   => $total,
            ]);
        }
    }
}

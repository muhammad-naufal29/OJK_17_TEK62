<?php

namespace App\Http\Controllers;

use App\Models\Investment;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        // Mengambil data investasi milik user yang login
        $investments = Investment::where('user_id', Auth::id())
            ->orderBy('tanggal_pembelian')
            ->get();

        // ==================================
        // STATISTIK DASHBOARD
        // ==================================

        // 1. Total seluruh nilai investasi
        $totalInvestasi = $investments->sum('total_investasi');

        // 2. Jumlah produk berbeda
        $jumlahProduk = $investments->unique('nama_produk')->count();

        // 3. Jumlah jenis reksa dana berbeda
        $jumlahJenis = $investments->unique('jenis_reksa_dana')->count();

        // 4. Total seluruh unit investasi
        $totalUnit = $investments->sum('jumlah_unit');


        // ==================================
        // DATA GRAFIK INVESTASI
        // ==================================

        $monthlyInvestments = $investments->groupBy(function ($item) {
            return Carbon::parse($item->tanggal_pembelian)
                ->format('Y-m');
        });

        $labels = [];
        $values = [];

        foreach ($monthlyInvestments as $month => $items) {

            $labels[] = Carbon::createFromFormat('Y-m', $month)
                ->format('M Y');

            $values[] = (float) $items->sum('total_investasi');
        }


        // ==================================
        // DATA GRAFIK KATEGORI
        // ==================================

        $categoryInvestments = $investments
            ->groupBy('jenis_reksa_dana');

        $categoryLabels = [];
        $categoryValues = [];

        foreach ($categoryInvestments as $category => $items) {

            $categoryLabels[] = $category;

            $categoryValues[] = (float) $items->sum('total_investasi');
        }


        // Mengirim semua data ke dashboard
        return view('dashboard', compact(
            'totalInvestasi',
            'jumlahProduk',
            'jumlahJenis',
            'totalUnit',
            'labels',
            'values',
            'categoryLabels',
            'categoryValues'
        ));
    }
}

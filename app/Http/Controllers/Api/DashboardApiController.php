<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Investment;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;

class DashboardApiController extends Controller
{
    // STATISTIK: Ringkasan dan data grafik dashboard investasi
    public function stats(): JsonResponse
    {
        $investments = Investment::where('user_id', Auth::id())
            ->orderBy('tanggal_pembelian')
            ->get();

        // Grafik investasi per bulan
        $monthly = $investments->groupBy(function ($item) {
            return Carbon::parse($item->tanggal_pembelian)->format('Y-m');
        });

        $labels = [];
        $values = [];

        foreach ($monthly as $month => $items) {
            $labels[] = Carbon::createFromFormat('Y-m', $month)->format('M Y');
            $values[] = (float) $items->sum('total_investasi');
        }

        // Grafik per kategori jenis reksa dana
        $category = $investments->groupBy('jenis_reksa_dana');

        $categoryLabels = [];
        $categoryValues = [];

        foreach ($category as $name => $items) {
            $categoryLabels[] = $name;
            $categoryValues[] = (float) $items->sum('total_investasi');
        }

        return response()->json([
            'success' => true,
            'message' => 'Statistik dashboard investasi reksa dana',
            'data'    => [
                'total_investasi' => (float) $investments->sum('total_investasi'),
                'jumlah_produk'   => $investments->unique('nama_produk')->count(),
                'jumlah_jenis'    => $investments->unique('jenis_reksa_dana')->count(),
                'total_unit'      => round((float) $investments->sum('jumlah_unit'), 2),
                'grafik_bulanan'  => [
                    'labels' => $labels,
                    'values' => $values,
                ],
                'grafik_kategori' => [
                    'labels' => $categoryLabels,
                    'values' => $categoryValues,
                ],
            ],
        ], 200);
    }
}

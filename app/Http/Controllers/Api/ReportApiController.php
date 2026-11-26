<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Investment;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class ReportApiController extends Controller
{
    // IMPORT EXCEL via API
    public function importExcel(Request $request): JsonResponse
    {
        $validator = validator($request->all(), [
            'file' => 'required|mimes:xlsx,xls,csv|max:2048',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validasi gagal',
                'errors'  => $validator->errors(),
            ], 422);
        }

        try {
            $spreadsheet = IOFactory::load($request->file('file')->getRealPath());
            $rows = $spreadsheet->getActiveSheet()->toArray();

            $imported = 0;
            foreach (array_slice($rows, 1) as $row) {
                if (empty($row[0])) {
                    continue;
                }

                $jumlahUnit  = (float) $row[4];
                $hargaPerUnit = (float) $row[5];

                Investment::create([
                    'user_id'           => Auth::id(),
                    'nama_produk'       => $row[0],
                    'jenis_reksa_dana'  => $row[1],
                    'manajer_investasi' => $row[2],
                    'tanggal_pembelian' => date('Y-m-d', strtotime($row[3])),
                    'jumlah_unit'       => $jumlahUnit,
                    'harga_per_unit'    => $hargaPerUnit,
                    'total_investasi'   => $jumlahUnit * $hargaPerUnit,
                ]);
                $imported++;
            }

            return response()->json([
                'success' => true,
                'message' => "Berhasil mengimport $imported data investasi",
                'data'    => ['imported' => $imported],
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal mengimport file Excel',
                'errors'  => $e->getMessage(),
            ], 500);
        }
    }

    // EXPORT EXCEL via API
    // Format export SAMA PERSIS dengan template import
    public function exportExcel()
    {
        $investments = Investment::where('user_id', Auth::id())
            ->latest()
            ->get();

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        $headers = [
            'nama_produk',
            'jenis_reksa_dana',
            'manajer_investasi',
            'tanggal_pembelian',
            'jumlah_unit',
            'harga_per_unit',
        ];
        $sheet->fromArray($headers, null, 'A1');

        $rowNumber = 2;
        foreach ($investments as $item) {
            $sheet->fromArray([
                $item->nama_produk,
                $item->jenis_reksa_dana,
                $item->manajer_investasi,
                $item->tanggal_pembelian->format('Y-m-d'),
                (float) $item->jumlah_unit,
                (float) $item->harga_per_unit,
            ], null, 'A' . $rowNumber);
            $rowNumber++;
        }

        $sheet->getStyle('E2:F' . $rowNumber)
            ->getNumberFormat()
            ->setFormatCode('0.00');

        foreach (range('A', 'F') as $col) {
            $sheet->getColumnDimension($col)->setAutoSize(true);
        }

        $writer = new Xlsx($spreadsheet);
        $fileName = 'laporan_investasi_' . date('Y-m-d') . '.xlsx';

        return response()->streamDownload(function () use ($writer) {
            $writer->save('php://output');
        }, $fileName, [
            'Content-Type' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
        ]);
    }

    // DOWNLOAD TEMPLATE EXCEL via API
    public function downloadTemplate()
    {
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        $headers = [
            'nama_produk', 'jenis_reksa_dana', 'manajer_investasi',
            'tanggal_pembelian', 'jumlah_unit', 'harga_per_unit',
        ];
        $sheet->fromArray($headers, null, 'A1');

        $dummy = [
            'Sucorinvest Money Market Fund',
            'Pasar Uang',
            'PT Sucorinvest Asset Management',
            '2026-11-24',
            1000,
            1500,
        ];
        $sheet->fromArray($dummy, null, 'A2');

        foreach (range('A', 'F') as $col) {
            $sheet->getColumnDimension($col)->setAutoSize(true);
        }

        $writer = new Xlsx($spreadsheet);

        return response()->streamDownload(function () use ($writer) {
            $writer->save('php://output');
        }, 'template_import_investasi.xlsx', [
            'Content-Type' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
        ]);
    }
}

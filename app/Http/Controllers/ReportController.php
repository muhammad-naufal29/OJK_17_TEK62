<?php

namespace App\Http\Controllers;

use App\Models\Investment;
use Illuminate\Http\Request;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class ReportController extends Controller
{
    // DOWNLOAD TEMPLATE EXCEL
    public function downloadTemplate()
    {
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
        $fileName = 'template_import_investasi.xlsx';

        return response()->streamDownload(function () use ($writer) {
            $writer->save('php://output');
        }, $fileName, [
            'Content-Type' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
        ]);
    }

    // IMPORT EXCEL
    public function importExcel(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,xls,csv|max:2048',
        ]);

        $spreadsheet = IOFactory::load($request->file('file')->getRealPath());
        $rows = $spreadsheet->getActiveSheet()->toArray();

        foreach (array_slice($rows, 1) as $row) {
            if (empty($row[0])) {
                continue;
            }

            $jumlahUnit = (float) $row[4];
            $hargaPerUnit = (float) $row[5];

            Investment::create([
                'nama_produk'       => $row[0],
                'jenis_reksa_dana'  => $row[1],
                'manajer_investasi' => $row[2],
                'tanggal_pembelian' => date('Y-m-d', strtotime($row[3])),
                'jumlah_unit'       => $jumlahUnit,
                'harga_per_unit'    => $hargaPerUnit,
                'total_investasi'   => $jumlahUnit * $hargaPerUnit,
            ]);
        }

        return redirect()
            ->route('investments.index')
            ->with('success', 'Data investasi dari Excel berhasil diimport!');
    }

    // EXPORT EXCEL
    public function exportExcel()
    {
        $investments = Investment::latest()->get();

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        $headers = [
            'No',
            'Nama Produk',
            'Jenis Reksa Dana',
            'Manajer Investasi',
            'Tanggal Pembelian',
            'Jumlah Unit',
            'Harga Per Unit',
            'Total Investasi',
        ];
        $sheet->fromArray($headers, null, 'A1');

        $rowNumber = 2;
        foreach ($investments as $index => $item) {
            $sheet->fromArray([
                $index + 1,
                $item->nama_produk,
                $item->jenis_reksa_dana,
                $item->manajer_investasi,
                $item->tanggal_pembelian,
                $item->jumlah_unit,
                $item->harga_per_unit,
                $item->total_investasi,
            ], null, 'A' . $rowNumber);
            $rowNumber++;
        }

        foreach (range('A', 'H') as $col) {
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
}
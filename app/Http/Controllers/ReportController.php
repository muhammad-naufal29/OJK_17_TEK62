<?php

namespace App\Http\Controllers;

use App\Models\Investment;
use Illuminate\Http\Request;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Shared\Date as ExcelDate;
use Illuminate\Support\Facades\Validator;

class ReportController extends Controller
{
    // EXPORT EXCEL
    public function exportExcel()
    {
        $investments = Investment::orderBy('id')->get();

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        // Judul kolom
        $sheet->fromArray([
            'nama_produk',
            'jenis_reksa_dana',
            'manajer_investasi',
            'tanggal_pembelian',
            'jumlah_unit',
            'harga_per_unit',
            'total_investasi'
        ], null, 'A1');

        $baris = 2;

        foreach ($investments as $item) {
            $sheet->fromArray([
                $item->nama_produk,
                $item->jenis_reksa_dana,
                $item->manajer_investasi,
                \Carbon\Carbon::parse(
                    $item->tanggal_pembelian
                )->format('Y-m-d'),
                (float) $item->jumlah_unit,
                (float) $item->harga_per_unit,
                (float) $item->total_investasi
            ], null, 'A' . $baris);

            $baris++;
        }

        // Format header
        $sheet->getStyle('A1:G1')->getFont()->setBold(true);

        foreach (range('A', 'G') as $kolom) {
            $sheet->getColumnDimension($kolom)->setAutoSize(true);
        }

        // Simpan file sementara
        $temp = tempnam(sys_get_temp_dir(), 'excel_');

        $writer = new Xlsx($spreadsheet);
        $writer->save($temp);

        $spreadsheet->disconnectWorksheets();

        return response()
            ->download($temp, 'data_investasi.xlsx')
            ->deleteFileAfterSend(true);
    }

    // IMPORT EXCEL
    public function importExcel(Request $request)
    {
        $request->validate([
            'file' => 'required|file|mimes:xlsx,xls|max:5120'
        ]);

        $file = $request->file('file');

        $spreadsheet = IOFactory::load($file->getRealPath());
        $rows = $spreadsheet->getActiveSheet()->toArray();

        $spreadsheet->disconnectWorksheets();

        $berhasil = 0;

        // Lewati baris pertama karena berisi header
        foreach (array_slice($rows, 1) as $row) {
            $row = array_pad($row, 7, null);

            // Lewati baris kosong
            if (empty($row[0])) {
                continue;
            }

            $tanggal = $row[3];

            if (is_numeric($tanggal)) {
                $tanggal = ExcelDate::excelToDateTimeObject(
                    $tanggal
                )->format('Y-m-d');
            }

            $data = [
                'nama_produk' => $row[0],
                'jenis_reksa_dana' => $row[1],
                'manajer_investasi' => $row[2],
                'tanggal_pembelian' => $tanggal,
                'jumlah_unit' => $row[4],
                'harga_per_unit' => $row[5],
            ];

            $validated = Validator::make($data, [
                'nama_produk' => 'required|string|max:255',
                'jenis_reksa_dana' => 'required|string|max:255',
                'manajer_investasi' => 'required|string|max:255',
                'tanggal_pembelian' => 'required|date_format:Y-m-d',
                'jumlah_unit' => 'required|numeric|gt:0',
                'harga_per_unit' => 'required|numeric|gte:0',
            ])->validate();

            // Hitung total otomatis
            $validated['total_investasi'] =
                round(
                    $validated['jumlah_unit'] *
                    $validated['harga_per_unit'],
                    2
                );

            Investment::create($validated);
            $berhasil++;
        }

        return redirect()->route('investments.index')
            ->with('success', "$berhasil data berhasil diimport!");
    }
}

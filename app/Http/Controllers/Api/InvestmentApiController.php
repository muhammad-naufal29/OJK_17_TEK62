<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Investment;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class InvestmentApiController extends Controller
{
    // READ: Menampilkan seluruh data investasi
    public function index(): JsonResponse
    {
        $investments = Investment::latest()->get();

        return response()->json([
            'success' => true,
            'message' => 'Daftar data investasi',
            'data'    => $investments,
        ], 200);
    }

    // READ: Menampilkan detail satu investasi
    public function show(int $id): JsonResponse
    {
        $investment = Investment::find($id);

        if (!$investment) {
            return response()->json([
                'success' => false,
                'message' => 'Data investasi tidak ditemukan',
            ], 404);
        }

        return response()->json([
            'success' => true,
            'message' => 'Detail data investasi',
            'data'    => $investment,
        ], 200);
    }

    // CREATE: Menyimpan data investasi
    public function store(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'nama_produk'       => 'required|string|max:255',
            'jenis_reksa_dana'  => 'required|in:Pasar Uang,Pendapatan Tetap,Saham,Campuran',
            'manajer_investasi' => 'required|string|max:255',
            'tanggal_pembelian' => 'required|date',
            'jumlah_unit'       => 'required|numeric|min:0.0001',
            'harga_per_unit'    => 'required|numeric|min:0',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validasi gagal',
                'errors'  => $validator->errors(),
            ], 422);
        }

        $validated = $validator->validated();
        $validated['total_investasi'] = $validated['jumlah_unit'] * $validated['harga_per_unit'];

        $investment = Investment::create($validated);

        return response()->json([
            'success' => true,
            'message' => 'Data investasi berhasil ditambahkan',
            'data'    => $investment,
        ], 201);
    }

    // UPDATE: Memperbarui data investasi
    public function update(Request $request, int $id): JsonResponse
    {
        $investment = Investment::find($id);

        if (!$investment) {
            return response()->json([
                'success' => false,
                'message' => 'Data investasi tidak ditemukan',
            ], 404);
        }

        $validator = Validator::make($request->all(), [
            'nama_produk'       => 'required|string|max:255',
            'jenis_reksa_dana'  => 'required|in:Pasar Uang,Pendapatan Tetap,Saham,Campuran',
            'manajer_investasi' => 'required|string|max:255',
            'tanggal_pembelian' => 'required|date',
            'jumlah_unit'       => 'required|numeric|min:0.0001',
            'harga_per_unit'    => 'required|numeric|min:0',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validasi gagal',
                'errors'  => $validator->errors(),
            ], 422);
        }

        $validated = $validator->validated();
        $validated['total_investasi'] = $validated['jumlah_unit'] * $validated['harga_per_unit'];

        $investment->update($validated);

        return response()->json([
            'success' => true,
            'message' => 'Data investasi berhasil diperbarui',
            'data'    => $investment->fresh(),
        ], 200);
    }

    // DELETE: Menghapus data investasi
    public function destroy(int $id): JsonResponse
    {
        $investment = Investment::find($id);

        if (!$investment) {
            return response()->json([
                'success' => false,
                'message' => 'Data investasi tidak ditemukan',
            ], 404);
        }

        $investment->delete();

        return response()->json([
            'success' => true,
            'message' => 'Data investasi berhasil dihapus',
            'data'    => $investment,
        ], 200);
    }
}

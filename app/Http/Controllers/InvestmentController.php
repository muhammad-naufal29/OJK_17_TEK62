<?php

namespace App\Http\Controllers;

use App\Models\Investment;
use Illuminate\Http\Request;

class InvestmentController extends Controller
{
    // READ: Menampilkan seluruh data investasi
    public function index()
    {
        $investments = Investment::latest()->get();

        return view('investments.index', compact('investments'));
    }

    // Menampilkan form tambah data
    public function create()
    {
        return view('investments.create');
    }

    // CREATE: Menyimpan data investasi
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_produk' => 'required|string|max:255',
            'jenis_reksa_dana' => 'required|in:Pasar Uang,Pendapatan Tetap,Saham,Campuran',
            'manajer_investasi' => 'required|string|max:255',
            'tanggal_pembelian' => 'required|date',
            'jumlah_unit' => 'required|numeric|min:0.0001',
            'harga_per_unit' => 'required|numeric|min:0',
        ]);

        $validated['total_investasi'] =
            $validated['jumlah_unit'] * $validated['harga_per_unit'];

        Investment::create($validated);

        return redirect()
            ->route('investments.index')
            ->with('success', 'Data investasi berhasil ditambahkan!');
    }

    // Menampilkan form edit
    public function edit(Investment $investment)
    {
        return view('investments.edit', compact('investment'));
    }

    // UPDATE: Memperbarui data investasi
    public function update(Request $request, Investment $investment)
    {
        $validated = $request->validate([
            'nama_produk' => 'required|string|max:255',
            'jenis_reksa_dana' => 'required|in:Pasar Uang,Pendapatan Tetap,Saham,Campuran',
            'manajer_investasi' => 'required|string|max:255',
            'tanggal_pembelian' => 'required|date',
            'jumlah_unit' => 'required|numeric|min:0.0001',
            'harga_per_unit' => 'required|numeric|min:0',
        ]);

        $validated['total_investasi'] =
            $validated['jumlah_unit'] * $validated['harga_per_unit'];

        $investment->update($validated);

        return redirect()
            ->route('investments.index')
            ->with('success', 'Data investasi berhasil diperbarui!');
    }

    // DELETE: Menghapus data investasi
    public function destroy(Investment $investment)
    {
        $investment->delete();

        return redirect()
            ->route('investments.index')
            ->with('success', 'Data investasi berhasil dihapus!');
    }
}

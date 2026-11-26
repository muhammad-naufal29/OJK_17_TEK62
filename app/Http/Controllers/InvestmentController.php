<?php

namespace App\Http\Controllers;

use App\Models\Investment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class InvestmentController extends Controller
{
    // READ: Menampilkan data investasi milik user yang login
    public function index()
    {
        $investments = Investment::where('user_id', Auth::id())
            ->latest()
            ->get();

        return view('investments.index', compact('investments'));
    }

    // Menampilkan form tambah data
    public function create()
    {
        return view('investments.create');
    }

    // CREATE: Menyimpan data investasi (terikat ke user yang login)
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_produk' => 'required|string|max:255',
            'jenis_reksa_dana' => 'required|in:Pasar Uang,Pendapatan Tetap,Saham,Campuran',
            'manajer_investasi' => 'required|string|max:255',
            'tanggal_pembelian' => 'required|date',
            'jumlah_unit' => 'required|numeric|min:0.01',
            'harga_per_unit' => 'required|numeric|min:0',
        ]);

        $validated['total_investasi'] =
            $validated['jumlah_unit'] * $validated['harga_per_unit'];
        $validated['user_id'] = Auth::id();

        Investment::create($validated);

        return redirect()
            ->route('investments.index')
            ->with('success', 'Data investasi berhasil ditambahkan!');
    }

    // Menampilkan form edit (hanya milik user)
    public function edit(Investment $investment)
    {
        abort_if($investment->user_id !== Auth::id(), 403);

        return view('investments.edit', compact('investment'));
    }

    // UPDATE: Memperbarui data investasi (hanya milik user)
    public function update(Request $request, Investment $investment)
    {
        abort_if($investment->user_id !== Auth::id(), 403);

        $validated = $request->validate([
            'nama_produk' => 'required|string|max:255',
            'jenis_reksa_dana' => 'required|in:Pasar Uang,Pendapatan Tetap,Saham,Campuran',
            'manajer_investasi' => 'required|string|max:255',
            'tanggal_pembelian' => 'required|date',
            'jumlah_unit' => 'required|numeric|min:0.01',
            'harga_per_unit' => 'required|numeric|min:0',
        ]);

        $validated['total_investasi'] =
            $validated['jumlah_unit'] * $validated['harga_per_unit'];

        $investment->update($validated);

        return redirect()
            ->route('investments.index')
            ->with('success', 'Data investasi berhasil diperbarui!');
    }

    // DELETE: Menghapus data investasi (hanya milik user)
    public function destroy(Investment $investment)
    {
        abort_if($investment->user_id !== Auth::id(), 403);

        $investment->delete();

        return redirect()
            ->route('investments.index')
            ->with('success', 'Data investasi berhasil dihapus!');
    }
}


@extends('layouts.app')

@section('title', 'Edit Investasi')

@section('content')

<div class="card shadow-sm">
    <div class="card-header bg-warning">
        <h5 class="mb-0">Edit Data Investasi</h5>
    </div>

    <div class="card-body">

        @if($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('investments.update', $investment->id) }}"
              method="POST">

            @csrf
            @method('PUT')

            <div class="mb-3">
                <label class="form-label">Nama Produk</label>
                <input type="text" name="nama_produk"
                       class="form-control"
                       value="{{ old('nama_produk', $investment->nama_produk) }}"
                       required>
            </div>

            <div class="mb-3">
                <label class="form-label">Jenis Reksa Dana</label>
                <select name="jenis_reksa_dana" class="form-select" required>
                    @foreach(['Pasar Uang', 'Pendapatan Tetap', 'Saham', 'Campuran'] as $jenis)
                        <option value="{{ $jenis }}"
                            {{ old('jenis_reksa_dana', $investment->jenis_reksa_dana) == $jenis ? 'selected' : '' }}>
                            {{ $jenis }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="mb-3">
                <label class="form-label">Manajer Investasi</label>
                <input type="text" name="manajer_investasi"
                       class="form-control"
                       value="{{ old('manajer_investasi', $investment->manajer_investasi) }}"
                       required>
            </div>

            <div class="mb-3">
                <label class="form-label">Tanggal Pembelian</label>
                <input type="date" name="tanggal_pembelian"
                       class="form-control"
                       value="{{ old('tanggal_pembelian', $investment->tanggal_pembelian->format('Y-m-d')) }}"
                       required>
            </div>

            <div class="mb-3">
                <label class="form-label">Jumlah Unit</label>
                <input type="number" name="jumlah_unit"
                       class="form-control" step="0.0001" min="0.0001"
                       value="{{ old('jumlah_unit', $investment->jumlah_unit) }}"
                       required>
            </div>

            <div class="mb-3">
                <label class="form-label">Harga Per Unit (Rp)</label>
                <input type="number" name="harga_per_unit"
                       class="form-control" step="0.01" min="0"
                       value="{{ old('harga_per_unit', $investment->harga_per_unit) }}"
                       required>
            </div>

            <button type="submit" class="btn btn-warning">
                Update Data
            </button>

            <a href="{{ route('investments.index') }}"
               class="btn btn-secondary">
                Batal
            </a>

        </form>
    </div>
</div>

@endsection

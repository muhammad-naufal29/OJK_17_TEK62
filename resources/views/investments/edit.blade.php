
@extends('layouts.app')

@section('title', 'Edit Investasi')

@section('content')

<div class="mb-4">
    <h3 class="fw-bold text-maroon">Edit Investasi</h3>
    <p class="text-muted">Perbarui informasi data investasi.</p>
</div>

<div class="card card-custom p-4">

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

        <div class="row g-3">

            <div class="col-md-6">
                <label class="form-label fw-semibold">Nama Produk</label>
                <input type="text" name="nama_produk"
                       class="form-control"
                       value="{{ old('nama_produk', $investment->nama_produk) }}"
                       required>
            </div>

            <div class="col-md-6">
                <label class="form-label fw-semibold">Jenis Reksa Dana</label>
                <select name="jenis_reksa_dana" class="form-select" required>
                    @foreach(['Pasar Uang','Pendapatan Tetap','Saham','Campuran'] as $jenis)
                        <option value="{{ $jenis }}"
                            {{ old('jenis_reksa_dana', $investment->jenis_reksa_dana) == $jenis ? 'selected' : '' }}>
                            {{ $jenis }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="col-md-6">
                <label class="form-label fw-semibold">Manajer Investasi</label>
                <input type="text" name="manajer_investasi"
                       class="form-control"
                       value="{{ old('manajer_investasi', $investment->manajer_investasi) }}"
                       required>
            </div>

            <div class="col-md-6">
                <label class="form-label fw-semibold">Tanggal Pembelian</label>
                <input type="date" name="tanggal_pembelian"
                       class="form-control"
                       value="{{ old('tanggal_pembelian', $investment->tanggal_pembelian->format('Y-m-d')) }}"
                       required>
            </div>

            <div class="col-md-6">
                <label class="form-label fw-semibold">Jumlah Unit</label>
                <input type="number" name="jumlah_unit"
                       class="form-control" step="0.0001" min="0.0001"
                       value="{{ old('jumlah_unit', $investment->jumlah_unit) }}"
                       required>
            </div>

            <div class="col-md-6">
                <label class="form-label fw-semibold">Harga Per Unit (Rp)</label>
                <input type="number" name="harga_per_unit"
                       class="form-control" step="0.01" min="0"
                       value="{{ old('harga_per_unit', $investment->harga_per_unit) }}"
                       required>
            </div>

        </div>

        <hr class="my-4">

        <div class="d-flex gap-2 justify-content-end">

            <a href="{{ route('investments.index') }}"
               class="btn btn-secondary">
                Batal
            </a>

            <button type="submit" class="btn btn-maroon">
                <i class="bi bi-check-circle"></i> Update Data
            </button>

        </div>

    </form>

</div>

@endsection

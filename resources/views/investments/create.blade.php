
@extends('layouts.app')

@section('title', 'Tambah Investasi')

@section('content')

<div class="mb-4">
    <h3 class="fw-bold text-maroon">Tambah Investasi</h3>
    <p class="text-muted">Masukkan informasi produk investasi baru.</p>
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

    <form action="{{ route('investments.store') }}" method="POST">
        @csrf

        <div class="row g-3">

            <div class="col-md-6">
                <label class="form-label fw-semibold">Nama Produk</label>
                <input type="text" name="nama_produk"
                       class="form-control"
                       value="{{ old('nama_produk') }}"
                       placeholder="Masukkan nama produk" required>
            </div>

            <div class="col-md-6">
                <label class="form-label fw-semibold">Jenis Reksa Dana</label>
                <select name="jenis_reksa_dana" class="form-select" required>
                    <option value="">Pilih Jenis</option>
                    @foreach(['Pasar Uang','Pendapatan Tetap','Saham','Campuran'] as $jenis)
                        <option value="{{ $jenis }}"
                            {{ old('jenis_reksa_dana') == $jenis ? 'selected' : '' }}>
                            {{ $jenis }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="col-md-6">
                <label class="form-label fw-semibold">Manajer Investasi</label>
                <input type="text" name="manajer_investasi"
                       class="form-control"
                       value="{{ old('manajer_investasi') }}"
                       placeholder="Nama manajer investasi" required>
            </div>

            <div class="col-md-6">
                <label class="form-label fw-semibold">Tanggal Pembelian</label>
                <input type="date" name="tanggal_pembelian"
                       class="form-control"
                       value="{{ old('tanggal_pembelian') }}" required>
            </div>

            <div class="col-md-6">
                <label class="form-label fw-semibold">Jumlah Unit</label>
                <input type="number" name="jumlah_unit"
                       class="form-control"
                       step="0.01" min="0.01"
                       value="{{ old('jumlah_unit') }}"
                       placeholder="Masukkan jumlah unit" required>
            </div>

            <div class="col-md-6">
                <label class="form-label fw-semibold">Harga Per Unit (Rp)</label>
                <input type="number" name="harga_per_unit"
                       class="form-control"
                       step="0.01" min="0"
                       value="{{ old('harga_per_unit') }}"
                       placeholder="Masukkan harga per unit" required>
            </div>

        </div>

        <hr class="my-4">

        <div class="d-flex gap-2 justify-content-end">
            <a href="{{ route('investments.index') }}"
               class="btn btn-secondary">
                Batal
            </a>

            <button type="submit" class="btn btn-maroon">
                <i class="bi bi-save"></i> Simpan Data
            </button>
        </div>

    </form>

</div>

@endsection

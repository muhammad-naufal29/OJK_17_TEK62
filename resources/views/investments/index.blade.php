
@extends('layouts.app')

@section('title', 'Data Investasi')

@section('content')

<!-- Header Halaman -->
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h3>Data Investasi</h3>
        <p class="text-muted">
            Daftar pengelolaan investasi dan reksa dana
        </p>
    </div>

    <a href="{{ route('investments.create') }}"
       class="btn btn-primary">
        + Tambah Investasi
    </a>
</div>

<!-- Pesan Berhasil -->
@if(session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif

<!-- Pesan Error -->
@if($errors->any())
    <div class="alert alert-danger">
        {{ $errors->first() }}
    </div>
@endif

<!-- FITUR IMPORT DAN EXPORT EXCEL -->
<div class="card shadow-sm mb-4">
    <div class="card-body">

        <h5 class="mb-3">Import & Export Excel</h5>

        <div class="row align-items-end">

            <!-- Import Excel -->
            <div class="col-md-8">
                <form action="{{ route('investments.import') }}"
                      method="POST"
                      enctype="multipart/form-data">

                    @csrf

                    <label class="form-label">
                        Pilih File Excel
                    </label>

                    <input type="file"
                           name="file"
                           accept=".xlsx,.xls"
                           class="form-control mb-2"
                           required>

                    <button type="submit"
                            class="btn btn-primary">
                        Import Excel
                    </button>

                </form>
            </div>

            <!-- Export Excel -->
            <div class="col-md-4 mt-3 mt-md-0">
                <label class="form-label">
                    Download Data Investasi
                </label>

                <div>
                    <a href="{{ route('investments.exportExcel') }}"
                       class="btn btn-success">
                        Export Excel
                    </a>
                </div>
            </div>

        </div>

    </div>
</div>

<!-- TABEL DATA INVESTASI -->
<div class="card shadow-sm">

    <div class="card-body table-responsive">

        <table class="table table-bordered table-striped align-middle">

            <thead class="table-primary">
                <tr>
                    <th>No</th>
                    <th>Nama Produk</th>
                    <th>Jenis Reksa Dana</th>
                    <th>Manajer Investasi</th>
                    <th>Tanggal Pembelian</th>
                    <th>Total Investasi</th>
                    <th>Aksi</th>
                </tr>
            </thead>

            <tbody>

                @forelse($investments as $investment)

                    <tr>
                        <td>{{ $loop->iteration }}</td>

                        <td>
                            {{ $investment->nama_produk }}
                        </td>

                        <td>
                            {{ $investment->jenis_reksa_dana }}
                        </td>

                        <td>
                            {{ $investment->manajer_investasi }}
                        </td>

                        <td>
                            {{ $investment->tanggal_pembelian->format('d-m-Y') }}
                        </td>

                        <td>
                            Rp {{ number_format(
                                $investment->total_investasi,
                                0,
                                ',',
                                '.'
                            ) }}
                        </td>

                        <td>
                            <!-- Tombol Edit -->
                            <a href="{{ route('investments.edit', $investment->id) }}"
                               class="btn btn-warning btn-sm">
                                Edit
                            </a>

                            <!-- Tombol Hapus -->
                            <form action="{{ route('investments.destroy', $investment->id) }}"
                                  method="POST"
                                  class="d-inline"
                                  onsubmit="return confirm('Yakin ingin menghapus data ini?')">

                                @csrf
                                @method('DELETE')

                                <button type="submit"
                                        class="btn btn-danger btn-sm">
                                    Hapus
                                </button>

                            </form>
                        </td>
                    </tr>

                @empty

                    <tr>
                        <td colspan="7"
                            class="text-center">
                            Belum ada data investasi.
                        </td>
                    </tr>

                @endforelse

            </tbody>

        </table>

    </div>

</div>

@endsection

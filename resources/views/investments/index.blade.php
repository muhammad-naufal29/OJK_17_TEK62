
@extends('layouts.app')

@section('title', 'Data Investasi')

@section('content')

<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h3>Data Investasi</h3>
        <p class="text-muted">Daftar pengelolaan investasi dan reksa dana</p>
    </div>

    <a href="{{ route('investments.create') }}"
       class="btn btn-primary">
        + Tambah Investasi
    </a>
</div>

@if(session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif

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
                        <td>{{ $investment->nama_produk }}</td>
                        <td>{{ $investment->jenis_reksa_dana }}</td>
                        <td>{{ $investment->manajer_investasi }}</td>
                        <td>{{ $investment->tanggal_pembelian->format('d-m-Y') }}</td>

                        <td>
                            Rp {{ number_format($investment->total_investasi, 0, ',', '.') }}
                        </td>

                        <td>
                            <a href="{{ route('investments.edit', $investment->id) }}"
                               class="btn btn-warning btn-sm">
                                Edit
                            </a>

                            <form action="{{ route('investments.destroy', $investment->id) }}"
                                  method="POST"
                                  class="d-inline"
                                  onsubmit="return confirm('Yakin ingin menghapus data ini?')">

                                @csrf
                                @method('DELETE')

                                <button type="submit" class="btn btn-danger btn-sm">
                                    Hapus
                                </button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="text-center">
                            Belum ada data investasi.
                        </td>
                    </tr>
                @endforelse
            </tbody>

        </table>

    </div>
</div>

@endsection

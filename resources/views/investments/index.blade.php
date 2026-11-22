@extends('layouts.app')

@section('content')

<div class="container-fluid">

    {{-- HEADER HALAMAN --}}
    <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-3">

        <div>
            <h3 class="fw-bold mb-1">Data Investasi</h3>
            <p class="text-muted mb-0">
                Kelola data pembelian reksa dana
            </p>
        </div>

        <div class="d-flex align-items-center gap-2 flex-wrap">

            {{-- DROPDOWN EKSPOR --}}
            <div class="dropdown">

                <button class="btn btn-maroon dropdown-toggle"
                        type="button"
                        data-bs-toggle="dropdown"
                        aria-expanded="false">

                    <i class="bi bi-download me-1"></i>
                    Ekspor

                </button>

                <ul class="dropdown-menu dropdown-menu-end shadow-sm">

                    {{-- EKSPOR PDF --}}
                    <li>
                        {{-- TODO: Integrasi route ekspor PDF --}}
                        <a class="dropdown-item" href="#">
                            <i class="bi bi-file-earmark-pdf me-2 text-danger"></i>
                            Ekspor PDF
                        </a>
                    </li>

                    {{-- EKSPOR EXCEL --}}
                    <li>
                        <a class="dropdown-item" href="{{ route('investments.exportExcel') }}">
                            <i class="bi bi-file-earmark-excel me-2 text-success"></i>
                            Ekspor Excel
                        </a>
                    </li>

                </ul>

            </div>


            {{-- DROPDOWN IMPOR --}}
            <div class="dropdown">

                <button class="btn btn-maroon dropdown-toggle"
                        type="button"
                        data-bs-toggle="dropdown"
                        aria-expanded="false">

                    <i class="bi bi-upload me-1"></i>
                    Impor

                </button>

                <ul class="dropdown-menu dropdown-menu-end shadow-sm">

                    {{-- IMPOR EXCEL --}}
                    <li>
                        <button type="button"
                                class="dropdown-item"
                                data-bs-toggle="modal"
                                data-bs-target="#importExcelModal">
                            <i class="bi bi-file-earmark-excel me-2 text-success"></i>
                            Impor Excel
                        </button>
                    </li>

                </ul>

            </div>


            {{-- TOMBOL TAMBAH INVESTASI --}}
            <a href="{{ route('investments.create') }}"
               class="btn btn-maroon">

                <i class="bi bi-plus-circle me-1"></i>
                Tambah Investasi

            </a>

        </div>

    </div>


    {{-- NOTIFIKASI SUKSES --}}
    @if (session('success'))

        <div class="alert alert-success alert-dismissible fade show"
             role="alert">

            <i class="bi bi-check-circle me-2"></i>
            {{ session('success') }}

            <button type="button"
                    class="btn-close"
                    data-bs-dismiss="alert">
            </button>

        </div>

    @endif


    {{-- NOTIFIKASI ERROR --}}
    @if ($errors->any())

        <div class="alert alert-danger">

            <strong>Terjadi kesalahan:</strong>

            <ul class="mb-0 mt-2">

                @foreach ($errors->all() as $error)

                    <li>{{ $error }}</li>

                @endforeach

            </ul>

        </div>

    @endif


    {{-- TABEL DATA INVESTASI --}}
    <div class="card border-0 shadow-sm">

        <div class="card-body">

            <div class="table-responsive">

                <table class="table table-hover align-middle">

                    <thead class="table-light">

                        <tr>
                            <th>No</th>
                            <th>Nama Produk</th>
                            <th>Jenis Reksa Dana</th>
                            <th>Manajer Investasi</th>
                            <th>Tanggal Pembelian</th>
                            <th>Jumlah Unit</th>
                            <th>Total Investasi</th>
                            <th class="text-center">Aksi</th>
                        </tr>

                    </thead>


                    <tbody>

                        @forelse ($investments as $investment)

                            <tr>

                                <td>{{ $loop->iteration }}</td>

                                <td class="fw-semibold">
                                    {{ $investment->nama_produk }}
                                </td>

                                <td>
                                    <span class="badge bg-light text-dark">
                                        {{ $investment->jenis_reksa_dana }}
                                    </span>
                                </td>

                                <td>
                                    {{ $investment->manajer_investasi }}
                                </td>

                                <td>
                                    {{ \Carbon\Carbon::parse($investment->tanggal_pembelian)->format('d-m-Y') }}
                                </td>

                                <td>
                                    {{ number_format((float) $investment->jumlah_unit, 4, ',', '.') }}
                                </td>

                                <td class="fw-semibold">
                                    Rp {{ number_format((float) $investment->total_investasi, 0, ',', '.') }}
                                </td>


                                {{-- AKSI EDIT DAN HAPUS --}}
                                <td class="text-center">

                                    <div class="d-flex justify-content-center gap-2">

                                        {{-- TOMBOL EDIT --}}
                                        <a href="{{ route('investments.edit', $investment->id) }}"
                                           class="btn btn-danger btn-sm"
                                           title="Edit data">

                                            <i class="bi bi-pencil-square"></i>

                                        </a>


                                        {{-- TOMBOL HAPUS --}}
                                        <button type="button"
                                                class="btn btn-danger btn-sm"
                                                data-bs-toggle="modal"
                                                data-bs-target="#deleteModal{{ $investment->id }}"
                                                title="Hapus data">

                                            <i class="bi bi-trash"></i>

                                        </button>

                                    </div>


                                    {{-- MODAL KONFIRMASI HAPUS --}}
                                    <div class="modal fade"
                                         id="deleteModal{{ $investment->id }}"
                                         tabindex="-1"
                                         aria-labelledby="deleteModalLabel{{ $investment->id }}"
                                         aria-hidden="true">

                                        <div class="modal-dialog modal-dialog-centered">

                                            <div class="modal-content border-0 shadow">

                                                <div class="modal-body text-center p-4">

                                                    <div class="mb-3">

                                                        <i class="bi bi-exclamation-circle-fill"
                                                           style="font-size: 55px; color: #781F36;">
                                                        </i>

                                                    </div>


                                                    <h5 class="fw-bold mb-2"
                                                        style="color: #781F36;">

                                                        Hapus Data Investasi?

                                                    </h5>


                                                    <p class="text-muted mb-4">

                                                        Apakah kamu yakin ingin menghapus data produk

                                                        <strong>
                                                            {{ $investment->nama_produk }}
                                                        </strong>?

                                                        <br>

                                                        Data yang sudah dihapus tidak dapat dikembalikan.

                                                    </p>


                                                    <div class="d-flex justify-content-center gap-2">

                                                        {{-- TOMBOL BATAL --}}
                                                        <button type="button"
                                                                class="btn btn-secondary"
                                                                data-bs-dismiss="modal">

                                                            Batal

                                                        </button>


                                                        {{-- FORM HAPUS --}}
                                                        <form action="{{ route('investments.destroy', $investment->id) }}"
                                                              method="POST">

                                                            @csrf
                                                            @method('DELETE')

                                                            <button type="submit"
                                                                    class="btn text-white"
                                                                    style="background-color: #781F36;">

                                                                <i class="bi bi-trash me-1"></i>
                                                                Ya, Hapus

                                                            </button>

                                                        </form>

                                                    </div>

                                                </div>

                                            </div>

                                        </div>

                                    </div>

                                </td>

                            </tr>


                        @empty

                            <tr>

                                <td colspan="8" class="text-center py-5">

                                    <i class="bi bi-inbox text-muted"
                                       style="font-size: 45px;">
                                    </i>

                                    <p class="text-muted mt-2 mb-0">
                                        Belum ada data investasi.
                                    </p>

                                    <a href="{{ route('investments.create') }}"
                                       class="btn btn-maroon btn-sm mt-3">

                                        Tambah Data Pertama

                                    </a>

                                </td>

                            </tr>

                        @endforelse

                    </tbody>

                </table>

            </div>

        </div>

    </div>

</div>


{{-- MODAL IMPOR EXCEL --}}
<div class="modal fade"
     id="importExcelModal"
     tabindex="-1"
     aria-labelledby="importExcelModalLabel"
     aria-hidden="true">

    <div class="modal-dialog modal-dialog-centered">

        <div class="modal-content border-0 shadow">

            <form action="{{ route('investments.import') }}"
                  method="POST"
                  enctype="multipart/form-data">

                @csrf

                <div class="modal-header">
                    <h5 class="modal-title fw-bold" id="importExcelModalLabel">
                        <i class="bi bi-file-earmark-excel me-2 text-success"></i>
                        Impor Data Excel
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="modal-body">
                    <label for="fileExcel" class="form-label">Pilih File Excel (.xlsx / .xls)</label>
                    <input type="file"
                           id="fileExcel"
                           name="file"
                           accept=".xlsx,.xls"
                           class="form-control"
                           required>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-maroon">
                        <i class="bi bi-upload me-1"></i>
                        Upload & Impor
                    </button>
                </div>

            </form>

        </div>

    </div>

</div>

@endsection
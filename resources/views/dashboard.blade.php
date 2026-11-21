
@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')

<div class="mb-4">
    <h3 class="fw-bold text-maroon">Dashboard</h3>
    <p class="text-muted">
        Selamat datang di Sistem Pengelolaan Investasi dan Reksa Dana.
    </p>
</div>

<!-- STATISTIK -->
<div class="row g-3 mb-4">

    <div class="col-md-3 col-sm-6">
        <div class="card card-custom p-3">
            <div class="d-flex justify-content-between">
                <div>
                    <small class="text-muted">Total Investasi</small>
                    <h5 class="fw-bold text-maroon mt-2">Rp -</h5>
                </div>
                <i class="bi bi-wallet2 fs-2 text-maroon"></i>
            </div>
        </div>
    </div>

    <div class="col-md-3 col-sm-6">
        <div class="card card-custom p-3">
            <div class="d-flex justify-content-between">
                <div>
                    <small class="text-muted">Jumlah Produk</small>
                    <h5 class="fw-bold text-maroon mt-2">- Produk</h5>
                </div>
                <i class="bi bi-box-seam fs-2 text-maroon"></i>
            </div>
        </div>
    </div>

    <div class="col-md-3 col-sm-6">
        <div class="card card-custom p-3">
            <div class="d-flex justify-content-between">
                <div>
                    <small class="text-muted">Jenis Reksa Dana</small>
                    <h5 class="fw-bold text-maroon mt-2">- Jenis</h5>
                </div>
                <i class="bi bi-pie-chart fs-2 text-maroon"></i>
            </div>
        </div>
    </div>

    <div class="col-md-3 col-sm-6">
        <div class="card card-custom p-3">
            <div class="d-flex justify-content-between">
                <div>
                    <small class="text-muted">Total Unit</small>
                    <h5 class="fw-bold text-maroon mt-2">- Unit</h5>
                </div>
                <i class="bi bi-layers fs-2 text-maroon"></i>
            </div>
        </div>
    </div>

</div>


<!-- AREA GRAFIK -->
<div class="row g-3 mb-4">

    <!-- GRAFIK INVESTASI -->
    <div class="col-lg-8">
        <div class="card card-custom p-4 h-100">

            <h5 class="fw-bold text-maroon">
                Grafik Perkembangan Investasi
            </h5>

            <p class="text-muted small">
                Perkembangan total investasi berdasarkan bulan.
            </p>

            <!-- TEMPAT GRAFIK TEMAN -->
            <div style="height: 320px; position: relative;">
                <canvas id="investmentChart"></canvas>
            </div>

        </div>
    </div>


    <!-- GRAFIK KATEGORI -->
    <div class="col-lg-4">
        <div class="card card-custom p-4 h-100">

            <h5 class="fw-bold text-maroon">
                Jenis Reksa Dana
            </h5>

            <p class="text-muted small">
                Komposisi investasi berdasarkan kategori.
            </p>

            <!-- TEMPAT GRAFIK TEMAN -->
            <div style="height: 320px; position: relative;">
                <canvas id="categoryChart"></canvas>
            </div>

        </div>
    </div>

</div>


<!-- INFORMASI -->
<div class="card card-custom p-4">

    <h5 class="fw-bold text-maroon">
        Informasi Sistem
    </h5>

    <p class="text-muted mb-0">
        Sistem ini digunakan untuk membantu pengelolaan data
        investasi dan reksa dana, mulai dari pencatatan,
        pengelolaan, hingga penyajian informasi investasi.
    </p>

</div>

@endsection

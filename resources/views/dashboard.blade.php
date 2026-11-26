
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

<!-- STATISTIK -->
<div class="row g-3 mb-4">

    <!-- TOTAL INVESTASI -->
    <div class="col-md-3 col-sm-6">
        <div class="card card-custom p-3">
            <div class="d-flex justify-content-between">
                <div>
                    <small class="text-muted">Total Investasi</small>
                    <h5 class="fw-bold text-maroon mt-2">
                        Rp {{ number_format($totalInvestasi, 0, ',', '.') }}
                    </h5>
                </div>
                <i class="bi bi-wallet2 fs-2 text-maroon"></i>
            </div>
        </div>
    </div>

    <!-- JUMLAH PRODUK -->
    <div class="col-md-3 col-sm-6">
        <div class="card card-custom p-3">
            <div class="d-flex justify-content-between">
                <div>
                    <small class="text-muted">Jumlah Produk</small>
                    <h5 class="fw-bold text-maroon mt-2">
                        {{ $jumlahProduk }} Produk
                    </h5>
                </div>
                <i class="bi bi-box-seam fs-2 text-maroon"></i>
            </div>
        </div>
    </div>

    <!-- JENIS REKSA DANA -->
    <div class="col-md-3 col-sm-6">
        <div class="card card-custom p-3">
            <div class="d-flex justify-content-between">
                <div>
                    <small class="text-muted">Jenis Reksa Dana</small>
                    <h5 class="fw-bold text-maroon mt-2">
                        {{ $jumlahJenis }} Jenis
                    </h5>
                </div>
                <i class="bi bi-pie-chart fs-2 text-maroon"></i>
            </div>
        </div>
    </div>

    <!-- TOTAL UNIT -->
    <div class="col-md-3 col-sm-6">
        <div class="card card-custom p-3">
            <div class="d-flex justify-content-between">
                <div>
                    <small class="text-muted">Total Unit</small>
                    <h5 class="fw-bold text-maroon mt-2">
                        {{ number_format($totalUnit, 2, ',', '.') }} Unit
                    </h5>
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


@push('scripts')

<!-- Library Chart.js -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
    // Mengambil data dari Laravel
    const labels = @json($labels);
    const values = @json($values);

    // Mengambil elemen canvas
    const ctx = document.getElementById('investmentChart');

    // Membuat grafik
    new Chart(ctx, {
        type: 'line',

        data: {
            labels: labels,

            datasets: [{
                label: 'Total Investasi',

                data: values,

                borderColor: '#781F36',
                backgroundColor: 'rgba(120, 31, 54, 0.15)',

                borderWidth: 3,
                fill: true,
                tension: 0.3,

                pointBackgroundColor: '#781F36',
                pointRadius: 5
            }]
        },

        options: {
            responsive: true,
            maintainAspectRatio: false,

            plugins: {
                legend: {
                    display: true
                },

                tooltip: {
                    callbacks: {
                        label: function(context) {
                            return 'Rp ' +
                                new Intl.NumberFormat('id-ID')
                                .format(context.raw);
                        }
                    }
                }
            },

            scales: {
                y: {
                    beginAtZero: true,

                    ticks: {
                        callback: function(value) {
                            return 'Rp ' +
                                new Intl.NumberFormat('id-ID', {
                                    notation: 'compact'
                                }).format(value);
                        }
                    }
                }
            }
        }
    });
</script>


<!-- GRAFIK JENIS REKSA DANA -->
<script>
    const categoryLabels = @json($categoryLabels);
    const categoryValues = @json($categoryValues);

    const categoryCtx = document.getElementById('categoryChart');

    new Chart(categoryCtx, {
        type: 'doughnut',

        data: {
            labels: categoryLabels,

            datasets: [{
                label: 'Total Investasi',

                data: categoryValues,

                backgroundColor: [
                    '#781F36',
                    '#A64D65',
                    '#D17B91',
                    '#E8AAB9',
                    '#F2D0D9'
                ],

                borderWidth: 2,
                borderColor: '#FFFFFF',
                hoverOffset: 8
            }]
        },

        options: {
            responsive: true,
            maintainAspectRatio: false,

            plugins: {
                legend: {
                    position: 'bottom',

                    labels: {
                        padding: 15,
                        usePointStyle: true
                    }
                },

                tooltip: {
                    callbacks: {
                        label: function(context) {
                            let value = context.raw;

                            return context.label + ': Rp ' +
                                new Intl.NumberFormat('id-ID')
                                .format(value);
                        }
                    }
                }
            }
        }
    });
</script>


@endpush


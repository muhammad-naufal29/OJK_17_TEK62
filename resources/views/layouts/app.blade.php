
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>@yield('title') | Investasi Reksa Dana</title>

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
          rel="stylesheet">

    <!-- Bootstrap Icons -->
    <link rel="stylesheet"
          href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <style>
        :root {
            --maroon: #781F36;
            --maroon-dark: #5B172A;
            --maroon-light: #A9445B;
            --background: #F7F1F2;
        }

        body {
            background: var(--background);
            font-family: Arial, sans-serif;
            margin: 0;
        }

        .sidebar {
            width: 250px;
            height: 100vh;
            position: fixed;
            top: 0;
            left: 0;
            background: var(--maroon-dark);
            color: white;
            padding: 25px 15px;
            z-index: 1000;
        }

        .brand {
            font-size: 18px;
            font-weight: bold;
            padding: 10px;
            margin-bottom: 35px;
        }

        .sidebar a {
            display: block;
            color: #F5DDE3;
            text-decoration: none;
            padding: 13px 15px;
            border-radius: 8px;
            margin-bottom: 8px;
        }

        .sidebar a:hover,
        .sidebar a.active {
            background: var(--maroon-light);
            color: white;
        }

        .main-content {
            margin-left: 250px;
            min-height: 100vh;
        }

        .topbar {
            background: white;
            padding: 18px 30px;
            border-bottom: 1px solid #eee;
        }

        .content {
            padding: 30px;
        }

        .card-custom {
            background: white;
            border: none;
            border-radius: 12px;
            box-shadow: 0 3px 12px rgba(0,0,0,.04);
        }

        .btn-maroon {
            background: var(--maroon);
            color: white;
            border: none;
        }

        .btn-maroon:hover {
            background: var(--maroon-dark);
            color: white;
        }

        .text-maroon {
            color: var(--maroon);
        }

        .table thead th {
            background: #781F36;
            color: white;
            white-space: nowrap;
        }

        .table td {
            vertical-align: middle;
        }

        @media(max-width: 768px) {
            .sidebar {
                width: 75px;
                padding: 15px 8px;
            }

            .sidebar .brand span,
            .sidebar .menu-text {
                display: none;
            }

            .sidebar a {
                text-align: center;
            }

            .main-content {
                margin-left: 75px;
            }

            .content {
                padding: 15px;
            }
        }


        /* TOMBOL MAROON */
        .btn-maroon {
            color: #fff;
            background-color: #781F36;
            border-color: #781F36;
            transition: 0.2s ease;
        }

        .btn-maroon:hover {
            color: #fff;
            background-color: #5E172A;
            border-color: #5E172A;
        }

        /* DROPDOWN */
        .dropdown-menu {
            border: none;
            border-radius: 8px;
            padding: 8px;
        }

        .dropdown-item {
            border-radius: 5px;
            padding: 9px 12px;
        }

        .dropdown-item:hover {
            background-color: #F9F0F3;
            color: #781F36;
        }

        /* RESPONSIVE */
        @media (max-width: 576px) {
            .container-fluid {
                padding-left: 12px;
                padding-right: 12px;
            }
        }

    </style>

    @stack('styles')
</head>

<body>

    <!-- SIDEBAR -->
    <aside class="sidebar">

        <div class="brand">
            <i class="bi bi-bank"></i>
            <span>INVESTMENT</span>
        </div>

        <small class="text-uppercase text-white-50 px-3">
            Menu Utama
        </small>

        <a href="{{ route('dashboard') }}"
           class="{{ request()->routeIs('dashboard') ? 'active' : '' }}">
            <i class="bi bi-grid"></i>
            <span class="menu-text"> Dashboard</span>
        </a>

        <a href="{{ route('investments.index') }}"
           class="{{ request()->routeIs('investments.*') ? 'active' : '' }}">
            <i class="bi bi-wallet2"></i>
            <span class="menu-text"> Data Investasi</span>
        </a>

    </aside>


    <!-- MAIN CONTENT -->
    <div class="main-content">

        <header class="topbar d-flex justify-content-between align-items-center">
            <div>
                <h6 class="mb-0 fw-bold text-maroon">
                    Sistem Pengelolaan Investasi
                </h6>
                <small class="text-muted">
                    Data Pengelolaan Investasi & Reksa Dana
                </small>
            </div>

            <div>
                <i class="bi bi-person-circle fs-4 text-maroon"></i>
            </div>
        </header>

        <main class="content">
            @yield('content')
        </main>

    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    @stack('scripts')

</body>
</html>

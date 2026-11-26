<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Daftar | Investasi Reksa Dana</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
          rel="stylesheet">

    <link rel="stylesheet"
          href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <style>
        :root {
            --maroon: #781F36;
            --maroon-dark: #5B172A;
            --maroon-light: #A9445B;
        }

        body {
            min-height: 100vh;
            margin: 0;
            display: flex;
            align-items: center;
            justify-content: center;
            background: linear-gradient(135deg, var(--maroon-dark), var(--maroon-light));
            font-family: Arial, sans-serif;
        }

        .register-card {
            width: 100%;
            max-width: 440px;
            background: white;
            border-radius: 16px;
            padding: 40px 35px;
            box-shadow: 0 20px 50px rgba(0,0,0,.25);
        }

        .register-logo {
            width: 70px;
            height: 70px;
            margin: 0 auto 20px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 50%;
            background: var(--maroon);
            color: white;
            font-size: 32px;
        }

        .form-control {
            padding: 12px 14px;
            border-radius: 10px;
        }

        .form-control:focus {
            border-color: var(--maroon-light);
            box-shadow: 0 0 0 .2rem rgba(169,68,91,.2);
        }

        /* Input password dengan tombol reveal */
        .input-group .form-control {
            border-top-right-radius: 0 !important;
            border-bottom-right-radius: 0 !important;
        }

        .input-group .btn {
            border-left: none;
        }

        .input-group .btn:hover,
        .input-group .btn:focus,
        .input-group .btn:active {
            background: #f5dde3;
            color: var(--maroon);
            box-shadow: none;
        }

        .btn-maroon {
            background: var(--maroon);
            color: white;
            border: none;
            padding: 12px;
            border-radius: 10px;
            font-weight: bold;
            transition: .2s ease;
        }

        .btn-maroon:hover {
            background: var(--maroon-dark);
            color: white;
        }

        .text-maroon {
            color: var(--maroon);
        }

        .alert {
            font-size: .9rem;
        }
    </style>
</head>
<body>

    <div class="register-card">

        <div class="register-logo">
            <i class="bi bi-person-plus"></i>
        </div>

        <h4 class="text-center fw-bold text-maroon mb-1">Buat Akun Baru</h4>
        <p class="text-center text-muted mb-4" style="font-size:.9rem">
            Daftarkan diri Anda untuk mengakses sistem
        </p>

        {{-- Pesan error --}}
        @if ($errors->any())
            <div class="alert alert-danger py-2">
                @foreach ($errors->all() as $error)
                    <div>{{ $error }}</div>
                @endforeach
            </div>
        @endif

        <form method="POST" action="{{ route('register') }}">
            @csrf

            <div class="mb-3">
                <label class="form-label fw-semibold">Nama Lengkap</label>
                <input type="text"
                       name="name"
                       value="{{ old('name') }}"
                       class="form-control"
                       placeholder="Masukkan nama Anda"
                       required
                       autofocus>
            </div>

            <div class="mb-3">
                <label class="form-label fw-semibold">Email</label>
                <input type="email"
                       name="email"
                       value="{{ old('email') }}"
                       class="form-control"
                       placeholder="contoh@email.com"
                       required>
            </div>

            <div class="mb-3">
                <label class="form-label fw-semibold">Password</label>
                <div class="input-group">
                    <input type="password"
                           id="password"
                           name="password"
                           class="form-control"
                           placeholder=""
                           required>
                    <button type="button"
                            class="btn btn-outline-secondary"
                            id="togglePassword"
                            title="Lihat/Sembunyikan password"
                            style="border-top-right-radius:10px;border-bottom-right-radius:10px">
                        <i class="bi bi-eye" id="togglePasswordIcon"></i>
                    </button>
                </div>
            </div>

            <div class="mb-4">
                <label class="form-label fw-semibold">Konfirmasi Password</label>
                <div class="input-group">
                    <input type="password"
                           id="password_confirmation"
                           name="password_confirmation"
                           class="form-control"
                           placeholder=""
                           required>
                    <button type="button"
                            class="btn btn-outline-secondary"
                            id="toggleConfirm"
                            title="Lihat/Sembunyikan password"
                            style="border-top-right-radius:10px;border-bottom-right-radius:10px">
                        <i class="bi bi-eye" id="toggleConfirmIcon"></i>
                    </button>
                </div>
            </div>

            <button type="submit" class="btn btn-maroon w-100">
                <i class="bi bi-person-plus me-1"></i> Daftar
            </button>
        </form>

        <p class="text-center text-muted mt-4 mb-0" style="font-size:.9rem">
            Sudah punya akun?
            <a href="{{ route('login') }}" class="fw-semibold text-maroon text-decoration-none">
                Login di sini
            </a>
        </p>

    </div>

    <script>
        // Toggle password (field password)
        document.getElementById('togglePassword').addEventListener('click', function () {
            const input = document.getElementById('password');
            const icon = document.getElementById('togglePasswordIcon');
            if (input.type === 'password') {
                input.type = 'text';
                icon.classList.remove('bi-eye');
                icon.classList.add('bi-eye-slash');
            } else {
                input.type = 'password';
                icon.classList.remove('bi-eye-slash');
                icon.classList.add('bi-eye');
            }
        });

        // Toggle password (field konfirmasi)
        document.getElementById('toggleConfirm').addEventListener('click', function () {
            const input = document.getElementById('password_confirmation');
            const icon = document.getElementById('toggleConfirmIcon');
            if (input.type === 'password') {
                input.type = 'text';
                icon.classList.remove('bi-eye');
                icon.classList.add('bi-eye-slash');
            } else {
                input.type = 'password';
                icon.classList.remove('bi-eye-slash');
                icon.classList.add('bi-eye');
            }
        });
    </script>

</body>
</html>

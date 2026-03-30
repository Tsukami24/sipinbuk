<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Register</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        :root {
            --navy: #0B132B;
            --primary: #2D6A4F;
            --accent: #74C69D;
            --card: #F8F9FA;
        }

        body {
            background-color: var(--navy);
        }

        .background-radial-gradient {
            background:
                radial-gradient(800px circle at 0% 0%,
                    rgba(116, 198, 157, 0.25),
                    transparent 60%),
                radial-gradient(800px circle at 100% 100%,
                    rgba(45, 106, 79, 0.35),
                    transparent 60%),
                var(--navy);
        }

        #radius-shape-1 {
            height: 150px;
            width: 150px;
            top: -40px;
            left: -90px;
            background: radial-gradient(var(--accent), var(--primary));
            z-index: -1;
        }

        #radius-shape-2 {
            bottom: -40px;
            right: -80px;
            width: 220px;
            height: 220px;
            background: radial-gradient(var(--accent), var(--primary));
            border-radius: 38% 62% 63% 37%;
            z-index: -1;
        }

        /* CARD */
        .bg-glass {
            background-color: var(--card);
            border-radius: 16px;
            box-shadow: 0 12px 30px rgba(0, 0, 0, 0.15);
        }

        .compact-card {
            max-width: 360px;
        }

        /* FORM */
        .auth-card-body {
            padding: 1.5rem;
        }

        .form-control {
            padding: 0.45rem 0.75rem;
            font-size: 0.85rem;
        }

        .form-control:focus {
            border-color: var(--primary) !important;
            box-shadow: 0 0 0 0.15rem rgba(116, 198, 157, 0.45) !important;
            outline: none !important;
        }

        .form-label {
            font-size: 0.8rem;
            font-weight: 600;
            color: #1B4332;
            margin-bottom: 0.25rem;
        }

        .form-outline {
            margin-bottom: 1rem;
        }

        /* BUTTON BASE */
        .btn-primary {
            background-color: var(--primary);
            border-color: var(--primary);
            padding: 0.5rem;
            font-size: 0.9rem;
        }

        .btn-primary:hover {
            background-color: #1B4332;
            border-color: #1B4332;
        }

        /* 🔥 MATIIN SEMUA STATE BIRU BOOTSTRAP */
        .btn-primary:focus,
        .btn-primary:focus-visible,
        .btn-primary:active,
        .btn-primary.active,
        .btn-check:focus+.btn-primary {
            background-color: #1B4332 !important;
            border-color: #1B4332 !important;
            box-shadow: none !important;
            outline: none !important;
        }

        /* LINK */
        a {
            color: var(--primary);
            font-weight: 500;
            text-decoration: none;
            font-size: 0.85rem;
        }

        a:hover {
            color: var(--accent);
        }
    </style>
</head>

<body>
    <section class="background-radial-gradient vh-100 d-flex align-items-center">
        <div class="container">
            <div class="row align-items-center">

                <!-- REGISTER CARD -->
                <div class="col-lg-6 position-relative d-flex justify-content-center mb-5 mb-lg-0">
                    <div id="radius-shape-1" class="position-absolute rounded-circle"></div>
                    <div id="radius-shape-2" class="position-absolute"></div>

                    <div class="card bg-glass compact-card w-100">
                        <div class="card-body auth-card-body">

                            <form method="POST" action="{{ route('register') }}">
                                @csrf

                                <div class="form-outline">
                                    <label class="form-label">Nama Lengkap</label>
                                    <input type="text" name="name" class="form-control" required>
                                </div>

                                <div class="form-outline">
                                    <label class="form-label">Email</label>
                                    <input type="email" name="email" class="form-control" required>
                                </div>

                                <div class="form-outline">
                                    <label class="form-label">No HP</label>
                                    <input type="text" name="phone" class="form-control" required>
                                </div>

                                <div class="form-outline">
                                    <label class="form-label">Password</label>
                                    <input type="password" name="password" class="form-control" required>
                                </div>

                                <div class="form-outline">
                                    <label class="form-label">Konfirmasi Password</label>
                                    <input type="password" name="password_confirmation" class="form-control" required>
                                </div>

                                <button type="submit" class="btn btn-primary w-100 mt-2">
                                    Daftar
                                </button>

                                <p class="text-center mt-3 mb-0" style="font-size:0.85rem;">
                                    Sudah punya akun?
                                    <a href="{{ route('login') }}">Login</a>
                                </p>
                            </form>

                        </div>
                    </div>
                </div>

                <!-- TEXT -->
                <div class="col-lg-6 text-white">
                    <h1 class="fw-bold mb-3">
                        Sistem Peminjaman <br>
                        <span style="color: var(--accent)">Buku Digital</span>
                    </h1>
                    <p class="opacity-75">
                        Kelola dan pinjam buku dengan mudah melalui sistem peminjaman
                        buku digital yang modern dan rapi.
                    </p>
                </div>

            </div>
        </div>
    </section>
</body>

</html>

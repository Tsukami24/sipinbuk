<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>SiPinBuk - Sistem Peminjaman Buku</title>

    <meta name="viewport" content="width=device-width, initial-scale=1">

    {{-- Bootstrap --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    {{-- Icons --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">

    <style>
        body {
            font-family: 'Segoe UI', sans-serif;
        }

        /* NAVBAR */
        .navbar {
            background: #0B132B;
        }

        .navbar-brand {
            font-weight: bold;
            color: #fff !important;
        }

        .nav-link {
            color: #ddd !important;
        }

        .nav-link:hover {
            color: #74C69D !important;
        }

        /* HERO */
        .hero {
            background: linear-gradient(135deg, #0B132B, #2D6A4F);
            color: #fff;
            padding: 100px 0;
        }

        .hero h1 {
            font-weight: bold;
        }

        .btn-main {
            background: #74C69D;
            border: none;
            color: #0B132B;
        }

        .btn-main:hover {
            background: #52b788;
        }

        /* FEATURES */
        .feature-card {
            border-radius: 16px;
            transition: 0.3s;
        }

        .feature-card:hover {
            transform: translateY(-5px);
        }

        /* BOOK CARD */
        .book-card {
            border-radius: 12px;
            overflow: hidden;
            transition: 0.3s;
        }

        .book-card:hover {
            transform: translateY(-4px);
        }

        .book-cover {
            aspect-ratio: 2/3;
            overflow: hidden;
        }

        .book-cover img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        /* CTA */
        .cta {
            background: #2D6A4F;
            color: #fff;
        }

        /* FOOTER */
        footer {
            background: #0B132B;
            color: #aaa;
        }
    </style>
</head>
<body>

{{-- NAVBAR --}}
<nav class="navbar navbar-expand-lg">
    <div class="container">
        <a class="navbar-brand" href="#">
            <i class="bi bi-book-half me-1"></i> SiPinBuk
        </a>

        <div class="ms-auto">
            <a href="{{ route('login') }}" class="btn btn-sm btn-outline-light me-2">Masuk</a>
        </div>
    </div>
</nav>

{{-- HERO --}}
<section class="hero text-center">
    <div class="container">
        <h1>Sistem Peminjaman Buku Digital</h1>
        <p class="mt-3 mb-4">
            Mudah, cepat, dan terintegrasi untuk siswa dan perpustakaan sekolah
        </p>

        <a href="{{ route('login') }}" class="btn btn-main px-4 py-2">
            Mulai Sekarang
        </a>
    </div>
</section>

{{-- FEATURES --}}
<section class="py-5">
    <div class="container text-center">

        <h4 class="fw-bold mb-4">Fitur Unggulan</h4>

        <div class="row g-4">

            <div class="col-md-4">
                <div class="card feature-card border-0 shadow-sm p-3">
                    <i class="bi bi-journal-plus fs-1 text-success"></i>
                    <h6 class="mt-3 fw-semibold">Peminjaman Mudah</h6>
                    <p class="text-muted small">
                        Ajukan peminjaman buku hanya dalam beberapa klik
                    </p>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card feature-card border-0 shadow-sm p-3">
                    <i class="bi bi-clock-history fs-1 text-primary"></i>
                    <h6 class="mt-3 fw-semibold">Riwayat Lengkap</h6>
                    <p class="text-muted small">
                        Lihat semua riwayat peminjaman dengan jelas
                    </p>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card feature-card border-0 shadow-sm p-3">
                    <i class="bi bi-exclamation-triangle fs-1 text-danger"></i>
                    <h6 class="mt-3 fw-semibold">Denda Otomatis</h6>
                    <p class="text-muted small">
                        Perhitungan denda otomatis jika terlambat
                    </p>
                </div>
            </div>

        </div>
    </div>
</section>

{{-- BOOK PREVIEW --}}
<section class="py-5 bg-light">
    <div class="container">

        <h4 class="fw-bold mb-4 text-center">Buku Terbaru</h4>

        <div class="row g-3">

            @foreach ($books as $book)
                <div class="col-6 col-md-3 col-lg-2">
                    <div class="card book-card shadow-sm border-0">

                        <div class="book-cover">
                            <img src="{{ $book->cover ? asset('storage/' . $book->cover) : 'https://via.placeholder.com/300x450' }}">
                        </div>

                        <div class="card-body p-2">
                            <h6 class="small text-truncate">{{ $book->title }}</h6>
                        </div>

                    </div>
                </div>
            @endforeach

        </div>

    </div>
</section>

{{-- CTA --}}
<section class="cta text-center py-5">
    <div class="container">
        <h4 class="fw-bold">Siap Memulai?</h4>
        <p class="mb-3">Gunakan SiPinBuk sekarang juga</p>

        <a href="{{ route('login') }}" class="btn btn-light px-4">
            Login Sekarang
        </a>
    </div>
</section>

{{-- FOOTER --}}
<footer class="py-3 text-center">
    <small>© 2026 SiPinBuk - Sistem Peminjaman Buku</small>
</footer>

</body>
</html>

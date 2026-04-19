<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SiPinBuk — Perpustakaan Digital Sekolah</title>

    {{-- Bootstrap --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    {{-- Bootstrap Icons --}}
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">

    <style>
        /* ===========================
           GLOBAL
        =========================== */
        * { box-sizing: border-box; }

        body {
            font-family: 'Segoe UI', system-ui, -apple-system, sans-serif;
            background-color: #F8F9FA;
            color: #0B132B;
            margin: 0;
            padding: 0;
        }

        /* ===========================
           NAVBAR
        =========================== */
        .lp-navbar {
            background-color: #0B132B;
            padding: 0 48px;
            height: 64px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            position: sticky;
            top: 0;
            z-index: 1030;
        }

        .lp-brand {
            display: flex;
            align-items: center;
            gap: 11px;
            text-decoration: none;
        }

        .brand-icon {
            width: 38px;
            height: 38px;
            background-color: #2D6A4F;
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }

        .brand-icon i { color: #74C69D; font-size: 1.1rem; }

        .brand-name {
            font-size: 1.1rem;
            font-weight: 800;
            color: #F8F9FA;
            display: block;
            line-height: 1.2;
        }

        .brand-name span { color: #74C69D; }

        .brand-tagline {
            font-size: 0.65rem;
            color: rgba(248, 249, 250, 0.4);
            display: block;
            letter-spacing: 0.2px;
        }

        .nav-right {
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .lp-nav-link {
            color: rgba(248, 249, 250, 0.7);
            text-decoration: none;
            padding: 7px 14px;
            border-radius: 6px;
            font-size: 0.875rem;
            transition: all 0.2s ease;
        }

        .lp-nav-link:hover {
            color: #74C69D;
            background-color: rgba(116, 198, 157, 0.1);
        }

        .btn-nav-login {
            background-color: #2D6A4F;
            color: #F8F9FA;
            padding: 8px 20px;
            border-radius: 6px;
            font-size: 0.875rem;
            font-weight: 600;
            text-decoration: none;
            transition: background-color 0.2s ease;
        }

        .btn-nav-login:hover { background-color: #245a41; color: #F8F9FA; }

        .navbar-toggler-lp {
            display: none;
            background: transparent;
            border: 1.5px solid rgba(116, 198, 157, 0.4);
            padding: 6px 10px;
            border-radius: 6px;
            cursor: pointer;
        }

        .navbar-toggler-lp i { color: #74C69D; font-size: 1.1rem; }

        @media (max-width: 768px) {
            .lp-navbar { padding: 12px 20px; flex-wrap: wrap; height: auto; gap: 10px; }
            .navbar-toggler-lp { display: block; }
            .nav-right { display: none; width: 100%; flex-direction: column; gap: 6px; padding-bottom: 6px; }
            .nav-right.open { display: flex; }
            .lp-nav-link, .btn-nav-login { width: 100%; text-align: center; }
        }

        /* ===========================
           HERO
        =========================== */
        .lp-hero {
            background-color: #0B132B;
            padding: 72px 48px;
            display: flex;
            align-items: center;
            gap: 48px;
        }

        .hero-left { flex: 1; }

        .school-badge {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            background-color: rgba(116, 198, 157, 0.1);
            border: 1px solid rgba(116, 198, 157, 0.3);
            color: #74C69D;
            padding: 5px 16px;
            border-radius: 20px;
            font-size: 0.72rem;
            font-weight: 700;
            letter-spacing: 0.5px;
            margin-bottom: 22px;
        }

        .hero-heading {
            font-size: 2.6rem;
            font-weight: 800;
            color: #F8F9FA;
            line-height: 1.18;
            margin-bottom: 16px;
        }

        .hero-heading span { color: #74C69D; }

        .hero-desc {
            color: rgba(248, 249, 250, 0.6);
            font-size: 0.97rem;
            line-height: 1.78;
            max-width: 450px;
            margin-bottom: 32px;
        }

        .hero-cta { display: flex; gap: 14px; flex-wrap: wrap; }

        .btn-hero-primary {
            background-color: #74C69D;
            color: #0B132B;
            padding: 12px 28px;
            border-radius: 8px;
            font-size: 0.93rem;
            font-weight: 700;
            text-decoration: none;
            display: inline-block;
            transition: background-color 0.2s ease;
        }

        .btn-hero-primary:hover { background-color: #5db88a; color: #0B132B; }

        .btn-hero-outline {
            background-color: transparent;
            color: #74C69D;
            padding: 12px 28px;
            border-radius: 8px;
            font-size: 0.93rem;
            font-weight: 600;
            text-decoration: none;
            border: 1.5px solid rgba(116, 198, 157, 0.4);
            display: inline-block;
            transition: all 0.2s ease;
        }

        .btn-hero-outline:hover {
            border-color: #74C69D;
            background-color: rgba(116, 198, 157, 0.08);
            color: #74C69D;
        }

        .hero-right {
            flex: 0 0 270px;
            display: flex;
            flex-direction: column;
            gap: 12px;
        }

        .hero-stat-card {
            background-color: rgba(255, 255, 255, 0.06);
            border: 1px solid rgba(116, 198, 157, 0.2);
            border-radius: 12px;
            padding: 18px 20px;
        }

        .hero-stat-lbl {
            font-size: 0.68rem;
            color: rgba(248, 249, 250, 0.4);
            text-transform: uppercase;
            letter-spacing: 0.8px;
            margin-bottom: 4px;
        }

        .hero-stat-val { font-size: 1.7rem; font-weight: 800; color: #74C69D; }

        .hero-stat-sub {
            font-size: 0.77rem;
            color: rgba(248, 249, 250, 0.45);
            margin-top: 3px;
        }

        .hero-mini {
            background-color: rgba(255, 255, 255, 0.04);
            border: 1px solid rgba(116, 198, 157, 0.15);
            border-radius: 10px;
            padding: 13px 16px;
            display: flex;
            align-items: center;
            gap: 13px;
        }

        .hero-mini-icon {
            width: 36px;
            height: 36px;
            background-color: #2D6A4F;
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }

        .hero-mini-icon i { color: #74C69D; font-size: 0.95rem; }
        .hero-mini-title { font-size: 0.83rem; font-weight: 600; color: #F8F9FA; }
        .hero-mini-sub { font-size: 0.73rem; color: rgba(248, 249, 250, 0.42); margin-top: 2px; }

        @media (max-width: 992px) {
            .lp-hero { flex-direction: column; padding: 56px 28px; }
            .hero-right { flex: 1; width: 100%; }
            .hero-heading { font-size: 1.9rem; }
        }

        /* ===========================
           STATS BAR
        =========================== */
        .lp-stats-bar {
            background-color: #2D6A4F;
            padding: 20px 48px;
            display: flex;
            justify-content: space-around;
            flex-wrap: wrap;
            gap: 16px;
        }

        .stat-item { text-align: center; }
        .stat-num { font-size: 1.45rem; font-weight: 800; color: #F8F9FA; }
        .stat-lbl { font-size: 0.72rem; color: rgba(248, 249, 250, 0.65); margin-top: 2px; }

        /* ===========================
           FEATURES
        =========================== */
        .lp-features {
            padding: 64px 48px;
            background-color: #F8F9FA;
        }

        .section-tag {
            font-size: 0.7rem;
            font-weight: 700;
            letter-spacing: 1.5px;
            color: #2D6A4F;
            text-transform: uppercase;
            margin-bottom: 8px;
        }

        .section-heading {
            font-size: 1.65rem;
            font-weight: 800;
            color: #0B132B;
            margin-bottom: 10px;
        }

        .section-sub {
            color: #5F5E5A;
            font-size: 0.9rem;
            line-height: 1.75;
            max-width: 500px;
            margin-bottom: 36px;
        }

        .features-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 16px;
            margin-bottom: 28px;
        }

        .feat-card {
            background-color: #fff;
            border: 1px solid #E4E4DC;
            border-radius: 12px;
            padding: 22px 18px;
            transition: border-color 0.2s ease, transform 0.2s ease;
        }

        .feat-card:hover { border-color: #2D6A4F; transform: translateY(-2px); }

        .feat-icon {
            width: 44px;
            height: 44px;
            background-color: #E9F5EF;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 14px;
        }

        .feat-icon i { color: #2D6A4F; font-size: 1.15rem; }
        .feat-title { font-size: 0.92rem; font-weight: 700; color: #0B132B; margin-bottom: 7px; }
        .feat-desc { font-size: 0.81rem; color: #5F5E5A; line-height: 1.65; }

        /* ===========================
           ANNOUNCEMENT BOX
        =========================== */
        .announce-box {
            background-color: #fff;
            border: 1px solid #E4E4DC;
            border-radius: 12px;
            padding: 20px 22px;
        }

        .announce-header {
            display: flex;
            align-items: center;
            gap: 8px;
            margin-bottom: 16px;
        }

        .announce-dot { width: 8px; height: 8px; border-radius: 50%; background-color: #74C69D; }
        .announce-title { font-size: 0.9rem; font-weight: 700; color: #0B132B; }

        .announce-item {
            display: flex;
            align-items: flex-start;
            gap: 12px;
            padding: 10px 0;
            border-bottom: 1px solid #F0F0E8;
        }

        .announce-item:last-child { border-bottom: none; padding-bottom: 0; }

        .announce-icon {
            width: 32px;
            height: 32px;
            background-color: #E9F5EF;
            border-radius: 7px;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
            margin-top: 1px;
        }

        .announce-icon i { color: #2D6A4F; font-size: 0.85rem; }
        .announce-text { font-size: 0.82rem; color: #0B132B; font-weight: 500; line-height: 1.45; }
        .announce-date { font-size: 0.71rem; color: #888780; margin-top: 3px; }

        /* ===========================
           HOW IT WORKS
        =========================== */
        .lp-steps { background-color: #0B132B; padding: 64px 48px; }
        .lp-steps .section-heading { color: #F8F9FA; }
        .lp-steps .section-sub { color: rgba(248, 249, 250, 0.5); }

        .steps-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 0;
            margin-top: 36px;
        }

        .step-item {
            padding: 0 28px;
            border-right: 1px solid rgba(116, 198, 157, 0.2);
            text-align: center;
        }

        .step-item:last-child { border-right: none; }

        .step-num {
            width: 44px;
            height: 44px;
            border-radius: 50%;
            background-color: #2D6A4F;
            color: #74C69D;
            font-size: 1rem;
            font-weight: 800;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 14px;
        }

        .step-title { font-size: 0.9rem; font-weight: 700; color: #F8F9FA; margin-bottom: 8px; }
        .step-desc { font-size: 0.79rem; color: rgba(248, 249, 250, 0.48); line-height: 1.65; }

        @media (max-width: 768px) {
            .steps-grid { grid-template-columns: 1fr; }
            .step-item { border-right: none; border-bottom: 1px solid rgba(116, 198, 157, 0.2); padding: 20px 0; }
            .step-item:last-child { border-bottom: none; }
        }

        /* ===========================
           CTA
        =========================== */
        .lp-cta { background-color: #74C69D; padding: 64px 48px; text-align: center; }
        .lp-cta h2 { font-size: 1.8rem; font-weight: 800; color: #0B132B; margin-bottom: 12px; }
        .lp-cta p { color: rgba(11, 19, 43, 0.62); font-size: 0.95rem; margin-bottom: 28px; }

        .btn-cta-dark {
            background-color: #0B132B;
            color: #74C69D;
            padding: 13px 38px;
            border-radius: 8px;
            font-size: 0.97rem;
            font-weight: 700;
            text-decoration: none;
            display: inline-block;
            transition: background-color 0.2s ease;
        }

        .btn-cta-dark:hover { background-color: #162040; color: #74C69D; }

        /* ===========================
           FOOTER
        =========================== */
        .lp-footer {
            background-color: #0B132B;
            padding: 22px 48px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            flex-wrap: wrap;
            gap: 10px;
        }

        .footer-brand { color: #74C69D; font-weight: 700; font-size: 0.87rem; }
        .footer-copy { color: rgba(248, 249, 250, 0.35); font-size: 0.73rem; }

        @media (max-width: 768px) {
            .lp-hero, .lp-features, .lp-steps,
            .lp-cta, .lp-footer, .lp-stats-bar {
                padding-left: 20px;
                padding-right: 20px;
            }
            .lp-footer { flex-direction: column; text-align: center; }
        }

        /* ===========================
           FORM FOCUS (konsisten)
        =========================== */
        .form-control:focus, .form-select:focus {
            border-color: #2D6A4F !important;
            box-shadow: 0 0 0 0.2rem rgba(45, 106, 79, 0.25) !important;
        }

        ::selection { background-color: rgba(45, 106, 79, 0.35); color: #0B132B; }
    </style>
</head>

<body>

    {{-- ===== NAVBAR ===== --}}
    <nav class="lp-navbar">
        <a class="lp-brand" href="#">
            <div class="brand-icon">
                <i class="bi bi-book-half"></i>
            </div>
            <div>
                <span class="brand-name">Si<span>Pin</span>Buk</span>
                <span class="brand-tagline">Perpustakaan Digital Sekolah</span>
            </div>
        </a>

        <button class="navbar-toggler-lp" id="navToggler" aria-label="Toggle menu">
            <i class="bi bi-list" id="navIcon"></i>
        </button>

        <div class="nav-right" id="navLinks">
            <a href="#fitur" class="lp-nav-link">Fitur</a>
            <a href="#cara-pakai" class="lp-nav-link">Cara Pakai</a>
            <a href="{{ route('login') }}" class="btn-nav-login">
                <i class="bi bi-box-arrow-in-right me-1"></i> Masuk
            </a>
        </div>
    </nav>

    {{-- ===== HERO ===== --}}
    <section class="lp-hero">
        <div class="hero-left">
            <div class="school-badge">
                <i class="bi bi-mortarboard-fill" style="font-size: .85rem;"></i>
                Perpustakaan Sekolah — Sistem Digital
            </div>
            <h1 class="hero-heading">
                Perpustakaan Sekolah<br>
                di Genggaman <span>Siswa</span>
            </h1>
            <p class="hero-desc">
                Pinjam buku pelajaran, novel, dan referensi dengan mudah.
                Tidak perlu antre panjang — cukup cari, pinjam, dan baca.
            </p>
            <div class="hero-cta">
                <a href="{{ route('login') }}" class="btn-hero-primary">
                    <i class="bi bi-arrow-right-circle me-1"></i> Pinjam Sekarang
                </a>
                <a href="#fitur" class="btn-hero-outline">
                    <i class="bi bi-grid me-1"></i> Lihat Fitur
                </a>
            </div>
        </div>

        <div class="hero-right">
            <div class="hero-stat-card">
                <div class="hero-stat-lbl">Koleksi Buku</div>
                <div class="hero-stat-val">1.240</div>
                <div class="hero-stat-sub">tersedia di perpustakaan</div>
            </div>
            <div class="hero-mini">
                <div class="hero-mini-icon"><i class="bi bi-journals"></i></div>
                <div>
                    <div class="hero-mini-title">Buku Pelajaran Lengkap</div>
                    <div class="hero-mini-sub">Semua mata pelajaran tersedia</div>
                </div>
            </div>
            <div class="hero-mini">
                <div class="hero-mini-icon"><i class="bi bi-bell-fill"></i></div>
                <div>
                    <div class="hero-mini-title">Tenggat Waktu Jelas</div>
                    <div class="hero-mini-sub">Pengingat otomatis via sistem</div>
                </div>
            </div>
        </div>
    </section>

    {{-- ===== STATS BAR ===== --}}
    <div class="lp-stats-bar">
        <div class="stat-item">
            <div class="stat-num">1.240+</div>
            <div class="stat-lbl">Koleksi Buku</div>
        </div>
        <div class="stat-item">
            <div class="stat-num">520+</div>
            <div class="stat-lbl">Siswa Terdaftar</div>
        </div>
        <div class="stat-item">
            <div class="stat-num">4.800+</div>
            <div class="stat-lbl">Total Peminjaman</div>
        </div>
    </div>

    {{-- ===== FEATURES ===== --}}
    <section class="lp-features" id="fitur">
        <div class="section-tag">Fitur Unggulan</div>
        <h2 class="section-heading">Semua kebutuhan perpustakaan</h2>
        <p class="section-sub">
            Dirancang untuk siswa dan guru agar proses peminjaman buku
            di sekolah jadi lebih teratur dan efisien.
        </p>

        <div class="features-grid">
            <div class="feat-card">
                <div class="feat-icon"><i class="bi bi-search"></i></div>
                <div class="feat-title">Cari Buku Mudah</div>
                <p class="feat-desc">Temukan buku berdasarkan judul, pengarang, atau kategori mata pelajaran.</p>
            </div>
            <div class="feat-card">
                <div class="feat-icon"><i class="bi bi-people-fill"></i></div>
                <div class="feat-title">Data Siswa & Guru</div>
                <p class="feat-desc">Setiap anggota perpustakaan punya akun pribadi dengan riwayat lengkap.</p>
            </div>
            <div class="feat-card">
                <div class="feat-icon"><i class="bi bi-check2-circle"></i></div>
                <div class="feat-title">Proses Pengembalian</div>
                <p class="feat-desc">Catat pengembalian dengan cepat, lengkap dengan status tepat waktu atau terlambat.</p>
            </div>
            <div class="feat-card">
                <div class="feat-icon"><i class="bi bi-clock-history"></i></div>
                <div class="feat-title">Riwayat Peminjaman</div>
                <p class="feat-desc">Siswa bisa melihat semua buku yang pernah dipinjam beserta tanggal dan statusnya.</p>
            </div>
            <div class="feat-card">
                <div class="feat-icon"><i class="bi bi-file-earmark-bar-graph"></i></div>
                <div class="feat-title">Laporan Admin</div>
                <p class="feat-desc">Pustakawan bisa cetak laporan peminjaman harian, mingguan, atau bulanan.</p>
            </div>
            <div class="feat-card">
                <div class="feat-icon"><i class="bi bi-shield-lock-fill"></i></div>
                <div class="feat-title">Akses Aman</div>
                <p class="feat-desc">Login terpisah untuk siswa, guru, dan admin perpustakaan dengan hak akses berbeda.</p>
            </div>
        </div>

        {{-- Pengumuman Perpustakaan --}}
        <div class="announce-box">
            <div class="announce-header">
                <div class="announce-dot"></div>
                <div class="announce-title">Pengumuman Perpustakaan</div>
            </div>
            <div class="announce-item">
                <div class="announce-icon"><i class="bi bi-clock"></i></div>
                <div>
                    <div class="announce-text">Jam operasional perpustakaan: Senin–Jumat, 07.00–15.00 WIB</div>
                    <div class="announce-date">Informasi rutin</div>
                </div>
            </div>
            <div class="announce-item">
                <div class="announce-icon"><i class="bi bi-book-fill"></i></div>
                <div>
                    <div class="announce-text">Koleksi buku baru semester genap 2025/2026 sudah tersedia</div>
                    <div class="announce-date">April 2026</div>
                </div>
            </div>
        </div>
    </section>

    {{-- ===== HOW IT WORKS ===== --}}
    <section class="lp-steps" id="cara-pakai">
        <div class="section-tag" style="color: #74C69D;">Cara Pakai</div>
        <h2 class="section-heading">Pinjam buku dalam 3 langkah</h2>
        <p class="section-sub">Tidak perlu bingung — prosesnya simpel dan cepat.</p>

        <div class="steps-grid">
            <div class="step-item">
                <div class="step-num">1</div>
                <div class="step-title">Login dengan NIS / NIP</div>
                <p class="step-desc">Masuk menggunakan Nomor Induk Siswa atau NIP guru yang diberikan pihak sekolah.</p>
            </div>
            <div class="step-item">
                <div class="step-num">2</div>
                <div class="step-title">Cari & Pilih Buku</div>
                <p class="step-desc">Telusuri katalog, cek ketersediaan, lalu ajukan peminjaman buku yang diinginkan.</p>
            </div>
            <div class="step-item">
                <div class="step-num">3</div>
                <div class="step-title">Ambil & Kembalikan</div>
                <p class="step-desc">Ambil buku di perpustakaan, pantau tenggat waktu, dan kembalikan sebelum jatuh tempo.</p>
            </div>
        </div>
    </section>

    {{-- ===== CTA ===== --}}
    <section class="lp-cta">
        <h2>Yuk, mulai pakai SiPinBuk!</h2>
        <p>Masuk dengan akun sekolahmu dan nikmati kemudahan meminjam buku kapan saja.</p>
        <a href="{{ route('login') }}" class="btn-cta-dark">
            <i class="bi bi-box-arrow-in-right me-2"></i>Masuk Sekarang
        </a>
    </section>

    {{-- ===== FOOTER ===== --}}
    <footer class="lp-footer">
        <div class="footer-brand">
            <i class="bi bi-book-half me-1"></i>
            SiPinBuk — Sistem Informasi Peminjaman Buku
        </div>
        <div class="footer-copy">
            &copy; {{ date('Y') }} Perpustakaan Sekolah. All rights reserved.
        </div>
    </footer>

    {{-- JS --}}
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        const toggler  = document.getElementById('navToggler');
        const navLinks = document.getElementById('navLinks');
        const navIcon  = document.getElementById('navIcon');

        toggler.addEventListener('click', () => {
            navLinks.classList.toggle('open');
            navIcon.className = navLinks.classList.contains('open')
                ? 'bi bi-x-lg'
                : 'bi bi-list';
        });

        document.querySelectorAll('a[href^="#"]').forEach(a => {
            a.addEventListener('click', function (e) {
                const target = document.querySelector(this.getAttribute('href'));
                if (target) {
                    e.preventDefault();
                    target.scrollIntoView({ behavior: 'smooth' });
                    navLinks.classList.remove('open');
                    navIcon.className = 'bi bi-list';
                }
            });
        });
    </script>

</body>
</html>

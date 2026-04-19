<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'SiPinBuk')</title>

    {{-- Bootstrap --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    {{-- Bootstrap Icons --}}
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">

    <style>
        body {
            background-color: #F8F9FA;
            color: #0B132B;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        /* =============================
           NAVBAR
        ============================= */
        .user-navbar {
            background-color: #0B132B;
            padding: 0 24px;
            height: 60px;
            position: sticky;
            top: 0;
            z-index: 1030;
        }

        .user-navbar .navbar-brand {
            color: #74C69D;
            font-weight: 700;
            font-size: 1.2rem;
            text-decoration: none;
            letter-spacing: 0.5px;
        }

        .user-navbar .nav-link {
            color: #F8F9FA;
            border-radius: 6px;
            padding: 8px 12px;
            font-size: 0.9rem;
            transition: all 0.2s ease;
        }

        .user-navbar .nav-link:hover {
            background-color: rgba(116, 198, 157, 0.15);
            color: #74C69D;
        }

        .user-navbar .nav-link.active {
            background-color: #2D6A4F;
            color: #F8F9FA !important;
            font-weight: 600;
        }

        .user-navbar .nav-link i {
            font-size: 0.95rem;
        }

        /* Avatar / Dropdown */
        .user-avatar {
            width: 36px;
            height: 36px;
            border-radius: 50%;
            background-color: #2D6A4F;
            color: #74C69D;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 0.8rem;
            font-weight: 700;
            border: 1.5px solid #74C69D;
            cursor: pointer;
            text-decoration: none;
        }

        .user-avatar:hover {
            background-color: #74C69D;
            color: #0B132B;
        }

        .dropdown-menu {
            border: 1px solid #dee2e6;
            border-radius: 8px;
            box-shadow: 0 4px 16px rgba(11, 19, 43, 0.12);
        }

        .dropdown-menu .dropdown-item {
            font-size: 0.875rem;
            padding: 8px 16px;
            transition: all 0.15s ease;
        }

        .dropdown-menu .dropdown-item:hover {
            background-color: rgba(116, 198, 157, 0.2);
            color: #0B132B;
        }

        .dropdown-menu .dropdown-item.active,
        .dropdown-menu .dropdown-item:active {
            background-color: #2D6A4F !important;
            color: #F8F9FA !important;
        }

        .dropdown-menu .dropdown-item.text-danger:hover {
            background-color: rgba(220, 53, 69, 0.1) !important;
            color: #DC3545 !important;
        }

        /* Hamburger mobile */
        .navbar-toggler {
            border-color: rgba(116, 198, 157, 0.5);
        }

        .navbar-toggler-icon {
            background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 30 30'%3e%3cpath stroke='rgba%28116, 198, 157, 0.9%29' stroke-linecap='round' stroke-miterlimit='10' stroke-width='2' d='M4 7h22M4 15h22M4 23h22'/%3e%3c/svg%3e");
        }

        /* =============================
           MAIN CONTENT
        ============================= */
        .user-content {
            flex: 1;
            padding: 28px 0;
        }

        /* =============================
           FLASH MESSAGES
        ============================= */
        .alert {
            border-radius: 8px;
            font-size: 0.9rem;
        }

        /* =============================
           FORM FOCUS THEME
        ============================= */
        .form-control:focus,
        .form-select:focus {
            border-color: #2D6A4F !important;
            box-shadow: 0 0 0 0.2rem rgba(45, 106, 79, 0.25) !important;
            outline: none !important;
        }

        .form-select option:checked,
        .form-select option:active {
            background-color: #2D6A4F !important;
            color: #fff !important;
        }

        .form-select {
            background-color: #fff;
            color: #0B132B;
        }

        input[type="file"]:focus {
            box-shadow: none !important;
            border-color: #2D6A4F !important;
        }

        /* =============================
           BUTTONS THEME
        ============================= */
        .btn-primary {
            background-color: #2D6A4F;
            border-color: #2D6A4F;
        }

        .btn-primary:hover,
        .btn-primary:focus {
            background-color: #245a41;
            border-color: #245a41;
        }

        .btn-outline-primary {
            color: #2D6A4F;
            border-color: #2D6A4F;
        }

        .btn-outline-primary:hover {
            background-color: #2D6A4F;
            border-color: #2D6A4F;
            color: #fff;
        }

        /* =============================
           TEXT SELECTION
        ============================= */
        ::selection {
            background-color: rgba(45, 106, 79, 0.35);
            color: #0B132B;
        }

        ::-moz-selection {
            background-color: rgba(45, 106, 79, 0.35);
            color: #0B132B;
        }

        /* =============================
           FOOTER
        ============================= */
        .user-footer {
            background-color: #0B132B;
            color: rgba(248, 249, 250, 0.5);
            text-align: center;
            padding: 16px 24px;
            font-size: 0.8rem;
        }

        .user-footer span {
            color: #74C69D;
        }
    </style>

    @stack('styles')
</head>

<body>

    {{-- Navbar --}}
    @include('components.user.navbar')

    {{-- Flash Messages --}}
    <div class="container mt-3">
        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="bi bi-check-circle-fill me-2"></i>{{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @if (session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <i class="bi bi-exclamation-circle-fill me-2"></i>{{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @if (session('warning'))
            <div class="alert alert-warning alert-dismissible fade show" role="alert">
                <i class="bi bi-exclamation-triangle-fill me-2"></i>{{ session('warning') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif
    </div>

    {{-- Content --}}
    <main class="user-content">
        <div class="container">
            @yield('content')
        </div>
    </main>

    {{-- Footer --}}
    <footer class="user-footer">
        &copy; {{ date('Y') }} <span>SiPinBuk</span> &mdash; Sistem Peminjaman Buku
    </footer>

    {{-- JS --}}
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

    @stack('scripts')
</body>

</html>

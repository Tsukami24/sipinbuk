<nav class="navbar user-navbar navbar-expand-lg">

    {{-- BRAND --}}
    <a class="navbar-brand" href="{{ route('user.home') }}">
        <i class="bi bi-book-half me-1"></i> SiPinBuk
    </a>

    {{-- TOGGLER --}}
    <button class="navbar-toggler ms-auto me-2" type="button" data-bs-toggle="collapse" data-bs-target="#userNavbarMenu">
        <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="userNavbarMenu">

        {{-- LEFT MENU --}}
        <ul class="navbar-nav me-auto mb-2 mb-lg-0 gap-1">
            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('user.home') ? 'active' : '' }}"
                    href="{{ route('user.home') }}">
                    <i class="bi bi-house me-1"></i> Beranda
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('borrows.history*') ? 'active' : '' }}"
                    href="{{ route('borrows.history') }}">
                    <i class="bi bi-clock-history me-1"></i> Riwayat
                </a>
            </li>
        </ul>

        {{-- SEARCH --}}
        <form action="{{ route('user.home') }}" method="GET"
            class="d-flex mx-lg-3 my-2 my-lg-0 flex-grow-1 search-box">

            <div class="input-group">

                <span class="input-group-text bg-white border-0">
                    <i class="bi bi-search text-muted"></i>
                </span>

                <input type="text" name="search" value="{{ request('search') }}"
                    class="form-control border-0 shadow-none" placeholder="Cari buku, penulis..."
                    onkeyup="clearTimeout(this.delay); this.delay = setTimeout(() => this.form.submit(), 500)">

                {{-- penting biar filter gak hilang --}}
                <input type="hidden" name="category" value="{{ request('category') }}">
                <input type="hidden" name="subcategory" value="{{ request('subcategory') }}">

                @if (request('search'))
                    <a href="{{ route('user.home') }}" class="btn btn-light border-0">
                        <i class="bi bi-x"></i>
                    </a>
                @endif

            </div>
        </form>

        {{-- RIGHT SIDE --}}
        <ul class="navbar-nav ms-lg-2 align-items-center">

            @auth
                @php
                    $notifCount = auth()->user()->unreadNotifications->count();
                @endphp

                {{-- NOTIFICATION --}}
                <li class="nav-item dropdown me-3">

                    <a class="nav-link position-relative" href="#" role="button" data-bs-toggle="dropdown">

                        <i class="bi bi-bell-fill fs-5 notif-icon"></i>

                        @if ($notifCount > 0)
                            <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                                {{ $notifCount }}
                            </span>
                        @endif

                    </a>

                    {{-- NOTIF DROPDOWN --}}
                    <ul class="dropdown-menu dropdown-menu-end shadow-sm notif-dropdown p-0">

                        {{-- HEADER --}}
                        <li class="notif-header px-3 py-2 fw-bold">
                            Notifikasi
                        </li>

                        <li>
                            <hr class="dropdown-divider m-0">
                        </li>

                        {{-- BODY SCROLL --}}
                        <div class="notif-body">

                            @forelse(auth()->user()->unreadNotifications->take(10) as $notif)
                                <li>
                                    <a class="dropdown-item small py-2" href="#">

                                        <div class="fw-semibold">
                                            {{ $notif->data['title'] ?? 'Notifikasi' }}
                                        </div>

                                        <div class="text-muted" style="font-size:12px;">
                                            {{ $notif->data['message'] ?? '' }}
                                        </div>

                                    </a>
                                </li>
                            @empty
                                <li class="px-3 py-3 text-muted small">
                                    Tidak ada notifikasi
                                </li>
                            @endforelse

                        </div>

                        {{--  FOOTER  --}}
                        <li class="notif-footer">
                            <hr class="dropdown-divider m-0">

                            <form method="POST" action="{{ route('notifications.readAll') }}">
                                @csrf
                                <button class="btn btn-sm w-100 text-success py-2">
                                    Tandai semua dibaca
                                </button>
                            </form>
                        </li>

                    </ul>
                </li>

                {{-- USER --}}
                <li class="nav-item dropdown">

                    <a class="user-avatar dropdown-toggle d-flex align-items-center justify-content-center" href="#"
                        data-bs-toggle="dropdown">

                        {{ strtoupper(substr(auth()->user()->name, 0, 2)) }}
                    </a>

                    <ul class="dropdown-menu dropdown-menu-end mt-2">

                        <li>
                            <span class="dropdown-item-text text-muted">
                                Masuk sebagai<br>
                                <strong>{{ auth()->user()->name }}</strong>
                            </span>
                        </li>

                        <li>
                            <hr class="dropdown-divider">
                        </li>

                        <li>
                            <a class="dropdown-item" href="{{ route('user.profile') }}">
                                <i class="bi bi-person me-2"></i> Profil Saya
                            </a>
                        </li>

                        <li>
                            <hr class="dropdown-divider">
                        </li>

                        <li>
                            <form action="{{ route('logout') }}" method="POST">
                                @csrf
                                <button class="dropdown-item text-danger">
                                    <i class="bi bi-box-arrow-right me-2"></i> Keluar
                                </button>
                            </form>
                        </li>

                    </ul>

                </li>
            @else
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('login') }}">
                        <i class="bi bi-box-arrow-in-right me-1"></i> Masuk
                    </a>
                </li>
            @endauth

        </ul>

    </div>
</nav>

<style>
    .search-box {
        max-width: 420px;
        width: 100%;
    }

    .search-box .input-group {
        border: 1px solid #e9ecef;
        border-radius: 12px;
        overflow: hidden;
        background: #fff;
    }

    .search-box .form-control {
        font-size: 0.9rem;
    }

    .search-box .input-group:focus-within {
        border-color: #2D6A4F;
        box-shadow: 0 0 0 0.15rem rgba(45, 106, 79, 0.15);
    }

    .navbar .badge {
        font-size: 10px;
    }

    .user-avatar {
        width: 38px;
        height: 38px;
        background: #2D6A4F;
        color: #fff;
        border-radius: 50%;
        font-weight: bold;
        font-size: 14px;
        text-decoration: none;
    }

    .notif-icon {
        color: #fff;
        transition: 0.2s;
    }

    .nav-link:hover .notif-icon {
        color: #2D6A4F;
        transform: scale(1.05);
    }

    .navbar .badge {
        font-size: 10px;
        padding: 4px 6px;
        border-radius: 999px;
    }

    .notif-dropdown {
        width: 320px;
    }

    .notif-header {
        background: #fff;
        position: sticky;
        top: 0;
        z-index: 2;
    }

    .notif-body {
        max-height: 300px;
        overflow-y: auto;
    }

    .notif-footer {
        background: #fff;
        position: sticky;
        bottom: 0;
    }

    .notif-body::-webkit-scrollbar {
        width: 6px;
    }

    .notif-body::-webkit-scrollbar-thumb {
        background: #ccc;
        border-radius: 10px;
    }
</style>

<nav class="navbar user-navbar navbar-expand-lg">

    {{-- Brand --}}
    <a class="navbar-brand" href="{{ route('user.home') }}">
        <i class="bi bi-book-half me-1"></i> SiPinBuk
    </a>

    <button class="navbar-toggler ms-auto me-2" type="button"
        data-bs-toggle="collapse" data-bs-target="#userNavbarMenu"
        aria-controls="userNavbarMenu" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>

    {{-- Menu --}}
    <div class="collapse navbar-collapse" id="userNavbarMenu">

        {{-- Nav Links (kiri) --}}
        <ul class="navbar-nav me-auto mb-2 mb-lg-0 gap-1">
            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('user.home') ? 'active' : '' }}"
                    href="{{ route('user.home') }}">
                    <i class="bi bi-house me-1"></i> Beranda
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('user.pinjaman*') ? 'active' : '' }}"
                    {{-- href="{{ route('user.pinjaman') }}"> --}}
                    <i class="bi bi-bookmark-check me-1"></i> Pinjaman Saya
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('borrows.history*') ? 'active' : '' }}"
                    href="{{ route('borrows.history') }}">
                    <i class="bi bi-clock-history me-1"></i> Riwayat Peminjaman
                </a>
            </li>
        </ul>

        {{-- User Dropdown (kanan) --}}
        <ul class="navbar-nav ms-lg-2">
            @auth
                <li class="nav-item dropdown">
                    <a class="user-avatar dropdown-toggle d-flex align-items-center justify-content-center"
                        href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false"
                        style="text-decoration: none;">
                        {{-- Inisial nama user --}}
                        {{ strtoupper(substr(auth()->user()->name, 0, 2)) }}
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end mt-2">
                        <li>
                            <span class="dropdown-item-text text-muted" style="font-size: 0.8rem; padding: 6px 16px;">
                                Masuk sebagai<br>
                                <strong class="text-dark">{{ auth()->user()->name }}</strong>
                            </span>
                        </li>
                        <li><hr class="dropdown-divider"></li>
                        <li>
                            <a class="dropdown-item {{ request()->routeIs('user.profil*') ? 'active' : '' }}"
                                {{-- href="{{ route('user.profil') }}"> --}}
                                <i class="bi bi-person me-2"></i> Profil Saya
                            </a>
                        </li>
                        <li><hr class="dropdown-divider"></li>
                        <li>
                            <form action="{{ route('logout') }}" method="POST">
                                @csrf
                                <button type="submit" class="dropdown-item text-danger">
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

<div class="admin-sidebar d-flex flex-column">

    {{-- BRAND --}}
    <a href="{{ route('admin.dashboard') }}"
       class="brand d-flex justify-content-center align-items-center">
        SiPinBuk
    </a>

    {{-- MENU --}}
    <ul class="nav flex-column mt-3 flex-grow-1">

        <li class="nav-item">
            <a href="{{ route('admin.dashboard') }}"
               class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                <i class="bi bi-speedometer2 me-2"></i>
                Dashboard
            </a>
        </li>

        <li class="nav-item">
            <a href="{{ route('admin.categories.index') }}"
               class="nav-link {{ request()->routeIs('admin.categories.*') ? 'active' : '' }}">
                <i class="bi bi-folder me-2"></i>
                Kategori
            </a>
        </li>

        <li class="nav-item">
            <a href="{{ route('admin.subcategories.index') }}"
               class="nav-link {{ request()->routeIs('admin.subcategories.*') ? 'active' : '' }}">
                <i class="bi bi-folder2-open me-2"></i>
                Subkategori
            </a>
        </li>

        <li class="nav-item">
            <a href="{{ route('admin.books.index') }}"
               class="nav-link {{ request()->routeIs('admin.books.*') ? 'active' : '' }}">
                <i class="bi bi-book me-2"></i>
                Buku
            </a>
        </li>

        <li class="nav-item">
            <a href="{{ route('admin.borrows.index') }}"
               class="nav-link {{ request()->routeIs('admin.borrows.*') ? 'active' : '' }}">
                <i class="bi bi-arrow-left-right me-2"></i>
                Peminjaman
            </a>
        </li>

        <li class="nav-item">
            <a href="{{ route('admin.classrooms.index') }}"
               class="nav-link {{ request()->routeIs('admin.classrooms.*') ? 'active' : '' }}">
                <i class="bi bi-easel2 me-2"></i>
                Kelas
            </a>
        </li>

        <li class="nav-item">
            <a href="{{ route('admin.users.index') }}"
               class="nav-link {{ request()->routeIs('admin.users.*') ? 'active' : '' }}">
                <i class="bi bi-people me-2"></i>
                User
            </a>
        </li>

    </ul>

    {{-- LOGOUT --}}
    <div class="p-3 border-top">
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="btn btn-outline-danger w-100">
                <i class="bi bi-box-arrow-right me-1"></i>
                Logout
            </button>
        </form>
    </div>

</div>

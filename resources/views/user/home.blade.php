<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Home | Perpustakaan</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<nav class="navbar navbar-expand-lg navbar-dark bg-primary">
    <div class="container">
        <span class="navbar-brand">Perpustakaan</span>

        <div class="ms-auto">
            @auth
                <span class="text-white me-3">
                    Login sebagai: <strong>{{ auth()->user()->name }}</strong>
                </span>

                <form action="{{ route('logout') }}" method="POST" class="d-inline">
                    @csrf
                    <button class="btn btn-light btn-sm">Logout</button>
                </form>
            @else
                <a href="{{ route('login') }}" class="btn btn-light btn-sm">Login</a>
            @endauth
        </div>
    </div>
</nav>

<div class="container mt-5">
    <div class="card">
        <div class="card-body">
            <h3>Home Page</h3>

            @auth
                <p class="text-success">
                    ✅ Anda login sebagai <strong>{{ auth()->user()->role }}</strong>
                </p>
            @else
                <p class="text-muted">
                    ℹ️ Anda belum login (guest)
                </p>
            @endauth

            <hr>

            <p>
                Halaman ini digunakan untuk:
            </p>
            <ul>
                <li>Home user</li>
                <li>Landing page setelah user login</li>
                <li>Akses publik (guest)</li>
            </ul>
        </div>
    </div>
</div>

</body>
</html>

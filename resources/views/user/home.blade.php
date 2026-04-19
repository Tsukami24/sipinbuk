@extends('layouts.user')

@section('title', 'Beranda')

@section('content')

    {{-- =============================
   HERO SECTION
============================= --}}
    <div class="p-4 rounded-4 mb-4 text-white" style="background: linear-gradient(135deg, #0B132B, #2D6A4F);">
        <div class="row align-items-center">
            <div class="col-md-8">
                <h4 class="fw-bold mb-2">Halo, {{ Auth::user()->name }} </h4>
                <p class="mb-3 opacity-75">
                    Selamat datang di sistem peminjaman buku sekolah.
                </p>
                <a href="{{ route('borrows.create') }}" class="btn btn-light btn-sm fw-semibold">
                    Pinjam Buku Sekarang
                </a>
            </div>
            <div class="col-md-4 text-end d-none d-md-block">
                <i class="bi bi-book-half" style="font-size: 70px; opacity: 0.3;"></i>
            </div>
        </div>
    </div>

    {{-- =============================
   STATISTIK USER
============================= --}}
    <div class="row g-3 mb-4">

        <div class="col-md-4">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <small class="text-muted">Total Peminjaman</small>
                    <h4 class="fw-bold mb-0 text-dark">{{ $totalBorrow }}</h4>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <small class="text-muted">Sedang Dipinjam</small>
                    <h4 class="fw-bold mb-0 text-success">{{ $activeBorrow }}</h4>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <small class="text-muted">Total Denda</small>
                    <h4 class="fw-bold mb-0 text-danger">
                        Rp {{ number_format($totalFine) }}
                    </h4>
                </div>
            </div>
        </div>

    </div>

    {{-- =============================
   BUKU TERBARU
============================= --}}
    <div class="mb-4">
        <h5 class="fw-semibold mb-3"> Buku Terbaru</h5>

        <div class="row g-3">
            @forelse ($books as $book)
                <div class="col-6 col-md-3 col-lg-2">
                    <div class="card book-card border-0 shadow-sm">

                        {{-- COVER --}}
                        <div class="book-cover">
                            <img src="{{ $book->cover ? asset('storage/' . $book->cover) : 'https://via.placeholder.com/300x450' }}"
                                alt="{{ $book->title }}">
                        </div>

                        {{-- CONTENT --}}
                        <div class="card-body p-2">

                            <h6 class="fw-semibold mb-1 text-truncate small">
                                {{ $book->title }}
                            </h6>

                            <div class="book-desc mb-2">
                                {{ $book->description ?? 'Tidak diketahui' }}
                            </div>

                            <a href="{{ route('books.show', $book->id) }}" class="btn btn-theme btn-sm w-100 py-1">
                                Detail
                            </a>

                        </div>

                    </div>
                </div>
            @empty
                <p class="text-muted">Belum ada buku tersedia.</p>
            @endforelse
        </div>
    </div>

    {{-- =============================
   QUICK ACTION
============================= --}}
    <div class="row g-3">

        <div class="col-md-6">
            <a href="{{ route('borrows.create') }}" class="text-decoration-none">
                <div class="card border-0 shadow-sm hover-card">
                    <div class="card-body d-flex align-items-center">
                        <div class="me-3">
                            <i class="bi bi-journal-plus text-success fs-3"></i>
                        </div>
                        <div>
                            <div class="fw-semibold text-dark">Pinjam Buku</div>
                            <small class="text-muted">Ajukan peminjaman baru</small>
                        </div>
                    </div>
                </div>
            </a>
        </div>

        <div class="col-md-6">
            <a href="{{ route('borrows.history') }}" class="text-decoration-none">
                <div class="card border-0 shadow-sm hover-card">
                    <div class="card-body d-flex align-items-center">
                        <div class="me-3">
                            <i class="bi bi-clock-history text-primary fs-3"></i>
                        </div>
                        <div>
                            <div class="fw-semibold text-dark">Riwayat</div>
                            <small class="text-muted">Lihat peminjaman kamu</small>
                        </div>
                    </div>
                </div>
            </a>
        </div>

    </div>

@endsection

@push('styles')
    <style>
        .hover-card {
            transition: 0.2s;
        }

        .hover-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 6px 18px rgba(0, 0, 0, 0.08);
        }

        .btn-theme {
            color: #2D6A4F;
            border: 1px solid #2D6A4F;
            background: transparent;
        }

        .btn-theme:hover {
            background-color: #2D6A4F;
            color: #fff;
            border-color: #2D6A4F;

            .book-card {
                border-radius: 12px;
                overflow: hidden;
                transition: 0.2s;
            }

            .book-card:hover {
                transform: translateY(-4px);
                box-shadow: 0 8px 20px rgba(0, 0, 0, 0.1);
            }

            /* COVER UKURAN BUKU */
            .book-cover {
                width: 100%;
                aspect-ratio: 2 / 3;
                /* ini kunci ukuran buku */
                overflow: hidden;
                background: #f8f9fa;
            }

            .book-cover img {
                width: 100%;
                height: 100%;
                object-fit: cover;
            }
        }

        .book-desc {
            font-size: 0.75rem;
            color: #6c757d;

            /* ini inti ellipsis */
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }
    </style>
@endpush

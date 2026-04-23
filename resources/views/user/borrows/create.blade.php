@extends('layouts.user')

@section('content')
    <div class="container py-5">

        <div class="row justify-content-center">
            <div class="col-lg-7">

                {{-- CARD --}}
                <div class="card border-0 shadow-lg rounded-4">

                    {{-- HEADER --}}
                    <div class="card-header border-0 text-white rounded-top-4"
                        style="background: linear-gradient(135deg, #0B132B, #2D6A4F);">
                        <h5 class="mb-0 fw-semibold">
                            <i class="bi bi-journal-plus me-2"></i>
                            Form Peminjaman Buku
                        </h5>
                    </div>

                    {{-- BODY --}}
                    <div class="card-body p-4">

                        @if ($errors->any())
                            <div class="alert alert-danger rounded-3">
                                <ul class="mb-0">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        @if (session('error'))
                            <div class="alert alert-danger rounded-3">
                                {{ session('error') }}
                            </div>
                        @endif

                        <form action="{{ route('borrows.store') }}" method="POST">
                            @csrf

                            {{-- DATE ROW --}}
                            <div class="mb-3">
                                <label class="form-label fw-semibold">Tanggal Pinjam</label>

                                <input type="date" class="form-control rounded-3 bg-light"
                                    value="{{ now()->toDateString() }}" readonly
                                    style="pointer-events: none; opacity: 0.8;">
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-semibold">Tanggal Pengembalian</label>

                                <input type="date" class="form-control rounded-3 bg-light"
                                    value="{{ now()->addDays(7)->toDateString() }}" readonly
                                    style="pointer-events: none; opacity: 0.8;">

                                <small class="text-muted">
                                    Otomatis 7 hari setelah tanggal peminjaman
                                </small>
                            </div>

                            {{-- BOOK LIST --}}
                            <div class="mb-4">
                                <label class="form-label fw-semibold mb-2">
                                    Pilih Buku
                                </label>

                                <div class="border rounded-3 p-3" style="max-height:300px; overflow-y:auto;">

                                    <div class="row g-3">
                                        @forelse ($books as $book)
                                            <div class="col-12">

                                                <label class="w-100">
                                                    <div class="d-flex align-items-center p-2 rounded-3 border book-item"
                                                        style="cursor:pointer; transition:0.2s;">

                                                        {{-- CHECKBOX --}}
                                                        <input class="form-check-input me-3" type="checkbox"
                                                            name="book_ids[]" value="{{ $book->id }}">

                                                        {{-- COVER --}}
                                                        <img src="{{ asset('storage/' . $book->cover) }}" alt="cover"
                                                            class="rounded"
                                                            style="width:60px; height:80px; object-fit:cover;">

                                                        {{-- INFO --}}
                                                        <div class="ms-3 flex-grow-1">
                                                            <div class="fw-semibold text-dark">
                                                                {{ $book->title }}
                                                            </div>

                                                            <small class="text-muted">
                                                                {{ $book->author ?? 'Penulis tidak diketahui' }}
                                                            </small>
                                                        </div>

                                                        {{-- STATUS --}}
                                                        <span class="badge bg-success">
                                                            tersedia
                                                        </span>

                                                    </div>
                                                </label>

                                            </div>
                                        @empty
                                            <p class="text-muted mb-0">Tidak ada buku tersedia</p>
                                        @endforelse
                                    </div>

                                </div>
                            </div>

                            {{-- QUANTITY --}}
                            <div class="mb-4">
                                <div class="p-3 rounded-3 mb-0"
                                    style="background: rgba(116, 198, 157, 0.15); border: 1px solid rgba(45, 106, 79, 0.2);">

                                    <div class="d-flex align-items-start gap-2">

                                        <i class="bi bi-info-circle-fill text-success mt-1"></i>

                                        <div>
                                            <div class="fw-semibold text-dark">
                                                Informasi Peminjaman
                                            </div>

                                            <small class="text-muted">
                                                Maksimal peminjaman 1 buku per judul dan maksimal 2 buku berbeda per
                                                peminjaman.
                                            </small>
                                        </div>

                                    </div>

                                </div>
                            </div>

                            {{-- BUTTON --}}
                            <div class="d-flex justify-content-between align-items-center gap-3 mt-2">

                                <a href="{{ route('user.home') }}" class="btn btn-outline-secondary px-4 rounded-3">
                                    ← Kembali
                                </a>

                                @php
                                    $hasPending = \App\Models\Borrow::where('user_id', auth()->id())
                                        ->where('status', 'pending')
                                        ->exists();
                                @endphp

                                @if ($hasPending)
                                    <button class="btn btn-secondary px-4 rounded-3" disabled>
                                        Masih Ada Pengajuan
                                    </button>
                                @else
                                    <button class="btn btn-primary px-4 rounded-3 shadow-sm">
                                        <i class="bi bi-send-check me-1"></i>
                                        Ajukan Peminjaman
                                    </button>
                                @endif

                            </div>
                        </form>
                    </div>

                </div>

            </div>
        </div>

    </div>
@endsection

@push('styles')
    <style>
        .btn-primary {
            background-color: #2D6A4F !important;
            border-color: #2D6A4F !important;
        }

        /* saat hover */
        .btn-primary:hover {
            background-color: #245a41 !important;
            border-color: #245a41 !important;
        }

        /* saat klik / aktif */
        .btn-primary:active,
        .btn-primary:focus,
        .btn-primary:focus:active,
        .btn-primary.active {
            background-color: #2D6A4F !important;
            border-color: #2D6A4F !important;
            box-shadow: 0 0 0 0.2rem rgba(45, 106, 79, 0.25) !important;
        }
    </style>
@endpush

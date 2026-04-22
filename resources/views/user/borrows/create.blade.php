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

                        <form action="{{ route('borrows.store') }}" method="POST">
                            @csrf

                            {{-- DATE ROW --}}
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label fw-semibold">Tanggal Pinjam</label>
                                    <input type="date" name="borrow_date" class="form-control rounded-3"
                                        value="{{ old('borrow_date', now()->toDateString()) }}" required>
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label class="form-label fw-semibold">Tanggal Pengembalian</label>
                                    <input type="date" name="due_date" class="form-control rounded-3"
                                        value="{{ old('due_date') }}" required>
                                </div>
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
                                <label class="form-label fw-semibold">
                                    Jumlah per Buku
                                </label>

                                <div class="input-group">
                                    <span class="input-group-text bg-success text-white">
                                        <i class="bi bi-stack"></i>
                                    </span>

                                    <input type="number" name="quantity" class="form-control"
                                        value="{{ old('quantity', 1) }}" min="1" required>
                                </div>

                                <small class="text-muted">
                                    Sistem akan memilih unit buku yang tersedia secara otomatis
                                </small>
                            </div>

                            {{-- BUTTON --}}
                            <div class="d-flex justify-content-between align-items-center">

                                <a href="{{ route('user.home') }}" class="btn btn-outline-secondary">
                                    ← Kembali
                                </a>

                                @php
                                    $hasPending = \App\Models\Borrow::where('user_id', auth()->id())
                                        ->where('status', 'pending')
                                        ->exists();
                                @endphp

                                @if ($hasPending)
                                    <button class="btn btn-secondary flex-fill" disabled>
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

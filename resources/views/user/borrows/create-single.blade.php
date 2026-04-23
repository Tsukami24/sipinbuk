@extends('layouts.user')

@section('content')
    <div class="container py-5">

        <div class="row justify-content-center">
            <div class="col-lg-7">

                {{-- CARD --}}
                <div class="card border-0 shadow-lg rounded-4 overflow-hidden">

                    {{-- HEADER --}}
                    <div class="card-header text-white border-0"
                        style="background: linear-gradient(135deg, #0B132B, #2D6A4F);">
                        <h5 class="mb-0 fw-semibold">
                            <i class="bi bi-journal-plus me-2"></i>
                            Form Peminjaman Buku
                        </h5>
                    </div>

                    {{-- BODY --}}
                    <div class="card-body p-4">

                        <div class="row g-4">

                            {{-- COVER --}}
                            <div class="col-md-4 text-center">
                                <img src="{{ $book->cover ? asset('storage/' . $book->cover) : 'https://via.placeholder.com/300x450' }}"
                                    class="img-fluid rounded-3 shadow-sm"
                                    style="width:100%; aspect-ratio:2/3; object-fit:cover;">
                            </div>

                            {{-- FORM --}}
                            <div class="col-md-8">

                                {{-- TITLE (DI BODY, SESUAI REQUEST) --}}
                                <h5 class="fw-bold text-dark mb-1">
                                    {{ $book->title }}
                                </h5>

                                <p class="text-muted mb-3">
                                    {{ $book->author ?? 'Penulis tidak diketahui' }}
                                </p>

                                <form action="{{ route('borrows.store') }}" method="POST">
                                    @csrf

                                    {{-- hidden book --}}
                                    <input type="hidden" name="book_ids[]" value="{{ $book->id }}">

                                    {{-- TANGGAL --}}
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

                                    {{-- JUMLAH --}}
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
                                    <div class="d-flex gap-2">

                                        <a href="{{ url()->previous() }}" class="btn btn-outline-secondary w-50 rounded-3">
                                            Kembali
                                        </a>

                                        <button class="btn btn-success w-50 rounded-3">
                                            <i class="bi bi-send-check me-1"></i>
                                            Ajukan
                                        </button>

                                    </div>

                                </form>

                            </div>

                        </div>

                    </div>
                </div>

            </div>
        </div>

    </div>
@endsection

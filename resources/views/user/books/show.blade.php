@extends('layouts.user')

@section('title', $book->title)

@section('content')
    <div class="container py-4">

        <div class="row g-4">

            {{-- COVER --}}
            <div class="col-md-4">
                <div class="card border-0 shadow-sm rounded-4 overflow-hidden h-100">

                    <img src="{{ asset('storage/' . $book->cover) }}" class="w-100 h-100"
                        style="object-fit: cover; min-height: 100%;">

                </div>
            </div>

            {{-- INFO --}}
            <div class="col-md-8">

                <div class="card border-0 shadow-sm rounded-4">
                    <div class="card-body p-4">

                        {{-- TITLE --}}
                        <h3 class="fw-bold text-dark mb-1">
                            {{ $book->title }}
                        </h3>

                        <p class="text-muted mb-3">
                            <i class="bi bi-person me-1"></i>
                            {{ $book->author ?? 'Penulis tidak diketahui' }}
                        </p>

                        {{-- BADGES --}}
                        <div class="mb-3">
                            <span class="badge me-1" style="background:#2D6A4F;">
                                {{ $book->category->name ?? 'Umum' }}
                            </span>

                            <span class="badge" style="background:#74C69D; color:#0B132B;">
                                {{ $book->subcategory->name ?? 'Umum' }}
                            </span>
                        </div>

                        <hr>

                        {{-- DETAIL INFO GRID --}}
                        <div class="row g-3 mb-3">

                            <div class="col-4">
                                <div class="p-3 rounded-3 text-center" style="background: rgba(45,106,79,0.1);">
                                    <div class="fw-bold text-success">
                                        {{ $book->pages ?? '-' }}
                                    </div>
                                    <small class="text-muted">Halaman</small>
                                </div>
                            </div>

                            <div class="col-4">
                                <div class="p-3 rounded-3 text-center" style="background: rgba(11,19,43,0.1);">
                                    <div class="fw-bold text-dark">
                                        {{ $book->year ?? '-' }}
                                    </div>
                                    <small class="text-muted">Tahun</small>
                                </div>
                            </div>

                            <div class="col-4">
                                <div class="p-3 rounded-3 text-center" style="background: rgba(116,198,157,0.2);">
                                    <div class="fw-bold text-success">
                                        {{ $book->publisher ?? '-' }}
                                    </div>
                                    <small class="text-muted">Penerbit</small>
                                </div>
                            </div>

                        </div>

                        <hr>

                        {{-- DESCRIPTION --}}
                        <h6 class="fw-semibold">Deskripsi</h6>
                        <p class="text-muted">
                            {{ $book->description ?? 'Tidak ada deskripsi untuk buku ini.' }}
                        </p>

                        <hr>

                        {{-- STATUS --}}
                        <div class="row text-center mb-3">

                            <div class="col">
                                <div class="p-3 rounded-3" style="background: rgba(45,106,79,0.1);">
                                    <div class="fw-bold text-success">
                                        {{ $book->items->where('status', 'available')->count() }}
                                    </div>
                                    <small class="text-muted">Tersedia</small>
                                </div>
                            </div>

                            <div class="col">
                                <div class="p-3 rounded-3" style="background: rgba(11,19,43,0.1);">
                                    <div class="fw-bold text-dark">
                                        {{ $book->items->count() }}
                                    </div>
                                    <small class="text-muted">Total Unit</small>
                                </div>
                            </div>

                        </div>

                        {{-- ACTION --}}
                        <div class="d-flex gap-2">

                            <a href="{{ route('borrows.create.singleBook', $book->id) }}" class="btn btn-success flex-fill">
                                Pinjam Buku
                            </a>

                            <a href="{{ url()->previous() }}" class="btn btn-outline-secondary">
                                Kembali
                            </a>

                        </div>

                    </div>
                </div>

            </div>
        </div>

    </div>
@endsection

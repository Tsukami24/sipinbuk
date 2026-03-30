@extends('layouts.user')

@section('content')
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-md-6">

            <div class="card shadow-sm">
                <div class="card-header fw-bold">
                    📚 Form Peminjaman Buku
                </div>

                <div class="card-body">
                    <form action="{{ route('borrows.store') }}" method="POST">
                        @csrf

                        {{-- Borrow date --}}
                        <div class="mb-3">
                            <label class="form-label">Tanggal Pinjam</label>
                            <input type="date" name="borrow_date" class="form-control"
                                value="{{ old('borrow_date', now()->toDateString()) }}" required>
                        </div>

                        {{-- Due date --}}
                        <div class="mb-3">
                            <label class="form-label">Tanggal Pengembalian</label>
                            <input type="date" name="due_date" class="form-control"
                                value="{{ old('due_date') }}" required>
                        </div>

                        {{-- Pilih buku --}}
                        <div class="mb-3">
                            <label class="form-label">Pilih Buku</label>

                            @foreach ($books as $book)
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="book_ids[]"
                                        value="{{ $book->id }}" id="book{{ $book->id }}"
                                        {{ in_array($book->id, old('book_ids', [])) ? 'checked' : '' }}>
                                    <label class="form-check-label" for="book{{ $book->id }}">
                                        {{ $book->title }}
                                    </label>
                                </div>
                            @endforeach

                            @if($books->isEmpty())
                                <p class="text-muted">Tidak ada buku tersedia</p>
                            @endif
                        </div>

                        {{-- Quantity --}}
                        <div class="mb-3">
                            <label class="form-label">Jumlah Buku yang Dipinjam per Jenis</label>
                            <input type="number" name="quantity" class="form-control"
                                value="{{ old('quantity', 1) }}" min="1" required>
                            <small class="text-muted">Sistem akan otomatis memilih unit buku yang tersedia.</small>
                        </div>

                        {{-- Submit --}}
                        <div class="d-flex justify-content-end">
                            <button class="btn btn-success">📥 Pinjam Buku</button>
                        </div>
                    </form>
                </div>
            </div>

        </div>
    </div>
</div>
@endsection

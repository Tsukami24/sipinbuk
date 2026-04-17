@extends('layouts.admin')

@section('title', 'Detail Buku Rusak')

@section('content')

    <div class="row justify-content-center">
        <div class="col-md-8">

            <div class="card shadow-sm border-0">
                <div class="card-header text-white" style="background-color:#0B132B;">
                    <h5 class="mb-0">Detail Buku Rusak</h5>
                </div>

                <div class="card-body">

                    <p><strong>Judul Buku</strong><br>
                        {{ $damagedBook->bookItem->book->title }}
                    </p>

                    <p><strong>Kode Unit</strong><br>
                        {{ $damagedBook->bookItem->book_code }}
                    </p>

                    <p><strong>Peminjam</strong><br>
                        {{ $damagedBook->borrowDetail?->borrow?->user?->name ?? '-' }}
                    </p>

                    <p><strong>Tanggal Dikembalikan</strong><br>
                        {{ $damagedBook->borrowDetail?->returned_at
                            ? \Carbon\Carbon::parse($damagedBook->borrowDetail->returned_at)->format('d M Y')
                            : '-' }}
                    </p>

                    <p><strong>Tingkat Kerusakan</strong><br>
                        @if ($damagedBook->damage_level === 'light')
                            <span class="badge bg-warning text-dark">Ringan</span>
                        @elseif ($damagedBook->damage_level === 'medium')
                            <span class="badge bg-danger">Sedang</span>
                        @else
                            <span class="badge bg-dark">Berat</span>
                        @endif
                    </p>

                    <p><strong>Deskripsi</strong><br>
                        {{ $damagedBook->description ?? '-' }}
                    </p>

                    <div class="text-end">
                        <a href="{{ route('admin.damaged-books.index') }}" class="btn btn-secondary">
                            Kembali
                        </a>
                    </div>

                </div>
            </div>

        </div>
    </div>

@endsection

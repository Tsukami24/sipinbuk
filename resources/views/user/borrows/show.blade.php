@extends('layouts.user')

@section('title', 'Detail Peminjaman')

@section('content')
<div class="container py-4">

    {{-- BACK BUTTON --}}
    <a href="{{ route('borrows.history') }}"
   class="btn btn-sm px-3 py-2 mb-3 d-inline-flex align-items-center gap-2 back-btn">

    <i class="bi bi-arrow-left"></i>
    Kembali ke Riwayat
</a>

    {{-- MAIN CARD --}}
    <div class="card border-0 shadow-sm rounded-4">
        <div class="card-header text-white fw-bold"
             style="background:#0B132B;">
            Detail Peminjaman #{{ $borrow->id }}
        </div>

        <div class="card-body p-4">

            {{-- INFO HEADER --}}
            <div class="row mb-4">

                <div class="col-md-6">
                    <small class="text-muted">Tanggal Pinjam</small>
                    <div class="fw-bold">
                        {{ $borrow->borrow_date->format('d M Y') }}
                    </div>
                </div>

                <div class="col-md-6">
                    <small class="text-muted">Batas Pengembalian</small>
                    <div class="fw-bold">
                        {{ $borrow->due_date->format('d M Y') }}
                    </div>
                </div>

            </div>

            {{-- STATUS --}}
            <div class="mb-4">
                @php $status = $borrow->status; @endphp

                @if ($status === 'active')
                    <span class="badge px-3 py-2 rounded-pill" style="background:#0B132B;">
                        <i class="bi bi-book me-1"></i> Dipinjam
                    </span>

                @elseif ($status === 'completed')
                    <span class="badge px-3 py-2 rounded-pill" style="background:#2D6A4F;">
                        <i class="bi bi-check-circle me-1"></i> Dikembalikan
                    </span>

                @elseif ($status === 'overdue')
                    <span class="badge px-3 py-2 rounded-pill" style="background:#E63946;">
                        <i class="bi bi-exclamation-circle me-1"></i> Terlambat
                    </span>
                @endif
            </div>

            <hr>

            {{-- BOOK LIST --}}
            <h6 class="fw-bold mb-3" style="color:#0B132B;">
                Daftar Buku
            </h6>

            <div class="row g-3">

                @foreach ($borrow->details as $detail)
                    <div class="col-12">

                        <div class="d-flex align-items-center gap-3 p-3 border rounded-4 shadow-sm book-item">

                            {{-- COVER --}}
                            <img src="{{ asset('storage/' . $detail->bookItem->book->cover) }}"
                                 class="rounded-3"
                                 style="width:70px; height:90px; object-fit:cover;">

                            {{-- INFO --}}
                            <div class="flex-grow-1">

                                <div class="fw-bold">
                                    {{ $detail->bookItem->book->title }}
                                </div>

                                <small class="text-muted">
                                    Kode Unit: {{ $detail->bookItem->book_code }}
                                </small>

                                {{-- STATUS MINI --}}
                                <div class="mt-1">

                                    @if ($detail->return_requested && !$detail->returned_at)
                                        <span class="badge bg-warning text-dark">
                                            Menunggu Persetujuan
                                        </span>
                                    @endif

                                    @if ($detail->fines->count())
                                        <span class="badge bg-danger">
                                            Ada Denda
                                        </span>
                                    @endif

                                </div>

                            </div>

                            {{-- ACTION --}}
                            <div>

                                @if (!$detail->returned_at && !$detail->return_requested)
                                    <form action="{{ route('user.borrow.requestReturn', $detail->id) }}"
                                          method="POST">
                                        @csrf
                                        <button class="btn btn-sm"
                                                style="background:#2D6A4F; color:white;">
                                            Ajukan
                                        </button>
                                    </form>
                                @endif

                            </div>

                        </div>

                    </div>
                @endforeach

            </div>

            {{-- TOTAL DENDA --}}
            @php
                $totalFine = $borrow->details->flatMap->fines->sum('amount');
            @endphp

            @if ($totalFine > 0)
                <div class="alert mt-4 border-0 rounded-4 text-white"
                     style="background:#E63946;">
                    <strong>Total Denda:</strong>
                    Rp {{ number_format($totalFine, 0, ',', '.') }}
                </div>
            @endif

        </div>
    </div>

</div>

{{-- STYLE --}}
<style>
.book-item {
    transition: 0.25s ease;
    background: #fff;
}

.book-item:hover {
    transform: translateY(-2px);
    box-shadow: 0 10px 20px rgba(0,0,0,0.08);
}

.back-btn {
    background: #ffffff;
    border: 1px solid #e9ecef;
    color: #0B132B;
    border-radius: 12px;
    transition: 0.2s ease;
    font-weight: 500;
}

.back-btn:hover {
    background: #0B132B;
    color: #fff;
    transform: translateX(-2px);
    box-shadow: 0 6px 15px rgba(0,0,0,0.08);
}

.back-btn i {
    transition: 0.2s ease;
}

.back-btn:hover i {
    transform: translateX(-3px);
}
</style>
@endsection

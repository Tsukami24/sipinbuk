@extends('layouts.user')

@section('title', 'Riwayat Peminjaman')

@section('content')
<div class="container py-4">

    <h4 class="fw-bold mb-3" style="color:#0B132B;">
        Riwayat Peminjaman
    </h4>

    {{-- TAB FILTER --}}
    <ul class="nav nav-pills mb-4 gap-2">

        <li class="nav-item">
            <a href="{{ route('borrows.history') }}"
               class="nav-link {{ request('status') == null ? 'active' : '' }}"
               style="{{ request('status') == null ? 'background:#2D6A4F;' : '' }}">
                Semua
            </a>
        </li>

        <li class="nav-item">
            <a href="?status=pending"
               class="nav-link {{ request('status') == 'pending' ? 'active' : '' }}">
                Menunggu
            </a>
        </li>

        <li class="nav-item">
            <a href="?status=active"
               class="nav-link {{ request('status') == 'active' ? 'active' : '' }}">
                Dipinjam
            </a>
        </li>

        <li class="nav-item">
            <a href="?status=overdue"
               class="nav-link {{ request('status') == 'overdue' ? 'active' : '' }}">
                Terlambat
            </a>
        </li>

        <li class="nav-item">
            <a href="?status=completed"
               class="nav-link {{ request('status') == 'completed' ? 'active' : '' }}">
                Selesai
            </a>
        </li>

        <li class="nav-item">
            <a href="?status=rejected"
               class="nav-link {{ request('status') == 'rejected' ? 'active' : '' }}">
                Ditolak
            </a>
        </li>

    </ul>

    {{-- LIST --}}
    @forelse ($borrows as $borrow)

        @php $status = $borrow->status; @endphp

        <div class="card border-0 shadow-sm rounded-4 mb-3 borrow-card">
            <div class="card-body p-4">

                {{-- HEADER --}}
                <div class="d-flex justify-content-between flex-wrap gap-3">

                    <div>
                        <div class="fw-semibold text-dark">
                            Peminjaman #{{ $borrow->id }}
                        </div>

                        <small class="text-muted">
                            {{ $borrow->borrow_date->format('d M Y') }}
                            →
                            {{ $borrow->due_date->format('d M Y') }}
                        </small>
                    </div>

                    {{-- STATUS --}}
                    <div>
                        @if ($status === 'pending')
                            <span class="badge px-3 py-2 rounded-pill"
                                  style="background:#FFD166; color:#000;">
                                Menunggu
                            </span>

                        @elseif ($status === 'active')
                            <span class="badge px-3 py-2 rounded-pill"
                                  style="background:#0B132B;">
                                Dipinjam
                            </span>

                        @elseif ($status === 'completed')
                            <span class="badge px-3 py-2 rounded-pill"
                                  style="background:#2D6A4F;">
                                Selesai
                            </span>

                        @elseif ($status === 'overdue')
                            <span class="badge px-3 py-2 rounded-pill"
                                  style="background:#E63946;">
                                Terlambat
                            </span>

                        @elseif ($status === 'rejected')
                            <span class="badge bg-dark px-3 py-2 rounded-pill">
                                Ditolak
                            </span>
                        @endif
                    </div>

                </div>

                <hr>

                {{-- BODY --}}
                <div class="d-flex justify-content-between align-items-center">

                    <div>
                        <small class="text-muted">Jumlah Buku</small>
                        <div class="fw-bold fs-5">
                            {{ $borrow->details->count() }}
                        </div>
                    </div>

                    <div>
                        <a href="{{ route('borrows.history.show', $borrow) }}"
                           class="btn btn-sm px-3"
                           style="background:#2D6A4F; color:white;">
                            Detail
                        </a>
                    </div>

                </div>

            </div>
        </div>

    @empty
        <div class="text-center py-5 text-muted">
            <i class="bi bi-inbox" style="font-size:40px;"></i>
            <h5 class="mt-2">Tidak ada data</h5>
        </div>
    @endforelse

</div>

{{-- STYLE --}}
<style>
.borrow-card {
    transition: .2s;
}

.borrow-card:hover {
    transform: translateY(-3px);
    box-shadow: 0 10px 25px rgba(0,0,0,0.08);
}

.nav-pills .nav-link {
    border-radius: 12px;
    color: #0B132B;
    background: #f1f3f5;
}

.nav-pills .nav-link.active {
    background: #2D6A4F;
    color: #fff;
}
</style>
@endsection

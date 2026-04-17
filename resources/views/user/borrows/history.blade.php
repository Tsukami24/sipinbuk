@extends('layouts.user')

@section('title', 'Riwayat Peminjaman')

@section('content')
    <div class="container">
        <h4 class="mb-4">📖 Riwayat Peminjaman</h4>

        @forelse ($borrows as $borrow)
            <div class="card mb-3 shadow-sm">
                <div class="card-body">

                    <div class="d-flex justify-content-between">
                        <div>
                            <strong>Kode Peminjaman:</strong> #{{ $borrow->id }} <br>
                            <small class="text-muted">
                                {{ $borrow->borrow_date->format('d M Y') }}
                                →
                                {{ $borrow->due_date->format('d M Y') }}
                            </small>
                        </div>

                        <div>
                            {{-- STATUS --}}
                            @php
                                $status = $borrow->status;
                            @endphp

                            @if ($status === 'pending')
                                <span class="badge bg-warning text-dark">Menunggu Persetujuan</span>
                            @elseif ($status === 'active')
                                <span class="badge bg-primary">Dipinjam</span>
                            @elseif ($status === 'completed')
                                <span class="badge bg-success">Dikembalikan</span>
                            @elseif ($status === 'overdue')
                                <span class="badge bg-danger">Terlambat</span>
                            @elseif ($status === 'rejected')
                                <span class="badge bg-dark">Ditolak</span>
                            @endif
                        </div>

                        <div class="mt-2">
                            @if ($status === 'pending')
                                <small class="text-warning">Menunggu persetujuan admin</small>
                            @elseif ($status === 'rejected')
                                <small class="text-danger">Pengajuan ditolak admin</small>
                            @endif
                        </div>
                    </div>

                    <hr>

                    <div>
                        <strong>Jumlah Buku:</strong>
                        {{ $borrow->details->count() }}
                    </div>

                    <div class="mt-3 text-end">
                        <a href="{{ route('borrows.history.show', $borrow) }}" class="btn btn-outline-success btn-sm">
                            Detail
                        </a>
                    </div>

                </div>
            </div>
        @empty
            <div class="alert alert-info">
                Belum ada riwayat peminjaman buku.
            </div>
        @endforelse
    </div>
@endsection

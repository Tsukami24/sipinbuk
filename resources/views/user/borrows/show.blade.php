    @extends('layouts.user')

    @section('title', 'Detail Peminjaman')

    @section('content')
        <div class="container">
            <a href="{{ route('borrows.history') }}" class="btn btn-link mb-3">
                ← Kembali ke Riwayat
            </a>

            <div class="card shadow-sm">
                <div class="card-header fw-bold">
                    📚 Detail Peminjaman #{{ $borrow->id }}
                </div>

                <div class="card-body">
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <strong>Tanggal Pinjam:</strong><br>
                            {{ $borrow->borrow_date->format('d M Y') }}
                        </div>
                        <div class="col-md-6">
                            <strong>Batas Pengembalian:</strong><br>
                            {{ $borrow->due_date->format('d M Y') }}
                        </div>
                    </div>

                    <div class="mb-3">
                        <strong>Status:</strong>
                        @if ($borrow->status === 'active')
                            <span class="badge bg-primary">Dipinjam</span>
                        @elseif ($borrow->status === 'returned')
                            <span class="badge bg-success">Dikembalikan</span>
                        @elseif ($borrow->status === 'overdue')
                            <span class="badge bg-danger">Terlambat</span>
                        @endif
                    </div>

                    <hr>

                    <h6>📘 Daftar Buku</h6>

                    <ul class="list-group">
                        @foreach ($borrow->details as $detail)
                            <li class="list-group-item d-flex justify-content-between">
                                <div>
                                    {{ $detail->bookItem->book->title }} <br>
                                    <small class="text-muted">
                                        Kode Unit: {{ $detail->bookItem->book_code }}
                                    </small>
                                </div>

                                @if (!$detail->returned_at && !$detail->return_requested)
                                    <form action="{{ route('user.borrow.requestReturn', $detail->id) }}" method="POST">
                                        @csrf
                                        <button class="btn btn-warning btn-sm">
                                            Ajukan Pengembalian
                                        </button>
                                    </form>
                                @endif

                                @if ($detail->return_requested && !$detail->returned_at)
                                    <span class="badge bg-warning">Menunggu Persetujuan</span>
                                @endif

                                {{-- DENDA --}}
                                @if ($detail->fines->count())
                                    <span class="badge bg-danger">
                                        Denda
                                    </span>
                                @endif
                            </li>
                        @endforeach
                    </ul>

                    {{-- TOTAL DENDA --}}
                    @php
                        $totalFine = $borrow->details->flatMap->fines->sum('amount');
                    @endphp

                    @if ($totalFine > 0)
                        <div class="alert alert-danger mt-3">
                            <strong>Total Denda:</strong>
                            Rp {{ number_format($totalFine, 0, ',', '.') }}
                        </div>
                    @endif

                </div>
            </div>
        </div>
    @endsection

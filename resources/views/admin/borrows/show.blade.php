@extends('layouts.admin')

@section('title', 'Detail Peminjaman')

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-10">

            {{-- DETAIL PEMINJAMAN --}}
            <div class="card shadow-sm border-0 mb-4">
                <div class="card-header text-white" style="background-color:#0B132B;">
                    <h5 class="mb-0">Detail Peminjaman</h5>
                </div>

                <div class="card-body">
                    <div class="row g-4">
                        <div class="col-md-6">
                            <p><strong>Nama Peminjam</strong><br>{{ $borrow->user->name }}</p>
                            <p><strong>Tanggal
                                    Pinjam</strong><br>{{ \Carbon\Carbon::parse($borrow->borrow_date)->format('d M Y') }}
                            </p>
                            <p><strong>Jatuh
                                    Tempo</strong><br>{{ \Carbon\Carbon::parse($borrow->due_date)->format('d M Y') }}</p>
                        </div>

                        <div class="col-md-6">
                            <p>
                                <strong>Status</strong><br>
                                <span
                                    class="badge
                                {{ $borrow->status === 'active'
                                    ? 'bg-warning text-dark'
                                    : ($borrow->status === 'completed'
                                        ? 'bg-success'
                                        : 'bg-secondary') }}">
                                    {{ ucfirst($borrow->status) }}
                                </span>
                            </p>

                            @php
                                $lastReturnedAt = $borrow->details->whereNotNull('returned_at')->max('returned_at');
                            @endphp

                            <p>
                                <strong>Tanggal Dikembalikan</strong><br>
                                {{ $lastReturnedAt ? \Carbon\Carbon::parse($lastReturnedAt)->format('d M Y') : '-' }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            {{-- DAFTAR BUKU DIPINJAM --}}
            <div class="card shadow-sm border-0 mb-4">
                <div class="card-header text-white" style="background-color:#0B132B;">
                    <h5 class="mb-0">Daftar Buku Dipinjam</h5>
                </div>

                <div class="card-body">
                    <table class="table table-bordered table-striped align-middle">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Judul Buku</th>
                                <th>Kode Unit</th>
                                <th>Kondisi Buku</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($borrow->details as $index => $item)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $item->bookItem->book->title }}</td>
                                    <td>{{ $item->bookItem->book_code }}</td>
                                    <td>
                                        @if (!$item->returned_at)
                                            <form method="POST" action="{{ route('admin.borrows.return', $borrow->id) }}">
                                                @csrf

                                                {{-- hidden untuk id detail --}}
                                                <input type="hidden" name="details[0][id]" value="{{ $item->id }}">
                                                <input type="hidden" name="details[0][condition]"
                                                    id="conditionInput-{{ $item->id }}" required>

                                                <div class="dropdown">
                                                    <button class="btn btn-outline-success dropdown-toggle w-100 text-start"
                                                        type="button" data-bs-toggle="dropdown"
                                                        id="conditionButton-{{ $item->id }}">
                                                        -- Pilih Kondisi Buku --
                                                    </button>

                                                    <ul class="dropdown-menu w-100">
                                                        <li>
                                                            <a class="dropdown-item" href="#"
                                                                onclick="setCondition('{{ $item->id }}', 'good', 'Baik')">
                                                                Baik
                                                            </a>
                                                        </li>
                                                        <li>
                                                            <a class="dropdown-item" href="#"
                                                                onclick="setCondition('{{ $item->id }}', 'damaged', 'Rusak')">
                                                                Rusak
                                                            </a>
                                                        </li>
                                                        <li>
                                                            <a class="dropdown-item" href="#"
                                                                onclick="setCondition('{{ $item->id }}', 'lost', 'Hilang')">
                                                                Hilang
                                                            </a>
                                                        </li>
                                                    </ul>
                                                </div>

                                                <button class="btn btn-success btn-sm mt-2 w-100">Return</button>
                                            </form>
                                        @else
                                            <span class="badge bg-success">Returned</span>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            {{-- DENDA --}}
            @if ($borrow->fines->count())
                <div class="card shadow-sm border-0 mb-4">
                    <div class="card-header text-white" style="background-color:#0B132B;">
                        <h5 class="mb-0">Denda</h5>
                    </div>

                    <div class="card-body">
                        <table class="table table-bordered table-striped align-middle">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Buku</th>
                                    <th>Jenis Denda</th>
                                    <th>Jumlah</th>
                                    <th>Status</th>
                                    <th width="120">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($borrow->fines as $fine)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>
                                            {{ $fine->borrowDetail->bookItem->book->title }}<br>
                                            <small
                                                class="text-muted">{{ $fine->borrowDetail->bookItem->book_code }}</small>
                                        </td>
                                        <td>
                                            <span
                                                class="badge
                                    {{ $fine->fine_type === 'late'
                                        ? 'bg-warning text-dark'
                                        : ($fine->fine_type === 'damaged'
                                            ? 'bg-danger'
                                            : 'bg-dark') }}">
                                                {{ ucfirst($fine->fine_type) }}
                                            </span>
                                        </td>
                                        <td>Rp {{ number_format($fine->amount, 0, ',', '.') }}</td>
                                        <td>
                                            <span class="badge {{ $fine->is_paid ? 'bg-success' : 'bg-secondary' }}">
                                                {{ $fine->is_paid ? 'Lunas' : 'Belum Lunas' }}
                                            </span>
                                        </td>
                                        <td>
                                            @if (!$fine->is_paid)
                                                <form method="POST" action="{{ route('admin.fines.pay', $fine->id) }}">
                                                    @csrf
                                                    @method('PATCH')
                                                    <button class="btn btn-success btn-sm w-100">
                                                        Tandai Lunas
                                                    </button>
                                                </form>
                                            @else
                                                <span class="text-muted small">—</span>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>

                        <div class="text-end fw-bold mt-3">
                            Total Denda:
                            <span class="text-danger">
                                Rp {{ number_format($borrow->fines->sum('amount'), 0, ',', '.') }}
                            </span>
                        </div>
                    </div>
                </div>
            @endif

            <div class="text-end">
                <a href="{{ route('admin.borrows.index') }}" class="btn btn-secondary">
                    Kembali
                </a>
            </div>

        </div>
    </div>
@endsection

@push('scripts')
    <script>
        function setCondition(itemId, value, text) {
            document.getElementById('conditionInput-' + itemId).value = value;
            document.getElementById('conditionButton-' + itemId).innerText = text;
        }
    </script>
@endpush

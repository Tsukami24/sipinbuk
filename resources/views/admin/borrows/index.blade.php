@extends('layouts.admin')

@section('title', 'Data Peminjaman')

@section('content')

    <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-2">

    <div>
        <h4 class="fw-bold mb-1">Data Transaksi</h4>
        <p class="text-muted mb-0">Manajemen data transaksi peminjaman buku</p>
    </div>

    {{-- FILTER EXPORT --}}
    <form action="{{ route('admin.export.borrow') }}" method="GET" class="d-flex gap-2">

        {{-- STATUS --}}
        <select name="status" class="form-select form-select-sm">
            <option value="">Semua Status</option>
            <option value="pending">Pending</option>
            <option value="active">Dipinjam</option>
            <option value="completed">Dikembalikan</option>
            <option value="overdue">Terlambat</option>
            <option value="rejected">Ditolak</option>
        </select>

        {{-- TANGGAL --}}
        <input type="date" name="start_date" class="form-control form-control-sm">
        <input type="date" name="end_date" class="form-control form-control-sm">

        {{-- BUTTON --}}
        <button class="btn btn-success btn-sm">
            Export Excel
        </button>

    </form>
</div>

    <table class="table table-bordered table-striped" id="borrowsTable">
        <thead>
            <tr>
                <th>No</th>
                <th>Kode</th>
                <th>Peminjam</th>
                <th>Judul Buku</th>
                <th>Tanggal Pinjam</th>
                <th>Batas Kembali</th>
                <th>Jumlah Buku</th>
                <th>Status</th>
                <th>Aksi</th>
            </tr>
        </thead>

        <tbody>
            @foreach ($borrows as $borrow)
                <tr>
                    <td>{{ $loop->iteration }}</td>

                    <td>{{ $borrow->id }}</td>

                    <td>{{ $borrow->user->name }}</td>

                    <td>
                        @foreach ($borrow->details as $detail)
                            <span class="badge bg-light text-dark border mb-1">
                                {{ $detail->bookItem->book->title ?? '-' }}
                            </span>
                        @endforeach
                    </td>

                    <td>{{ $borrow->borrow_date->format('d M Y') }}</td>

                    <td>{{ $borrow->due_date->format('d M Y') }}</td>

                    <td class="text-center">
                        {{ $borrow->details->count() }}
                    </td>

                    <td class="text-center">
                        @if ($borrow->status === 'pending')
                            <span class="badge bg-warning text-dark">Menunggu</span>
                        @elseif ($borrow->status === 'active')
                            <span class="badge bg-primary">Dipinjam</span>
                        @elseif ($borrow->status === 'completed')
                            <span class="badge bg-success">Dikembalikan</span>
                        @elseif ($borrow->status === 'overdue')
                            <span class="badge bg-danger">Terlambat</span>
                        @elseif ($borrow->status === 'rejected')
                            <span class="badge bg-dark">Ditolak</span>
                        @endif
                    </td>

                    <td class="text-center">
                        <div class="dropdown">
                            <button class="btn btn-light btn-sm border" data-bs-toggle="dropdown">
                                &#x22EE;
                            </button>

                            <ul class="dropdown-menu">
                                <li>
                                    <a class="dropdown-item" href="{{ route('admin.borrows.show', $borrow->id) }}">
                                        Detail
                                    </a>
                                </li>

                                @if ($borrow->status === 'pending')
                                    <li>
                                        <form action="{{ route('admin.borrows.approve', $borrow->id) }}" method="POST">
                                            @csrf
                                            <button class="dropdown-item text-success">
                                                Terima
                                            </button>
                                        </form>
                                    </li>

                                    <li>
                                        <form action="{{ route('admin.borrows.reject', $borrow->id) }}" method="POST">
                                            @csrf
                                            <button class="dropdown-item text-danger">
                                                Tolak
                                            </button>
                                        </form>
                                    </li>
                                @endif
                            </ul>
                        </div>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

@endsection

@push('scripts')
    <script>
        $(document).ready(function() {
            $('#borrowsTable').DataTable({
                pageLength: 10,
                lengthChange: true,
                language: {
                    search: "Cari:",
                    lengthMenu: "Tampilkan _MENU_ data",
                    info: "Menampilkan _START_ - _END_ dari _TOTAL_ data",
                    paginate: {
                        previous: "‹",
                        next: "›"
                    }
                }
            });
        });
    </script>
@endpush

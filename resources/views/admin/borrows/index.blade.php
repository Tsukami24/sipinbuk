@extends('layouts.admin')

@section('title', 'Data Peminjaman')

@section('content')

    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="fw-bold mb-1">Data Peminjaman</h4>
            <p class="text-muted mb-0">Manajemen data peminjaman buku</p>
        </div>
    </div>

    <table class="table table-bordered table-striped" id="borrowsTable">
        <thead>
            <tr>
                <th>No</th>
                <th>Kode</th>
                <th>Peminjam</th>
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

                    <td>{{ $borrow->borrow_date->format('d M Y') }}</td>

                    <td>{{ $borrow->due_date->format('d M Y') }}</td>

                    <td class="text-center">
                        {{ $borrow->details->count() }}
                    </td>

                    <td class="text-center">
                        @if ($borrow->status === 'active')
                            <span class="badge bg-primary">Dipinjam</span>
                        @elseif ($borrow->status === 'completed')
                            <span class="badge bg-success">Dikembalikan</span>
                        @elseif ($borrow->status === 'overdue')
                            <span class="badge bg-danger">Terlambat</span>
                        @else
                            <span class="badge bg-secondary">{{ $borrow->status }}</span>
                        @endif
                    </td>

                    <td class="text-center">
                        <div class="dropdown">
                            <button class="btn btn-light btn-sm border" data-bs-toggle="dropdown">
                                &#x22EE;
                            </button>

                            <ul class="dropdown-menu">
                                <li>
                                    <a class="dropdown-item"
                                       href="{{ route('admin.borrows.show', $borrow->id) }}">
                                        Detail
                                    </a>
                                </li>
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
        $(document).ready(function () {
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

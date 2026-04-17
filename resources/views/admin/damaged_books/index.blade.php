@extends('layouts.admin')

@section('title', 'Buku Rusak')

@section('content')

    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="fw-bold mb-1">Data Buku Rusak</h4>
            <p class="text-muted mb-0">Daftar buku yang mengalami kerusakan</p>
        </div>

        <a href="{{ route('admin.damaged-books.create') }}" class="btn btn-success">
            + Tambah Buku Rusak
        </a>
    </div>

    <table class="table table-bordered table-striped" id="damagedBooksTable">
        <thead>
            <tr>
                <th>No</th>
                <th>Judul Buku</th>
                <th>Kode Unit</th>
                <th>Peminjam</th>
                <th>Tingkat Kerusakan</th>
                <th>Tanggal</th>
                <th>Aksi</th>
            </tr>
        </thead>

        <tbody>
            @foreach ($damagedBooks as $item)
                <tr>
                    <td>{{ $loop->iteration }}</td>

                    <td>{{ $item->bookItem->book->title }}</td>

                    <td>{{ $item->bookItem->book_code }}</td>

                    <td>
                        {{ optional($item->borrowDetail?->borrow?->user)->name ?? '-' }}
                    </td>

                    <td class="text-center">
                        @if ($item->damage_level === 'light')
                            <span class="badge bg-warning text-dark">Ringan</span>
                        @elseif ($item->damage_level === 'medium')
                            <span class="badge bg-danger">Sedang</span>
                        @elseif ($item->damage_level === 'heavy')
                            <span class="badge bg-dark">Berat</span>
                        @endif
                    </td>

                    <td>{{ $item->created_at->format('d M Y') }}</td>

                    <td class="text-center">
                        <div class="dropdown">
                            <button class="btn btn-light btn-sm border" data-bs-toggle="dropdown">
                                &#x22EE;
                            </button>

                            <ul class="dropdown-menu">
                                <li>
                                    <a class="dropdown-item" href="{{ route('admin.damaged-books.show', $item->id) }}">
                                        Detail
                                    </a>
                                </li>

                                <li>
                                    <form method="POST" action="{{ route('admin.damaged-books.destroy', $item->id) }}"
                                        onsubmit="return confirm('Apakah buku ini sudah diperbaiki?')">
                                        @csrf
                                        @method('DELETE')
                                        <button class="dropdown-item text-success">
                                            Sudah Diperbaiki
                                        </button>
                                    </form>
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
        $(document).ready(function() {
            $('#damagedBooksTable').DataTable({
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

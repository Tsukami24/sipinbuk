@extends('layouts.admin')

@section('title', 'Data Buku')

@section('content')

    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="fw-bold mb-1">Data Buku</h4>
            <p class="text-muted mb-0">Manajemen data buku perpustakaan</p>
        </div>

        <a href="{{ route('admin.books.create') }}" class="btn btn-success">
            + Tambah Buku
        </a>
    </div>

    <table class="table table-bordered table-striped" id="booksTable">
        <thead>
            <tr>
                <th>No</th>
                <th>Cover</th>
                <th>Judul</th>
                <th>Kategori</th>
                <th>Subkategori</th>
                <th>Penulis</th>
                <th>Unit</th>
                <th>Stok</th>
                <th>Aksi</th>
            </tr>
        </thead>

        <tbody>
            @foreach ($books as $book)
                <tr>
                    <td>{{ $loop->iteration }}</td>

                    <td class="text-center">
                        @if ($book->cover)
                            <img src="{{ asset('storage/' . $book->cover) }}" alt="Cover {{ $book->title }}"
                                class="img-thumbnail" style="width:60px; height:80px; object-fit:cover;">
                        @else
                            <span class="text-muted small">No Image</span>
                        @endif
                    </td>
                    <td>{{ $book->title }}</td>
                    <td>{{ $book->category->name }}</td>
                    <td>{{ $book->subcategory->name }}</td>
                    <td>{{ $book->author }}</td>
                    <td>{{ $book->items->count() }}</td>
                    <td>{{ $book->stock }}</td>
                    <td class="text-center">
                        <div class="dropdown">
                            <button class="btn btn-light btn-sm border" data-bs-toggle="dropdown">
                                &#x22EE;
                            </button>

                            <ul class="dropdown-menu">
                                <li>
                                    <a class="dropdown-item" href="{{ route('admin.books.show', $book->id) }}">
                                        Detail
                                    </a>
                                </li>

                                <li>
                                    <a class="dropdown-item" href="{{ route('admin.books.edit', $book->id) }}">
                                        Edit
                                    </a>
                                </li>

                                <li>
                                    <form method="POST" action="{{ route('admin.books.destroy', $book->id) }}"
                                        onsubmit="return confirm('Hapus buku ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button class="dropdown-item text-danger">
                                            Hapus
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
            $('#booksTable').DataTable({
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

@extends('layouts.admin')

@section('title', 'Kategori')

@section('content')

    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="fw-bold mb-1">Data Kategori</h4>
            <p class="text-muted mb-0">Manajemen data kategori perpustakaan</p>
        </div>

        <a href="{{ route('admin.categories.create') }}" class="btn btn-success">
            + Tambah Kategori
        </a>
    </div>

<table class="table table-bordered table-striped" id="categoriesTable">
    <thead>
        <tr>
            <th>No</th>
            <th>Nama</th>
            <th>Aksi</th>
        </tr>
    </thead>
    <tbody>
    @foreach($categories as $category)
        <tr>
            <td>{{ $loop->iteration }}</td>
            <td>{{ $category->name }}</td>
            <td>
                <a href="{{ route('admin.categories.edit', $category->id) }}"
                   class="btn btn-primary btn-sm">Edit</a>

                <form action="{{ route('admin.categories.destroy', $category->id) }}"
                      method="POST"
                      class="d-inline">
                    @csrf
                    @method('DELETE')
                    <button class="btn btn-danger btn-sm"
                            onclick="return confirm('Hapus?')">
                        Hapus
                    </button>
                </form>
            </td>
        </tr>
    @endforeach
    </tbody>
</table>
@endsection

@push('scripts')
<script>
$(document).ready(function () {
    $('#categoriesTable').DataTable({
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


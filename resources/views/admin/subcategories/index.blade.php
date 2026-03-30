@extends('layouts.admin')

@section('title', 'Subkategori')

@section('content')

    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="fw-bold mb-1">Data Subkategori</h4>
            <p class="text-muted mb-0">Manajemen data subkategori perpustakaan</p>
        </div>

        <a href="{{ route('admin.subcategories.create') }}" class="btn btn-success">
            + Tambah Subkategori
        </a>
    </div>

<table class="table table-bordered table-striped" id="subcategoriesTable">
    <thead>
        <tr>
            <th>No</th>
            <th>Category</th>
            <th>Nama Subcategory</th>
            <th>Aksi</th>
        </tr>
    </thead>
    <tbody>
    @foreach($subcategories as $subcategory)
        <tr>
            <td>{{ $loop->iteration }}</td>
            <td>{{ $subcategory->category->name }}</td>
            <td>{{ $subcategory->name }}</td>
            <td>
                <a href="{{ route('admin.subcategories.edit', $subcategory->id) }}"
                   class="btn btn-primary btn-sm">Edit</a>

                <form action="{{ route('admin.subcategories.destroy', $subcategory->id) }}"
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
    $('#subcategoriesTable').DataTable({
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


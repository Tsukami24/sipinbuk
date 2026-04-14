@extends('layouts.admin')

@section('title', 'Data Class')

@section('content')

    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="fw-bold mb-1">Data Kelas</h4>
            <p class="text-muted mb-0">Manajemen data kelas perpustakaan</p>
        </div>

        <a href="{{ route('admin.classrooms.create') }}" class="btn btn-success">
            + Tambah Kelas
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <table class="table table-bordered table-striped" id="classroomsTable">
        <thead>
            <tr>
                <th>No</th>
                <th>Class Name</th>
                <th>Major</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach($classrooms as $c)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $c->name }}</td>
                    <td>{{ $c->major }}</td>
                    <td>
                        <a href="{{ route('admin.classrooms.edit', $c->id) }}"
                           class="btn btn-primary btn-sm">
                            Edit
                        </a>

                        <form action="{{ route('admin.classrooms.destroy', $c->id) }}"
                              method="POST"
                              class="d-inline">
                            @csrf
                            @method('DELETE')

                            <button class="btn btn-danger btn-sm"
                                    onclick="return confirm('Hapus data ini?')">
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
    $('#classroomsTable').DataTable({
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

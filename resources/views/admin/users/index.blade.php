@extends('layouts.admin')

@section('title', 'Data User')

@section('content')
{{-- HEADER --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="fw-bold mb-1">Data User</h4>
            <p class="text-muted mb-0">Manajemen data user perpustakaan</p>
        </div>

        <a href="{{ route('admin.users.create') }}" class="btn btn-success">
            + Tambah User
        </a>
    </div>

<table class="table table-bordered table-striped" id="usersTable">
    <thead>
        <tr>
            <th>Nama</th>
            <th>NIS</th>
            <th>Kelas</th>
            <th>Aksi</th>
        </tr>
    </thead>
    <tbody>
    @foreach ($users as $user)
        <tr>
            <td>{{ $user->name }}</td>
            <td>{{ $user->nis }}</td>
            <td>{{ $user->classroom->name ?? '-' }}</td>
            <td>
                <a href="{{ route('admin.users.edit', $user->id) }}"
                   class="btn btn-primary btn-sm">Edit</a>
                <form action="{{ route('admin.users.destroy', $user) }}"
                      method="POST"
                      class="d-inline">
                    @csrf
                    @method('DELETE')
                    <button class="btn btn-danger btn-sm"
                            onclick="return confirm('Yakin hapus user?')">
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
    $('#usersTable').DataTable({
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


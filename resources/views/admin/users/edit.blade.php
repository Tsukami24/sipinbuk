@extends('layouts.admin')

@section('title', 'Edit User')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-6">

        <div class="card shadow-sm border-0">

            <div class="card-header text-white" style="background-color:#0B132B;">
                <h5 class="mb-0">Edit User</h5>
            </div>

            <div class="card-body">

                {{-- ERROR --}}
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul class="mb-0">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form method="POST"
                      action="{{ route('admin.users.update', $user->id) }}">
                    @csrf
                    @method('PUT')

                    {{-- NAME --}}
                    <div class="mb-3">
                        <label class="form-label">Nama</label>
                        <input type="text"
                               name="name"
                               class="form-control border-success"
                               value="{{ old('name', $user->name) }}"
                               required>
                    </div>

                    {{-- NIS --}}
                    <div class="mb-3">
                        <label class="form-label">NIS</label>
                        <input type="text"
                               name="nis"
                               class="form-control border-success"
                               value="{{ old('nis', $user->nis) }}"
                               required>
                    </div>

                    {{-- CLASSROOM DROPDOWN --}}
                    <div class="mb-3">
                        <label class="form-label">Kelas</label>

                        <div class="dropdown">
                            <button class="btn btn-outline-success dropdown-toggle w-100 text-start"
                                    type="button"
                                    data-bs-toggle="dropdown"
                                    id="classroomButton">
                                {{ optional($classrooms->firstWhere(
                                    'id',
                                    old('classroom_id', $user->classroom_id)
                                ))->name ?? '-- Pilih Kelas --' }}
                            </button>

                            <ul class="dropdown-menu w-100">
                                @foreach ($classrooms as $classroom)
                                    <li>
                                        <a class="dropdown-item" href="#"
                                           onclick="setClassroom('{{ $classroom->id }}', '{{ $classroom->name }}')">
                                            {{ $classroom->name }}
                                        </a>
                                    </li>
                                @endforeach
                            </ul>
                        </div>

                        <input type="hidden"
                               name="classroom_id"
                               id="classroomInput"
                               value="{{ old('classroom_id', $user->classroom_id) }}">
                    </div>

                    {{-- PASSWORD (OPTIONAL) --}}
                    <div class="mb-3">
                        <label class="form-label">Password</label>
                        <input type="password"
                               name="password"
                               class="form-control border-success"
                               placeholder="Kosongkan jika tidak diubah">
                        <small class="text-muted">
                            Biarkan kosong jika tidak ingin mengganti password
                        </small>
                    </div>

                    {{-- BUTTON --}}
                    <div class="d-flex justify-content-between">
                        <a href="{{ route('admin.users.index') }}"
                           class="btn btn-secondary">
                            Kembali
                        </a>

                        <button class="btn btn-success">
                            Update
                        </button>
                    </div>

                </form>

            </div>
        </div>

    </div>
</div>
@endsection

@push('scripts')
<script>
    function setClassroom(id, text) {
        document.getElementById('classroomInput').value = id;
        document.getElementById('classroomButton').innerText = text;
    }
</script>
@endpush

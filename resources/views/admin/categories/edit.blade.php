@extends('layouts.admin')

@section('title', 'Edit Kategori')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-6">

        <div class="card shadow-sm border-0">
            <div class="card-header text-white"
                 style="background-color: #0B132B;">
                <h5 class="mb-0">Edit Category</h5>
            </div>

            <div class="card-body">

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
                      action="{{ route('admin.categories.update', $category->id) }}">
                    @csrf
                    @method('PUT')

                    <div class="mb-3">
                        <label class="form-label">Nama Category</label>
                        <input type="text"
                               name="name"
                               class="form-control border-success"
                               placeholder="Masukkan nama category"
                               value="{{ old('name', $category->name) }}"
                               required>
                    </div>

                    <div class="d-flex justify-content-between">
                        <a href="{{ route('admin.categories.index') }}"
                           class="btn btn-secondary">
                            Kembali
                        </a>

                        <button class="btn btn-success">
                            Simpan Perubahan
                        </button>
                    </div>
                </form>

            </div>
        </div>

    </div>
</div>
@endsection

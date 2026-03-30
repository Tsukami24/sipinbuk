@extends('layouts.admin')

@section('title', 'Tambah Subcategory')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-6">

        <div class="card shadow-sm border-0">
            <div class="card-header text-white" style="background-color:#0B132B;">
                <h5 class="mb-0">Tambah Subcategory</h5>
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

                <form method="POST" action="{{ route('admin.subcategories.store') }}">
                    @csrf

                    {{-- CATEGORY --}}
                    <div class="mb-3">
                        <label class="form-label">Category</label>

                        <div class="dropdown">
                            <button class="btn btn-outline-success dropdown-toggle w-100 text-start"
                                    type="button"
                                    data-bs-toggle="dropdown"
                                    id="categoryButton">
                                {{ old('category_id')
                                    ? optional($categories->firstWhere('id', old('category_id')))->name
                                    : '-- Pilih Category --' }}
                            </button>

                            <ul class="dropdown-menu w-100">
                                @foreach ($categories as $cat)
                                    <li>
                                        <a class="dropdown-item" href="#"
                                           onclick="setCategory('{{ $cat->id }}', '{{ $cat->name }}')">
                                            {{ $cat->name }}
                                        </a>
                                    </li>
                                @endforeach
                            </ul>
                        </div>

                        <input type="hidden"
                               name="category_id"
                               id="categoryInput"
                               value="{{ old('category_id') }}"
                               required>
                    </div>

                    {{-- SUBCATEGORY NAME --}}
                    <div class="mb-3">
                        <label class="form-label">Nama Subcategory</label>
                        <input type="text"
                               name="name"
                               class="form-control border-success"
                               placeholder="Masukkan nama subcategory"
                               value="{{ old('name') }}"
                               required>
                    </div>

                    <div class="d-flex justify-content-between">
                        <a href="{{ route('admin.subcategories.index') }}"
                           class="btn btn-secondary">
                            Kembali
                        </a>

                        <button class="btn btn-success">
                            Simpan
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
    function setCategory(id, text) {
        document.getElementById('categoryInput').value = id;
        document.getElementById('categoryButton').innerText = text;
    }
</script>
@endpush

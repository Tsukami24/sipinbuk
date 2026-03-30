@extends('layouts.admin')

@section('title', 'Tambah Buku')

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-8">

            <div class="card shadow-sm border-0">
                <div class="card-header text-white" style="background-color: #0B132B;">
                    <h5 class="mb-0">Tambah Buku</h5>
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

                    <form method="POST" action="{{ route('admin.books.store') }}" enctype="multipart/form-data">
                        @csrf

                        <div class="row g-3">

                            {{-- JUDUL --}}
                            <div class="col-12">
                                <label class="form-label">Judul Buku</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light text-success">
                                        <i class="bi bi-book"></i>
                                    </span>
                                    <input type="text" name="title" class="form-control border-success"
                                        placeholder="Masukkan judul buku" value="{{ old('title') }}" required>
                                </div>
                            </div>

                            {{-- TAHUN --}}
                            <div class="col-md-3">
                                <label class="form-label">Tahun Terbit</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light text-success">
                                        <i class="bi bi-calendar"></i>
                                    </span>
                                    <input type="number" name="year" class="form-control border-success"
                                        placeholder="Tahun" value="{{ old('year') }}" required>
                                </div>
                            </div>

                            {{-- KATEGORI --}}
                            <div class="col-md-4">
                                <label class="form-label">Kategori</label>

                                <div class="dropdown">
                                    <button class="btn btn-outline-success dropdown-toggle w-100 text-start" type="button"
                                        data-bs-toggle="dropdown" id="categoryButton">
                                        -- Pilih Kategori --
                                    </button>

                                    <ul class="dropdown-menu w-100">
                                        @foreach ($categories as $category)
                                            <li>
                                                <a class="dropdown-item" href="#"
                                                    onclick="setCategory('{{ $category->id }}', '{{ $category->name }}')">
                                                    {{ $category->name }}
                                                </a>
                                            </li>
                                        @endforeach
                                    </ul>
                                </div>

                                <input type="hidden" name="category_id" id="categoryInput"
                                    value="{{ old('category_id') }}">
                            </div>

                            {{-- SUBKATEGORI --}}
                            <div class="col-md-5">
                                <label class="form-label">Subkategori</label>

                                <div class="dropdown">
                                    <button class="btn btn-outline-success dropdown-toggle w-100 text-start" type="button"
                                        data-bs-toggle="dropdown" id="subcategoryButton">
                                        -- Pilih Subkategori --
                                    </button>

                                    <ul class="dropdown-menu w-100" id="subcategoryMenu">
                                        @foreach ($subcategories as $subcategory)
                                            <li data-category="{{ $subcategory->category_id }}">
                                                <a class="dropdown-item" href="#"
                                                    onclick="setSubcategory('{{ $subcategory->id }}', '{{ $subcategory->name }}')">
                                                    {{ $subcategory->name }}
                                                </a>
                                            </li>
                                        @endforeach
                                    </ul>

                                </div>

                                <input type="hidden" name="subcategory_id" id="subcategoryInput"
                                    value="{{ old('subcategory_id') }}">
                            </div>

                            {{-- PENULIS --}}
                            <div class="col-md-6">
                                <label class="form-label">Penulis</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light text-success">
                                        <i class="bi bi-person"></i>
                                    </span>
                                    <input type="text" name="author" class="form-control border-success"
                                        placeholder="Nama penulis" value="{{ old('author') }}" required>
                                </div>
                            </div>

                            {{-- PENERBIT --}}
                            <div class="col-md-6">
                                <label class="form-label">Penerbit</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light text-success">
                                        <i class="bi bi-building"></i>
                                    </span>
                                    <input type="text" name="publisher" class="form-control border-success"
                                        placeholder="Nama penerbit" value="{{ old('publisher') }}" required>
                                </div>
                            </div>

                            {{-- COVER --}}
                            <div class="col-md-8">
                                <label class="form-label">Cover Buku</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light text-success">
                                        <i class="bi bi-image"></i>
                                    </span>
                                    <input type="file" name="cover" class="form-control border-success"
                                        accept="image/*" onchange="previewCover(this)">
                                </div>
                                <small class="text-muted d-block mt-1">Format jpg / png</small>

                                <div class="mt-3">
                                    <img id="coverPreview" class="rounded shadow-sm d-none border border-success"
                                        style="max-height: 160px; object-fit: cover;">
                                </div>
                            </div>

                            {{-- DESKRIPSI --}}
                            <div class="col-12">
                                <label class="form-label">Deskripsi</label>
                                <textarea name="description" rows="4" class="form-control border-success"
                                    placeholder="Deskripsi singkat buku">{{ old('description') }}</textarea>
                            </div>

                        </div>


                        {{-- ACTION --}}
                        <div class="d-flex justify-content-between mt-4">
                            <a href="{{ route('admin.books.index') }}" class="btn btn-secondary">
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

            document.getElementById('subcategoryInput').value = '';
            document.getElementById('subcategoryButton').innerText = '-- Pilih Subkategori --';

            const items = document.querySelectorAll('#subcategoryMenu li');

            items.forEach(item => {
                if (item.dataset.category == id) {
                    item.classList.remove('d-none');
                } else {
                    item.classList.add('d-none');
                }
            });
        }

        function setSubcategory(id, text) {
            document.getElementById('subcategoryInput').value = id;
            document.getElementById('subcategoryButton').innerText = text;
        }



        function previewCover(input) {
            const preview = document.getElementById('coverPreview');
            if (input.files && input.files[0]) {
                const reader = new FileReader();
                reader.onload = e => {
                    preview.src = e.target.result;
                    preview.classList.remove('d-none');
                };
                reader.readAsDataURL(input.files[0]);
            }
        }
    </script>
@endpush

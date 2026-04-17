@extends('layouts.admin')

@section('title', 'Tambah Buku Rusak')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-6">

        <div class="card shadow-sm border-0">
            <div class="card-header text-white" style="background-color:#0B132B;">
                <h5 class="mb-0">Tambah Buku Rusak</h5>
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

                <form method="POST" action="{{ route('admin.damaged-books.store') }}">
                    @csrf

                    {{-- PILIH BUKU --}}
                    <div class="mb-3">
                        <label class="form-label">Buku (Unit)</label>

                        <div class="dropdown">
                            <button class="btn btn-outline-success dropdown-toggle w-100 text-start"
                                    type="button"
                                    data-bs-toggle="dropdown"
                                    id="bookButton">
                                {{ old('book_item_id')
                                    ? optional($bookItems->firstWhere('id', old('book_item_id')))->book->title
                                    : '-- Pilih Buku --' }}
                            </button>

                            <ul class="dropdown-menu w-100">
                                @foreach ($bookItems as $item)
                                    <li>
                                        <a class="dropdown-item" href="#"
                                           onclick="setBook('{{ $item->id }}', '{{ $item->book->title }} - {{ $item->book_code }}')">
                                            {{ $item->book->title }} - {{ $item->book_code }}
                                        </a>
                                    </li>
                                @endforeach
                            </ul>
                        </div>

                        <input type="hidden"
                               name="book_item_id"
                               id="bookInput"
                               value="{{ old('book_item_id') }}"
                               required>
                    </div>

                    {{-- DAMAGE LEVEL --}}
                    <div class="mb-3">
                        <label class="form-label">Tingkat Kerusakan</label>

                        <div class="dropdown">
                            <button class="btn btn-outline-success dropdown-toggle w-100 text-start"
                                    type="button"
                                    data-bs-toggle="dropdown"
                                    id="damageButton">
                                {{ old('damage_level') ?? '-- Pilih Tingkat Kerusakan --' }}
                            </button>

                            <ul class="dropdown-menu w-100">
                                <li>
                                    <a class="dropdown-item" href="#"
                                       onclick="setDamage('light', 'Ringan')">
                                        Ringan
                                    </a>
                                </li>
                                <li>
                                    <a class="dropdown-item" href="#"
                                       onclick="setDamage('medium', 'Sedang')">
                                        Sedang
                                    </a>
                                </li>
                                <li>
                                    <a class="dropdown-item" href="#"
                                       onclick="setDamage('heavy', 'Parah')">
                                        Parah
                                    </a>
                                </li>
                            </ul>
                        </div>

                        <input type="hidden"
                               name="damage_level"
                               id="damageInput"
                               value="{{ old('damage_level') }}"
                               required>
                    </div>

                    {{-- DESKRIPSI --}}
                    <div class="mb-3">
                        <label class="form-label">Deskripsi</label>
                        <textarea name="description"
                                  class="form-control border-success"
                                  placeholder="Masukkan deskripsi kerusakan">{{ old('description') }}</textarea>
                    </div>

                    {{-- ACTION --}}
                    <div class="d-flex justify-content-between">
                        <a href="{{ route('admin.damaged-books.index') }}"
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
    function setBook(id, text) {
        document.getElementById('bookInput').value = id;
        document.getElementById('bookButton').innerText = text;
    }

    function setDamage(value, text) {
        document.getElementById('damageInput').value = value;
        document.getElementById('damageButton').innerText = text;
    }
</script>
@endpush

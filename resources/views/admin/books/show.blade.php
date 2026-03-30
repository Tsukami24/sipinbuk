@extends('layouts.admin')

@section('title', 'Detail Buku')

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-10">

            {{-- ========================= --}}
            {{-- DETAIL BUKU --}}
            {{-- ========================= --}}
            <div class="card shadow-sm border-0 mb-4">
                <div class="card-header text-white" style="background-color:#0B132B;">
                    <h5 class="mb-0">Detail Buku</h5>
                </div>

                <div class="card-body">
                    <div class="row g-4">

                        {{-- COVER --}}
                        <div class="col-md-4 text-center">
                            @if ($book->cover)
                                <img src="{{ asset('storage/' . $book->cover) }}" class="img-fluid rounded shadow-sm"
                                    style="max-height: 280px; object-fit: cover;">
                            @else
                                <div class="border rounded d-flex align-items-center justify-content-center"
                                    style="height: 280px; background:#F8F9FA;">
                                    <span class="text-muted">Tidak ada cover</span>
                                </div>
                            @endif
                        </div>

                        {{-- INFO --}}
                        <div class="col-md-8">
                            <div class="row">
                                <div class="col-md-6">
                                    <p><strong>Judul</strong><br>{{ $book->title }}</p>
                                    <p><strong>Penulis</strong><br>{{ $book->author }}</p>
                                    <p><strong>Penerbit</strong><br>{{ $book->publisher }}</p>
                                </div>

                                <div class="col-md-6">
                                    <p><strong>Tahun Terbit</strong><br>{{ $book->year }}</p>
                                    <p><strong>Deskripsi</strong><br>{{ $book->description ?? '-' }}</p>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>

            {{-- ========================= --}}
            {{-- TAMBAH UNIT BUKU --}}
            {{-- ========================= --}}
            <div class="card shadow-sm border-0 mb-4">
                <div class="card-header text-white" style="background-color:#0B132B;">
                    <h5 class="mb-0">Tambah Unit Buku</h5>
                </div>

                <div class="card-body">
                    <form method="POST" action="{{ route('admin.books.items.store', $book->id) }}">
                        @csrf

                        <div class="row g-3">
                            <div class="col-md-5">
                                <label class="form-label">Kode Buku</label>

                                <div class="input-group">
                                    <span class="input-group-text bg-light text-success fw-semibold">
                                        <i class="bi bi-upc-scan"></i>
                                    </span>

                                    <input type="text" name="book_code" class="form-control border-success"
                                        placeholder="Contoh: BK-001" required>
                                </div>
                            </div>


                            <div class="col-md-4">
                                <label class="form-label">Status</label>

                                <div class="dropdown">
                                    <button class="btn btn-outline-success dropdown-toggle w-100 text-start" type="button"
                                        data-bs-toggle="dropdown" aria-expanded="false" id="statusButton">
                                        Available
                                    </button>

                                    <ul class="dropdown-menu w-100">
                                        @foreach ($statuses as $value => $status)
                                            <li>
                                                <a class="dropdown-item" href="#"
                                                    onclick="setStatus('{{ $value }}', '{{ $status }}')">
                                                    {{ $status }}
                                                </a>
                                            </li>
                                        @endforeach

                                    </ul>
                                </div>

                                <input type="hidden" name="status" id="statusInput" value="available">
                            </div>


                            <div class="col-md-3 d-flex align-items-end">
                                <button class="btn btn-success w-100">
                                    Tambah Unit
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            {{-- ========================= --}}
            {{-- DAFTAR UNIT BUKU --}}
            {{-- ========================= --}}
            <div class="card shadow-sm border-0">
                <div class="card-header text-white" style="background-color:#0B132B;">
                    <h5 class="mb-0">Daftar Unit Buku</h5>
                </div>

                <div class="card-body">
                    <table id="bookItemsTable" class="table table-bordered table-striped align-middle">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Kode Buku</th>
                                <th>Status</th>
                                <th width="120">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($book->items as $item)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $item->book_code }}</td>
                                    <td>
                                        <span
                                            class="badge
                                    {{ $item->status == 'available'
                                        ? 'bg-success'
                                        : ($item->status == 'borrowed'
                                            ? 'bg-warning text-dark'
                                            : 'bg-danger') }}">
                                            {{ ucfirst($item->status) }}
                                        </span>
                                    </td>
                                    <td>
                                        <form method="POST"
                                            action="{{ route('admin.books.items.destroy', [$book->id, $item->id]) }}"
                                            onsubmit="return confirm('Hapus unit buku ini?')">
                                            @csrf
                                            @method('DELETE')

                                            <button class="btn btn-danger btn-sm w-100">
                                                Hapus
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>

                    <div class="mt-3">
                        <a href="{{ route('admin.books.index') }}" class="btn btn-secondary">
                            Kembali
                        </a>
                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection

@push('scripts')
    <script>
        function setStatus(value, text) {
            document.getElementById('statusInput').value = value;
            document.getElementById('statusButton').innerText = text;
        }

        $(document).ready(function() {
            $('#bookItemsTable').DataTable({
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

@extends('layouts.user')

@section('title', 'Profil Saya')

@section('content')
    <div class="container py-4">

        <div class="card border-0 shadow-sm rounded-4">
            <div class="card-body p-4">

                <h5 class="fw-bold mb-3">Profil Saya</h5>

                <div class="mb-3">
                    <label class="text-muted">Nama</label>
                    <div class="fw-semibold">{{ auth()->user()->name }}</div>
                </div>

                <div class="mb-3">
                    <label class="text-muted">Nis</label>
                    <div class="fw-semibold">{{ auth()->user()->nis }}</div>
                </div>

                <div class="mb-3">
                    <label class="text-muted">Kelas</label>
                    <div class="fw-semibold">
                        {{ auth()->user()->classroom->name ?? 'Belum diatur' }}
                    </div>
                </div>

                <a href="{{ route('user.password.edit') }}" class="btn btn-success">
                    Ubah Password
                </a>

            </div>
        </div>

    </div>
@endsection

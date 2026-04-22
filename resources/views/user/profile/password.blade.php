@extends('layouts.user')

@section('title', 'Ubah Password')

@section('content')
<div class="container py-4">

    <div class="card border-0 shadow-sm rounded-4">
        <div class="card-body p-4">

            <h5 class="fw-bold mb-3">Ubah Password</h5>

            @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            @if(session('error'))
                <div class="alert alert-danger">{{ session('error') }}</div>
            @endif

            <form method="POST" action="{{ route('user.password.update') }}">
                @csrf

                <div class="mb-3">
                    <label>Password Lama</label>
                    <input type="password" name="current_password" class="form-control">
                </div>

                <div class="mb-3">
                    <label>Password Baru</label>
                    <input type="password" name="password" class="form-control">
                </div>

                <div class="mb-3">
                    <label>Konfirmasi Password</label>
                    <input type="password" name="password_confirmation" class="form-control">
                </div>

                <button class="btn btn-success">
                    Simpan
                </button>

            </form>

        </div>
    </div>

</div>
@endsection

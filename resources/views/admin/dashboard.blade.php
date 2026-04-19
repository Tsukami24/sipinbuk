@extends('layouts.admin')

@section('title', 'Dashboard')

@php

    $logs = [
        (object)[
            'waktu_log' => '2026-02-01 10:15',
            'action'    => 'Tambah Kategori',
            'reason'    => 'Menambahkan kategori Buku Teknologi'
        ],
        (object)[
            'waktu_log' => '2026-02-01 11:00',
            'action'    => 'Peminjaman Buku',
            'reason'    => 'User meminjam buku Laravel Dasar'
        ],
        (object)[
            'waktu_log' => '2026-02-02 09:30',
            'action'    => 'Pengembalian Buku',
            'reason'    => 'Buku dikembalikan tepat waktu'
        ],
    ];
@endphp

@section('content')
<div class="container-fluid">

    {{-- HEADER --}}
    <div class="mb-4">
        <h4 class="fw-bold mb-1 text-dark">Dashboard</h4>
        <p class="text-muted mb-0">Selamat datang di Admin Panel</p>
    </div>

    {{-- STATISTIC CARD --}}
    <div class="row g-3 mb-4">

        <div class="col-md-4">
            <div class="card border-0 shadow-sm text-white" style="background:#0B132B">
                <div class="card-body">
                    <h6 class="text-uppercase small opacity-75">Total Buku</h6>
<h3 class="fw-bold mb-0">{{ $totalBooks }}</h3>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card border-0 shadow-sm text-white" style="background:#2D6A4F">
                <div class="card-body">
                    <h6 class="text-uppercase small opacity-75">Total Peminjaman Aktif</h6>
<h3 class="fw-bold mb-0">{{ $activeLoans }}</h3>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card border-0 shadow-sm text-white" style="background:#74C69D">
                <div class="card-body">
                    <h6 class="text-uppercase small">Total Buku Rusak</h6>
<h3 class="fw-bold mb-0">{{ $damagedBooks }}</h3>
                </div>
            </div>
        </div>

    </div>

    {{-- CHART & LOG --}}
    <div class="row g-3">

        {{-- CHART --}}
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm">
                <div class="card-header border-0" style="background:#F8F9FA">
                    <h6 class="fw-semibold mb-0 text-dark">Statistik Pengelolaan Buku</h6>
                </div>
                <div class="card-body">
                    <div style="height:300px">
                        <canvas id="loanChart"></canvas>
                    </div>
                </div>
            </div>
        </div>

        {{-- ACTIVITY LOG --}}
        <div class="col-lg-4">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-header border-0" style="background:#F8F9FA">
                    <h6 class="fw-semibold mb-0 text-dark">Log Aktivitas</h6>
                </div>
                <div class="card-body p-0">
                    <ul class="list-group list-group-flush">
                        @foreach ($logs as $log)
                            <li class="list-group-item">
                                <small class="text-muted">{{ $log->waktu_log }}</small>
                                <div class="fw-semibold">{{ $log->action }}</div>
                                <div class="small text-muted">{{ $log->reason }}</div>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>

    </div>

</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    new Chart(document.getElementById('loanChart'), {
        type: 'bar',
        data: {
            labels: ['Total Buku', 'Peminjaman Aktif', 'Buku Rusak'],
            datasets: [{
                data: [{{ $totalBooks }}, {{ $activeLoans }}, {{ $damagedBooks }}],
                backgroundColor: [
                    'rgba(11,19,43,0.85)',   // Navy
                    'rgba(45,106,79,0.85)', // Forest Green
                    'rgba(116,198,157,0.85)'// Mint
                ],
                borderRadius: 6
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: { display: false }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: { stepSize: 2 }
                }
            }
        }
    });
</script>
@endpush

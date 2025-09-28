@extends('layouts.app')

{{-- Kirim CSS kustom ke layout utama --}}
@push('styles')
<style>
    .hero-section {
        background-image: url('{{ asset('images/image.png') }}');
        background-size: cover;
        background-position: center;
        padding: 5rem 1.5rem;
        border-radius: 0.5rem;
        color: white;
        text-shadow: 2px 2px 4px rgba(0,0,0,0.6);
    }
    .stats-card {
        background-image: url('{{ asset('images/Union.png') }}');
        background-size: cover;
        background-position: center;
        background-repeat: no-repeat;
        color: white;
        padding: 4rem 2rem;
        text-align: center;
    }
    .stats-card h1 { font-size: 3rem; font-weight: bold; }
    .image-card { border-radius: 25px; box-shadow: 0 4px 8px rgba(0,0,0,0.1); }
    .flow-card { text-align: center; padding: 1.5rem; }
</style>
@endpush

@section('content')
<div class="container">
    {{-- Bagian Hero --}}
    <div class="hero-section text-center mb-5">
        <h1 class="display-4 fw-bold">LAPOR UNAIR</h1>
        <h2>Lapor Segera, Nyaman Bersama</h2>
    </div>

    {{-- Bagian Deskripsi & Tombol Aksi --}}
    <div class="row align-items-center mb-5">
        <div class="col-md-4 text-center">
            <img src="{{ asset('images/image.png') }}" class="img-fluid image-card" alt="Gerbang UNAIR">
        </div>
        <div class="col-md-8">
            <p class="lead">LaporUnair adalah layanan digital Universitas Airlangga untuk mempermudah civitas akademika dalam melaporkan berbagai kendala di kampus, mulai dari kerusakan sarana-prasarana, kendala persuratan, hingga keluhan akademik. Sistem ini memastikan laporan tersampaikan langsung ke unit kerja terkait, dapat dipantau statusnya secara real-time, serta ditangani dengan lebih cepat dan transparan.</p>
            <a href="{{ route('reports.create') }}" class="btn btn-primary btn-lg">Buat Laporan Baru</a>
        </div>
    </div>

    {{-- Bagian Alur Pelaporan --}}
    <div class="row text-center mb-5 align-items-center">
        <div class="col-md-3">
            <div class="flow-card">
                <img src="{{ asset('images/padi (7) 1.png') }}" alt="Kirim Laporan" class="img-fluid mb-3" style="max-height: 80px;">
                <h4>Kirim Laporan</h4>
            </div>
        </div>
        <div class="col-md-3">
            <div class="flow-card">
                <img src="{{ asset('images/padi (6) 1.png') }}" alt="Laporan Diproses" class="img-fluid mb-3" style="max-height: 80px;">
                <h4>Laporan Diproses</h4>
            </div>
        </div>
        <div class="col-md-3">
            <div class="flow-card">
                <img src="{{ asset('images/padi (5) 1.png') }}" alt="Masalah Selesai" class="img-fluid mb-3" style="max-height: 80px;">
                <h4>Masalah Selesai</h4>
            </div>
        </div>
        <div class="col-md-3">
            <div class="flow-card">
                <img src="{{ asset('images/padi (4) 1.png') }}" alt="Nilai Pelayanan" class="img-fluid mb-3" style="max-height: 80px;">
                <h4>Nilai Pelayanan</h4>
            </div>
        </div>
    </div>

    {{-- Bagian Statistik Laporan (Gunakan data dinamis dari Controller) --}}
    <div class="stats-card">
        <h3 class="mb-4">Jumlah Laporan Saat Ini</h3>
        <div class="row">
            <div class="col-4"><h1>{{ $pendingCount }}</h1><p>Terkirim</p></div>
            <div class="col-4"><h1>{{ $inProgressCount }}</h1><p>Dalam Proses</p></div>
            <div class="col-4"><h1>{{ $completedCount }}</h1><p>Selesai</p></div>
        </div>
    </div>
</div>
@endsection
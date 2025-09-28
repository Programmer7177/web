@extends('layouts.app')

@section('content')
<div class="container">
    <div class="card shadow-sm">
        <div class="card-header bg-white d-flex justify-content-between align-items-center">
            <h2 class="mb-0">Detail Laporan</h2>
            <a class="btn btn-secondary" href="{{ route('reports.index') }}"> Kembali</a>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-8">
                    <h3 class="card-title mb-3">{{ $report->title }}</h3>
                    <p class="card-text">{{ $report->description }}</p>
                </div>
                <div class="col-md-4">
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item d-flex justify-content-between">
                            <strong>Status:</strong>
                            <span class="badge bg-warning text-dark">{{ Str::title(str_replace('_', ' ', $report->status)) }}</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between">
                            <strong>Kategori:</strong>
                            <span>{{ $report->category->name }}</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between">
                            <strong>Instansi:</strong>
                            <span>{{ $report->instansi->name ?? 'N/A' }}</span>
                        </li>
                         <li class="list-group-item d-flex justify-content-between">
                            <strong>Lokasi:</strong>
                            <span>{{ $report->location }}</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between">
                            <strong>Pelapor:</strong>
                            <span>{{ $report->reporter->username ?? 'N/A' }}</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between">
                            <strong>Tanggal:</strong>
                            <span>{{ $report->created_at->format('d M Y, H:i') }}</span>
                        </li>
                        @if($report->attachment_path)
                            <li class="list-group-item d-flex justify-content-between">
                                <strong>Lampiran:</strong>
                                <a href="{{ Storage::url($report->attachment_path) }}" target="_blank">Lihat Lampiran</a>
                            </li>
                        @endif
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
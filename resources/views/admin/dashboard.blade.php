@extends('layouts.admin')

@section('content')
<div class="container">
    <div class="d-flex align-items-center justify-content-between mb-3">
        <h2 class="h4 fw-bold mb-0">Daftar Laporan</h2>
        <div class="d-flex gap-2">
            <button class="btn btn-outline-secondary btn-sm" type="button" data-bs-toggle="collapse" data-bs-target="#filters" aria-expanded="false" aria-controls="filters">
                <i class="bi bi-funnel"></i> Filter
            </button>
            <button class="btn btn-primary btn-sm" type="button" onclick="window.print()">
                <i class="bi bi-printer"></i> Cetak
            </button>
        </div>
    </div>
    <div id="filters" class="collapse mb-3">
        <div class="card border-0 shadow-sm">
            <div class="card-body p-3">
                <div class="row g-2">
                    <div class="col-12 col-md-4">
                        <input type="text" class="form-control" placeholder="Cari judul atau deskripsi..." aria-label="Cari">
                    </div>
                    <div class="col-6 col-md-3">
                        <select class="form-select" aria-label="Filter Kategori">
                            <option value="">Semua Kategori</option>
                        </select>
                    </div>
                    <div class="col-6 col-md-3">
                        <select class="form-select" aria-label="Filter Status">
                            <option value="">Semua Status</option>
                            <option value="pending">Pending</option>
                            <option value="proses">Proses</option>
                            <option value="selesai">Selesai</option>
                        </select>
                    </div>
                    <div class="col-12 col-md-2 d-grid d-md-block">
                        <button class="btn btn-primary w-100" type="button"><i class="bi bi-search"></i> Terapkan</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="card border-0 shadow-sm">
        <div class="card-body">

            @if ($message = Session::get('success'))
                <div class="alert alert-success">
                    <p>{{ $message }}</p>
                </div>
            @endif

            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>No. Laporan</th>
                            <th>Nama Pelapor</th>
                            <th>Kategori</th>
                            <th>Instansi</th>
                            <th>Judul Laporan</th>
                            <th>Lokasi</th>
                            <th>Tanggal Laporan</th>
                            <th>Deskripsi</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($reports as $report)
                        <tr>
                            <td>#{{ $report->report_id }}</td>
                            <td>{{ $report->reporter->username ?? 'N/A' }}</td>
                            <td>{{ $report->category->name }}</td>
                            <td>{{ $report->instansi->name ?? 'N/A' }}</td>
                            <td>{{ Str::limit($report->title, 20) }}</td>
                            <td>{{ $report->location }}</td>
                            <td>{{ $report->created_at->format('d M Y') }}</td>
                            <td>{{ Str::limit($report->description, 30) }}</td>
                            <td>
                                @php
                                    $status = Str::of($report->status)->replace('_', ' ')->title();
                                    $badgeClass = 'bg-secondary';
                                    if (Str::contains(strtolower($report->status), 'pending')) $badgeClass = 'bg-warning text-dark';
                                    elseif (Str::contains(strtolower($report->status), 'proses')) $badgeClass = 'bg-info text-dark';
                                    elseif (Str::contains(strtolower($report->status), 'selesai')) $badgeClass = 'bg-success';
                                @endphp
                                <span class="badge {{ $badgeClass }}">{{ $status }}</span>
                            </td>
                            <td>
                                <div class="btn-group" role="group" aria-label="Aksi Laporan">
                                    <a class="btn btn-outline-secondary btn-sm" href="{{ route('reports.show', $report->report_id) }}" data-bs-toggle="tooltip" data-bs-title="Lihat Detail">
                                        <i class="bi bi-eye"></i>
                                    </a>
                                    <a class="btn btn-outline-primary btn-sm" href="{{ route('reports.edit', $report->report_id) }}" data-bs-toggle="tooltip" data-bs-title="Edit Laporan">
                                        <i class="bi bi-pencil"></i>
                                    </a>
                                    <form action="{{ route('reports.destroy', $report->report_id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus laporan ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-outline-danger btn-sm" data-bs-toggle="tooltip" data-bs-title="Hapus Laporan">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                            <tr>
                                <td colspan="10" class="text-center text-muted">Belum ada laporan yang masuk.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="d-flex justify-content-center">
                {!! $reports->links() !!}
            </div>
        </div>
    </div>
</div>
@endsection

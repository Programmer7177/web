@extends('layouts.admin')

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-4 border-bottom">
    <h1 class="h2 text-white fw-bold">
        <i class="fas fa-tachometer-alt me-2"></i>
        Dashboard Admin
    </h1>
    <div class="btn-toolbar mb-2 mb-md-0">
        <div class="btn-group me-2">
            <button type="button" class="btn btn-outline-light">
                <i class="fas fa-download me-1"></i>
                Export
            </button>
            <button type="button" class="btn btn-outline-light">
                <i class="fas fa-filter me-1"></i>
                Filter
            </button>
        </div>
    </div>
</div>

<!-- Statistics Cards -->
<div class="row mb-4">
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="stats-card">
            <div class="d-flex align-items-center">
                <div class="stats-icon" style="background: linear-gradient(135deg, #667eea, #764ba2);">
                    <i class="fas fa-file-alt"></i>
                </div>
                <div class="ms-3">
                    <div class="stats-number">{{ $reports->total() ?? 0 }}</div>
                    <div class="stats-label">Total Laporan</div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="stats-card">
            <div class="d-flex align-items-center">
                <div class="stats-icon" style="background: linear-gradient(135deg, #fbbf24, #f59e0b);">
                    <i class="fas fa-clock"></i>
                </div>
                <div class="ms-3">
                    <div class="stats-number">{{ $reports->where('status', 'pending')->count() ?? 0 }}</div>
                    <div class="stats-label">Menunggu</div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="stats-card">
            <div class="d-flex align-items-center">
                <div class="stats-icon" style="background: linear-gradient(135deg, #3b82f6, #1d4ed8);">
                    <i class="fas fa-cogs"></i>
                </div>
                <div class="ms-3">
                    <div class="stats-number">{{ $reports->where('status', 'processing')->count() ?? 0 }}</div>
                    <div class="stats-label">Diproses</div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="stats-card">
            <div class="d-flex align-items-center">
                <div class="stats-icon" style="background: linear-gradient(135deg, #10b981, #059669);">
                    <i class="fas fa-check-circle"></i>
                </div>
                <div class="ms-3">
                    <div class="stats-number">{{ $reports->where('status', 'completed')->count() ?? 0 }}</div>
                    <div class="stats-label">Selesai</div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Reports Table -->
<div class="modern-table">
    <div class="p-4 border-bottom">
        <div class="d-flex justify-content-between align-items-center">
            <h5 class="mb-0 fw-bold text-dark">
                <i class="fas fa-list me-2"></i>
                Daftar Laporan
            </h5>
            <div class="d-flex gap-2">
                <div class="input-group" style="width: 250px;">
                    <span class="input-group-text bg-white border-end-0">
                        <i class="fas fa-search text-muted"></i>
                    </span>
                    <input type="text" class="form-control border-start-0" placeholder="Cari laporan...">
                </div>
                <button class="btn btn-outline-primary">
                    <i class="fas fa-sync-alt me-1"></i>
                    Refresh
                </button>
            </div>
        </div>
    </div>

    @if ($message = Session::get('success'))
        <div class="alert alert-success alert-dismissible fade show m-4" role="alert">
            <i class="fas fa-check-circle me-2"></i>
            {{ $message }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="table-responsive">
        <table class="table table-hover align-middle mb-0">
            <thead>
                <tr>
                    <th>No. Laporan</th>
                    <th>Pelapor</th>
                    <th>Kategori</th>
                    <th>Instansi</th>
                    <th>Judul</th>
                    <th>Lokasi</th>
                    <th>Tanggal</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($reports as $report)
                <tr>
                    <td>
                        <div class="d-flex align-items-center">
                            <div class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center me-2" style="width: 35px; height: 35px; font-size: 0.8rem; font-weight: 600;">
                                #{{ $report->report_id }}
                            </div>
                        </div>
                    </td>
                    <td>
                        <div class="d-flex align-items-center">
                            <div class="bg-light rounded-circle d-flex align-items-center justify-content-center me-2" style="width: 35px; height: 35px;">
                                <i class="fas fa-user text-muted"></i>
                            </div>
                            <div>
                                <div class="fw-medium">{{ $report->reporter->username ?? 'N/A' }}</div>
                                <small class="text-muted">{{ $report->reporter->email ?? '' }}</small>
                            </div>
                        </div>
                    </td>
                    <td>
                        <span class="badge bg-light text-dark border">
                            {{ $report->category->name }}
                        </span>
                    </td>
                    <td>
                        <span class="text-muted">{{ $report->instansi->name ?? 'N/A' }}</span>
                    </td>
                    <td>
                        <div class="fw-medium" style="max-width: 200px;">
                            {{ Str::limit($report->title, 30) }}
                        </div>
                        <small class="text-muted">{{ Str::limit($report->description, 40) }}</small>
                    </td>
                    <td>
                        <span class="text-muted">{{ Str::limit($report->location, 20) }}</span>
                    </td>
                    <td>
                        <div class="fw-medium">{{ $report->created_at->format('d M Y') }}</div>
                        <small class="text-muted">{{ $report->created_at->format('H:i') }}</small>
                    </td>
                    <td>
                        @php
                            $statusClass = match($report->status) {
                                'pending' => 'status-pending',
                                'processing' => 'status-processing',
                                'completed' => 'status-completed',
                                'rejected' => 'status-rejected',
                                default => 'status-pending'
                            };
                        @endphp
                        <span class="status-badge {{ $statusClass }}">
                            {{ Str::title(str_replace('_', ' ', $report->status)) }}
                        </span>
                    </td>
                    <td>
                        <div class="d-flex gap-1">
                            <a class="btn btn-action btn-view" href="{{ route('reports.show', $report->report_id) }}" title="Lihat Detail">
                                <i class="fas fa-eye"></i>
                            </a>
                            <a class="btn btn-action btn-edit" href="{{ route('reports.edit', $report->report_id) }}" title="Edit">
                                <i class="fas fa-edit"></i>
                            </a>
                            <form action="{{ route('reports.destroy', $report->report_id) }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-action btn-delete" title="Hapus" onclick="return confirm('Apakah Anda yakin ingin menghapus laporan ini?')">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                    <tr>
                        <td colspan="9" class="text-center py-5">
                            <div class="text-muted">
                                <i class="fas fa-inbox fa-3x mb-3 d-block"></i>
                                <h5>Belum ada laporan yang masuk</h5>
                                <p class="mb-0">Laporan akan muncul di sini setelah ada yang mengirim.</p>
                            </div>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($reports->hasPages())
        <div class="p-4 border-top">
            <div class="d-flex justify-content-center">
                {!! $reports->links() !!}
            </div>
        </div>
    @endif
</div>
@endsection

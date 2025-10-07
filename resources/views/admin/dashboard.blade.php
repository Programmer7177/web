@extends('layouts.admin')

@section('content')
<div class="container">
    {{-- Metrik ringkas --}}
    @isset($metrics)
    <div class="row g-3 mb-3">
        <div class="col-12 col-md-3">
            <div class="card border-0 shadow-sm h-100" style="background: linear-gradient(135deg, #eef2ff, #e0e7ff);">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <div class="small text-muted">Total Laporan</div>
                            <div class="h4 fw-bold mb-0">{{ $metrics['total'] ?? 0 }}</div>
                        </div>
                        <i class="bi bi-clipboard-data text-primary fs-3"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-12 col-md-3">
            <div class="card border-0 shadow-sm h-100" style="background: linear-gradient(135deg, #fff7ed, #ffedd5);">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <div class="small text-muted">Pending</div>
                            <div class="h4 fw-bold mb-0">{{ $metrics['pending'] ?? 0 }}</div>
                        </div>
                        <i class="bi bi-hourglass-split text-warning fs-3"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-12 col-md-3">
            <div class="card border-0 shadow-sm h-100" style="background: linear-gradient(135deg, #ecfeff, #cffafe);">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <div class="small text-muted">In Progress</div>
                            <div class="h4 fw-bold mb-0">{{ $metrics['in_progress'] ?? 0 }}</div>
                        </div>
                        <i class="bi bi-gear text-info fs-3"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-12 col-md-3">
            <div class="card border-0 shadow-sm h-100" style="background: linear-gradient(135deg, #f0fdf4, #dcfce7);">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <div class="small text-muted">Completed</div>
                            <div class="h4 fw-bold mb-0">{{ $metrics['completed'] ?? 0 }}</div>
                        </div>
                        <i class="bi bi-check2-circle text-success fs-3"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endisset

    <div class="d-flex align-items-center justify-content-between mb-3">
        <h2 class="h4 fw-bold mb-0">Daftar Laporan</h2>
        <div class="d-flex gap-2">
            <a class="btn btn-outline-success btn-sm" href="{{ route('dashboard.export', request()->query()) }}">
                <i class="bi bi-filetype-csv"></i> Ekspor CSV
            </a>
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
                <form action="{{ route('dashboard') }}" method="GET">
                    <div class="row g-2 align-items-end">
                        <div class="col-12 col-md-4">
                            <label class="form-label small">Pencarian</label>
                            <input name="q" value="{{ $search ?? request('q') }}" type="text" class="form-control" placeholder="Cari judul, deskripsi, lokasi" aria-label="Cari">
                        </div>
                        <div class="col-6 col-md-3">
                            <label class="form-label small">Kategori</label>
                            <select name="category_id" class="form-select" aria-label="Filter Kategori">
                                <option value="">Semua Kategori</option>
                                @isset($categories)
                                    @foreach ($categories as $cat)
                                        <option value="{{ $cat->category_id }}" {{ (string)($categoryId ?? request('category_id')) === (string)$cat->category_id ? 'selected' : '' }}>{{ $cat->name }}</option>
                                    @endforeach
                                @endisset
                            </select>
                        </div>
                        <div class="col-6 col-md-3">
                            <label class="form-label small">Status</label>
                            <select name="status" class="form-select" aria-label="Filter Status">
                                <option value="">Semua Status</option>
                                <option value="pending" {{ ($status ?? request('status')) === 'pending' ? 'selected' : '' }}>Pending</option>
                                <option value="in_progress" {{ ($status ?? request('status')) === 'in_progress' ? 'selected' : '' }}>In Progress</option>
                                <option value="completed" {{ ($status ?? request('status')) === 'completed' ? 'selected' : '' }}>Completed</option>
                            </select>
                        </div>
                        <div class="col-12 col-md-2 d-grid d-md-block">
                            <button class="btn btn-primary w-100" type="submit"><i class="bi bi-search"></i> Terapkan</button>
                        </div>
                        <div class="col-12 col-md-auto">
                            <a class="btn btn-outline-secondary w-100" href="{{ route('dashboard') }}">Reset</a>
                        </div>
                    </div>
                </form>
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
                            <th>Rating</th>
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
                                    if ($report->status === 'pending') $badgeClass = 'bg-warning text-dark';
                                    elseif ($report->status === 'in_progress') $badgeClass = 'bg-info text-dark';
                                    elseif ($report->status === 'completed') $badgeClass = 'bg-success';
                                @endphp
                                <span class="badge {{ $badgeClass }}">{{ $status }}</span>
                            </td>
                            <td>
                                @if($report->status === 'completed')
                                    @if($report->ratings->count() > 0)
                                        @php
                                            $rating = $report->ratings->first();
                                        @endphp
                                        <div class="d-flex align-items-center gap-1">
                                            <x-star-rating :rating="$rating->rating_value" :interactive="false" size="sm" />
                                            <small class="text-muted">({{ $rating->rating_value }}/5)</small>
                                        </div>
                                        @if($rating->comment)
                                            <small class="text-muted d-block" style="font-size: 0.75rem;">{{ Str::limit($rating->comment, 30) }}</small>
                                        @endif
                                    @else
                                        <span class="badge bg-light text-dark">Belum dirating</span>
                                    @endif
                                @else
                                    <span class="text-muted">-</span>
                                @endif
                            </td>
                            <td>
                                <div class="d-flex align-items-center gap-2 flex-wrap">
                                    <div class="btn-group" role="group" aria-label="Navigasi Laporan">
                                        <a class="btn btn-outline-secondary btn-sm" href="{{ route('reports.show', $report->report_id) }}" data-bs-toggle="tooltip" data-bs-title="Lihat Detail">
                                            <i class="bi bi-eye"></i>
                                        </a>
                                        @if($report->status !== 'completed')
                                            <a class="btn btn-outline-primary btn-sm" href="{{ route('reports.edit', $report->report_id) }}" data-bs-toggle="tooltip" data-bs-title="Edit Laporan">
                                                <i class="bi bi-pencil"></i>
                                            </a>
                                        @endif
                                    </div>
                                    @if($report->status !== 'completed')
                                        <form action="{{ route('reports.destroy', $report->report_id) }}" method="POST" class="d-inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus laporan ini?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-outline-danger btn-sm" data-bs-toggle="tooltip" data-bs-title="Hapus Laporan">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </form>
                                    @endif
                                </div>
                            </td>
                        </tr>
                        @empty
                            <tr>
                                <td colspan="11" class="text-center text-muted">Belum ada laporan yang masuk.</td>
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

@extends('layouts.admin')

@push('styles')
<style>
    .kpi-card { border:0; border-radius:16px; box-shadow:0 10px 24px rgba(0,0,0,.06); }
    .kpi-value { font-weight:800; font-size:2rem; }
    .kpi-label { color:#64748b; font-size:.9rem }
    .badge-status { text-transform: capitalize; }
    .table thead th { white-space: nowrap; }
</style>
@endpush

@section('content')
<div class="container">
    @if ($message = Session::get('success'))
        <div class="alert alert-success">{{ $message }}</div>
    @endif

    <!-- KPIs -->
    <div class="row g-3 mb-4">
        <div class="col-sm-6 col-lg-3">
            <div class="card kpi-card p-3">
                <div class="d-flex align-items-center">
                    <div class="flex-grow-1">
                        <div class="kpi-value">{{ $totalReports }}</div>
                        <div class="kpi-label">Total Laporan</div>
                    </div>
                    <span class="fs-3">📊</span>
                </div>
            </div>
        </div>
        <div class="col-sm-6 col-lg-3">
            <div class="card kpi-card p-3">
                <div class="d-flex align-items-center">
                    <div class="flex-grow-1">
                        <div class="kpi-value">{{ $pendingCount }}</div>
                        <div class="kpi-label">Pending</div>
                    </div>
                    <span class="fs-3">⏳</span>
                </div>
            </div>
        </div>
        <div class="col-sm-6 col-lg-3">
            <div class="card kpi-card p-3">
                <div class="d-flex align-items-center">
                    <div class="flex-grow-1">
                        <div class="kpi-value">{{ $inProgressCount }}</div>
                        <div class="kpi-label">Dalam Proses</div>
                    </div>
                    <span class="fs-3">🚧</span>
                </div>
            </div>
        </div>
        <div class="col-sm-6 col-lg-3">
            <div class="card kpi-card p-3">
                <div class="d-flex align-items-center">
                    <div class="flex-grow-1">
                        <div class="kpi-value">{{ $completedCount }}</div>
                        <div class="kpi-label">Selesai</div>
                    </div>
                    <span class="fs-3">✅</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Charts -->
    <div class="row g-3 mb-4">
        <div class="col-lg-8">
            <div class="card kpi-card p-3 h-100">
                <div class="d-flex justify-content-between align-items-center mb-2">
                    <h6 class="mb-0">Tren Laporan 7 Hari</h6>
                </div>
                <canvas id="trendChart" height="110"></canvas>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="card kpi-card p-3 h-100">
                <div class="d-flex justify-content-between align-items-center mb-2">
                    <h6 class="mb-0">Sebaran Kategori</h6>
                </div>
                <canvas id="categoryChart" height="110"></canvas>
            </div>
        </div>
    </div>

    <!-- Table -->
    <div class="card border-0 shadow-sm">
        <div class="card-body">
            <h5 class="mb-3">Daftar Laporan Terbaru</h5>
            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead class="table-light">
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
                            <td>#{{ $report->report_id }}</td>
                            <td>{{ $report->reporter->username ?? 'N/A' }}</td>
                            <td>{{ $report->category->name ?? 'N/A' }}</td>
                            <td>{{ $report->instansi->name ?? 'N/A' }}</td>
                            <td>{{ Str::limit($report->title, 24) }}</td>
                            <td>{{ $report->location }}</td>
                            <td>{{ $report->created_at->format('d M Y') }}</td>
                            <td>
                                @php($st = $report->status)
                                <span class="badge badge-status {{
                                    $st==='completed' ? 'bg-success' : ($st==='in_progress' ? 'bg-primary' : 'bg-warning text-dark')
                                }}">{{ Str::title(str_replace('_',' ',$st)) }}</span>
                            </td>
                            <td>
                                <form action="{{ route('reports.destroy', $report->report_id) }}" method="POST" class="d-inline-flex">
                                    <a class="btn btn-sm btn-info me-1" href="{{ route('reports.show', $report->report_id) }}">Lihat</a>
                                    <a class="btn btn-sm btn-primary me-1" href="{{ route('reports.edit', $report->report_id) }}">Edit</a>
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Apakah Anda yakin ingin menghapus laporan ini?')">Hapus</button>
                                </form>
                            </td>
                        </tr>
                        @empty
                            <tr>
                                <td colspan="9" class="text-center text-muted">Belum ada laporan yang masuk.</td>
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

@push('styles')
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.1/dist/chart.umd.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function(){
    const trendCtx = document.getElementById('trendChart');
    if (trendCtx) {
        new Chart(trendCtx, {
            type: 'line',
            data: {
                labels: @json($trendLabels ?? []),
                datasets: [{
                    label: 'Laporan',
                    data: @json($trendCounts ?? []),
                    borderColor: '#0f5bd8',
                    backgroundColor: 'rgba(15,91,216,0.12)',
                    tension: .35,
                    fill: true,
                    pointRadius: 3,
                }]
            },
            options: {
                plugins: { legend: { display:false } },
                scales: { y: { beginAtZero:true, ticks: { precision:0 } } }
            }
        });
    }
    const catCtx = document.getElementById('categoryChart');
    if (catCtx) {
        const data = @json(($byCategory ?? collect())->pluck('value'));
        const labels = @json(($byCategory ?? collect())->pluck('label'));
        new Chart(catCtx, {
            type: 'doughnut',
            data: { labels, datasets: [{ data, backgroundColor: ['#0ea5a6','#38bdf8','#a78bfa','#f59e0b','#ef4444','#10b981','#6366f1'] }] },
            options: { plugins: { legend: { position:'bottom' } } }
        });
    }
});
</script>
@endpush

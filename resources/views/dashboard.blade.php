@extends('layouts.app')

{{-- Kirim CSS kustom ke layout utama --}}
@push('styles')
<style>
    body {
        /* Warna dasar yang netral */
        background-color: #f8f9fa;
        /* Dua sumber cahaya radial yang menyebar dengan lembut */
        background-image: 
            radial-gradient(circle at top left, rgba(255, 221, 114, 0.2), transparent 100%),
            radial-gradient(circle at bottom right, rgba(144, 202, 249, 0.3), transparent 100%);
        background-attachment: fixed;
    }

    .hero-section {
        background-image: url('{{ asset('images/image_main.png') }}'); /* Ganti dengan gambar hero yang besar */
        background-size: cover;
        background-position: center;
        padding: 8rem 1.5rem; /* Padding lebih besar untuk memperbesar ke bawah */
        border-radius: 0.5rem;
        color: white;
        text-shadow: 2px 2px 4px rgba(0,0,0,0.6);
        margin-bottom: 3rem;
        position: relative; /* Untuk menempatkan logo LaporUnair di atas gambar */
    }
    .hero-title-container {
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        text-align: center;
        width: 80%; /* Batasi lebar container judul */
    }
    .hero-title-container img {
        height: 60px; /* Ukuran logo LaporUnair di hero */
        margin-bottom: 10px;
    }
    .hero-title-container h2 {
        font-size: 1.5rem;
        font-weight: normal;
        margin-top: 0;
    }

    .description-section {
        margin-bottom: 5rem;
    }
    .description-section p.lead {
        line-height: 1.8; /* Rapatkan baris teks */
        margin-bottom: 2rem;
    }
    .image-card {
        border-radius: 25px;
        box-shadow: 0 4px 8px rgba(0,0,0,0.1);
        width: 100%;
        height: auto;
        max-width: 350px; /* Batasi ukuran gambar gerbang */
        margin: 0 auto; /* Tengah gambar */
    }

    .flow-section {
        margin-bottom: 5rem;
    }
    .flow-card:not(:first-child)::before {
        content: '';
        position: absolute;
        top: 50px; 
        right: 50%;
        width: 100%;
    
        /* REVISI DI SINI */
        height: 10px; /* Sesuaikan dengan tinggi gambar garis Anda */
        background-image: url('{{ asset('images/garis.png') }}');
        background-size: contain;
        background-repeat: no-repeat;
        background-position: center;
    
        /*z-index: -1;*/
    }
    .flow-card img {
        max-height: 90px; /* Ukuran ikon alur */
        margin-bottom: 1rem;
    }
    .flow-card h4 {
        font-weight: bold;
        color: #333;
    }

    .stats-card {
        background-image: url('{{ asset('images/Union.png') }}'); /* Gambar background untuk statistik */
        background-size: cover;
        background-position: center;
        background-repeat: no-repeat;
        color: white;
        padding: 5rem 2rem; /* Padding lebih besar */
        text-align: center;
        border-radius: 1rem;
        box-shadow: 0 8px 25px rgba(0,0,0,0.2);
        margin-bottom: 5rem; /* Memberi jarak ke footer */
    }
    .stats-card h3 {
        font-size: 2rem;
        font-weight: bold;
        margin-bottom: 2rem;
    }
    .stats-card h1 {
        font-size: 4.5rem; /* Ukuran angka lebih besar */
        font-weight: bolder;
        margin-bottom: 0.5rem;
    }
    .stats-card p {
        font-size: 1.2rem;
        margin-bottom: 0;
    }

    /* Responsif untuk layar kecil */
    @media (max-width: 768px) {
        .hero-section {
            padding: 5rem 1rem;
        }
        .hero-title-container img {
            height: 40px;
        }
        .hero-title-container h2 {
            font-size: 1.2rem;
        }
        body {
            background: #f0f2f5; /* Nonaktifkan gradasi di mobile jika tidak cocok */
        }
        .intro-image-right-wrapper {
            position: relative; /* Ubah ke relatif di mobile */
            text-align: center;
            margin-top: 2rem;
        }
        .intro-megaphone-img {
            position: static; /* Hilangkan posisi absolut di mobile */
            width: 70px;
            margin-top: 1rem;
            transform: none;
        }
    }
</style>
@endpush

@section('content')
    {{-- Bagian Hero --}}
    <div class="hero-section">
        <div class="hero-title-container">
            <img src="{{ asset('images/logo laporunair.png') }}" alt="Lapor Unair Logo" class="img-fluid">
            <h2 class="text-white">Lapor Segera, Nyaman Bersama</h2>
        </div>
    </div>

    {{-- Bagian Deskripsi & Tombol Aksi --}}
    <div class="description-section">
        <div class="row align-items-center">
            <div class="col-md-4 text-center">
                <img src="{{ asset('images/image.png') }}" class="img-fluid image-card" alt="Gerbang UNAIR">
            </div>
            <div class="col-md-8 px-4">
                <p class="lead text-dark">LaporUnair adalah layanan digital Universitas Airlangga untuk mempermudah civitas akademika dalam melaporkan berbagai kendala di kampus, mulai dari kerusakan sarana-prasarana, kendala persuratan, hingga keluhan akademik. Sistem ini memastikan laporan tersampaikan langsung ke unit kerja terkait, dapat dipantau statusnya secara real-time, serta ditangani dengan lebih cepat dan transparan.</p>
                <a href="{{ route('reports.create') }}" class="btn btn-primary btn-lg rounded-pill px-4 py-2">Buat Laporan Baru</a>
            </div>
        </div>
    </div>

    {{-- Bagian Alur Pelaporan --}}
    <div class="flow-section">
        <h2 class="text-center mb-5 fw-bold">Alur Pelaporan</h2>
        <div class="row text-center justify-content-center">
            <div class="col-md-3">
                <div class="flow-card">
                    <img src="{{ asset('images/padi (7) 1.png') }}" alt="Kirim Laporan" class="img-fluid mb-3">
                    <h4>Kirim Laporan</h4>
                </div>
            </div>
            <div class="col-md-3">
                <div class="flow-card">
                    <img src="{{ asset('images/padi (6) 1.png') }}" alt="Laporan Diproses" class="img-fluid mb-3">
                    <h4>Laporan Diproses</h4>
                </div>
            </div>
            <div class="col-md-3">
                <div class="flow-card">
                    <img src="{{ asset('images/padi (5) 1.png') }}" alt="Masalah Selesai" class="img-fluid mb-3">
                    <h4>Masalah Selesai</h4>
                </div>
            </div>
            <div class="col-md-3">
                <div class="flow-card">
                    <img src="{{ asset('images/padi (4) 1.png') }}" alt="Nilai Pelayanan" class="img-fluid mb-3">
                    <h4>Nilai Pelayanan</h4>
                </div>
            </div>
        </div>
    </div>

    {{-- Bagian Statistik Laporan --}}
    <div class="stats-card">
        <h3 class="mb-4">Jumlah Laporan Saat Ini</h3>
        <div class="row justify-content-center">
            <div class="col-md-3 col-6 mb-3"><h1 class="stat-number" data-countup data-target="{{ $pendingCount }}">0</h1><p>Terkirim</p></div>
            <div class="col-md-3 col-6 mb-3"><h1 class="stat-number" data-countup data-target="{{ $inProgressCount }}">0</h1><p>Dalam Proses</p></div>
            <div class="col-md-3 col-6 mb-3"><h1 class="stat-number" data-countup data-target="{{ $completedCount }}">0</h1><p>Selesai</p></div>
        </div>
    </div>

    {{-- Widget Interaktif: Tren 7 Hari & Distribusi Status --}}
    <div class="row g-4 mb-5">
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h5 class="mb-0">Tren Laporan 7 Hari Terakhir</h5>
                        <span class="text-muted small">Semua laporan</span>
                    </div>
                    <canvas id="reportsTrendChart" height="120"></canvas>
                </div>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <h5 class="mb-3">Distribusi Status</h5>
                    <canvas id="statusDoughnutChart" height="200"></canvas>
                    <div class="mt-3 d-flex flex-column gap-1">
                        <div class="d-flex justify-content-between"><span class="badge bg-secondary">Terkirim</span><span>{{ $statusCounts['pending'] ?? $pendingCount }}</span></div>
                        <div class="d-flex justify-content-between"><span class="badge bg-info text-dark">Dalam Proses</span><span>{{ $statusCounts['in_progress'] ?? $inProgressCount }}</span></div>
                        <div class="d-flex justify-content-between"><span class="badge bg-success">Selesai</span><span>{{ $statusCounts['completed'] ?? $completedCount }}</span></div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Laporan Terbaru --}}
    <div class="card border-0 shadow-sm mb-5">
        <div class="card-body">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h5 class="mb-0">Laporan Terbaru Anda</h5>
                <a href="{{ route('reports.index') }}" class="btn btn-sm btn-outline-primary">Lihat Semua</a>
            </div>
            @if(isset($latestReports) && $latestReports->count())
                <div class="table-responsive">
                    <table class="table align-middle">
                        <thead class="table-light">
                            <tr>
                                <th>Judul</th>
                                <th>Kategori</th>
                                <th>Lokasi</th>
                                <th>Status</th>
                                <th>Tanggal</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($latestReports as $report)
                                <tr>
                                    <td>{{ Str::limit($report->title, 40) }}</td>
                                    <td>{{ $report->category->name ?? '-' }}</td>
                                    <td>{{ Str::limit($report->location, 24) }}</td>
                                    <td>
                                        @php
                                            $badgeClass = match($report->status) {
                                                'completed' => 'bg-success',
                                                'in_progress' => 'bg-info text-dark',
                                                'pending' => 'bg-warning text-dark',
                                                default => 'bg-secondary',
                                            };
                                        @endphp
                                        <span class="badge {{ $badgeClass }}">{{ Str::title(str_replace('_', ' ', $report->status)) }}</span>
                                    </td>
                                    <td>{{ $report->created_at->format('d M Y') }}</td>
                                    <td>
                                        <a href="{{ route('reports.show', $report->report_id) }}" class="btn btn-sm btn-outline-secondary">Lihat</a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <p class="text-muted mb-0">Belum ada laporan terbaru.</p>
            @endif
        </div>
    </div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.1/dist/chart.umd.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function () {
  const counters = document.querySelectorAll('[data-countup]');
  if (counters.length) {
    const animateCounter = function (el, target) {
      const duration = 1200;
      const startTime = performance.now();
      const step = function (now) {
        const progress = Math.min((now - startTime) / duration, 1);
        const value = Math.floor(progress * target);
        el.textContent = value.toString();
        if (progress < 1) requestAnimationFrame(step);
      };
      requestAnimationFrame(step);
    };
    const obs = new IntersectionObserver((entries, observer) => {
      entries.forEach(entry => {
        if (entry.isIntersecting) {
          const el = entry.target;
          const target = parseInt(el.getAttribute('data-target') || '0', 10);
          animateCounter(el, target);
          observer.unobserve(el);
        }
      });
    }, { threshold: 0.4 });
    counters.forEach(el => obs.observe(el));
  }

  const trendLabels = @json($trendLabels ?? []);
  const trendCounts = @json($trendCounts ?? []);
  const statusCounts = @json($statusCounts ?? []);

  const trendCtx = document.getElementById('reportsTrendChart');
  if (trendCtx && window.Chart) {
    new Chart(trendCtx, {
      type: 'line',
      data: {
        labels: trendLabels,
        datasets: [{
          label: 'Total Laporan',
          data: trendCounts,
          fill: true,
          borderColor: 'rgb(13,110,253)',
          backgroundColor: 'rgba(13,110,253,0.1)',
          tension: 0.35,
          pointRadius: 3,
        }]
      },
      options: {
        responsive: true,
        maintainAspectRatio: false,
        scales: {
          y: { beginAtZero: true, ticks: { precision:0 } }
        },
        plugins: { legend: { display: false } }
      }
    });
  }

  const doughnutCtx = document.getElementById('statusDoughnutChart');
  if (doughnutCtx && window.Chart) {
    const values = [statusCounts.pending || 0, statusCounts.in_progress || 0, statusCounts.completed || 0];
    new Chart(doughnutCtx, {
      type: 'doughnut',
      data: {
        labels: ['Terkirim', 'Dalam Proses', 'Selesai'],
        datasets: [{
          data: values,
          backgroundColor: ['#ffc107', '#0dcaf0', '#198754'],
          borderWidth: 0
        }]
      },
      options: {
        plugins: { legend: { display: false } },
        cutout: '60%'
      }
    });
  }
});
</script>
@endpush
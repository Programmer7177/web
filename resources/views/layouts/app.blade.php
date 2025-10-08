<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Aplikasi Pelaporan Kampus</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    @stack('styles')
</head>
<body style="background-color: #f0f2f5;">
    
    <nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm py-3">
        <div class="container-fluid px-md-5">
            <a class="navbar-brand" href="{{ route('dashboard') }}">
                <img src="{{ asset('images/logo laporunair.png') }}" alt="Lapor Unair Logo" height="40">
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav mx-auto">
                    <li class="nav-item"><a class="nav-link" href="{{ route('dashboard') }}">Dashboard</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ route('reports.create') }}">Buat Laporan</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ route('reports.index') }}">Laporan Saya</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ route('pages.about') }}">Tentang Layanan</a></li>
                </ul>
                
                <div class="d-flex align-items-center">

                    <div class="dropdown me-3">
                        <a href="#" class="text-secondary position-relative fs-4 text-decoration-none" data-bs-toggle="dropdown" aria-expanded="false">
                            🔔
                            {{-- Tampilkan badge hanya jika ada notifikasi --}}
                            @if(isset($notifications) && $notifications->count() > 0)
                                <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger" style="font-size: 0.6em;">
                                    {{ $notifications->count() }}
                                    <span class="visually-hidden">unread messages</span>
                                </span>
                            @endif
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end" style="width: 350px;">
                            <li class="px-3 py-2"><strong>Notifikasi</strong></li>
                            <li><hr class="dropdown-divider"></li>
                            @if(isset($notifications))
                                @forelse($notifications as $notification)
                                    @php
                                        $rawUrl = $notification->data['url'] ?? '#';
                                        $urlParts = explode('#', $rawUrl, 2);
                                        $baseUrl = $urlParts[0];
                                        $fragment = $urlParts[1] ?? null;
                                        $href = $baseUrl . (str_contains($baseUrl, '?') ? '&' : '?') . 'notify_id=' . $notification->id . ($fragment ? '#' . $fragment : '');
                                    @endphp
                                    <li>
                                        <a class="dropdown-item" href="{{ $href }}" style="white-space: normal;">
                                            <p class="mb-0 small">{{ $notification->data['message'] }}</p>
                                            <small class="text-muted">{{ $notification->created_at->diffForHumans() }}</small>
                                        </a>
                                    </li>
                                @empty
                                    <li class="text-center p-2 text-muted small">Tidak ada notifikasi baru.</li>
                                @endforelse
                            @endif
                        </ul>
                    </div>
                    <div class="dropdown">
                        <a href="#" class="d-block link-dark text-decoration-none dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                            Hi, {{ Auth::user()->username }}
                        </a>
                        <ul class="dropdown-menu text-small dropdown-menu-end">
                            <li>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault(); this.closest('form').submit();">
                                        Logout
                                    </a>
                                </form>
                            </li>
                        </ul>
                    </div>
                </div>

            </div>
        </div>
    </nav>

    <main class="py-4">
        <div class="container-fluid px-md-5">
             @yield('content')
        </div>
    </main>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    @stack('scripts')
</body>
</html>

@push('styles')
<style>
    /* 1. REVISI GRADASI WARNA */
    body {
        /* Warna dasar yang netral */
        background-color: #f8f9fa;
        /* Dua sumber cahaya radial yang menyebar dengan lembut */
        background-image: 
            radial-gradient(circle at top left, rgba(255, 221, 114, 0.2), transparent 100%),
            radial-gradient(circle at bottom right, rgba(144, 202, 249, 0.3), transparent 100%);
        background-attachment: fixed;
    }

    /* Fix untuk pagination dan elemen UI yang bermasalah */
    .pagination {
        margin-bottom: 0;
    }
    
    .pagination .page-link {
        font-size: 0.875rem;
        padding: 0.5rem 0.75rem;
        border-radius: 0.375rem;
        margin: 0 0.125rem;
        border: 1px solid #dee2e6;
        color: #0d6efd;
        text-decoration: none;
    }
    
    .pagination .page-link:hover {
        background-color: #e9ecef;
        border-color: #adb5bd;
        color: #0a58ca;
    }
    
    .pagination .page-item.active .page-link {
        background-color: #0d6efd;
        border-color: #0d6efd;
        color: white;
    }
    
    .pagination .page-item.disabled .page-link {
        color: #6c757d;
        background-color: #fff;
        border-color: #dee2e6;
    }
    
    /* Pastikan tidak ada elemen yang terlalu besar */
    .pagination .page-link,
    .pagination .page-item {
        max-width: none;
        max-height: none;
        font-size: inherit;
        line-height: inherit;
    }
    
    /* Fix untuk chevron/panah yang terlalu besar */
    .pagination .page-link::before,
    .pagination .page-link::after {
        font-size: inherit;
        line-height: inherit;
    }
    
    /* Pastikan input field tidak kosong dan terlihat aneh */
    .form-control:empty {
        display: none;
    }
    
    /* Fix untuk elemen yang mungkin tumpang tindih */
    .card {
        position: relative;
        z-index: 1;
    }
    
    .hero-section {
        /* ... */
    }
    /* ... sisa kode CSS ... */
</style>
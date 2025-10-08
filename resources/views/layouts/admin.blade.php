<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - Lapor Unair</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    @stack('styles')
</head>
<body data-bs-theme="light">
    
    <nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm border-bottom sticky-top py-2">
        <div class="container">
            <a class="navbar-brand" href="{{ route('dashboard') }}">
                <img src="{{ asset('images/logo laporunair.png') }}" alt="Lapor Unair Logo" height="40">
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav mx-auto">
                    <li class="nav-item"><a class="nav-link fw-semibold" href="{{ route('dashboard') }}">Daftar Laporan</a></li>
                </ul>
                <div class="d-flex align-items-center">

                    <div class="dropdown me-3">
                        <a href="#" class="text-secondary position-relative fs-5 text-decoration-none" data-bs-toggle="dropdown" aria-expanded="false" aria-label="Notifikasi">
                            <i class="bi bi-bell"></i>
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
                                    <li>
                                        <a class="dropdown-item" href="{{ $notification->data['url'] }}" style="white-space: normal;">
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
                    {{-- Dropdown untuk User --}}
                    <div class="dropdown">
                        <a href="#" class="d-block link-dark text-decoration-none dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                            <img src="{{ asset('images/profile-icon.png') }}" alt="mdo" width="32" height="32" class="rounded-circle">
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
        @yield('content')
    </main>

    <footer class="footer mt-auto py-3 bg-dark text-white text-center">
        <div class="container">
            <span>© 2025 LaporUnair. All Rights Reserved.</span>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Enable tooltips globally
        const tooltipTriggerList = document.querySelectorAll('[data-bs-toggle="tooltip"]');
        const tooltipList = [...tooltipTriggerList].map(el => new bootstrap.Tooltip(el));
    </script>
</body>
</html>

<style>
    :root {
        --bs-primary: #6366f1; /* indigo-500 */
        --bs-primary-rgb: 99, 102, 241;
        --bs-link-color: #4f46e5; /* indigo-600 */
        --bs-link-hover-color: #4338ca; /* indigo-700 */
    }

    body {
        font-family: 'Poppins', system-ui, -apple-system, Segoe UI, Roboto, "Helvetica Neue", Arial, "Noto Sans", "Apple Color Emoji", "Segoe UI Emoji";
        color: #0f172a; /* slate-900 */
        background-image:
            radial-gradient(circle at 0% 0%, rgba(255, 221, 114, 0.18), transparent 55%),
            radial-gradient(circle at 100% 100%, rgba(144, 202, 249, 0.25), transparent 55%);
        background-color: #f8fafc; /* slate-50 */
        background-attachment: fixed;
    }

    .navbar.bg-white {
        background-color: rgba(255,255,255,0.85) !important;
        backdrop-filter: saturate(180%) blur(8px);
    }

    .navbar .nav-link {
        color: #334155; /* slate-600 */
    }
    .navbar .nav-link:hover, .navbar .nav-link:focus {
        color: var(--bs-link-color);
    }
    .navbar .nav-link.active {
        color: var(--bs-link-color);
        position: relative;
    }
    .navbar .nav-link.active::after {
        content: "";
        position: absolute;
        left: 0;
        right: 0;
        bottom: -8px;
        height: 2px;
        background: linear-gradient(90deg, var(--bs-link-color), var(--bs-primary));
        border-radius: 2px;
        opacity: 0.85;
    }

    .card {
        border-radius: 12px;
    }

    .table thead th {
        position: sticky;
        top: 0;
        z-index: 1;
        background: #ffffff;
    }

    .badge {
        letter-spacing: .3px;
    }

    .dropdown-menu {
        border-radius: 10px;
        box-shadow: 0 10px 30px rgba(2, 6, 23, 0.08);
    }

    .footer {
        background: linear-gradient(90deg, #0f172a, #0b1324);
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
</style>
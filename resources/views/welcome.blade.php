<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Lapor UNAIR — Pelaporan Masalah Kampus</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://unpkg.com/aos@next/dist/aos.css" rel="stylesheet">

    <style>
        html { scroll-behavior: smooth; }
        body { background: #f7f9fc; }

        .navbar-brand img { height: 40px; }
        .navbar-scrolled { backdrop-filter: saturate(180%) blur(8px); box-shadow: 0 4px 16px rgba(0,0,0,0.08); }

        .content-wrapper { padding-top: 6rem; }

        .hero-section {
            position: relative;
            border-radius: 16px;
            padding: 6rem 1.5rem;
            color: #fff;
            background-image: url('{{ asset('images/image_main.png') }}');
            background-size: cover;
            background-position: center;
            overflow: hidden;
        }
        .hero-section::before {
            content: "";
            position: absolute; inset: 0;
            background: linear-gradient(135deg, rgba(16, 85, 197, 0.75), rgba(16, 200, 157, 0.65));
        }
        .hero-content { position: relative; z-index: 1; }
        .hero-title { font-weight: 800; letter-spacing: 0.5px; }
        .hero-subtitle { opacity: 0.95; }

        .cta-btn { padding: 0.8rem 1.4rem; border-radius: 999px; }
        .cta-btn-secondary { background: rgba(255,255,255,0.2); color: #fff; border: 1px solid rgba(255,255,255,0.35); }
        .cta-btn-secondary:hover { background: rgba(255,255,255,0.3); color: #fff; }

        .section-title { font-weight: 700; }

        .feature-card {
            height: 100%;
            border: 0;
            border-radius: 16px;
            background: #fff;
            box-shadow: 0 6px 20px rgba(0,0,0,0.06);
            transition: transform .2s ease, box-shadow .2s ease;
        }
        .feature-card:hover { transform: translateY(-4px); box-shadow: 0 12px 30px rgba(0,0,0,0.08); }

        .step-card {
            height: 100%;
            border-radius: 14px;
            background: #ffffff;
            border: 1px solid #eef2f7;
            transition: transform .2s ease, box-shadow .2s ease;
        }
        .step-card:hover { transform: translateY(-3px); box-shadow: 0 10px 24px rgba(16,85,197,0.12); }

        .stats-card {
            background-image: url('{{ asset('images/Union.png') }}');
            background-size: cover;
            background-position: center;
            color: #fff;
            padding: 3.5rem 2rem;
            border-radius: 16px;
            text-align: center;
        }
        .counter-value { font-size: 2.75rem; font-weight: 800; }

        .login-card {
            background: #ffffff;
            padding: 2rem;
            border-radius: 16px;
            box-shadow: 0 12px 32px rgba(0,0,0,0.08);
            max-width: 520px;
            margin: auto;
        }

        .back-to-top {
            position: fixed; right: 1.25rem; bottom: 1.25rem; z-index: 1030;
            width: 44px; height: 44px; border-radius: 50%;
            display: none; align-items: center; justify-content: center;
            background: #0d6efd; color: #fff; border: none;
            box-shadow: 0 10px 24px rgba(13,110,253,0.35);
        }
        .back-to-top:hover { background: #0b5ed7; }
    </style>
</head>
<body>

    <nav class="navbar navbar-expand-lg sticky-top bg-white">
        <div class="container py-2">
            <a class="navbar-brand d-flex align-items-center" href="#home">
                <img src="{{ asset('images/logo laporunair.png') }}" alt="Lapor UNAIR">
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto align-items-lg-center gap-lg-2">
                    <li class="nav-item"><a class="nav-link" href="#home">Beranda</a></li>
                    <li class="nav-item"><a class="nav-link" href="#features">Fitur</a></li>
                    <li class="nav-item"><a class="nav-link" href="#alur">Alur</a></li>
                    <li class="nav-item"><a class="nav-link" href="#faq">FAQ</a></li>
                    <li class="nav-item mt-2 mt-lg-0"><a href="#login-section" class="btn btn-primary rounded-pill">Login</a></li>
                </ul>
            </div>
        </div>
    </nav>

    <main class="content-wrapper">
        <div class="container">
            <!-- HERO -->
            <section id="home" class="hero-section mb-5" data-aos="fade-up">
                <div class="hero-content text-center">
                    <h1 class="display-5 display-md-4 hero-title mb-3">Lapor UNAIR</h1>
                    <p class="lead hero-subtitle mb-4">Laporkan kendala kampus Anda. Cepat, transparan, dan terpantau.</p>
                    <div class="d-flex gap-2 justify-content-center">
                        <a href="#login-section" class="btn btn-light cta-btn">Buat Laporan</a>
                        <a href="#alur" class="btn cta-btn cta-btn-secondary">Lihat Alur</a>
                    </div>
                </div>
            </section>

            <!-- DESKRIPSI + ILUSTRASI -->
            <section class="row align-items-center g-4 mb-5">
                <div class="col-md-6" data-aos="fade-right">
                    <h2 class="section-title mb-3">Platform Pelaporan untuk Civitas Akademika</h2>
                    <p class="text-secondary mb-3">Lapor UNAIR memudahkan pelaporan fasilitas rusak, kebersihan, keamanan, dan kebutuhan layanan lainnya. Setiap laporan tercatat dan dipantau hingga selesai.</p>
                    <ul class="text-secondary mb-4">
                        <li>Pelaporan terstruktur dan mudah</li>
                        <li>Notifikasi status laporan</li>
                        <li>Terintegrasi dengan unit terkait</li>
                    </ul>
                    <a href="#features" class="btn btn-outline-primary rounded-pill">Jelajahi Fitur</a>
                </div>
                <div class="col-md-6 text-center" data-aos="fade-left">
                    <img src="{{ asset('images/image.png') }}" class="img-fluid rounded-4 shadow-sm" alt="Ilustrasi Laporan">
                </div>
            </section>

            <!-- FITUR -->
            <section id="features" class="mb-5">
                <h2 class="section-title text-center mb-4" data-aos="fade-up">Mengapa Menggunakan Lapor UNAIR?</h2>
                <div class="row g-4">
                    <div class="col-md-4" data-aos="zoom-in" data-aos-delay="0">
                        <div class="card feature-card p-4 h-100">
                            <div class="mb-3"><img src="{{ asset('images/computer.png') }}" alt="Cepat" width="44"></div>
                            <h5 class="fw-bold">Proses Cepat</h5>
                            <p class="text-secondary mb-0">Antarmuka sederhana membuat pelaporan hanya dalam hitungan menit.</p>
                        </div>
                    </div>
                    <div class="col-md-4" data-aos="zoom-in" data-aos-delay="100">
                        <div class="card feature-card p-4 h-100">
                            <div class="mb-3"><img src="{{ asset('images/garis.png') }}" alt="Transparan" width="44"></div>
                            <h5 class="fw-bold">Transparan</h5>
                            <p class="text-secondary mb-0">Status laporan mudah dipantau dari terkirim hingga selesai.</p>
                        </div>
                    </div>
                    <div class="col-md-4" data-aos="zoom-in" data-aos-delay="200">
                        <div class="card feature-card p-4 h-100">
                            <div class="mb-3"><img src="{{ asset('images/Padi (4) 1.png') }}" alt="Terintegrasi" width="44"></div>
                            <h5 class="fw-bold">Terintegrasi</h5>
                            <p class="text-secondary mb-0">Terhubung dengan unit terkait agar tindak lanjut lebih efektif.</p>
                        </div>
                    </div>
                </div>
            </section>

            <!-- ALUR PELAPORAN -->
            <section id="alur" class="mb-5">
                <h2 class="section-title text-center mb-4" data-aos="fade-up">Alur Pelaporan</h2>
                <div class="row g-3">
                    <div class="col-6 col-md-3" data-aos="fade-up" data-aos-delay="0">
                        <div class="p-3 step-card text-center h-100">
                            <div class="display-6 fw-bold text-primary">1</div>
                            <div class="fw-semibold">Kirim Laporan</div>
                            <div class="text-secondary small">Isi detail dan lokasi masalah</div>
                        </div>
                    </div>
                    <div class="col-6 col-md-3" data-aos="fade-up" data-aos-delay="100">
                        <div class="p-3 step-card text-center h-100">
                            <div class="display-6 fw-bold text-primary">2</div>
                            <div class="fw-semibold">Verifikasi</div>
                            <div class="text-secondary small">Petugas memvalidasi laporan</div>
                        </div>
                    </div>
                    <div class="col-6 col-md-3" data-aos="fade-up" data-aos-delay="200">
                        <div class="p-3 step-card text-center h-100">
                            <div class="display-6 fw-bold text-primary">3</div>
                            <div class="fw-semibold">Ditindaklanjuti</div>
                            <div class="text-secondary small">Unit terkait menangani masalah</div>
                        </div>
                    </div>
                    <div class="col-6 col-md-3" data-aos="fade-up" data-aos-delay="300">
                        <div class="p-3 step-card text-center h-100">
                            <div class="display-6 fw-bold text-primary">4</div>
                            <div class="fw-semibold">Selesai</div>
                            <div class="text-secondary small">Anda menerima pembaruan status</div>
                        </div>
                    </div>
                </div>
            </section>

            <!-- STATISTIK (COUNTER) -->
            <section class="stats-card mb-5" data-aos="zoom-in">
                <h3 class="mb-4">Jumlah Laporan Saat Ini</h3>
                <div class="row g-4">
                    <div class="col-4">
                        <div class="counter-value" data-countup data-target="{{ $pendingCount ?? 0 }}">0</div>
                        <p class="mb-0">Terkirim</p>
                    </div>
                    <div class="col-4">
                        <div class="counter-value" data-countup data-target="{{ $inProgressCount ?? 0 }}">0</div>
                        <p class="mb-0">Dalam Proses</p>
                    </div>
                    <div class="col-4">
                        <div class="counter-value" data-countup data-target="{{ $completedCount ?? 0 }}">0</div>
                        <p class="mb-0">Selesai</p>
                    </div>
                </div>
            </section>

            <!-- FAQ -->
            <section id="faq" class="mb-5">
                <h2 class="section-title text-center mb-4" data-aos="fade-up">Pertanyaan Umum</h2>
                <div class="accordion" id="faqAccordion">
                    <div class="accordion-item" data-aos="fade-up" data-aos-delay="0">
                        <h2 class="accordion-header" id="q1">
                            <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#a1" aria-expanded="true" aria-controls="a1">
                                Bagaimana cara membuat laporan?
                            </button>
                        </h2>
                        <div id="a1" class="accordion-collapse collapse show" aria-labelledby="q1" data-bs-parent="#faqAccordion">
                            <div class="accordion-body">Klik tombol "Buat Laporan", login/daftar jika diminta, lalu isi formulir.</div>
                        </div>
                    </div>
                    <div class="accordion-item" data-aos="fade-up" data-aos-delay="100">
                        <h2 class="accordion-header" id="q2">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#a2" aria-expanded="false" aria-controls="a2">
                                Apakah saya bisa memantau status laporan?
                            </button>
                        </h2>
                        <div id="a2" class="accordion-collapse collapse" aria-labelledby="q2" data-bs-parent="#faqAccordion">
                            <div class="accordion-body">Ya, setiap laporan memiliki status yang diperbarui secara berkala.</div>
                        </div>
                    </div>
                    <div class="accordion-item" data-aos="fade-up" data-aos-delay="200">
                        <h2 class="accordion-header" id="q3">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#a3" aria-expanded="false" aria-controls="a3">
                                Siapa yang akan menindaklanjuti laporan saya?
                            </button>
                        </h2>
                        <div id="a3" class="accordion-collapse collapse" aria-labelledby="q3" data-bs-parent="#faqAccordion">
                            <div class="accordion-body">Unit terkait di lingkungan kampus sesuai kategori laporan Anda.</div>
                        </div>
                    </div>
                </div>
            </section>

            <!-- LOGIN -->
            <section id="login-section" class="my-5 py-3">
                <div class="login-card" data-aos="fade-up">
                    <h2 class="text-center mb-4">Login</h2>
                    <form method="POST" action="{{ route('login') }}">
                        @csrf
                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input id="email" class="form-control" type="email" name="email" :value="old('email')">
                        </div>
                        <div class="mb-3">
                            <label for="password" class="form-label">Password</label>
                            <input id="password" class="form-control" type="password" name="password" required>
                        </div>
                        <div class="d-flex justify-content-between align-items-center">
                            <a href="{{ route('password.request') }}" class="text-sm">Lupa password?</a>
                            <button type="submit" class="btn btn-primary rounded-pill px-4">Login</button>
                        </div>
                        <p class="text-center mt-4 text-sm">
                            Belum punya akun? <a href="{{ route('register') }}">Daftar di sini</a>
                        </p>
                    </form>
                </div>
            </section>
        </div>
    </main>

    <button class="back-to-top" aria-label="Kembali ke atas">▲</button>

    <!-- Scroll Popup (Toast) -->
    <div class="position-fixed bottom-0 end-0 p-3" style="z-index: 1080">
        <div id="scrollToast" class="toast align-items-center text-bg-primary border-0" role="alert" aria-live="assertive" aria-atomic="true" data-bs-delay="6000">
            <div class="d-flex">
                <div class="toast-body">
                    Ada kendala di kampus? Buat laporan sekarang agar cepat ditangani.
                </div>
                <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://unpkg.com/aos@next/dist/aos.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // AOS animations
            if (window.AOS) {
                AOS.init({ once: true, duration: 650, easing: 'ease-out-quart' });
            }

            // Smooth scroll for on-page links
            document.querySelectorAll('a[href^="#"]').forEach(function (anchor) {
                anchor.addEventListener('click', function (e) {
                    const targetId = this.getAttribute('href');
                    if (targetId && targetId.length > 1) {
                        e.preventDefault();
                        const el = document.querySelector(targetId);
                        if (el) el.scrollIntoView({ behavior: 'smooth', block: 'start' });
                    }
                });
            });

            // Navbar shadow on scroll
            const navbar = document.querySelector('.navbar');
            const onScroll = function () {
                if (!navbar) return;
                if (window.scrollY > 12) navbar.classList.add('navbar-scrolled');
                else navbar.classList.remove('navbar-scrolled');
            };
            window.addEventListener('scroll', onScroll);
            onScroll();

            // Back to top button
            const backToTop = document.querySelector('.back-to-top');
            const toggleBackToTop = function () {
                if (!backToTop) return;
                backToTop.style.display = window.scrollY > 300 ? 'flex' : 'none';
            };
            window.addEventListener('scroll', toggleBackToTop);
            toggleBackToTop();
            if (backToTop) {
                backToTop.addEventListener('click', function () {
                    window.scrollTo({ top: 0, behavior: 'smooth' });
                });
            }

            // Counter animation on visible
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

            // Popup saat scroll (muncul sekali per sesi ketika sudah scroll cukup jauh)
            try {
                const toastEl = document.getElementById('scrollToast');
                if (toastEl && window.bootstrap) {
                    let popupShown = sessionStorage.getItem('scrollToastShown') === '1';
                    const onScrollToast = function () {
                        if (popupShown) return;
                        if (window.scrollY > 500) {
                            const toast = window.bootstrap.Toast.getOrCreateInstance(toastEl);
                            toast.show();
                            popupShown = true;
                            sessionStorage.setItem('scrollToastShown', '1');
                            window.removeEventListener('scroll', onScrollToast);
                        }
                    };
                    window.addEventListener('scroll', onScrollToast, { passive: true });
                }
            } catch (e) {}
        });
    </script>
</body>
</html>


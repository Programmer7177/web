<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Lapor UNAIR — Layanan Aduan Kampus</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        html { scroll-behavior: smooth; }
        body { background: #f7fafc; color: #0f172a; }

        .navbar-brand img { height: 36px; }
        .navbar .btn-login { border-radius: 999px; padding: .45rem 1rem; }
        .navbar-scrolled { box-shadow: 0 4px 20px rgba(0,0,0,.06); }

        .hero { position: relative; padding: 3.5rem 0 0; }
        .hero-title { font-weight: 800; line-height: 1.1; }
        .hero-subtitle { color: #475569; }
        .hero-cta { border-radius: 999px; padding: .7rem 1.1rem; font-weight: 600; }
        .hero-art { position: relative; }
        .hero-art .blob {
            position: absolute; right: 0; top: 0; transform: translate(15%, -10%);
            width: 340px; height: 340px; border-radius: 50%;
            background: radial-gradient(circle at 30% 30%, #ffd24d, #0ea5a6 65%, #0f5bd8);
            filter: blur(2px);
            z-index: 0;
        }
        .hero-art img { position: relative; z-index: 1; width: 100%; max-width: 520px; }

        .hero-wave { margin-top: 2rem; height: 130px; border-bottom-left-radius: 50% 80px; border-bottom-right-radius: 50% 80px; background: linear-gradient(180deg, #0f5bd8, #0ea5a6); }
        @media (min-width: 992px) { .hero { padding-top: 4.5rem; } .hero-wave { height: 160px; } }

        .about { padding: 4rem 0; background: linear-gradient(180deg, rgba(14,165,166,0.05), rgba(255,255,255,0)); }
        .bubble-title {
            display: inline-block; font-weight: 800; color: #0f172a; background: linear-gradient(90deg,#0f5bd8,#0ea5a6);
            -webkit-background-clip: text; background-clip: text; color: transparent;
            padding: .2rem .8rem; border-radius: 12px; position: relative;
        }
        .bubble-title::before { content: ""; position: absolute; left: -10px; top: 50%; transform: translateY(-50%); width: 14px; height: 14px; background: #0f5bd8; border-radius: 3px; filter: blur(10px); opacity: .4; }
        .about p { color: #334155; }

        .steps { padding: 2rem 0 3rem; }
        .step { text-align: center; }
        .step .icon { width: 70px; height: 70px; border-radius: 16px; display: grid; place-items: center; margin: 0 auto .75rem; box-shadow: 0 10px 24px rgba(2,132,199,.12); background: white; }
        .step .label { font-weight: 700; color: #0f172a; }
        .step .hint { color: #64748b; font-size: .9rem; }
        .step-arrow { height: 2px; background: linear-gradient(90deg,#cbd5e1,transparent); margin-top: 2.2rem; }

        .stats-wrap { padding: 2rem 0 4rem; }
        .stats-bubble { position: relative; background: linear-gradient(135deg, #0f5bd8, #0ea5a6); color: white; border-radius: 20px; padding: 2.5rem; }
        .stats-bubble::after { content: ""; position: absolute; left: 70px; bottom: -22px; width: 0; height: 0; border: 14px solid transparent; border-top-color: #0ea5a6; filter: drop-shadow(0 10px 16px rgba(0,0,0,.2)); }
        .stat-number { font-weight: 800; font-size: 3rem; line-height: 1; }
        .stat-label { opacity: .95; }

        .login-wrap { padding: 1rem 0 4rem; position: relative; }
        .login-card { background: white; border-radius: 18px; box-shadow: 0 14px 40px rgba(0,0,0,.08); padding: 1.5rem; max-width: 520px; margin: 0 auto; }
        .login-card .btn { border-radius: 999px; }
        .section-heading { font-weight: 800; text-align: center; margin-bottom: 1.5rem; }
        .footer { color: #94a3b8; font-size: .9rem; padding: 2rem 0; border-top: 1px solid #e2e8f0; text-align: center; }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg bg-white sticky-top">
        <div class="container py-2">
            <a class="navbar-brand" href="#">
                <img src="{{ asset('images/logo laporunair.png') }}" alt="Lapor UNAIR">
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#nav" aria-controls="nav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="nav">
                <ul class="navbar-nav ms-auto align-items-lg-center gap-lg-3">
                    <li class="nav-item"><a class="nav-link" href="#">Beranda</a></li>
                    <li class="nav-item"><a class="nav-link" href="#about">Tentang Layanan</a></li>
                    <li class="nav-item mt-2 mt-lg-0"><a class="btn btn-primary btn-login" href="{{ route('login') }}">Login</a></li>
                </ul>
            </div>
        </div>
    </nav>

    <main>
        <!-- HERO -->
        <section class="hero">
            <div class="container">
                <div class="row align-items-center g-4">
                    <div class="col-lg-6">
                        <h1 class="hero-title display-5 mb-3">Lapor Segera,<br>Nyaman Bersama</h1>
                        <p class="hero-subtitle mb-4">Layanan aduan untuk civitas UNAIR yang cepat, transparan, dan terintegrasi</p>
                        <a href="{{ route('login') }}" class="btn btn-primary hero-cta">Buat Laporan</a>
                    </div>
                    <div class="col-lg-6 hero-art text-center">
                        <div class="blob"></div>
                        <img src="{{ asset('images/image_main.png') }}" alt="Komputer ilustrasi">
                    </div>
                </div>
            </div>
            <div class="hero-wave"></div>
        </section>

        <!-- TENTANG -->
        <section id="about" class="about">
            <div class="container">
                <div class="row align-items-center g-4">
                    <div class="col-md-6 text-center">
                        <img src="{{ asset('images/image 12.png') }}" class="img-fluid rounded-4" alt="Kampus UNAIR">
                    </div>
                    <div class="col-md-6">
                        <div class="mb-2 bubble-title">LAPOR UNAIR</div>
                        <p class="mb-3">LaporUnair adalah layanan digital Universitas Airlangga untuk mempermudah civitas akademika melaporkan berbagai kendala di kampus, dari kerusakan sarana-prasarana hingga keluhan akademik. Laporan tersampaikan ke unit kerja terkait dan statusnya dipantau secara real-time.</p>
                        <a href="{{ route('login') }}" class="btn btn-primary">Buat Laporan</a>
                    </div>
                </div>
            </div>
        </section>

        <!-- ALUR -->
        <section class="steps">
            <div class="container">
                <div class="row text-center g-3 align-items-center justify-content-center">
                    <div class="col-6 col-md-3 step">
                        <div class="icon">
                            <svg width="34" height="34" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M4 4h12v16H4z" stroke="#0f5bd8" stroke-width="1.5"/><path d="M8 8h6M8 12h6" stroke="#0f5bd8" stroke-width="1.5"/><path d="M16 16l3 3 3-7" stroke="#0ea5a6" stroke-width="1.5" stroke-linecap="round"/></svg>
                        </div>
                        <div class="label">Kirim Laporan</div>
                    </div>
                    <div class="col-6 col-md-3 step">
                        <div class="icon">
                            <svg width="34" height="34" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><circle cx="9" cy="15" r="3" stroke="#0f5bd8" stroke-width="1.5"/><path d="M14 6l4 4" stroke="#0ea5a6" stroke-width="1.5"/><path d="M16 4l4 4" stroke="#0f5bd8" stroke-width="1.5"/></svg>
                        </div>
                        <div class="label">Laporan Diproses</div>
                    </div>
                    <div class="col-6 col-md-3 step">
                        <div class="icon">
                            <svg width="34" height="34" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><rect x="4" y="4" width="16" height="16" rx="4" stroke="#0f5bd8" stroke-width="1.5"/><path d="M8 12l3 3 5-6" stroke="#0ea5a6" stroke-width="1.5" stroke-linecap="round"/></svg>
                        </div>
                        <div class="label">Masalah Selesai</div>
                    </div>
                    <div class="col-6 col-md-3 step">
                        <div class="icon">
                            <svg width="34" height="34" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M5 21l1.5-5L2 11h5L9 6l2 5h5l-4.5 5L13 21l-4-2z" stroke="#f59e0b" stroke-width="1.5"/></svg>
                        </div>
                        <div class="label">Nilai Pelayanan</div>
                    </div>
                </div>
            </div>
        </section>

        <!-- STATISTIK -->
        <section class="stats-wrap">
            <div class="container">
                <div class="stats-bubble">
                    <h4 class="text-white text-center mb-4">Jumlah Laporan Saat Ini</h4>
                    <div class="row text-center">
                        <div class="col-4">
                            <div class="stat-number" data-countup data-target="3">0</div>
                            <div class="stat-label">Terkirim</div>
                        </div>
                        <div class="col-4">
                            <div class="stat-number" data-countup data-target="10">0</div>
                            <div class="stat-label">Dalam Proses</div>
                        </div>
                        <div class="col-4">
                            <div class="stat-number" data-countup data-target="25">0</div>
                            <div class="stat-label">Selesai</div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- LOGIN -->
        <section class="login-wrap">
            <div class="container">
                <h3 class="section-heading">Lapor Segera, Nyaman Bersama</h3>
                <div class="login-card">
                    <h5 class="text-center mb-3">Login</h5>
                    <form method="POST" action="{{ route('login') }}">
                        @csrf
                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input id="email" type="email" class="form-control" name="email" required autofocus>
                        </div>
                        <div class="mb-3">
                            <label for="password" class="form-label">Password</label>
                            <input id="password" type="password" class="form-control" name="password" required>
                        </div>
                        <div class="d-flex justify-content-between align-items-center">
                            <a href="{{ route('password.request') }}" class="small">Forgot password?</a>
                            <button type="submit" class="btn btn-primary px-4">Login</button>
                        </div>
                    </form>
                </div>
            </div>
        </section>

        <div class="footer">© 2025 LaporUnair. All Rights Reserved.</div>
    </main>

    <button class="back-to-top" aria-label="Kembali ke atas" style="display:none; position:fixed; right:1rem; bottom:1rem; width:44px; height:44px; border-radius:50%; background:#0f5bd8; color:white; border:0;">▲</button>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        const navbar = document.querySelector('.navbar');
        const backToTop = document.querySelector('.back-to-top');
        const onScroll = () => {
            if (window.scrollY > 10) navbar.classList.add('navbar-scrolled');
            else navbar.classList.remove('navbar-scrolled');
            backToTop.style.display = window.scrollY > 240 ? 'block' : 'none';
        };
        window.addEventListener('scroll', onScroll);
        onScroll();
        backToTop.addEventListener('click', () => window.scrollTo({ top: 0, behavior: 'smooth' }));

        // Count up when visible
        const counters = document.querySelectorAll('[data-countup]');
        if (counters.length) {
            const animate = (el, target) => {
                const start = performance.now();
                const duration = 1200;
                const frame = now => {
                    const p = Math.min((now - start) / duration, 1);
                    el.textContent = Math.floor(p * target);
                    if (p < 1) requestAnimationFrame(frame);
                };
                requestAnimationFrame(frame);
            };
            const io = new IntersectionObserver((entries, o) => {
                entries.forEach(e => {
                    if (e.isIntersecting) {
                        const t = parseInt(e.target.getAttribute('data-target') || '0', 10);
                        animate(e.target, t); o.unobserve(e.target);
                    }
                });
            }, { threshold: 0.4 });
            counters.forEach(c => io.observe(c));
        }
    </script>
</body>
</html>


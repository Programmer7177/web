@extends('layouts.app')

{{-- Menambahkan CSS khusus untuk halaman ini --}}
@push('styles')
<style>
    /* Intro Section */
    .intro-container {
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 2rem;
        margin-bottom: 4rem;
    }
    .intro-image-left,
    .intro-image-right-wrapper {
        flex: 0 0 25%;
        text-align: center;
    }
    .intro-text {
        flex: 1;
    }
    .intro-image-right-wrapper { position: relative; }
    .intro-megaphone-img {
        position: absolute;
        top: -24px;
        right: -36px;
        width: 90px;
    }

    /* FAQ bubbles */
    .faq-bubble {
        padding: 1.1rem 1.5rem;
        border-radius: 1.5rem;
        margin-bottom: 1.25rem;
        position: relative;
        max-width: 68%;
        line-height: 1.7;
        box-shadow: 0 8px 18px rgba(0,0,0,0.06);
    }
    .faq-question {
        background-color: #F3C208; /* kuning */
        color: #212529;
        border-bottom-left-radius: 0;
        font-weight: 600;
    }
    .faq-answer {
        background-color: #0B5ED7; /* biru */
        color: #fff;
        border-top-right-radius: 0;
    }
    .faq-question::after,
    .faq-answer::after {
        content: '';
        position: absolute;
        border-style: solid;
    }
    .faq-question::after {
        border-width: 16px 16px 0 0;
        border-color: #F3C208 transparent transparent transparent;
        bottom: 0;
        left: -16px;
    }
    .faq-answer::after {
        border-width: 0 0 16px 16px;
        border-color: transparent transparent #0B5ED7 transparent;
        top: 0;
        right: -16px;
    }

    /* Full-bleed footer strip */
    .footer-strip {
        margin-top: 4rem;
        margin-left: calc(-50vw + 50%);
        margin-right: calc(-50vw + 50%);
        background-color: #0B4A8B;
        color: #ffffff;
        text-align: center;
        padding: 18px 16px;
    }

    /* Responsive */
    @media (max-width: 768px) {
        .intro-container { flex-direction: column; }
        .faq-bubble { max-width: 100%; }
        .intro-megaphone-img { right: -8px; top: -12px; width: 70px; }
    }
</style>
@endpush

@section('content')
    <h1 class="text-center mb-5">Tentang LaporUnair</h1>

    {{-- Bagian Intro dengan struktur Flexbox --}}
    <div class="intro-container">
        {{-- Gambar Komputer di Kiri --}}
        <div class="intro-image-left d-none d-md-block">
            <img src="{{ asset('images/computer.png') }}" alt="Ilustrasi Komputer" class="img-fluid">
        </div>

        {{-- Teks di Tengah --}}
        <div class="intro-text text-center">
            <p class="lead">
                LaporUnair adalah layanan digital Universitas Airlangga untuk mempermudah civitas akademika dalam melaporkan berbagai kendala di kampus, mulai dari kerusakan sarana-prasarana, kendala persuratan, hingga keluhan akademik. Sistem ini memastikan laporan tersampaikan langsung ke unit kerja terkait, dipantau statusnya secara real-time, serta ditangani lebih cepat dan transparan.
            </p>
        </div>
        
        {{-- Gambar Logo & Megaphone di Kanan --}}
        <div class="intro-image-right-wrapper d-none d-md-block">
            <img src="{{ asset('images/logo laporunair.png') }}" alt="Logo Lapor Unair" class="img-fluid">
            <img src="{{ asset('images/image 12.png') }}" alt="Megaphone Icon" class="intro-megaphone-img">
        </div>
    </div>

    <hr class="my-5">

    {{-- Bagian FAQ --}}
    <h2 class="text-center mb-5">Frequently Asked Questions</h2>
    <div class="row justify-content-center">
        <div class="col-md-10">
            {{-- FAQ 1 --}}
            <div class="d-flex justify-content-start mb-4">
                <div class="faq-bubble faq-question">Apa itu LaporUnair?</div>
            </div>
            <div class="d-flex justify-content-end mb-4">
                <div class="faq-bubble faq-answer">
                    LaporUnair adalah layanan digital Universitas Airlangga yang memfasilitasi civitas akademika untuk melaporkan kendala di kampus, seperti kerusakan fasilitas, kendala persuratan, maupun keluhan akademik.
                </div>
            </div>

            {{-- FAQ 2 --}}
            <div class="d-flex justify-content-start mb-4">
                <div class="faq-bubble faq-question">Siapa saja yang bisa menggunakan LaporUnair?</div>
            </div>
            <div class="d-flex justify-content-end mb-4">
                <div class="faq-bubble faq-answer">
                    Seluruh civitas akademika Universitas Airlangga (mahasiswa, dosen, tenaga kependidikan) dapat mengakses layanan ini.
                </div>
            </div>

            {{-- FAQ 3 --}}
            <div class="d-flex justify-content-start mb-4">
                <div class="faq-bubble faq-question">Apa saja jenis laporan yang bisa disampaikan melalui LaporUnair?</div>
            </div>
            <div class="d-flex justify-content-end mb-4">
                <div class="faq-bubble faq-answer">
                    Anda dapat melaporkan pengaduan terkait sarana-prasarana, persuratan, akademik, dan layanan umum kampus lainnya.
                </div>
            </div>

            {{-- FAQ 4 --}}
            <div class="d-flex justify-content-start mb-4">
                <div class="faq-bubble faq-question">Bagaimana cara memantau status laporan saya?</div>
            </div>
            <div class="d-flex justify-content-end mb-4">
                <div class="faq-bubble faq-answer">
                    Status laporan dapat dipantau secara <em>real-time</em> melalui akun LaporUnair pada menu <strong>Laporan Saya</strong>. Indikator status meliputi <strong>Terkirim</strong> – <strong>Dalam proses</strong> – <strong>Selesai</strong>.
                </div>
            </div>

            {{-- Footer strip --}}
            <div class="footer-strip">
                © 2025 LaporUnair. All Rights Reserved.
            </div>
        </div>
    </div>
@endsection
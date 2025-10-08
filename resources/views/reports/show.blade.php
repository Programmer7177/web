@extends(Auth::user()->role->name == 'admin_sarpras' ? 'layouts.admin' : 'layouts.app')

@push('styles')
<style>
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
</style>
@endpush

@section('content')
    {{-- KARTU DETAIL LAPORAN --}}
    <div class="card shadow-sm mb-4">
        <div class="card-header bg-white d-flex justify-content-between align-items-center">
            <h2 class="mb-0">Detail Laporan</h2>
            <a class="btn btn-secondary" href="{{ (Auth::user()->role->name == 'admin_sarpras') ? route('dashboard') : route('reports.index') }}"> Kembali</a>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-8">
                    <h3 class="card-title mb-3">{{ $report->title }}</h3>
                    <p class="card-text">{{ $report->description }}</p>
                </div>
                <div class="col-md-4">
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item d-flex justify-content-between">
                            <strong>Status:</strong>
                            <span class="badge bg-warning text-dark">{{ Str::title(str_replace('_', ' ', $report->status)) }}</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between">
                            <strong>Kategori:</strong>
                            <span>{{ $report->category->name }}</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between">
                            <strong>Instansi:</strong>
                            <span>{{ $report->instansi->name ?? 'N/A' }}</span>
                        </li>
                         <li class="list-group-item d-flex justify-content-between">
                            <strong>Lokasi:</strong>
                            <span>{{ $report->location }}</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between">
                            <strong>Pelapor:</strong>
                            <span>{{ $report->reporter->username ?? 'N/A' }}</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between">
                            <strong>Tanggal:</strong>
                            <span>{{ $report->created_at->format('d M Y, H:i') }}</span>
                        </li>

                        {{-- Tampilkan Link Lampiran Jika Ada --}}
                        @if($report->attachment_path)
                            <li class="list-group-item d-flex justify-content-between">
                                <strong>Lampiran:</strong>
                                <a href="{{ Storage::url($report->attachment_path) }}" target="_blank">Lihat Lampiran</a>
                            </li>
                        @endif
                    </ul>
                </div>
            </div>
        </div>

    {{-- BAGIAN RATING UNTUK USER --}}
    @if(Auth::id() === $report->user_id && $report->status === 'completed')
        <div id="beri-rating" class="card shadow-sm mb-4">
            <div class="card-header bg-white d-flex justify-content-between align-items-center">
                <h4 class="mb-0">Beri Rating Penyelesaian</h4>
                @if($userRating)
                    <span class="badge bg-success">Anda sudah memberi rating</span>
                @endif
            </div>
            <div class="card-body">
                @if (session('success'))
                    <div class="alert alert-success">{{ session('success') }}</div>
                @endif
                @if (session('error'))
                    <div class="alert alert-danger">{{ session('error') }}</div>
                @endif
                @if (session('info'))
                    <div class="alert alert-info">{{ session('info') }}</div>
                @endif

                @if(!$userRating)
                <form action="{{ url('reports/'.$report->report_id.'/rating') }}" method="POST" class="row g-3">
                    @csrf
                    <div class="col-12">
                        <label class="form-label">Penilaian</label>
                        <div class="mb-3">
                            <x-star-rating :rating="0" :interactive="true" size="lg" />
                        </div>
                        @error('rating_value')
                            <div class="text-danger small">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-12">
                        <label for="comment" class="form-label">Komentar (opsional)</label>
                        <textarea id="comment" name="comment" class="form-control" rows="3" placeholder="Tulis pengalaman Anda"></textarea>
                        @error('comment')
                            <div class="text-danger small">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-12">
                        <button type="submit" class="btn btn-warning">Kirim Rating</button>
                    </div>
                </form>
                @else
                    <div>
                        <p class="mb-2">Rating Anda:</p>
                        <x-star-rating :rating="$userRating->rating_value" :interactive="false" size="lg" />
                        @if($userRating->comment)
                            <p class="mt-3 mb-0"><strong>Komentar:</strong> {{ $userRating->comment }}</p>
                        @endif
                    </div>
                @endif
            </div>
        </div>
    @endif

    {{-- BAGIAN RATING UNTUK ADMIN --}}
    @if(Auth::user()->role->name == 'admin_sarpras' && $report->status === 'completed')
        <div class="card shadow-sm mb-4">
            <div class="card-header bg-white">
                <h4 class="mb-0">Rating dari User</h4>
            </div>
            <div class="card-body">
                @if($report->ratings->count() > 0)
                    @php
                        $rating = $report->ratings->first();
                    @endphp
                    <div class="d-flex align-items-center gap-3 mb-3">
                        <div>
                            <p class="mb-1"><strong>Rating:</strong></p>
                            <x-star-rating :rating="$rating->rating_value" :interactive="false" size="lg" />
                            <small class="text-muted">({{ $rating->rating_value }}/5 bintang)</small>
                        </div>
                    </div>
                    @if($rating->comment)
                        <div>
                            <p class="mb-1"><strong>Komentar User:</strong></p>
                            <div class="bg-light p-3 rounded">
                                <p class="mb-0">{{ $rating->comment }}</p>
                            </div>
                        </div>
                    @endif
                    <div class="mt-3">
                        <small class="text-muted">
                            <i class="bi bi-clock"></i> Rating diberikan pada {{ $rating->created_at->format('d M Y, H:i') }}
                        </small>
                    </div>
                @else
                    <div class="text-center text-muted py-4">
                        <i class="bi bi-star fs-1"></i>
                        <p class="mb-0">User belum memberikan rating untuk laporan ini</p>
                    </div>
                @endif
            </div>
        </div>
    @endif

    {{-- PESAN UNTUK ADMIN JIKA LAPORAN SUDAH COMPLETED DAN DIRATING --}}
    @if(Auth::user()->role->name == 'admin_sarpras' && $report->status === 'completed' && $report->ratings->count() > 0)
        <div class="card shadow-sm mb-4">
            <div class="card-body text-center">
                <i class="bi bi-check-circle-fill text-success fs-1 mb-3"></i>
                <h5 class="text-success">Laporan Selesai dan Sudah Dirating</h5>
                <p class="text-muted mb-0">User telah memberikan rating untuk laporan ini. Diskusi tidak tersedia untuk laporan yang sudah selesai dan dirating.</p>
            </div>
        </div>
    @endif

    {{-- PESAN UNTUK ADMIN JIKA LAPORAN COMPLETED TAPI BELUM DIRATING --}}
    @if(Auth::user()->role->name == 'admin_sarpras' && $report->status === 'completed' && $report->ratings->count() == 0)
        <div class="card shadow-sm mb-4">
            <div class="card-body text-center">
                <i class="bi bi-hourglass-split text-warning fs-1 mb-3"></i>
                <h5 class="text-warning">Menunggu Rating dari User</h5>
                <p class="text-muted mb-0">Laporan sudah selesai, menunggu user memberikan rating. Diskusi masih tersedia hingga user memberikan rating.</p>
            </div>
        </div>
    @endif

    {{-- BAGIAN KOMENTAR - Hanya tampil jika laporan belum completed atau belum dirating --}}
    @if($report->status !== 'completed' || ($report->status === 'completed' && Auth::id() === $report->user_id && !$userRating))
    <div class="card shadow-sm">
        <div class="card-header bg-white">
            <h4 class="mb-0">Diskusi / Tindak Lanjut</h4>
        </div>
        <div class="card-body">
            {{-- Daftar Komentar yang Sudah Ada --}}
            @forelse($report->comments as $comment)
                <div class="d-flex mb-3">
                    <div class="flex-shrink-0 me-3">
                        {{-- Anda bisa ganti dengan avatar user jika ada --}}
                        <img src="https://via.placeholder.com/50" alt="Avatar" class="rounded-circle">
                    </div>
                    <div class="flex-grow-1 border-bottom pb-2">
                        <h5 class="mt-0 mb-1">
                            {{ $comment->user->username }}
                            {{-- Tambahkan badge jika yang berkomentar adalah admin --}}
                            @if($comment->user->role->name == 'admin_sarpras')
                                <span class="badge bg-primary">Admin</span>
                            @endif
                        </h5>
                        <p class="mb-1">{{ $comment->body }}</p>
                        <small class="text-muted">{{ $comment->created_at->diffForHumans() }}</small>
                    </div>
                </div>
            @empty
                <p class="text-center text-muted">Belum ada komentar.</p>
            @endforelse

            <hr class="my-4">

            {{-- Form untuk Menambah Komentar Baru --}}
            <form action="{{ route('comments.store', $report->report_id) }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label for="body" class="form-label">Tulis Balasan</label>
                    <textarea name="body" id="body" rows="3" class="form-control" placeholder="Tulis komentar Anda di sini..." required></textarea>
                </div>
                <button type="submit" class="btn btn-primary">Kirim Komentar</button>
            </form>
        </div>
    </div>
    @endif

    {{-- Footer strip --}}
    <div class="footer-strip">
        © 2025 LaporUnair. All Rights Reserved.
    </div>
</div>
@endsection
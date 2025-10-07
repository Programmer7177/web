@extends('layouts.app')

@section('content')
<div class="card shadow-sm">
    <div class="card-header bg-white d-flex justify-content-between align-items-center">
        <h2 class="mb-0">Beri Rating Laporan</h2>
        <a class="btn btn-secondary" href="{{ route('reports.show', $report->report_id) }}">Kembali</a>
    </div>
    <div class="card-body">
        <div class="mb-3">
            <strong>Judul:</strong> {{ $report->title }}<br>
            <strong>Status:</strong> <span class="badge bg-success">Completed</span>
        </div>

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('ratings.store', $report->report_id) }}">
            @csrf

            <div class="mb-3">
                <label class="form-label d-block">Nilai Kepuasan</label>
                <div class="rating-group" style="font-size: 2rem; color: #f1c40f;">
                    <input type="radio" class="btn-check" name="rating_value" id="star5" value="5" autocomplete="off">
                    <label class="me-1" for="star5" title="5">★</label>

                    <input type="radio" class="btn-check" name="rating_value" id="star4" value="4" autocomplete="off">
                    <label class="me-1" for="star4" title="4">★</label>

                    <input type="radio" class="btn-check" name="rating_value" id="star3" value="3" autocomplete="off">
                    <label class="me-1" for="star3" title="3">★</label>

                    <input type="radio" class="btn-check" name="rating_value" id="star2" value="2" autocomplete="off">
                    <label class="me-1" for="star2" title="2">★</label>

                    <input type="radio" class="btn-check" name="rating_value" id="star1" value="1" autocomplete="off">
                    <label class="me-1" for="star1" title="1">★</label>
                </div>
                <small class="text-muted">Pilih 1 hingga 5 bintang.</small>
            </div>

            <div class="mb-3">
                <label for="comment" class="form-label">Ulasan (Opsional)</label>
                <textarea id="comment" name="comment" rows="3" class="form-control" placeholder="Ceritakan pengalaman Anda..."></textarea>
            </div>

            <button type="submit" class="btn btn-primary">Kirim Rating</button>
        </form>
    </div>
</div>
@endsection

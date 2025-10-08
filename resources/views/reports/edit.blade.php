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
    <div class="card shadow-sm">
        <div class="card-header bg-white d-flex justify-content-between align-items-center">
            <h2 class="mb-0">Edit Laporan</h2>
            <a class="btn btn-secondary" href="{{ (Auth::user()->role->name == 'admin_sarpras') ? route('dashboard') : route('reports.index') }}"> Kembali</a>
        </div>
        <div class="card-body">
            @if ($errors->any())
                <div class="alert alert-danger">
                    <strong>Whoops!</strong> Terjadi kesalahan pada input Anda.<br><br>
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('reports.update', $report->report_id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                @php
                    $isAdmin = Auth::user()->role->name == 'admin_sarpras';
                @endphp

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="title" class="form-label">Judul Laporan</label>
                        <input type="text" name="title" value="{{ old('title', $report->title) }}" class="form-control" placeholder="Judul" {{ $isAdmin ? 'disabled' : '' }}>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="location" class="form-label">Lokasi</label>
                        <input type="text" name="location" value="{{ old('location', $report->location) }}" class="form-control" placeholder="Lokasi" {{ $isAdmin ? 'disabled' : '' }}>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="category_id" class="form-label">Kategori</label>
                        <select name="category_id" class="form-select" {{ $isAdmin ? 'disabled' : '' }}>
                            @foreach ($categories as $category)
                                <option value="{{ $category->category_id }}" {{ old('category_id', $report->category_id) == $category->category_id ? 'selected' : '' }}>
                                    {{ $category->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="jenis_instansi" class="form-label">Jenis Instansi</label>
                        <select class="form-select" id="jenis_instansi" name="jenis_instansi" {{ $isAdmin ? 'disabled' : '' }}>
                            <option selected disabled value="">Pilih Jenis Instansi...</option>
                            <option value="fakultas" {{ old('jenis_instansi', $report->instansi->jenis ?? '') == 'fakultas' ? 'selected' : '' }}>🏛️ Fakultas</option>
                            <option value="perpustakaan" {{ old('jenis_instansi', $report->instansi->jenis ?? '') == 'perpustakaan' ? 'selected' : '' }}>📚 Perpustakaan</option>
                            <option value="lainnya" {{ old('jenis_instansi', $report->instansi->jenis ?? '') == 'lainnya' ? 'selected' : '' }}>🏢 Lainnya</option>
                        </select>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="instansi_id" class="form-label">Nama Instansi</label>
                        <select name="instansi_id" id="instansi_id" class="form-select" {{ $isAdmin ? 'disabled' : '' }}>
                            <option value="">Pilih Nama Instansi...</option>
                        </select>
                    </div>
                    <div class="col-md-12 mb-3">
                        <label for="description" class="form-label">Deskripsi</label>
                        <textarea class="form-control" style="height:150px" name="description" placeholder="Deskripsi" {{ $isAdmin ? 'disabled' : '' }}>{{ old('description', $report->description) }}</textarea>
                    </div>
                    
                    {{-- HANYA TAMPIL UNTUK ADMIN --}}
                    @if($isAdmin)
                        <div class="col-md-6 mb-3">
                            <label for="status" class="form-label">Ubah Status</label>
                            <select name="status" class="form-select">
                                <option value="pending" {{ old('status', $report->status) == 'pending' ? 'selected' : '' }}>Pending</option>
                                <option value="in_progress" {{ old('status', $report->status) == 'in_progress' ? 'selected' : '' }}>In Progress</option>
                                <option value="completed" {{ old('status', $report->status) == 'completed' ? 'selected' : '' }}>Completed</option>
                                <option value="rejected" {{ old('status', $report->status) == 'rejected' ? 'selected' : '' }}>Rejected</option>
                            </select>
                        </div>
                        <div class="col-md-12 mb-3">
                            <label for="admin_comment" class="form-label">Tambah Komentar / Catatan (Opsional)</label>
                            <textarea class="form-control" name="admin_comment" placeholder="Tambahkan catatan untuk user..."></textarea>
                        </div>
                    @else
                    {{-- HANYA TAMPIL UNTUK USER --}}
                        <div class="col-md-6 mb-3">
                            <label for="attachment" class="form-label">Ganti Lampiran (Opsional)</label>
                            <input class="form-control" type="file" name="attachment">
                        </div>
                    @endif
                    
                    <div class="col-md-12 text-end">
                        <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const jenisInstansiSelect = document.getElementById('jenis_instansi');
            const instansiSelect = document.getElementById('instansi_id');
            const currentInstansiId = {{ $report->instansi_id }};
            const currentJenis = '{{ $report->instansi->jenis ?? "" }}';
            
            // Load instansi based on current jenis
            if (currentJenis) {
                loadInstansiByJenis(currentJenis, currentInstansiId);
            }
            
            jenisInstansiSelect.addEventListener('change', function() {
                const jenis = this.value;
                loadInstansiByJenis(jenis);
            });
            
            function loadInstansiByJenis(jenis, selectedId = null) {
                if (!jenis) {
                    instansiSelect.innerHTML = '<option value="">Pilih Jenis Instansi terlebih dahulu...</option>';
                    instansiSelect.disabled = true;
                    return;
                }
                
                // Enable instansi select
                instansiSelect.disabled = false;
                instansiSelect.innerHTML = '<option value="">Memuat...</option>';
                
                // Fetch instansi berdasarkan jenis
                fetch(`{{ route('reports.get-instansi-by-type') }}?jenis=${jenis}`)
                    .then(response => response.json())
                    .then(data => {
                        instansiSelect.innerHTML = '<option value="">Pilih Nama Instansi...</option>';
                        
                        data.forEach(instansi => {
                            const option = document.createElement('option');
                            option.value = instansi.instansi_id;
                            option.textContent = instansi.name;
                            
                            if (selectedId && instansi.instansi_id == selectedId) {
                                option.selected = true;
                            }
                            
                            instansiSelect.appendChild(option);
                        });
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        instansiSelect.innerHTML = '<option value="">Error loading data</option>';
                    });
            }
        });
    </script>

    {{-- Footer strip --}}
    <div class="footer-strip">
        © 2025 LaporUnair. All Rights Reserved.
    </div>
@endsection


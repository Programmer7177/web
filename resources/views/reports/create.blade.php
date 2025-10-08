@extends('layouts.app')

@push('styles')
<style>
    .form-container {
        background-color: #ffffff;
        border: 1px solid #d1e7fd;
        border-radius: 15px;
        padding: 2rem;
        max-width: 800px;
        margin: 2rem auto;
        box-shadow: 0 4px 12px rgba(0,0,0,0.05);
    }
    .form-container h2 {
        text-align: center;
        margin-bottom: 2rem;
        font-weight: bold;
    }
    .form-label {
        margin-bottom: 0.5rem;
        font-weight: 600;
    }
    .form-control, .form-select {
        border-radius: 8px;
        border: 1px solid #ced4da;
    }
    .btn-submit {
        background-color: #0d6efd;
        border: none;
        border-radius: 25px;
        padding: 10px 30px;
        float: right;
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
</style>
@endpush

@section('content')
    <div class="form-container">
        <h2>Pembuatan Laporan</h2>
        
        <form action="{{ route('reports.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="mb-3">
                <label for="category_id" class="form-label">Kategori Laporan</label>
                <select class="form-select" id="category_id" name="category_id" required>
                    <option selected disabled value="">Pilih Kategori...</option>
                    @foreach ($categories as $category)
                        <option value="{{ $category->category_id }}">{{ $category->name }}</option>
                    @endforeach
                </select>
            </div>

    <div class="mb-3">
        <label for="jenis_instansi" class="form-label">Jenis Instansi</label>
        <select class="form-select" id="jenis_instansi" name="jenis_instansi" required>
            <option selected disabled value="">Pilih Jenis Instansi...</option>
            <option value="fakultas">🏛️ Fakultas</option>
            <option value="perpustakaan">📚 Perpustakaan</option>
            <option value="lainnya">🏢 Lainnya</option>
        </select>
    </div>

    <div class="mb-3">
        <label for="instansi_id" class="form-label">Nama Instansi</label>
        <select class="form-select" id="instansi_id" name="instansi_id" required disabled>
            <option selected disabled value="">Pilih Jenis Instansi terlebih dahulu...</option>
        </select>
    </div>

            <div class="mb-3">
                <label for="title" class="form-label">Judul Laporan</label>
                <input type="text" class="form-control" id="title" name="title" required>
            </div>

            <div class="mb-3">
                <label for="location" class="form-label">Lokasi (Contoh: Ruang 6.09, Gedung Nano)</label>
                <input type="text" class="form-control" id="location" name="location" required>
            </div>

            <div class="mb-3">
                <label for="description" class="form-label">Deskripsi</label>
                <textarea class="form-control" id="description" name="description" rows="4" required></textarea>
            </div>

            <div class="mb-3">
                <label for="attachment" class="form-label">Lampirkan File (Opsional)</label>
                <input class="form-control" type="file" id="attachment" name="attachment">
            </div>

            <button type="submit" class="btn btn-primary btn-submit">Kirim Laporan</button>
        </form>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const jenisInstansiSelect = document.getElementById('jenis_instansi');
            const instansiSelect = document.getElementById('instansi_id');
            
            jenisInstansiSelect.addEventListener('change', function() {
                const jenis = this.value;
                
                if (!jenis) {
                    instansiSelect.innerHTML = '<option selected disabled value="">Pilih Jenis Instansi terlebih dahulu...</option>';
                    instansiSelect.disabled = true;
                    return;
                }
                
                // Enable instansi select
                instansiSelect.disabled = false;
                instansiSelect.innerHTML = '<option selected disabled value="">Memuat...</option>';
                
                // Fetch instansi berdasarkan jenis
                fetch(`{{ route('reports.get-instansi-by-type') }}?jenis=${jenis}`)
                    .then(response => response.json())
                    .then(data => {
                        instansiSelect.innerHTML = '<option selected disabled value="">Pilih Nama Instansi...</option>';
                        
                        data.forEach(instansi => {
                            const option = document.createElement('option');
                            option.value = instansi.instansi_id;
                            option.textContent = instansi.name;
                            instansiSelect.appendChild(option);
                        });
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        instansiSelect.innerHTML = '<option selected disabled value="">Error loading data</option>';
                    });
            });
        });
    </script>

    {{-- Footer strip --}}
    <div class="footer-strip">
        © 2025 LaporUnair. All Rights Reserved.
    </div>
@endsection
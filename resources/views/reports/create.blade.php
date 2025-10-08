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
                <label for="instansi_type_id" class="form-label">Jenis Instansi</label>
                <select class="form-select" id="instansi_type_id" name="instansi_type_id" required>
                    <option selected disabled value="">Pilih Jenis Instansi...</option>
                    @foreach ($instansiTypes as $instansiType)
                        <option value="{{ $instansiType->instansi_type_id }}">{{ $instansiType->name }}</option>
                    @endforeach
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
            const instansiTypeSelect = document.getElementById('instansi_type_id');
            const instansiSelect = document.getElementById('instansi_id');
            
            instansiTypeSelect.addEventListener('change', function() {
                const instansiTypeId = this.value;
                
                if (instansiTypeId) {
                    // Enable instansi select
                    instansiSelect.disabled = false;
                    instansiSelect.innerHTML = '<option selected disabled value="">Memuat...</option>';
                    
                    // Fetch instansi by type
                    fetch(`{{ route('reports.get-instansi-by-type') }}?instansi_type_id=${instansiTypeId}`)
                        .then(response => response.json())
                        .then(data => {
                            instansiSelect.innerHTML = '<option selected disabled value="">Pilih Nama Instansi...</option>';
                            
                            data.instansis.forEach(instansi => {
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
                } else {
                    // Disable instansi select
                    instansiSelect.disabled = true;
                    instansiSelect.innerHTML = '<option selected disabled value="">Pilih Jenis Instansi terlebih dahulu...</option>';
                }
            });
        });
    </script>
@endsection
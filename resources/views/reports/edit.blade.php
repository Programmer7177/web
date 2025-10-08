@extends(Auth::user()->role->name == 'admin_sarpras' ? 'layouts.admin' : 'layouts.app')

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
                        <label for="instansi_type_id" class="form-label">Jenis Instansi</label>
                        <select name="instansi_type_id" id="instansi_type_id" class="form-select" {{ $isAdmin ? 'disabled' : '' }}>
                            <option value="">Pilih Jenis Instansi...</option>
                            @foreach ($instansiTypes as $instansiType)
                                <option value="{{ $instansiType->instansi_type_id }}" {{ old('instansi_type_id', $report->instansi_type_id) == $instansiType->instansi_type_id ? 'selected' : '' }}>
                                    {{ $instansiType->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="instansi_id" class="form-label">Nama Instansi</label>
                        <select name="instansi_id" id="instansi_id" class="form-select" {{ $isAdmin ? 'disabled' : '' }}>
                            <option value="">Pilih Nama Instansi...</option>
                            @foreach ($instansis as $instansi)
                                <option value="{{ $instansi->instansi_id }}" {{ old('instansi_id', $report->instansi_id) == $instansi->instansi_id ? 'selected' : '' }}>
                                    {{ $instansi->name }}
                                </option>
                            @endforeach
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
            const instansiTypeSelect = document.getElementById('instansi_type_id');
            const instansiSelect = document.getElementById('instansi_id');
            
            // Function to load instansi by type
            function loadInstansiByType(instansiTypeId, selectedInstansiId = null) {
                if (instansiTypeId) {
                    instansiSelect.innerHTML = '<option value="">Memuat...</option>';
                    
                    fetch(`{{ route('reports.get-instansi-by-type') }}?instansi_type_id=${instansiTypeId}`)
                        .then(response => response.json())
                        .then(data => {
                            instansiSelect.innerHTML = '<option value="">Pilih Nama Instansi...</option>';
                            
                            data.instansis.forEach(instansi => {
                                const option = document.createElement('option');
                                option.value = instansi.instansi_id;
                                option.textContent = instansi.name;
                                if (selectedInstansiId && instansi.instansi_id == selectedInstansiId) {
                                    option.selected = true;
                                }
                                instansiSelect.appendChild(option);
                            });
                        })
                        .catch(error => {
                            console.error('Error:', error);
                            instansiSelect.innerHTML = '<option value="">Error loading data</option>';
                        });
                } else {
                    instansiSelect.innerHTML = '<option value="">Pilih Jenis Instansi terlebih dahulu...</option>';
                }
            }
            
            // Load instansi on page load if type is already selected
            const currentTypeId = instansiTypeSelect.value;
            const currentInstansiId = '{{ $report->instansi_id }}';
            if (currentTypeId) {
                loadInstansiByType(currentTypeId, currentInstansiId);
            }
            
            // Handle type change
            instansiTypeSelect.addEventListener('change', function() {
                const instansiTypeId = this.value;
                loadInstansiByType(instansiTypeId);
            });
        });
    </script>
@endsection


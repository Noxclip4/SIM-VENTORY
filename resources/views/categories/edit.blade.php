@extends('layouts.app')

@section('content')
<!-- Header -->
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h2 class="mb-1">Edit Kategori</h2>
        <p class="text-muted mb-0">Perbarui informasi kategori</p>
    </div>
    <div class="btn-group-spaced">
        <a href="{{ route('categories.index') }}" class="btn btn-outline-secondary">
            <i class="bi bi-arrow-left me-2"></i>Kembali
        </a>
    </div>
</div>

<!-- Form Card -->
<div class="card">
    <div class="card-header">
        <h5 class="mb-0 fw-bold">
            <i class="bi bi-tag me-2"></i>Form Edit Kategori
        </h5>
    </div>
    <div class="card-body">
        <form method="POST" action="{{ route('categories.update', $category) }}">
            @csrf
            @method('PUT')
            
            <div class="row">
                <div class="col-md-8">
                    <div class="mb-4">
                        <label for="name" class="form-label fw-medium">
                            <i class="bi bi-tag me-1"></i>Nama Kategori <span class="text-danger">*</span>
                        </label>
                        <input type="text" 
                               name="name" 
                               id="name" 
                               class="form-control @error('name') is-invalid @enderror" 
                               value="{{ old('name', $category->name) }}" 
                               placeholder="Contoh: Elektronik, Pakaian, Makanan..."
                               required>
                        @error('name')
                            <div class="invalid-feedback">
                                <i class="bi bi-exclamation-triangle me-1"></i>{{ $message }}
                            </div>
                        @enderror
                        <div class="form-text">
                            <i class="bi bi-info-circle me-1"></i>Nama kategori harus unik dan deskriptif
                        </div>
                    </div>
                </div>
                
                <div class="col-md-4">
                    <div class="mb-4">
                        <label class="form-label fw-medium">
                            <i class="bi bi-palette me-1"></i>Warna Kategori
                        </label>
                        <div class="d-flex gap-2">
                            <input type="color" 
                                   class="form-control form-control-color" 
                                   name="color" 
                                   value="{{ old('color', $category->color ?? '#4e73df') }}" 
                                   title="Pilih warna kategori">
                            <span class="text-muted small align-self-center">Opsional</span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="mb-4">
                <label for="description" class="form-label fw-medium">
                    <i class="bi bi-text-paragraph me-1"></i>Deskripsi
                </label>
                <textarea name="description" 
                          id="description" 
                          class="form-control @error('description') is-invalid @enderror" 
                          rows="4" 
                          placeholder="Jelaskan kategori ini untuk membantu pengguna memahami jenis produk yang termasuk...">{{ old('description', $category->description) }}</textarea>
                @error('description')
                    <div class="invalid-feedback">
                        <i class="bi bi-exclamation-triangle me-1"></i>{{ $message }}
                    </div>
                @enderror
                <div class="form-text">
                    <i class="bi bi-info-circle me-1"></i>Deskripsi membantu pengguna memahami kategori ini
                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="mb-4">
                        <label class="form-label fw-medium">
                            <i class="bi bi-gear me-1"></i>Pengaturan
                        </label>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="is_active" name="is_active" value="1" {{ old('is_active', $category->is_active ?? true) ? 'checked' : '' }}>
                            <label class="form-check-label" for="is_active">
                                Kategori aktif (dapat digunakan)
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="show_in_menu" name="show_in_menu" value="1" {{ old('show_in_menu', $category->show_in_menu ?? true) ? 'checked' : '' }}>
                            <label class="form-check-label" for="show_in_menu">
                                Tampilkan di menu navigasi
                            </label>
                        </div>
                    </div>
                </div>
                
                <div class="col-md-6">
                    <div class="mb-4">
                        <label class="form-label fw-medium">
                            <i class="bi bi-info-circle me-1"></i>Informasi
                        </label>
                        <div class="bg-light p-3 rounded">
                            <small class="text-muted">
                                <i class="bi bi-lightbulb me-1"></i>
                                <strong>Tips:</strong> Buat kategori yang jelas dan mudah dipahami. 
                                Contoh kategori yang baik: "Laptop & Komputer", "Smartphone & Tablet", "Aksesoris".
                            </small>
                        </div>
                    </div>
                </div>
            </div>

            <hr class="my-4">

            <!-- Action Buttons -->
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <a href="{{ route('categories.index') }}" class="btn btn-outline-secondary">
                        <i class="bi bi-x-circle me-2"></i>Batal
                    </a>
                </div>
                <div class="btn-group-spaced">
                    <button type="reset" class="btn btn-outline-warning">
                        <i class="bi bi-arrow-clockwise me-2"></i>Reset
                    </button>
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-check-circle me-2"></i>Update Kategori
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>

<style>
    .form-control:focus {
        border-color: #1e40af;
        box-shadow: 0 0 0 0.2rem rgba(30, 64, 175, 0.25);
    }
    
    .btn-group-spaced .btn {
        margin-right: 0.5rem;
    }
    
    .btn-group-spaced .btn:last-child {
        margin-right: 0;
    }
    
    .form-control-color {
        width: 60px;
        height: 38px;
    }
</style>
@endsection 
@extends('layouts.app')

@section('content')
<!-- Header -->
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h2 class="mb-1">Detail Produk</h2>
        <p class="text-muted mb-0">Informasi lengkap produk</p>
    </div>
    <div class="btn-group-spaced">
        <a href="{{ route('products.index') }}" class="btn btn-outline-secondary">
            <i class="bi bi-arrow-left me-2"></i>Kembali
        </a>
    </div>
</div>

<div class="card">
    <div class="card-header">
        <h5 class="mb-0 fw-bold">
            <i class="bi bi-box me-2"></i>Informasi Produk
        </h5>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-md-5 mb-4">
                @if ($product->image)
                    <img src="{{ asset('storage/' . $product->image) }}" 
                         alt="{{ $product->name }}" 
                         class="img-fluid rounded shadow-sm"
                         style="max-height: 300px; object-fit: cover;">
                @else
                    <div class="bg-light rounded d-flex align-items-center justify-content-center p-5" 
                         style="height: 300px;">
                        <div class="text-center">
                            <i class="bi bi-image display-4 text-muted"></i>
                            <h5 class="text-muted mt-3">Tidak Ada Gambar</h5>
                        </div>
                    </div>
                @endif
            </div>
            <div class="col-md-7">
                <h3 class="mb-3">{{ $product->name }}</h3>
                <div class="mb-3">
                    <span class="badge" style="background-color: var(--primary-color); color: white; font-size: 0.9rem;">
                        {{ $product->category->name }}
                    </span>
                </div>
                <div class="mb-3">
                    <h4 class="fw-bold" style="color: var(--success-color);">
                        Rp {{ number_format($product->price, 0, ',', '.') }}
                    </h4>
                </div>
                
                <div class="mb-3">
                    <label class="form-label fw-medium">Stok Tersedia</label>
                    <p class="mb-0">
                        @if($product->stock_quantity > 0)
                            <span class="badge" style="background-color: var(--success-color); color: white;">
                                {{ $product->stock_quantity }} unit
                            </span>
                        @else
                            <span class="badge" style="background-color: var(--danger-color); color: white;">
                                Stok Habis
                            </span>
                        @endif
                    </p>
                </div>
                
                <div class="mb-4">
                    <label class="form-label fw-medium">Deskripsi</label>
                    <p class="mb-0">{{ $product->description ?: 'Tidak ada deskripsi' }}</p>
                </div>
                
                <div class="mb-3">
                    <label class="form-label fw-medium">Dibuat Pada</label>
                    <p class="mb-0 text-muted">{{ $product->created_at->format('d M Y, H:i') }}</p>
                </div>
                
                <div class="mb-3">
                    <label class="form-label fw-medium">Terakhir Diperbarui</label>
                    <p class="mb-0 text-muted">{{ $product->updated_at->format('d M Y, H:i') }}</p>
                </div>
                
                <hr class="my-4">
                
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <a href="{{ route('products.index') }}" class="btn btn-outline-secondary">
                            <i class="bi bi-arrow-left me-2"></i>Kembali
                        </a>
                    </div>
                    <div class="btn-group-spaced">
                        <a href="{{ route('products.edit', $product) }}" class="btn btn-warning">
                            <i class="bi bi-pencil me-2"></i>Edit
                        </a>
                        <form action="{{ route('products.destroy', $product) }}" method="POST" class="d-inline delete-form">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger">
                                <i class="bi bi-trash me-2"></i>Hapus
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
// SweetAlert for delete confirmation
document.addEventListener('DOMContentLoaded', function() {
    const deleteForms = document.querySelectorAll('.delete-form');
    
    deleteForms.forEach(form => {
        form.addEventListener('submit', function(e) {
            e.preventDefault();
            
            Swal.fire({
                title: 'Konfirmasi Hapus',
                text: 'Apakah Anda yakin ingin menghapus produk ini?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#dc2626',
                cancelButtonColor: '#6b7280',
                confirmButtonText: 'Ya, Hapus!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    // Show loading
                    Swal.fire({
                        title: 'Menghapus Produk...',
                        text: 'Mohon tunggu sebentar',
                        allowOutsideClick: false,
                        didOpen: () => {
                            Swal.showLoading();
                        }
                    });
                    // Submit form
                    form.submit();
                }
            });
        });
    });
});
</script>
@endsection
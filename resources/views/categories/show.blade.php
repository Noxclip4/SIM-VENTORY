@extends('layouts.app')

@section('content')
<!-- Header -->
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h2 class="mb-1">Detail Kategori</h2>
        <p class="text-muted mb-0">Informasi lengkap kategori</p>
    </div>
    <div class="btn-group-spaced">
        <a href="{{ route('categories.index') }}" class="btn btn-outline-secondary">
            <i class="bi bi-arrow-left me-2"></i>Kembali
        </a>
    </div>
</div>

<div class="card">
    <div class="card-header">
        <h5 class="mb-0 fw-bold">
            <i class="bi bi-tag me-2"></i>Informasi Kategori
        </h5>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-md-6">
                <div class="mb-4">
                    <label class="form-label fw-medium">Nama Kategori</label>
                    <h4 class="mb-0" style="color: var(--primary-color);">{{ $category->name }}</h4>
                </div>
                
                <div class="mb-4">
                    <label class="form-label fw-medium">Deskripsi</label>
                    <p class="mb-0">{{ $category->description ?: 'Tidak ada deskripsi' }}</p>
                </div>
                
                <div class="mb-4">
                    <label class="form-label fw-medium">Jumlah Produk</label>
                    <div>
                        <span class="badge" style="background-color: var(--info-color); color: white; font-size: 1rem;">
                            {{ $category->products_count ?? 0 }} produk
                        </span>
                    </div>
                </div>
                
                <div class="mb-4">
                    <label class="form-label fw-medium">Dibuat Pada</label>
                    <p class="mb-0 text-muted">{{ $category->created_at->format('d M Y, H:i') }}</p>
                </div>
                
                <div class="mb-4">
                    <label class="form-label fw-medium">Terakhir Diperbarui</label>
                    <p class="mb-0 text-muted">{{ $category->updated_at->format('d M Y, H:i') }}</p>
                </div>
            </div>
        </div>

        @if($category->products && $category->products->count() > 0)
        <hr class="my-4">
        <div class="mb-4">
            <h5 class="fw-bold">
                <i class="bi bi-box me-2"></i>Produk dalam Kategori Ini
            </h5>
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th class="px-4 py-3">No</th>
                            <th class="px-4 py-3">Nama Produk</th>
                            <th class="px-4 py-3">Harga</th>
                            <th class="px-4 py-3">Stok</th>
                            <th class="px-4 py-3">Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($category->products as $index => $product)
                        <tr>
                            <td class="px-4 py-3">{{ $index + 1 }}</td>
                            <td class="px-4 py-3">
                                <div class="fw-medium">{{ $product->name }}</div>
                            </td>
                            <td class="px-4 py-3">
                                <span class="fw-bold" style="color: var(--success-color);">
                                    Rp {{ number_format($product->price, 0, ',', '.') }}
                                </span>
                            </td>
                            <td class="px-4 py-3">
                                @if($product->stock_quantity > 0)
                                    <span class="badge" style="background-color: var(--success-color); color: white;">
                                        {{ $product->stock_quantity }}
                                    </span>
                                @else
                                    <span class="badge" style="background-color: var(--danger-color); color: white;">
                                        Habis
                                    </span>
                                @endif
                            </td>
                            <td class="px-4 py-3">
                                @if($product->stock_quantity > 10)
                                    <span class="badge" style="background-color: var(--success-color); color: white;">
                                        <i class="bi bi-check-circle me-1"></i>Tersedia
                                    </span>
                                @elseif($product->stock_quantity > 0)
                                    <span class="badge" style="background-color: var(--warning-color); color: white;">
                                        <i class="bi bi-exclamation-triangle me-1"></i>Stok Rendah
                                    </span>
                                @else
                                    <span class="badge" style="background-color: var(--danger-color); color: white;">
                                        <i class="bi bi-x-circle me-1"></i>Habis
                                    </span>
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        @else
        <hr class="my-4">
        <div class="text-center py-4">
            <i class="bi bi-box display-4 text-muted"></i>
            <h5 class="text-muted mt-3">Belum ada produk</h5>
            <p class="text-muted mb-0">Kategori ini belum memiliki produk</p>
        </div>
        @endif

        <hr class="my-4">
        
        <div class="d-flex justify-content-between align-items-center">
            <div>
                <a href="{{ route('categories.index') }}" class="btn btn-outline-secondary">
                    <i class="bi bi-arrow-left me-2"></i>Kembali
                </a>
            </div>
            <div class="btn-group-spaced">
                <a href="{{ route('categories.edit', $category) }}" class="btn btn-warning">
                    <i class="bi bi-pencil me-2"></i>Edit
                </a>
            </div>
        </div>
    </div>
</div>
@endsection 
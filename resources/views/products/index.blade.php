@extends('layouts.app')

@section('content')
<!-- Header -->
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h2 class="mb-1">Daftar Produk</h2>
        <p class="text-muted mb-0">Kelola inventori produk Anda</p>
    </div>
    <div class="btn-group-spaced">
        @if(auth()->user()->role === 'admin')
        <a href="{{ route('products.create') }}" class="btn btn-primary">
            <i class="bi bi-plus-circle me-2"></i>Tambah Produk
        </a>
        @endif
    </div>
</div>

<!-- Search and Filter -->
<div class="card mb-4">
    <div class="card-body">
        <form method="GET" action="{{ route('products.index') }}" class="row g-3">
            <div class="col-md-3">
                <label for="search" class="form-label fw-medium">Cari Produk</label>
                <input type="text" class="form-control" id="search" name="search" 
                       value="{{ request('search') }}" placeholder="Nama produk...">
            </div>
            <div class="col-md-2">
                <label for="category" class="form-label fw-medium">Kategori</label>
                <select class="form-select" id="category" name="category">
                    <option value="">Semua Kategori</option>
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}" {{ request('category') == $category->id ? 'selected' : '' }}>
                            {{ $category->name }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-2">
                <label for="stock_status" class="form-label fw-medium">Status Stok</label>
                <select class="form-select" id="stock_status" name="stock_status">
                    <option value="">Semua</option>
                    <option value="low" {{ request('stock_status') == 'low' ? 'selected' : '' }}>Stok Rendah</option>
                    <option value="normal" {{ request('stock_status') == 'normal' ? 'selected' : '' }}>Stok Normal</option>
                    <option value="high" {{ request('stock_status') == 'high' ? 'selected' : '' }}>Stok Tinggi</option>
                </select>
            </div>
            <div class="col-md-2">
                <label for="sort" class="form-label fw-medium">Urutkan</label>
                <select class="form-select" id="sort" name="sort">
                    <option value="name" {{ request('sort') == 'name' ? 'selected' : '' }}>Nama (A-Z)</option>
                    <option value="price" {{ request('sort') == 'price' ? 'selected' : '' }}>Harga (Rendah-Tinggi)</option>
                    <option value="price_desc" {{ request('sort') == 'price_desc' ? 'selected' : '' }}>Harga (Tinggi-Rendah)</option>
                    <option value="stock" {{ request('sort') == 'stock' ? 'selected' : '' }}>Stok (Rendah-Tinggi)</option>
                    <option value="created_at" {{ request('sort') == 'created_at' ? 'selected' : '' }}>Terbaru</option>
                </select>
            </div>
            <div class="col-md-2">
                <label for="per_page" class="form-label fw-medium">Per Halaman</label>
                <select class="form-select" id="per_page" name="per_page">
                    <option value="10" {{ request('per_page') == '10' ? 'selected' : '' }}>10</option>
                    <option value="25" {{ request('per_page') == '25' ? 'selected' : '' }}>25</option>
                    <option value="50" {{ request('per_page') == '50' ? 'selected' : '' }}>50</option>
                </select>
            </div>
            <div class="col-md-1 d-flex align-items-end">
                <div class="btn-group-spaced w-100">
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-search me-1"></i>Cari
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>

<!-- Products Table -->
<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="mb-0 fw-bold">
            <i class="bi bi-box me-2"></i>Produk ({{ $products->total() }})
        </h5>
        @if($products->count() > 0 && auth()->user()->role === 'admin')
        <div class="btn-group-spaced">
            <a href="{{ route('products.create') }}" class="btn btn-success btn-sm">
                <i class="bi bi-plus-circle me-1"></i>Tambah Baru
            </a>
        </div>
        @endif
    </div>
    <div class="card-body p-0">
        @if($products->count() > 0)
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead>
                        <tr>
                            <th class="px-4 py-3">No</th>
                            <th class="px-4 py-3">Produk</th>
                            <th class="px-4 py-3">Kategori</th>
                            <th class="px-4 py-3">Harga</th>
                            <th class="px-4 py-3">Stok</th>
                            <th class="px-4 py-3">Status</th>
                            <th class="px-4 py-3 text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($products as $index => $product)
                        <tr>
                            <td class="px-4 py-3">
                                <span class="fw-medium">{{ $products->firstItem() + $index }}</span>
                            </td>
                            <td class="px-4 py-3">
                                <div class="d-flex align-items-center">
                                    @if($product->image)
                                        <img src="{{ asset('storage/' . $product->image) }}" 
                                             alt="{{ $product->name }}" 
                                             class="rounded me-3"
                                             style="width: 50px; height: 50px; object-fit: cover;">
                                    @else
                                        <div class="bg-light rounded d-flex align-items-center justify-content-center me-3" 
                                             style="width: 50px; height: 50px;">
                                            <i class="bi bi-image text-muted"></i>
                                        </div>
                                    @endif
                                    <div>
                                        <div class="fw-bold text-dark">{{ $product->name }}</div>
                                        <small class="text-muted">{{ Str::limit($product->description, 50) }}</small>
                                    </div>
                                </div>
                            </td>
                            <td class="px-4 py-3">
                                <span class="badge" style="background-color: var(--secondary-color); color: white; font-weight: 600;">
                                    {{ $product->category->name }}
                                </span>
                            </td>
                            <td class="px-4 py-3">
                                <span class="fw-bold text-success">
                                    Rp {{ number_format($product->price, 0, ',', '.') }}
                                </span>
                            </td>
                            <td class="px-4 py-3">
                                <div class="d-flex align-items-center">
                                    <span class="fw-medium me-2">{{ $product->stock_quantity }}</span>
                                    @if($product->stock_quantity <= 10)
                                        <span class="badge" style="background-color: var(--danger-color); color: white; font-weight: 600;">Rendah</span>
                                    @elseif($product->stock_quantity >= 50)
                                        <span class="badge" style="background-color: var(--success-color); color: white; font-weight: 600;">Tinggi</span>
                                    @else
                                        <span class="badge" style="background-color: var(--warning-color); color: white; font-weight: 600;">Normal</span>
                                    @endif
                                </div>
                            </td>
                            <td class="px-4 py-3">
                                @if($product->stock_quantity > 0)
                                    <span class="badge" style="background-color: var(--success-color); color: white; font-weight: 600;">
                                        <i class="bi bi-check-circle me-1"></i>Tersedia
                                    </span>
                                @else
                                    <span class="badge" style="background-color: var(--danger-color); color: white; font-weight: 600;">
                                        <i class="bi bi-x-circle me-1"></i>Habis
                                    </span>
                                @endif
                            </td>
                            <td class="px-4 py-3 text-center">
                                <div class="btn-group-spaced">
                                    <a href="{{ route('products.show', $product) }}" 
                                       class="btn btn-outline-primary btn-sm" 
                                       title="Lihat Detail">
                                        <i class="bi bi-eye"></i>
                                    </a>
                                    @if(auth()->user()->role === 'admin')
                                    <a href="{{ route('products.edit', $product) }}" 
                                       class="btn btn-outline-warning btn-sm" 
                                       title="Edit">
                                        <i class="bi bi-pencil"></i>
                                    </a>
                                    <form action="{{ route('products.destroy', $product) }}" 
                                          method="POST" 
                                          class="d-inline delete-form">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" 
                                                class="btn btn-outline-danger btn-sm" 
                                                title="Hapus">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </form>
                                    @endif
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <div class="text-center py-5">
                <div class="mb-3">
                    <i class="bi bi-box text-muted" style="font-size: 3rem;"></i>
                </div>
                <h5 class="text-muted mb-2">Belum ada produk</h5>
                <p class="text-muted mb-4">Mulai dengan menambahkan produk pertama Anda</p>
                <a href="{{ route('products.create') }}" class="btn btn-primary">
                    <i class="bi bi-plus-circle me-2"></i>Tambah Produk Pertama
                </a>
            </div>
        @endif
    </div>
</div>

<!-- Pagination -->
@if($products->hasPages())
<div class="d-flex justify-content-center mt-4">
    {{ $products->appends(request()->query())->links() }}
</div>
@endif

<script>
// SweetAlert2 for delete confirmation
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
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Ya, Hapus!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    form.submit();
                }
            });
        });
    });
});
</script>
@endsection

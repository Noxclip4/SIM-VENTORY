@extends('layouts.app')

@section('content')
<!-- Header -->
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h2 class="mb-1">Daftar Kategori</h2>
        <p class="text-muted mb-0">Kelola kategori produk Anda</p>
    </div>
    <div class="btn-group-spaced">
        @if(auth()->user()->role === 'admin')
        <a href="{{ route('categories.create') }}" class="btn btn-primary">
            <i class="bi bi-plus-circle me-2"></i>Tambah Kategori
        </a>
        @endif
    </div>
</div>

<!-- Search and Filter -->
<div class="card mb-4">
    <div class="card-body">
        <form method="GET" action="{{ route('categories.index') }}" class="row g-3">
            <div class="col-md-4">
                <label for="search" class="form-label fw-medium">Cari Kategori</label>
                <input type="text" class="form-control" id="search" name="search" 
                       value="{{ request('search') }}" placeholder="Masukkan nama kategori...">
            </div>
            <div class="col-md-3">
                <label for="sort" class="form-label fw-medium">Urutkan</label>
                <select class="form-select" id="sort" name="sort">
                    <option value="name" {{ request('sort') == 'name' ? 'selected' : '' }}>Nama (A-Z)</option>
                    <option value="name_desc" {{ request('sort') == 'name_desc' ? 'selected' : '' }}>Nama (Z-A)</option>
                    <option value="created_at" {{ request('sort') == 'created_at' ? 'selected' : '' }}>Terbaru</option>
                    <option value="created_at_desc" {{ request('sort') == 'created_at_desc' ? 'selected' : '' }}>Terlama</option>
                </select>
            </div>
            <div class="col-md-3">
                <label for="per_page" class="form-label fw-medium">Per Halaman</label>
                <select class="form-select" id="per_page" name="per_page">
                    <option value="10" {{ request('per_page') == '10' ? 'selected' : '' }}>10</option>
                    <option value="25" {{ request('per_page') == '25' ? 'selected' : '' }}>25</option>
                    <option value="50" {{ request('per_page') == '50' ? 'selected' : '' }}>50</option>
                </select>
            </div>
            <div class="col-md-2 d-flex align-items-end">
                <div class="btn-group-spaced w-100">
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-search me-1"></i>Cari
                    </button>
                    <a href="{{ route('categories.index') }}" class="btn btn-outline-secondary">
                        <i class="bi bi-arrow-clockwise me-1"></i>Reset
                    </a>
                </div>
            </div>
        </form>
    </div>
</div>

<!-- Categories Table -->
<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="mb-0 fw-bold">
            <i class="bi bi-tags me-2"></i>Kategori ({{ $categories->total() }})
        </h5>
        @if($categories->count() > 0 && auth()->user()->role === 'admin')
        <div class="btn-group-spaced">
            <a href="{{ route('categories.create') }}" class="btn btn-success btn-sm">
                <i class="bi bi-plus-circle me-1"></i>Tambah Baru
            </a>
        </div>
        @endif
    </div>
    <div class="card-body p-0">
        @if($categories->count() > 0)
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead>
                        <tr>
                            <th class="px-4 py-3">No</th>
                            <th class="px-4 py-3">Nama Kategori</th>
                            <th class="px-4 py-3">Deskripsi</th>
                            <th class="px-4 py-3">Jumlah Produk</th>
                            <th class="px-4 py-3">Dibuat</th>
                            <th class="px-4 py-3 text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($categories as $index => $category)
                        <tr>
                            <td class="px-4 py-3">
                                <span class="fw-medium">{{ $categories->firstItem() + $index }}</span>
                            </td>
                            <td class="px-4 py-3">
                                <div class="d-flex align-items-center">
                                    <div class="bg-primary bg-opacity-10 rounded-circle d-flex align-items-center justify-content-center me-3" 
                                         style="width: 40px; height: 40px;">
                                        <i class="bi bi-tag text-primary"></i>
                                    </div>
                                    <div>
                                        <div class="fw-bold text-dark">{{ $category->name }}</div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-4 py-3">
                                <span class="text-muted">
                                    {{ $category->description ? Str::limit($category->description, 50) : 'Tidak ada deskripsi' }}
                                </span>
                            </td>
                            <td class="px-4 py-3">
                                <span class="badge" style="background-color: var(--info-color); color: white; font-weight: 600;">
                                    {{ $category->products_count ?? 0 }} produk
                                </span>
                            </td>
                            <td class="px-4 py-3">
                                <small class="text-muted">
                                    {{ $category->created_at->format('d M Y, H:i') }}
                                </small>
                            </td>
                            <td class="px-4 py-3 text-center">
                                <div class="btn-group-spaced">
                                    <a href="{{ route('categories.show', $category) }}" 
                                       class="btn btn-outline-primary btn-sm" 
                                       title="Lihat Detail">
                                        <i class="bi bi-eye"></i>
                                    </a>
                                    @if(auth()->user()->role === 'admin')
                                    <a href="{{ route('categories.edit', $category) }}" 
                                       class="btn btn-outline-warning btn-sm" 
                                       title="Edit">
                                        <i class="bi bi-pencil"></i>
                                    </a>
                                    <form action="{{ route('categories.destroy', $category) }}" 
                                          method="POST" 
                                          class="d-inline delete-form">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" 
                                                class="btn btn-outline-danger btn-sm" 
                                                title="Hapus"
                                                {{ ($category->products_count ?? 0) > 0 ? 'disabled' : '' }}>
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
                    <i class="bi bi-tags text-muted" style="font-size: 3rem;"></i>
                </div>
                <h5 class="text-muted mb-2">Belum ada kategori</h5>
                <p class="text-muted mb-4">Mulai dengan menambahkan kategori pertama Anda</p>
                <a href="{{ route('categories.create') }}" class="btn btn-primary">
                    <i class="bi bi-plus-circle me-2"></i>Tambah Kategori Pertama
                </a>
            </div>
        @endif
    </div>
</div>

<!-- Pagination -->
@if($categories->hasPages())
<div class="d-flex justify-content-center mt-4">
    {{ $categories->appends(request()->query())->links() }}
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
                text: 'Apakah Anda yakin ingin menghapus kategori ini?',
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
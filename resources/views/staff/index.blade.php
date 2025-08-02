@extends('layouts.app')

@section('content')
<!-- Header -->
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h2 class="mb-1">Manajemen Staff</h2>
        <p class="text-muted mb-0">Kelola akun staff dan admin</p>
    </div>
    <div class="btn-group-spaced">
        <a href="{{ route('staff.create') }}" class="btn btn-primary">
            <i class="bi bi-person-plus me-2"></i>Tambah Staff
        </a>
    </div>
</div>

<!-- Search and Filter -->
<div class="card mb-4">
    <div class="card-body">
        <form method="GET" action="{{ route('staff.index') }}" class="row g-3">
            <div class="col-md-4">
                <label for="search" class="form-label fw-medium">Cari Staff</label>
                <input type="text" class="form-control" id="search" name="search" 
                       value="{{ request('search') }}" placeholder="Nama atau email...">
            </div>
            <div class="col-md-3">
                <label for="sort" class="form-label fw-medium">Urutkan</label>
                <select class="form-select" id="sort" name="sort">
                    <option value="created_at" {{ request('sort') == 'created_at' ? 'selected' : '' }}>Terbaru</option>
                    <option value="name" {{ request('sort') == 'name' ? 'selected' : '' }}>Nama (A-Z)</option>
                    <option value="email" {{ request('sort') == 'email' ? 'selected' : '' }}>Email (A-Z)</option>
                </select>
            </div>
            <div class="col-md-3">
                <label for="direction" class="form-label fw-medium">Arah</label>
                <select class="form-select" id="direction" name="direction">
                    <option value="desc" {{ request('direction') == 'desc' ? 'selected' : '' }}>Descending</option>
                    <option value="asc" {{ request('direction') == 'asc' ? 'selected' : '' }}>Ascending</option>
                </select>
            </div>
            <div class="col-md-2 d-flex align-items-end">
                <div class="btn-group-spaced w-100">
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-search me-1"></i>Cari
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>

<!-- Staff Table -->
<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="mb-0 fw-bold">
            <i class="bi bi-people me-2"></i>Daftar Staff ({{ $staff->total() }})
        </h5>
        @if($staff->count() > 0)
        <div class="btn-group-spaced">
            <a href="{{ route('staff.create') }}" class="btn btn-success btn-sm">
                <i class="bi bi-person-plus me-1"></i>Tambah Baru
            </a>
        </div>
        @endif
    </div>
    <div class="card-body p-0">
        @if($staff->count() > 0)
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead>
                        <tr>
                            <th class="px-4 py-3">No</th>
                            <th class="px-4 py-3">Nama</th>
                            <th class="px-4 py-3">Email</th>
                            <th class="px-4 py-3">Role</th>
                            <th class="px-4 py-3">Status</th>
                            <th class="px-4 py-3">Bergabung</th>
                            <th class="px-4 py-3 text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($staff as $index => $user)
                        <tr>
                            <td class="px-4 py-3">{{ $staff->firstItem() + $index }}</td>
                            <td class="px-4 py-3">
                                <div class="d-flex align-items-center">
                                    <div class="avatar-sm me-3">
                                        <i class="bi bi-person-circle fs-3" style="color: var(--primary-color);"></i>
                                    </div>
                                    <div>
                                        <h6 class="mb-0 fw-semibold">{{ $user->name }}</h6>
                                        <small class="text-muted">ID: {{ $user->id }}</small>
                                    </div>
                                </div>
                            </td>
                            <td class="px-4 py-3">
                                <span style="color: var(--primary-color);">{{ $user->email }}</span>
                            </td>
                            <td class="px-4 py-3">
                                @if($user->role === 'admin')
                                    <span class="badge" style="background-color: var(--danger-color); color: white;">
                                        <i class="bi bi-shield-check me-1"></i>Administrator
                                    </span>
                                @else
                                    <span class="badge" style="background-color: var(--info-color); color: white;">
                                        <i class="bi bi-person me-1"></i>Staff
                                    </span>
                                @endif
                            </td>
                            <td class="px-4 py-3">
                                @if($user->email_verified_at)
                                    <span class="badge" style="background-color: var(--success-color); color: white;">
                                        <i class="bi bi-check-circle me-1"></i>Email Terverifikasi
                                    </span>
                                @else
                                    <span class="badge" style="background-color: var(--warning-color); color: white;">
                                        <i class="bi bi-envelope me-1"></i>Email Belum Diverifikasi
                                    </span>
                                @endif
                            </td>
                            <td class="px-4 py-3">
                                <small class="text-muted">
                                    {{ $user->created_at->format('d M Y, H:i') }}
                                </small>
                            </td>
                            <td class="px-4 py-3 text-center">
                                <div class="btn-group-spaced">
                                    <a href="{{ route('staff.show', $user) }}" 
                                       class="btn btn-outline-primary btn-sm" 
                                       title="Lihat Detail">
                                        <i class="bi bi-eye"></i>
                                    </a>
                                    <a href="{{ route('staff.edit', $user) }}" 
                                       class="btn btn-outline-warning btn-sm" 
                                       title="Edit">
                                        <i class="bi bi-pencil"></i>
                                    </a>
                                    @if($user->id !== auth()->id())
                                    <form action="{{ route('staff.destroy', $user) }}" 
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
                    <i class="bi bi-people text-muted" style="font-size: 3rem;"></i>
                </div>
                <h5 class="text-muted mb-2">Belum ada staff</h5>
                <p class="text-muted mb-4">Mulai dengan menambahkan staff pertama</p>
                <a href="{{ route('staff.create') }}" class="btn btn-primary">
                    <i class="bi bi-person-plus me-2"></i>Tambah Staff Pertama
                </a>
            </div>
        @endif
    </div>
</div>

<!-- Pagination -->
@if($staff->hasPages())
<div class="d-flex justify-content-center mt-4">
    {{ $staff->appends(request()->query())->links() }}
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
                text: 'Apakah Anda yakin ingin menghapus staff ini?',
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
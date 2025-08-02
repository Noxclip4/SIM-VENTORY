@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="mb-1">Profil Saya</h2>
            <p class="text-muted mb-0">Kelola informasi profil Anda</p>
        </div>
        <div class="btn-group-spaced">
            <a href="{{ route('profile.edit') }}" class="btn btn-primary">
                <i class="bi bi-pencil me-2"></i>Edit Profil
            </a>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-8">
            <!-- Profile Card -->
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0 fw-bold">
                        <i class="bi bi-person-circle me-2"></i>Informasi Profil
                    </h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-3 text-center mb-4">
                            <div class="bg-primary bg-opacity-10 rounded-circle d-flex align-items-center justify-content-center mx-auto mb-3" 
                                 style="width: 100px; height: 100px;">
                                <i class="bi bi-person text-primary" style="font-size: 3rem;"></i>
                            </div>
                            <h5 class="fw-bold">{{ $user->name }}</h5>
                            <span class="badge bg-{{ $user->role == 'admin' ? 'danger' : 'info' }}">
                                {{ ucfirst($user->role) }}
                            </span>
                        </div>
                        <div class="col-md-9">
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label fw-medium text-muted">Nama Lengkap</label>
                                    <p class="mb-0 fw-bold">{{ $user->name }}</p>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label fw-medium text-muted">Email</label>
                                    <p class="mb-0 fw-bold">{{ $user->email }}</p>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label fw-medium text-muted">Role</label>
                                    <p class="mb-0 fw-bold">{{ ucfirst($user->role) }}</p>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label fw-medium text-muted">Bergabung Sejak</label>
                                    <p class="mb-0 fw-bold">{{ $user->created_at->format('d M Y') }}</p>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label fw-medium text-muted">Terakhir Login</label>
                                    <p class="mb-0 fw-bold">{{ $user->updated_at->diffForHumans() }}</p>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label fw-medium text-muted">Status</label>
                                    <span class="badge bg-success">Aktif</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <!-- Quick Stats -->
            <div class="card mb-4">
                <div class="card-header">
                    <h6 class="mb-0 fw-bold">
                        <i class="bi bi-graph-up me-2"></i>Aktivitas
                    </h6>
                </div>
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <span class="text-muted">Total Login</span>
                        <span class="fw-bold">15 kali</span>
                    </div>
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <span class="text-muted">Terakhir Login</span>
                        <span class="fw-bold">2 jam yang lalu</span>
                    </div>
                    <div class="d-flex justify-content-between align-items-center">
                        <span class="text-muted">Status</span>
                        <span class="badge bg-success">Online</span>
                    </div>
                </div>
            </div>

            <!-- Security Info -->
            <div class="card">
                <div class="card-header">
                    <h6 class="mb-0 fw-bold">
                        <i class="bi bi-shield-check me-2"></i>Keamanan
                    </h6>
                </div>
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <span class="text-muted">Password</span>
                        <span class="badge bg-success">Aktif</span>
                    </div>
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <span class="text-muted">2FA</span>
                        <span class="badge bg-secondary">Tidak Aktif</span>
                    </div>
                    <div class="d-flex justify-content-between align-items-center">
                        <span class="text-muted">Session</span>
                        <span class="badge bg-info">Aktif</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 
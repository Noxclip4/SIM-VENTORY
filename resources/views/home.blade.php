@extends('layouts.guest')

@section('content')
<div class="auth-container">
    <div class="auth-card">
        <div class="auth-header">
            <h2 class="text-center mb-2">
                <i class="bi bi-box-seam me-2"></i>SIM-VENTORY
            </h2>
            <p class="text-center text-white mb-0">Sistem Manajemen Inventaris dan Penjualan yang dirancang khusus untuk UMKM. Kelola stok, catat transaksi, dan pantau performa bisnis Anda dengan mudah.</p>
        </div>
        
        <div class="auth-body">
            <div class="text-center mb-4">
                <i class="bi bi-graph-up display-1" style="color: var(--primary-color);"></i>
            </div>
            
            <div class="d-grid gap-3">
                <a href="{{ route('login') }}" class="btn btn-primary btn-lg">
                    <i class="bi bi-box-arrow-in-right me-2"></i>Masuk
                </a>
            </div>
            
            <div class="text-center mt-4">
                <p class="text-muted mb-0">
                    <i class="bi bi-shield-check me-1"></i>
                    Akses terbatas untuk pengguna yang berwenang
                </p>
            </div>
        </div>
    </div>
</div>
@endsection

@extends('layouts.app')

@section('content')
<!-- Header -->
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h2 class="mb-1">Detail Staff</h2>
        <p class="text-muted mb-0">Informasi lengkap staff</p>
    </div>
    <div class="btn-group-spaced">
        <a href="{{ route('staff.index') }}" class="btn btn-outline-secondary">
            <i class="bi bi-arrow-left me-2"></i>Kembali
        </a>
        <a href="{{ route('staff.edit', $staff) }}" class="btn btn-warning">
            <i class="bi bi-pencil me-2"></i>Edit
        </a>
    </div>
</div>

<!-- Staff Information -->
<div class="row">
    <div class="col-lg-8">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0 fw-bold">
                    <i class="bi bi-person-circle me-2"></i>Informasi Staff
                </h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6 mb-4">
                        <label class="form-label fw-medium">Nama Lengkap</label>
                        <h5 class="mb-0" style="color: var(--primary-color);">{{ $staff->name }}</h5>
                    </div>
                    <div class="col-md-6 mb-4">
                        <label class="form-label fw-medium">Email</label>
                        <p class="mb-0 text-muted">{{ $staff->email }}</p>
                    </div>
                </div>
                
                <div class="row">
                    <div class="col-md-6 mb-4">
                        <label class="form-label fw-medium">Role</label>
                        <div>
                            @if($staff->role === 'admin')
                                <span class="badge" style="background-color: var(--danger-color); color: white; font-size: 0.9rem;">
                                    <i class="bi bi-shield-check me-1"></i>Administrator
                                </span>
                            @else
                                <span class="badge" style="background-color: var(--info-color); color: white; font-size: 0.9rem;">
                                    <i class="bi bi-person me-1"></i>Staff
                                </span>
                            @endif
                        </div>
                    </div>
                    <div class="col-md-6 mb-4">
                        <label class="form-label fw-medium">Status</label>
                        <div>
                            @if($staff->email_verified_at)
                                <span class="badge" style="background-color: var(--success-color); color: white; font-size: 0.9rem;">
                                    <i class="bi bi-check-circle me-1"></i>Email Terverifikasi
                                </span>
                            @else
                                <span class="badge" style="background-color: var(--warning-color); color: white; font-size: 0.9rem;">
                                    <i class="bi bi-envelope me-1"></i>Email Belum Diverifikasi
                                </span>
                            @endif
                        </div>
                    </div>
                </div>
                
                <div class="row">
                    <div class="col-md-6 mb-4">
                        <label class="form-label fw-medium">Bergabung Sejak</label>
                        <p class="mb-0 text-muted">{{ $staff->created_at->format('d M Y, H:i') }}</p>
                    </div>
                    <div class="col-md-6 mb-4">
                        <label class="form-label fw-medium">Terakhir Diperbarui</label>
                        <p class="mb-0 text-muted">{{ $staff->updated_at->format('d M Y, H:i') }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-lg-4">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0 fw-bold">
                    <i class="bi bi-graph-up me-2"></i>Statistik
                </h5>
            </div>
            <div class="card-body">
                <div class="row text-center">
                    <div class="col-6 mb-3">
                        <div class="border rounded p-3" style="background-color: var(--gray-50);">
                            <i class="bi bi-cart display-6" style="color: var(--primary-color);"></i>
                            <h4 class="mb-1 fw-bold">{{ $staff->transactions()->count() }}</h4>
                            <small class="text-muted">Total Transaksi</small>
                        </div>
                    </div>
                    <div class="col-6 mb-3">
                        <div class="border rounded p-3" style="background-color: var(--gray-50);">
                            <i class="bi bi-currency-dollar display-6" style="color: var(--success-color);"></i>
                            <h4 class="mb-1 fw-bold">Rp {{ number_format($staff->transactions()->where('status', 'completed')->sum('total_amount')) }}</h4>
                            <small class="text-muted">Total Revenue</small>
                        </div>
                    </div>
                </div>
                
                <div class="row text-center">
                    <div class="col-6 mb-3">
                        <div class="border rounded p-3" style="background-color: var(--gray-50);">
                            <i class="bi bi-check-circle display-6" style="color: var(--success-color);"></i>
                            <h4 class="mb-1 fw-bold">{{ $staff->transactions()->where('status', 'completed')->count() }}</h4>
                            <small class="text-muted">Transaksi Selesai</small>
                        </div>
                    </div>
                    <div class="col-6 mb-3">
                        <div class="border rounded p-3" style="background-color: var(--gray-50);">
                            <i class="bi bi-clock display-6" style="color: var(--warning-color);"></i>
                            <h4 class="mb-1 fw-bold">{{ $staff->transactions()->where('status', 'pending')->count() }}</h4>
                            <small class="text-muted">Transaksi Pending</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Recent Transactions -->
<div class="row mt-4">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0 fw-bold">
                    <i class="bi bi-clock-history me-2"></i>Transaksi Terbaru
                </h5>
            </div>
            <div class="card-body">
                @if($staff->transactions()->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th class="px-4 py-3">Invoice</th>
                                    <th class="px-4 py-3">Customer</th>
                                    <th class="px-4 py-3">Total</th>
                                    <th class="px-4 py-3">Status</th>
                                    <th class="px-4 py-3">Tanggal</th>
                                    <th class="px-4 py-3">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($staff->transactions()->latest()->limit(10)->get() as $transaction)
                                <tr>
                                    <td class="px-4 py-3">
                                        <a href="{{ route('transactions.show', $transaction) }}" 
                                           class="text-decoration-none fw-medium"
                                           style="color: var(--primary-color);">
                                            {{ $transaction->invoice_number }}
                                        </a>
                                    </td>
                                    <td class="px-4 py-3">
                                        <div>
                                            <div class="fw-medium">{{ $transaction->customer_name ?? $transaction->user->name }}</div>
                                            <small class="text-muted">{{ $transaction->customer_phone ?? '-' }}</small>
                                        </div>
                                    </td>
                                    <td class="px-4 py-3">
                                        <span class="fw-bold" style="color: var(--success-color);">
                                            Rp {{ number_format($transaction->total_amount) }}
                                        </span>
                                    </td>
                                    <td class="px-4 py-3">
                                        @if($transaction->status == 'completed')
                                            <span class="badge" style="background-color: var(--success-color); color: white;">
                                                <i class="bi bi-check-circle me-1"></i>Selesai
                                            </span>
                                        @elseif($transaction->status == 'pending')
                                            <span class="badge" style="background-color: var(--warning-color); color: white;">
                                                <i class="bi bi-clock me-1"></i>Pending
                                            </span>
                                        @else
                                            <span class="badge" style="background-color: var(--danger-color); color: white;">
                                                <i class="bi bi-x-circle me-1"></i>Dibatalkan
                                            </span>
                                        @endif
                                    </td>
                                    <td class="px-4 py-3">
                                        <small class="text-muted">
                                            {{ $transaction->created_at->format('d/m/Y H:i') }}
                                        </small>
                                    </td>
                                    <td class="px-4 py-3">
                                        <a href="{{ route('transactions.show', $transaction) }}" 
                                           class="btn btn-sm"
                                           style="background-color: var(--info-color); color: white;">
                                            <i class="bi bi-eye"></i>
                                        </a>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="text-center py-4">
                        <i class="bi bi-cart display-4 text-muted"></i>
                        <h6 class="mt-3 text-muted">Belum Ada Transaksi</h6>
                        <p class="text-muted mb-0">Staff ini belum membuat transaksi apapun</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

<style>
.border.rounded {
    transition: all 0.3s ease;
}

.border.rounded:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
}
</style>
@endsection 
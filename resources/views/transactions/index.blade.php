@extends('layouts.app')

@section('content')
<!-- Header -->
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h2 class="mb-1">Daftar Transaksi</h2>
        <p class="text-muted mb-0">Kelola semua transaksi penjualan</p>
    </div>
    <div class="btn-group-spaced">
        @if(auth()->user()->role === 'admin' || auth()->user()->role === 'staff')
        <a href="{{ route('transactions.create') }}" class="btn btn-primary">
            <i class="bi bi-plus-circle me-2"></i>Buat Transaksi
        </a>
        @endif
        <a href="{{ route('transactions.excel') }}" class="btn btn-success">
            <i class="bi bi-file-excel me-2"></i>Export Excel
        </a>
    </div>
</div>

<!-- Search and Filter -->
<div class="card mb-4">
    <div class="card-body">
        <form method="GET" action="{{ route('transactions.index') }}" class="row g-3">
            <div class="col-md-3">
                <label for="search" class="form-label fw-medium">Cari Invoice</label>
                <input type="text" name="search" class="form-control" id="search"
                       placeholder="Masukkan nomor invoice..." value="{{ request('search') }}">
            </div>
            <div class="col-md-2">
                <label for="status" class="form-label fw-medium">Status</label>
                <select name="status" class="form-select" id="status">
                    <option value="">Semua Status</option>
                    <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                    <option value="completed" {{ request('status') == 'completed' ? 'selected' : '' }}>Completed</option>
                    <option value="cancelled" {{ request('status') == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                </select>
            </div>
            <div class="col-md-2">
                <label for="date_from" class="form-label fw-medium">Dari Tanggal</label>
                <input type="date" name="date_from" class="form-control" id="date_from" 
                       value="{{ request('date_from') }}">
            </div>
            <div class="col-md-2">
                <label for="date_to" class="form-label fw-medium">Sampai Tanggal</label>
                <input type="date" name="date_to" class="form-control" id="date_to" 
                       value="{{ request('date_to') }}">
            </div>
            <div class="col-md-3 d-flex align-items-end">
                <div class="btn-group-spaced w-100">
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-search me-1"></i>Filter
                    </button>
                    <a href="{{ route('transactions.index') }}" class="btn btn-outline-secondary">
                        <i class="bi bi-arrow-clockwise me-1"></i>Reset
                    </a>
                </div>
            </div>
        </form>
    </div>
</div>

<!-- Transactions Table -->
<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="mb-0 fw-bold">
            <i class="bi bi-cart me-2"></i>Transaksi ({{ $transactions->total() }})
        </h5>
        @if($transactions->count() > 0 && (auth()->user()->role === 'admin' || auth()->user()->role === 'staff'))
        <div class="btn-group-spaced">
            <a href="{{ route('transactions.create') }}" class="btn btn-success btn-sm">
                <i class="bi bi-plus-circle me-1"></i>Buat Baru
            </a>
        </div>
        @endif
    </div>
    <div class="card-body p-0">
        @if($transactions->count() > 0)
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead>
                        <tr>
                            <th class="px-4 py-3">Invoice</th>
                            <th class="px-4 py-3">Tanggal</th>
                            <th class="px-4 py-3">Customer</th>
                            <th class="px-4 py-3">Total</th>
                            <th class="px-4 py-3">Status</th>
                            <th class="px-4 py-3">Payment</th>
                            <th class="px-4 py-3 text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($transactions as $transaction)
                        <tr>
                            <td class="px-4 py-3">
                                <strong>{{ $transaction->invoice_number }}</strong>
                            </td>
                            <td class="px-4 py-3">
                                {{ $transaction->created_at->format('d/m/Y H:i') }}
                            </td>
                            <td class="px-4 py-3">
                                <div class="fw-medium">{{ $transaction->customer_name ?? $transaction->user->name }}</div>
                            </td>
                            <td class="px-4 py-3">
                                <span class="fw-bold text-primary">
                                    Rp {{ number_format($transaction->total_amount, 0, ',', '.') }}
                                </span>
                            </td>
                            <td class="px-4 py-3">
                                @if($transaction->status == 'pending' && auth()->user()->role === 'admin')
                                    <form action="{{ route('transactions.update', $transaction) }}" method="POST" class="d-inline confirm-payment-form">
                                        @csrf
                                        @method('PUT')
                                        <input type="hidden" name="status" value="completed">
                                        <button type="submit" class="btn btn-sm btn-success">
                                            <i class="bi bi-check-circle"></i> Konfirmasi
                                        </button>
                                    </form>
                                @else
                                    @if($transaction->status == 'completed')
                                        <span class="badge" style="background-color: var(--success-color); color: white; font-weight: 600;">
                                            <i class="bi bi-check-circle me-1"></i>Selesai
                                        </span>
                                    @elseif($transaction->status == 'pending')
                                        <span class="badge" style="background-color: var(--warning-color); color: white; font-weight: 600;">
                                            <i class="bi bi-clock me-1"></i>Pending
                                        </span>
                                    @else
                                        <span class="badge" style="background-color: var(--danger-color); color: white; font-weight: 600;">
                                            <i class="bi bi-x-circle me-1"></i>Dibatalkan
                                        </span>
                                    @endif
                                @endif
                            </td>
                            <td class="px-4 py-3">
                                <span class="badge" style="background-color: var(--info-color); color: white; font-weight: 600;">
                                    {{ $transaction->payment_method }}
                                </span>
                            </td>
                            <td class="px-4 py-3 text-center">
                                <div class="btn-group-spaced">
                                    <a href="{{ route('transactions.show', $transaction) }}" 
                                       class="btn btn-outline-primary btn-sm" 
                                       title="Lihat Detail">
                                        <i class="bi bi-eye"></i>
                                    </a>
                                    <a href="{{ route('transactions.pdf', $transaction) }}" 
                                       class="btn btn-outline-danger btn-sm" 
                                       target="_blank" 
                                       title="Export PDF">
                                        <i class="bi bi-file-pdf"></i>
                                    </a>
                                    @if(auth()->user()->role === 'admin' || auth()->user()->role === 'staff')
                                    <a href="{{ route('transactions.edit', $transaction) }}" 
                                       class="btn btn-outline-warning btn-sm" 
                                       title="Edit">
                                        <i class="bi bi-pencil"></i>
                                    </a>
                                    @endif
                                    @if(auth()->user()->role === 'admin')
                                    <form action="{{ route('transactions.destroy', $transaction) }}" 
                                          method="POST" 
                                          class="d-inline delete-transaction-form">
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
                    <i class="bi bi-cart text-muted" style="font-size: 3rem;"></i>
                </div>
                <h5 class="text-muted mb-2">Belum ada transaksi</h5>
                <p class="text-muted mb-4">Mulai dengan membuat transaksi pertama</p>
                <a href="{{ route('transactions.create') }}" class="btn btn-primary">
                    <i class="bi bi-plus-circle me-2"></i>Buat Transaksi Pertama
                </a>
            </div>
        @endif
    </div>
</div>

<!-- Pagination -->
@if($transactions->hasPages())
<div class="d-flex justify-content-center mt-4">
    {{ $transactions->appends(request()->query())->links() }}
</div>
@endif

<script>
// SweetAlert2 for payment confirmation
document.addEventListener('DOMContentLoaded', function() {
    const confirmPaymentForms = document.querySelectorAll('.confirm-payment-form');
    
    confirmPaymentForms.forEach(form => {
        form.addEventListener('submit', function(e) {
            e.preventDefault();
            
            Swal.fire({
                title: 'Konfirmasi Pembayaran',
                text: 'Konfirmasi pembayaran untuk transaksi ini?',
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#10b981',
                cancelButtonColor: '#6b7280',
                confirmButtonText: 'Ya, Konfirmasi!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    form.submit();
                }
            });
        });
    });
    
    // SweetAlert2 for delete confirmation
    const deleteForms = document.querySelectorAll('.delete-transaction-form');
    
    deleteForms.forEach(form => {
        form.addEventListener('submit', function(e) {
            e.preventDefault();
            
            Swal.fire({
                title: 'Konfirmasi Hapus',
                text: 'Apakah Anda yakin ingin menghapus transaksi ini?',
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
@extends('layouts.app')

@section('content')
<!-- Header -->
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h2 class="mb-1">Detail Transaksi</h2>
        <p class="text-muted mb-0">Informasi lengkap transaksi</p>
    </div>
    <div class="btn-group-spaced">
        <a href="{{ route('transactions.pdf', $transaction) }}" class="btn btn-outline-danger" target="_blank">
            <i class="bi bi-file-pdf me-2"></i>Export PDF
        </a>
        <a href="{{ route('transactions.index') }}" class="btn btn-outline-secondary">
            <i class="bi bi-arrow-left me-2"></i>Kembali
        </a>
    </div>
</div>

<div class="card">
    <div class="card-header">
        <h5 class="mb-0 fw-bold">
            <i class="bi bi-receipt me-2"></i>Informasi Transaksi
        </h5>
    </div>
    <div class="card-body">
        <div class="row mb-4">
            <div class="col-md-6">
                <div class="mb-4">
                    <label class="form-label fw-medium">Invoice Number</label>
                    <h5 class="mb-0" style="color: var(--primary-color);">{{ $transaction->invoice_number }}</h5>
                </div>
                
                <div class="mb-4">
                    <label class="form-label fw-medium">Tanggal Transaksi</label>
                    <p class="mb-0 text-muted">{{ $transaction->created_at->format('d M Y, H:i') }}</p>
                </div>
                
                <div class="mb-4">
                    <label class="form-label fw-medium">Status</label>
                    <div>
                        @if($transaction->status == 'completed')
                            <span class="badge" style="background-color: var(--success-color); color: white; font-size: 0.9rem;">
                                <i class="bi bi-check-circle me-1"></i>Selesai
                            </span>
                        @elseif($transaction->status == 'pending')
                            <span class="badge" style="background-color: var(--warning-color); color: white; font-size: 0.9rem;">
                                <i class="bi bi-clock me-1"></i>Pending
                            </span>
                        @else
                            <span class="badge" style="background-color: var(--danger-color); color: white; font-size: 0.9rem;">
                                <i class="bi bi-x-circle me-1"></i>Dibatalkan
                            </span>
                        @endif
                    </div>
                </div>
                
                <div class="mb-4">
                    <label class="form-label fw-medium">Metode Pembayaran</label>
                    <p class="mb-0">{{ $transaction->payment_method }}</p>
                </div>
                
                <div class="mb-4">
                    <label class="form-label fw-medium">Total Amount</label>
                    <h4 class="mb-0 fw-bold" style="color: var(--success-color);">
                        Rp {{ number_format($transaction->total_amount, 0, ',', '.') }}
                    </h4>
                </div>
            </div>
            
            <div class="col-md-6">
                <div class="mb-4">
                    <label class="form-label fw-medium">Nama Customer</label>
                    <p class="mb-0">{{ $transaction->customer_name ?? $transaction->user->name }}</p>
                </div>
                
                <div class="mb-4">
                    <label class="form-label fw-medium">Telepon</label>
                    <p class="mb-0 text-muted">{{ $transaction->customer_phone ?? '-' }}</p>
                </div>
                
                <div class="mb-4">
                    <label class="form-label fw-medium">Email</label>
                    <p class="mb-0 text-muted">{{ $transaction->customer_email ?? '-' }}</p>
                </div>
            </div>
        </div>

        @if($transaction->notes)
        <hr class="my-4">
        <div class="mb-4">
            <label class="form-label fw-medium">Catatan</label>
            <p class="mb-0 text-muted">{{ $transaction->notes }}</p>
        </div>
        @endif

        <hr class="my-4">
        
        <div class="mb-4">
            <h5 class="fw-bold">
                <i class="bi bi-box me-2"></i>Detail Produk
            </h5>
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th class="px-4 py-3">No</th>
                            <th class="px-4 py-3">Produk</th>
                            <th class="px-4 py-3">Harga</th>
                            <th class="px-4 py-3">Jumlah</th>
                            <th class="px-4 py-3">Subtotal</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($transaction->details as $index => $detail)
                        <tr>
                            <td class="px-4 py-3">{{ $index + 1 }}</td>
                            <td class="px-4 py-3">
                                <div class="fw-medium">{{ $detail->product->name }}</div>
                            </td>
                            <td class="px-4 py-3">
                                <span class="fw-medium">
                                    Rp {{ number_format($detail->price_at_transaction, 0, ',', '.') }}
                                </span>
                            </td>
                            <td class="px-4 py-3">
                                <span class="badge" style="background-color: var(--info-color); color: white;">
                                    {{ $detail->quantity }}
                                </span>
                            </td>
                            <td class="px-4 py-3">
                                <span class="fw-bold" style="color: var(--success-color);">
                                    Rp {{ number_format($detail->subtotal, 0, ',', '.') }}
                                </span>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr style="background-color: var(--gray-50);">
                            <td colspan="4" class="text-end px-4 py-3">
                                <strong>Total:</strong>
                            </td>
                            <td class="px-4 py-3">
                                <strong style="color: var(--success-color); font-size: 1.1rem;">
                                    Rp {{ number_format($transaction->total_amount, 0, ',', '.') }}
                                </strong>
                            </td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>

        <hr class="my-4">
        
        <div class="d-flex justify-content-between align-items-center">
            <div>
                <a href="{{ route('transactions.index') }}" class="btn btn-outline-secondary">
                    <i class="bi bi-arrow-left me-2"></i>Kembali
                </a>
            </div>
            <div class="btn-group-spaced">
                <a href="{{ route('transactions.edit', $transaction) }}" class="btn btn-warning">
                    <i class="bi bi-pencil me-2"></i>Edit Status
                </a>
            </div>
        </div>
    </div>
</div>
@endsection 
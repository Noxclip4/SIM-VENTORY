@extends('layouts.app')

@section('content')
<style>
    .form-section {
        background: #fff;
        border-radius: 8px;
        box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        transition: all 0.3s ease;
    }
    
    .form-section:hover {
        box-shadow: 0 4px 8px rgba(0,0,0,0.15);
    }
    
    .form-label {
        font-weight: 600;
        color: #374151;
        margin-bottom: 0.5rem;
    }
    
    .form-control, .form-select {
        border: 1px solid #d1d5db;
        border-radius: 6px;
        transition: all 0.2s ease;
    }
    
    .form-control:focus, .form-select:focus {
        border-color: #3b82f6;
        box-shadow: 0 0 0 0.2rem rgba(59, 130, 246, 0.25);
    }
    
    .product-row {
        background: #f9fafb;
        border-radius: 8px;
        padding: 1rem;
        margin-bottom: 1rem;
        border: 1px solid #e5e7eb;
    }
    
    .summary-card {
        background: #ffffff;
        color: #374151;
        border-radius: 12px;
        box-shadow: 0 8px 32px rgba(0, 0, 0, 0.1);
        border: 2px solid #e5e7eb;
    }
    
    .summary-card .card-header {
        background: #f8fafc;
        border-bottom: 1px solid #e5e7eb;
        color: #374151;
    }
    
    .btn-primary {
        background: #1e40af;
        border: none;
        border-radius: 8px;
        font-weight: 600;
        transition: all 0.3s ease;
    }
    
    .btn-primary:hover {
        background: #1e3a8a;
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(30, 64, 175, 0.4);
    }
    
    .btn-success {
        background: #10b981;
        border: none;
        border-radius: 6px;
        font-weight: 600;
    }
    
    .btn-success:hover {
        background: #059669;
    }
    
    .btn-outline-danger {
        border-radius: 6px;
        font-weight: 600;
    }
    
    .badge {
        font-size: 0.875rem;
        padding: 0.5rem 0.75rem;
        border-radius: 6px;
    }
    
    @media (max-width: 768px) {
        .sticky-top {
            position: relative !important;
            top: 0 !important;
        }
        
        .product-row .col-md-2,
        .product-row .col-md-3,
        .product-row .col-md-5 {
            margin-bottom: 1rem;
        }
    }
</style>

<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-lg-12">
            <div class="card shadow">
                <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">
                        <i class="bi bi-cart-plus me-2"></i>Buat Transaksi Baru
                    </h5>
                    <a href="{{ route('transactions.index') }}" class="btn btn-outline-light btn-sm">
                        <i class="bi bi-arrow-left me-1"></i>Kembali
                    </a>
                </div>

                <div class="card-body p-4">
                    <form method="POST" action="{{ route('transactions.store') }}" id="transactionForm">
                        @csrf
                        
                        <div class="row g-4">
                            <!-- Kolom Kiri - Form Utama -->
                            <div class="col-lg-8">
                                <!-- Informasi Customer -->
                                <div class="form-section">
                                    <div class="card-header bg-light border-0">
                                        <h6 class="mb-0 fw-bold text-primary">
                                            <i class="bi bi-person-circle me-2"></i>Informasi Customer
                                        </h6>
                                    </div>
                                    <div class="card-body">
                                        <div class="row g-3">
                                            <div class="col-md-4">
                                                <label for="customer_name" class="form-label">
                                                    Nama Customer <span class="text-danger">*</span>
                                                </label>
                                                <input type="text" name="customer_name" id="customer_name" 
                                                       class="form-control @error('customer_name') is-invalid @enderror" 
                                                       value="{{ old('customer_name') }}" 
                                                       placeholder="Masukkan nama customer" required>
                                                @error('customer_name')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                            <div class="col-md-4">
                                                <label for="customer_phone" class="form-label">No. Telepon</label>
                                                <input type="text" name="customer_phone" id="customer_phone" 
                                                       class="form-control @error('customer_phone') is-invalid @enderror" 
                                                       value="{{ old('customer_phone') }}" 
                                                       placeholder="08123456789">
                                                @error('customer_phone')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                            <div class="col-md-4">
                                                <label for="customer_email" class="form-label">Email</label>
                                                <input type="email" name="customer_email" id="customer_email" 
                                                       class="form-control @error('customer_email') is-invalid @enderror" 
                                                       value="{{ old('customer_email') }}" 
                                                       placeholder="customer@example.com">
                                                @error('customer_email')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Informasi Pembayaran -->
                                <div class="form-section mt-4">
                                    <div class="card-header bg-light border-0">
                                        <h6 class="mb-0 fw-bold text-primary">
                                            <i class="bi bi-credit-card me-2"></i>Informasi Pembayaran
                                        </h6>
                                    </div>
                                    <div class="card-body">
                                        <div class="row g-3">
                                            <div class="col-md-6">
                                                <label for="payment_method" class="form-label">
                                                    Metode Pembayaran <span class="text-danger">*</span>
                                                </label>
                                                <select name="payment_method" id="payment_method" 
                                                        class="form-select @error('payment_method') is-invalid @enderror" required>
                                                    <option value="">Pilih metode pembayaran</option>
                                                    <option value="cash" {{ old('payment_method') == 'cash' ? 'selected' : '' }}>💵 Cash</option>
                                                    <option value="transfer" {{ old('payment_method') == 'transfer' ? 'selected' : '' }}>🏦 Transfer Bank</option>
                                                    <option value="card" {{ old('payment_method') == 'card' ? 'selected' : '' }}>💳 Kartu Debit/Credit</option>
                                                    <option value="ewallet" {{ old('payment_method') == 'ewallet' ? 'selected' : '' }}>📱 E-Wallet</option>
                                                </select>
                                                @error('payment_method')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                            <div class="col-md-6">
                                                <label for="notes" class="form-label">Catatan (Opsional)</label>
                                                <textarea name="notes" id="notes" 
                                                          class="form-control @error('notes') is-invalid @enderror" 
                                                          rows="3" placeholder="Catatan tambahan...">{{ old('notes') }}</textarea>
                                                @error('notes')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Pilih Produk -->
                                <div class="form-section mt-4">
                                    <div class="card-header bg-light border-0 d-flex justify-content-between align-items-center">
                                        <h6 class="mb-0 fw-bold text-primary">
                                            <i class="bi bi-box me-2"></i>Pilih Produk
                                        </h6>
                                        <button type="button" class="btn btn-success btn-sm" id="add-product">
                                            <i class="bi bi-plus-circle me-1"></i>Tambah Produk
                                        </button>
                                    </div>
                                    <div class="card-body">
                                        <div id="products-container">
                                            <div class="product-row">
                                                <div class="row g-3">
                                                    <div class="col-md-5">
                                                        <label class="form-label">
                                                            Produk <span class="text-danger">*</span>
                                                        </label>
                                                        <select name="product_id[]" class="form-select product-select" required>
                                                            <option value="">Pilih produk</option>
                                                            @foreach($products as $product)
                                                                <option value="{{ $product->id }}" 
                                                                        data-price="{{ $product->price }}" 
                                                                        data-stock="{{ $product->stock_quantity }}">
                                                                    {{ $product->name }} - Stok: {{ $product->stock_quantity }}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    <div class="col-md-2">
                                                        <label class="form-label">
                                                            Jumlah <span class="text-danger">*</span>
                                                        </label>
                                                        <input type="number" name="quantity[]" 
                                                               class="form-control quantity-input" 
                                                               placeholder="Qty" min="1" required>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <label class="form-label">Subtotal</label>
                                                        <input type="text" class="form-control subtotal-display" 
                                                               placeholder="Rp 0" readonly>
                                                    </div>
                                                    <div class="col-md-2">
                                                        <label class="form-label">&nbsp;</label>
                                                        <button type="button" class="btn btn-outline-danger btn-remove-product w-100">
                                                            <i class="bi bi-trash"></i> Hapus
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Kolom Kanan - Ringkasan -->
                            <div class="col-lg-4">
                                <div class="summary-card sticky-top" style="top: 20px;">
                                    <div class="card-header">
                                        <h6 class="mb-0 fw-bold">
                                            <i class="bi bi-calculator me-2"></i>Ringkasan Transaksi
                                        </h6>
                                    </div>
                                    <div class="card-body">
                                        <div class="mb-4">
                                            <div class="d-flex justify-content-between align-items-center mb-3">
                                                <span class="fw-bold">Total Produk:</span>
                                                <span class="badge bg-primary text-white fs-6" id="total-items">0 item</span>
                                            </div>
                                            <div class="d-flex justify-content-between align-items-center">
                                                <span class="fw-bold fs-5">Total Transaksi:</span>
                                                <span class="fw-bold fs-4 text-primary" id="total-amount">Rp 0</span>
                                            </div>
                                        </div>
                                        
                                        <hr>
                                        
                                        <div class="d-grid gap-2">
                                            <button type="submit" class="btn btn-primary btn-lg fw-bold">
                                                <i class="bi bi-check-circle me-2"></i>Buat Transaksi
                                            </button>
                                            <a href="{{ route('transactions.index') }}" class="btn btn-outline-secondary">
                                                <i class="bi bi-x-circle me-2"></i>Batal
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script src="{{ asset('js/transaction-create.js') }}"></script>
@endpush
@endsection 
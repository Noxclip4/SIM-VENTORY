@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="mb-1">Edit Staff</h2>
            <p class="text-muted mb-0">Edit informasi staff atau admin</p>
        </div>
        <div class="btn-group-spaced">
            <a href="{{ route('staff.index') }}" class="btn btn-secondary">
                <i class="bi bi-arrow-left me-2"></i>Kembali
            </a>
        </div>
    </div>

    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0 fw-bold">
                        <i class="bi bi-person-gear me-2"></i>Form Edit Staff
                    </h5>
                </div>
                <div class="card-body">
                    @if($errors->any())
                        <div class="alert alert-danger">
                            <h6 class="fw-bold">Terjadi kesalahan:</h6>
                            <ul class="mb-0">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('staff.update', $staff) }}" method="POST">
                        @csrf
                        @method('PUT')
                        
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="name" class="form-label fw-medium">
                                    <i class="bi bi-person me-1"></i>Nama Lengkap
                                </label>
                                <input type="text" class="form-control @error('name') is-invalid @enderror" 
                                       id="name" name="name" value="{{ old('name', $staff->name) }}" 
                                       placeholder="Masukkan nama lengkap" required>
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="email" class="form-label fw-medium">
                                    <i class="bi bi-envelope me-1"></i>Email
                                </label>
                                <input type="email" class="form-control @error('email') is-invalid @enderror" 
                                       id="email" name="email" value="{{ old('email', $staff->email) }}" 
                                       placeholder="contoh@email.com" required>
                                @error('email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="password" class="form-label fw-medium">
                                    <i class="bi bi-lock me-1"></i>Password Baru (Opsional)
                                </label>
                                <input type="password" class="form-control @error('password') is-invalid @enderror" 
                                       id="password" name="password" placeholder="Kosongkan jika tidak ingin mengubah">
                                @error('password')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <small class="text-muted">Kosongkan jika tidak ingin mengubah password</small>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="password_confirmation" class="form-label fw-medium">
                                    <i class="bi bi-lock-fill me-1"></i>Konfirmasi Password Baru
                                </label>
                                <input type="password" class="form-control" 
                                       id="password_confirmation" name="password_confirmation" 
                                       placeholder="Ulangi password baru">
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="role" class="form-label fw-medium">
                                    <i class="bi bi-shield me-1"></i>Role
                                </label>
                                <select class="form-select @error('role') is-invalid @enderror" 
                                        id="role" name="role" required>
                                    <option value="">Pilih Role</option>
                                    <option value="staff" {{ old('role', $staff->role) == 'staff' ? 'selected' : '' }}>
                                        <i class="bi bi-person me-1"></i>Staff
                                    </option>
                                    @if(auth()->user()->role === 'admin')
                                    <option value="admin" {{ old('role', $staff->role) == 'admin' ? 'selected' : '' }}>
                                        <i class="bi bi-shield-check me-1"></i>Administrator
                                    </option>
                                    @endif
                                </select>
                                @error('role')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <small class="text-muted">
                                    @if(auth()->user()->role === 'admin')
                                        Staff: Akses terbatas, Admin: Akses penuh
                                    @else
                                        Staff: Akses terbatas untuk transaksi dan view produk
                                    @endif
                                </small>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-medium">
                                    <i class="bi bi-calendar me-1"></i>Bergabung Sejak
                                </label>
                                <div class="form-control-plaintext">
                                    {{ $staff->created_at->format('d F Y H:i') }}
                                </div>
                            </div>
                        </div>

                        <hr class="my-4">

                        <div class="d-flex justify-content-end">
                            <button type="submit" class="btn btn-primary">
                                <i class="bi bi-check-circle me-2"></i>Update Staff
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.form-control-plaintext {
    padding: 0.375rem 0;
    margin-bottom: 0;
    color: #212529;
    background-color: transparent;
    border: solid transparent;
    border-width: 1px 0;
}
</style>

<script>
// Password validation (only if password is entered)
document.getElementById('password').addEventListener('input', function() {
    const password = this.value;
    const confirmPassword = document.getElementById('password_confirmation').value;
    
    this.classList.remove('is-valid', 'is-invalid');
    
    if (password.length === 0) {
        // Password is optional, so no validation needed
        return;
    }
    
    if (password.length >= 8) {
        this.classList.add('is-valid');
    } else {
        this.classList.add('is-invalid');
    }
    
    // Update confirmation validation
    if (confirmPassword.length > 0) {
        validatePasswordConfirmation();
    }
});

// Confirm password validation
document.getElementById('password_confirmation').addEventListener('input', function() {
    validatePasswordConfirmation();
});

function validatePasswordConfirmation() {
    const password = document.getElementById('password').value;
    const confirmPassword = document.getElementById('password_confirmation').value;
    
    document.getElementById('password_confirmation').classList.remove('is-valid', 'is-invalid');
    
    if (password.length === 0) {
        // Password is optional, so no validation needed
        return;
    }
    
    if (confirmPassword === password && password.length > 0) {
        document.getElementById('password_confirmation').classList.add('is-valid');
    } else if (confirmPassword.length > 0) {
        document.getElementById('password_confirmation').classList.add('is-invalid');
    }
}
</script>
@endsection 
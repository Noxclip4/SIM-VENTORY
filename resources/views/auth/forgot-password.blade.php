@extends('layouts.guest')

@section('content')
<div class="auth-container">
    <div class="auth-card">
        <div class="auth-header">
            <h2 class="text-center mb-2">
                <i class="bi bi-key me-2"></i>Lupa Password
            </h2>
            <p class="text-center text-white mb-0">Masukkan email Anda untuk reset password</p>
        </div>
        
        <div class="auth-body">
            <div class="mb-4 text-muted">
                Lupa password Anda? Tidak masalah. Masukkan alamat email Anda dan kami akan mengirimkan link reset password yang memungkinkan Anda memilih password baru.
            </div>

            @if(session('status'))
                <div class="alert alert-success">
                    <h6 class="fw-bold">Berhasil!</h6>
                    <p class="mb-0">{{ session('status') }}</p>
                </div>
            @endif

            @if($errors->any())
                <div class="alert alert-danger">
                    <h6 class="fw-bold">Error!</h6>
                    <ul class="mb-0">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST" action="{{ route('password.email') }}">
                @csrf

                <div class="mb-4">
                    <label for="email" class="form-label fw-medium">
                        <i class="bi bi-envelope me-1"></i>Email Address
                    </label>
                    <input type="email" class="form-control @error('email') is-invalid @enderror" 
                           id="email" name="email" value="{{ old('email') }}" 
                           placeholder="Masukkan email Anda" required autofocus>
                    @error('email')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="d-grid mb-4">
                    <button type="submit" class="btn btn-primary btn-lg">
                        <i class="bi bi-envelope me-2"></i>Kirim Link Reset Password
                    </button>
                </div>

                <div class="text-center">
                    <a href="{{ route('login') }}" class="text-decoration-none">
                        <i class="bi bi-arrow-left me-1"></i>Kembali ke Login
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@extends('layouts.app')

@section('content')
<style>
/* Clean and simple styling */
.settings-container {
    max-width: 1200px;
    margin: 0 auto;
    padding: 0 15px;
}

.settings-header {
    background: #ffffff;
    border: 1px solid #e5e7eb;
    border-radius: 12px;
    padding: 2rem;
    margin-bottom: 2rem;
    box-shadow: 0 1px 3px rgba(0,0,0,0.1);
}

.settings-card {
    background: white;
    border-radius: 12px;
    border: 1px solid #e5e7eb;
    box-shadow: 0 1px 3px rgba(0,0,0,0.1);
    transition: all 0.2s ease;
    overflow: hidden;
    height: 100%;
}

.settings-card:hover {
    box-shadow: 0 4px 12px rgba(0,0,0,0.15);
}

.card-header-custom {
    background: #f9fafb;
    border-bottom: 1px solid #e5e7eb;
    padding: 1.25rem 1.5rem;
}

.card-header-custom h6 {
    color: #374151;
    font-weight: 600;
    margin: 0;
}

.card-body {
    padding: 1.5rem 2rem;
}

.profile-photo-section {
    text-align: center;
    padding: 2rem 2rem;
}

.profile-photo-display {
    position: relative;
    display: inline-block;
    margin-bottom: 1.5rem;
}

.profile-photo-circle {
    width: 120px;
    height: 120px;
    border-radius: 50%;
    border: 3px solid #ffffff;
    box-shadow: 0 4px 12px rgba(0,0,0,0.15);
    object-fit: cover;
    transition: all 0.2s ease;
}

.profile-photo-circle:hover {
    transform: scale(1.02);
    box-shadow: 0 6px 16px rgba(0,0,0,0.2);
}

.profile-photo-placeholder {
    width: 120px;
    height: 120px;
    border-radius: 50%;
    background: #f3f4f6;
    display: flex;
    align-items: center;
    justify-content: center;
    border: 3px solid #ffffff;
    box-shadow: 0 4px 12px rgba(0,0,0,0.15);
    transition: all 0.2s ease;
}

.profile-photo-placeholder:hover {
    transform: scale(1.02);
    box-shadow: 0 6px 16px rgba(0,0,0,0.2);
}

.photo-status-badge {
    position: absolute;
    bottom: 5px;
    right: 5px;
    z-index: 10;
}

.upload-section {
    background: #f9fafb;
    border-radius: 8px;
    padding: 1.5rem 2rem;
    margin-top: 1rem;
    border: 1px solid #e5e7eb;
}

.file-input-wrapper {
    position: relative;
    display: inline-block;
    width: 100%;
}

.file-input-wrapper input[type=file] {
    position: absolute;
    left: -9999px;
}

.file-input-label {
    display: inline-block;
    padding: 10px 16px;
    background: #3b82f6;
    color: white;
    border-radius: 6px;
    cursor: pointer;
    transition: all 0.2s ease;
    font-weight: 500;
    text-align: center;
    width: 100%;
    border: none;
}

.file-input-label:hover {
    background: #2563eb;
    transform: translateY(-1px);
}

.file-info {
    font-size: 0.875rem;
    color: #6b7280;
    margin-top: 0.5rem;
    text-align: center;
}

.btn-custom {
    border-radius: 6px;
    font-weight: 500;
    padding: 10px 20px;
    transition: all 0.2s ease;
    border: none;
    font-size: 0.875rem;
}

.btn-custom:hover {
    transform: translateY(-1px);
}

.btn-upload {
    background: #10b981;
    color: white;
}

.btn-upload:hover {
    background: #059669;
    color: white;
}

.btn-delete {
    background: #ef4444;
    color: white;
}

.btn-delete:hover {
    background: #dc2626;
    color: white;
}

.btn-update {
    background: #f59e0b;
    color: #ffffff;
}

.btn-update:hover {
    background: #d97706;
    color: #ffffff;
}

.form-control-custom {
    border-radius: 6px;
    border: 1px solid #d1d5db;
    padding: 10px 12px;
    transition: all 0.2s ease;
    font-size: 0.875rem;
}

.form-control-custom:focus {
    border-color: #3b82f6;
    box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
    outline: none;
}

.info-item {
    padding: 1rem 1.25rem;
    background: #f9fafb;
    border-radius: 6px;
    margin-bottom: 0.75rem;
    border: 1px solid #e5e7eb;
}

.info-label {
    font-weight: 600;
    color: #374151;
    margin-bottom: 0.25rem;
    font-size: 0.875rem;
}

.info-value {
    color: #6b7280;
    margin-bottom: 0;
    font-size: 0.875rem;
}

.role-badge {
    padding: 0.375rem 0.75rem;
    border-radius: 6px;
    font-weight: 500;
    font-size: 0.75rem;
}

.role-admin {
    background: #ef4444;
    color: white;
}

.role-staff {
    background: #3b82f6;
    color: white;
}

.alert-custom {
    border-radius: 8px;
    border: none;
    padding: 1rem 1.25rem;
}

.alert-success-custom {
    background: #d1fae5;
    color: #065f46;
    border-left: 4px solid #10b981;
}

.alert-danger-custom {
    background: #fee2e2;
    color: #991b1b;
    border-left: 4px solid #ef4444;
}

.section-divider {
    border-top: 1px solid #e5e7eb;
    margin: 1.5rem 0;
}

.section-title {
    font-size: 0.875rem;
    font-weight: 600;
    color: #374151;
    margin-bottom: 1rem;
}

.form-label {
    font-weight: 500;
    color: #374151;
    margin-bottom: 0.5rem;
    font-size: 0.875rem;
}

.form-text {
    font-size: 0.75rem;
    color: #6b7280;
    margin-top: 0.25rem;
}

/* Responsive adjustments */
@media (max-width: 768px) {
    .settings-container {
        padding: 0 10px;
    }
    
    .settings-header {
        padding: 1.5rem;
    }
    
    .card-body {
        padding: 1.25rem 1.5rem;
    }
    
    .profile-photo-section {
        padding: 1.5rem 1.5rem;
    }
    
    .upload-section {
        padding: 1.25rem 1.5rem;
    }
    
    .profile-photo-circle,
    .profile-photo-placeholder {
        width: 100px;
        height: 100px;
    }
    
    .info-item {
        padding: 0.875rem 1rem;
    }
}

@media (max-width: 576px) {
    .card-body {
        padding: 1rem 1.25rem;
    }
    
    .profile-photo-section {
        padding: 1.25rem 1.25rem;
    }
    
    .upload-section {
        padding: 1rem 1.25rem;
    }
}
</style>

<div class="settings-container">
    <!-- Header -->
    <div class="settings-header">
        <div class="row align-items-center">
            <div class="col-md-8">
                <h2 class="mb-2 text-dark">
                    <i class="bi bi-gear me-2"></i>Pengaturan Akun
                </h2>
                <p class="mb-0 text-muted">Kelola profil dan keamanan akun Anda</p>
            </div>
            <div class="col-md-4 text-md-end">
                <div class="d-flex align-items-center justify-content-md-end">
                    <div class="me-3">
                        <small class="d-block text-muted">Terakhir login</small>
                        <strong class="text-dark">{{ $user->updated_at->format('d M Y, H:i') }}</strong>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success-custom alert-custom alert-dismissible fade show" role="alert">
            <i class="bi bi-check-circle me-2"></i>{{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if($errors->any())
        <div class="alert alert-danger-custom alert-custom alert-dismissible fade show" role="alert">
            <i class="bi bi-exclamation-triangle me-2"></i>
            <strong>Terjadi kesalahan:</strong>
            <ul class="mb-0 mt-2">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="row g-4">
        <!-- Profile Photo Section -->
        <div class="col-lg-4">
            <div class="settings-card">
                <div class="card-header-custom">
                    <h6>
                        <i class="bi bi-camera me-2"></i>Foto Profil
                    </h6>
                </div>
                <div class="profile-photo-section">
                    <!-- Current Photo Display -->
                    <div class="profile-photo-display">
                        @if($user->profile_photo && Storage::disk('public')->exists($user->profile_photo))
                            <img src="{{ asset('storage/' . $user->profile_photo) }}" 
                                 alt="Foto Profil" 
                                 class="profile-photo-circle"
                                 onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">
                            <div class="profile-photo-placeholder" style="display: none;">
                                <i class="bi bi-person display-5 text-muted"></i>
                            </div>
                        @else
                            <div class="profile-photo-placeholder">
                                <i class="bi bi-person display-5 text-muted"></i>
                            </div>
                        @endif
                        
                        <!-- Status Badge -->
                        <div class="photo-status-badge">
                            @if($user->profile_photo && Storage::disk('public')->exists($user->profile_photo))
                                <span class="badge bg-success rounded-pill">
                                    <i class="bi bi-check-circle me-1"></i>Aktif
                                </span>
                            @else
                                <span class="badge bg-secondary rounded-pill">
                                    <i class="bi bi-image me-1"></i>Belum Ada
                                </span>
                            @endif
                        </div>
                    </div>
                    
                    <!-- Upload Section -->
                    <div class="upload-section">
                        <form action="{{ route('settings.update') }}" method="POST" enctype="multipart/form-data" id="photoForm">
                            @csrf
                            <input type="hidden" name="action" value="update_photo">
                            
                            <div class="mb-3">
                                <div class="file-input-wrapper">
                                    <input type="file" class="form-control" 
                                           id="profile_photo" name="profile_photo" 
                                           accept="image/jpeg,image/png,image/jpg,image/gif" 
                                           onchange="previewPhoto(this)">
                                    <label for="profile_photo" class="file-input-label">
                                        <i class="bi bi-upload me-2"></i>Pilih Foto Baru
                                    </label>
                                </div>
                                <div class="file-info">
                                    <i class="bi bi-info-circle me-1"></i>
                                    Format: JPG, PNG, GIF. Maksimal 2MB
                                </div>
                                @error('profile_photo')
                                    <div class="text-danger small mt-2">
                                        <i class="bi bi-exclamation-circle me-1"></i>{{ $message }}
                                    </div>
                                @enderror
                                <div class="text-danger small mt-2" id="photoError"></div>
                            </div>
                            
                            <div class="d-grid gap-2">
                                <button type="submit" class="btn btn-custom btn-upload" id="uploadBtn" disabled>
                                    <i class="bi bi-upload me-2"></i>Upload Foto
                                </button>
                                
                                @if($user->profile_photo && Storage::disk('public')->exists($user->profile_photo))
                                    <button type="button" class="btn btn-custom btn-delete" onclick="confirmDeletePhoto()">
                                        <i class="bi bi-trash me-2"></i>Hapus Foto
                                    </button>
                                @endif
                            </div>
                        </form>
                        
                        <!-- Hidden Delete Form -->
                        @if($user->profile_photo && Storage::disk('public')->exists($user->profile_photo))
                            <form action="{{ route('settings.delete-photo') }}" method="POST" style="display: none;" id="deletePhotoForm">
                                @csrf
                                @method('DELETE')
                            </form>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <!-- Profile Information -->
        <div class="col-lg-4">
            <div class="settings-card">
                <div class="card-header-custom">
                    <h6>
                        <i class="bi bi-person me-2"></i>Informasi Akun
                    </h6>
                </div>
                <div class="card-body">
                    <!-- Current Info -->
                    <div class="mb-4">
                        <div class="section-title">Informasi Saat Ini</div>
                        
                        <div class="info-item">
                            <div class="info-label">Nama</div>
                            <div class="info-value">{{ $user->name }}</div>
                        </div>
                        
                        <div class="info-item">
                            <div class="info-label">Email</div>
                            <div class="info-value">{{ $user->email }}</div>
                        </div>
                        
                        <div class="info-item">
                            <div class="info-label">Role</div>
                            <div class="info-value">
                                @if($user->role === 'admin')
                                    <span class="role-badge role-admin">
                                        <i class="bi bi-shield-check me-1"></i>Administrator
                                    </span>
                                @else
                                    <span class="role-badge role-staff">
                                        <i class="bi bi-person me-1"></i>Staff
                                    </span>
                                @endif
                            </div>
                        </div>
                        
                        <div class="info-item">
                            <div class="info-label">Bergabung Sejak</div>
                            <div class="info-value">{{ $user->created_at->format('d M Y, H:i') }}</div>
                        </div>
                    </div>
                    
                    <!-- Update Form -->
                    <div class="section-divider"></div>
                    <div class="section-title">Update Informasi</div>
                    <form action="{{ route('settings.update') }}" method="POST" id="profileForm">
                        @csrf
                        <input type="hidden" name="action" value="update_profile">
                        
                        <div class="mb-3">
                            <label for="name" class="form-label">Nama Baru</label>
                            <input type="text" class="form-control form-control-custom" id="name" name="name" 
                                   value="{{ old('name', $user->name) }}" required>
                        </div>
                        
                        <div class="mb-3">
                            <label for="email" class="form-label">Email Baru</label>
                            <input type="email" class="form-control form-control-custom" id="email" name="email" 
                                   value="{{ old('email', $user->email) }}" required>
                        </div>
                        
                        <button type="submit" class="btn btn-custom btn-update">
                            <i class="bi bi-pencil me-2"></i>Update Profil
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <!-- Change Password -->
        <div class="col-lg-4">
            <div class="settings-card">
                <div class="card-header-custom">
                    <h6>
                        <i class="bi bi-lock me-2"></i>Ubah Password
                    </h6>
                </div>
                <div class="card-body">
                    <form action="{{ route('settings.update') }}" method="POST" id="passwordForm">
                        @csrf
                        <input type="hidden" name="action" value="update_password">
                        
                        <div class="mb-3">
                            <label for="current_password" class="form-label">Password Saat Ini</label>
                            <input type="password" class="form-control form-control-custom" id="current_password" 
                                   name="current_password" required>
                        </div>
                        
                        <div class="mb-3">
                            <label for="password" class="form-label">Password Baru</label>
                            <input type="password" class="form-control form-control-custom" id="password" 
                                   name="password" required>
                            <div class="form-text">
                                <i class="bi bi-shield-check me-1"></i>
                                Minimal 8 karakter
                            </div>
                        </div>
                        
                        <div class="mb-3">
                            <label for="password_confirmation" class="form-label">Konfirmasi Password Baru</label>
                            <input type="password" class="form-control form-control-custom" id="password_confirmation" 
                                   name="password_confirmation" required>
                        </div>
                        
                        <button type="submit" class="btn btn-custom btn-delete">
                            <i class="bi bi-key me-2"></i>Ubah Password
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
// Photo preview function
function previewPhoto(input) {
    const file = input.files[0];
    const uploadBtn = document.getElementById('uploadBtn');
    const photoError = document.getElementById('photoError');
    
    // Reset error
    photoError.textContent = '';
    input.classList.remove('is-invalid');
    uploadBtn.disabled = true;
    uploadBtn.classList.remove('btn-upload');
    uploadBtn.classList.add('btn-secondary');
    
    if (file) {
        // Validate file type
        const allowedTypes = ['image/jpeg', 'image/png', 'image/jpg', 'image/gif'];
        if (!allowedTypes.includes(file.type)) {
            photoError.textContent = 'Format file tidak didukung. Gunakan JPG, PNG, atau GIF.';
            input.classList.add('is-invalid');
            uploadBtn.disabled = true;
            input.value = '';
            return;
        }
        
        // Validate file size (2MB = 2 * 1024 * 1024 bytes)
        if (file.size > 2 * 1024 * 1024) {
            photoError.textContent = 'Ukuran file terlalu besar. Maksimal 2MB.';
            input.classList.add('is-invalid');
            uploadBtn.disabled = true;
            input.value = '';
            return;
        }
        
        // Check if file size is too small (likely corrupted)
        if (file.size < 1024) {
            photoError.textContent = 'File terlalu kecil atau rusak. Pilih file gambar yang valid.';
            input.classList.add('is-invalid');
            uploadBtn.disabled = true;
            input.value = '';
            return;
        }
        
        // Enable upload button
        uploadBtn.disabled = false;
        uploadBtn.classList.remove('btn-secondary');
        uploadBtn.classList.add('btn-upload');
    }
}

// Delete photo confirmation
function confirmDeletePhoto() {
    Swal.fire({
        title: 'Konfirmasi Hapus Foto',
        text: 'Yakin ingin menghapus foto profil?',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#ef4444',
        cancelButtonColor: '#6b7280',
        confirmButtonText: 'Ya, Hapus!',
        cancelButtonText: 'Batal'
    }).then((result) => {
        if (result.isConfirmed) {
            Swal.fire({
                title: 'Menghapus Foto...',
                text: 'Mohon tunggu sebentar',
                allowOutsideClick: false,
                didOpen: () => {
                    Swal.showLoading();
                }
            });
            document.getElementById('deletePhotoForm').submit();
        }
    });
}

// Form validations
document.getElementById('passwordForm').addEventListener('submit', function(e) {
    const password = document.getElementById('password').value;
    const confirmPassword = document.getElementById('password_confirmation').value;
    const currentPassword = document.getElementById('current_password').value;
    
    if (currentPassword === '') {
        e.preventDefault();
        Swal.fire({
            icon: 'error',
            title: 'Password Saat Ini Diperlukan',
            text: 'Masukkan password saat ini untuk melanjutkan!'
        });
    } else if (password !== confirmPassword) {
        e.preventDefault();
        Swal.fire({
            icon: 'error',
            title: 'Password Tidak Cocok',
            text: 'Password baru dan konfirmasi password harus sama!'
        });
    } else if (password.length < 8) {
        e.preventDefault();
        Swal.fire({
            icon: 'warning',
            title: 'Password Terlalu Pendek',
            text: 'Password harus minimal 8 karakter!'
        });
    } else {
        Swal.fire({
            title: 'Mengubah Password...',
            text: 'Mohon tunggu sebentar',
            allowOutsideClick: false,
            didOpen: () => {
                Swal.showLoading();
            }
        });
    }
});

document.getElementById('profileForm').addEventListener('submit', function(e) {
    const name = document.getElementById('name').value;
    const email = document.getElementById('email').value;
    
    if (name.trim() === '') {
        e.preventDefault();
        Swal.fire({
            icon: 'error',
            title: 'Nama Diperlukan',
            text: 'Nama tidak boleh kosong!'
        });
    } else if (email.trim() === '') {
        e.preventDefault();
        Swal.fire({
            icon: 'error',
            title: 'Email Diperlukan',
            text: 'Email tidak boleh kosong!'
        });
    } else {
        Swal.fire({
            title: 'Memperbarui Profil...',
            text: 'Mohon tunggu sebentar',
            allowOutsideClick: false,
            didOpen: () => {
                Swal.showLoading();
            }
        });
    }
});

document.getElementById('photoForm').addEventListener('submit', function(e) {
    const photoInput = document.getElementById('profile_photo');
    
    if (!photoInput.files || photoInput.files.length === 0) {
        e.preventDefault();
        Swal.fire({
            icon: 'error',
            title: 'Foto Diperlukan',
            text: 'Pilih foto terlebih dahulu!'
        });
    } else {
        Swal.fire({
            title: 'Mengupload Foto...',
            text: 'Mohon tunggu sebentar',
            allowOutsideClick: false,
            didOpen: () => {
                Swal.showLoading();
            }
        });
    }
});

// Handle image errors
document.addEventListener('DOMContentLoaded', function() {
    const currentPhoto = document.getElementById('currentPhoto');
    if (currentPhoto && currentPhoto.tagName === 'IMG') {
        currentPhoto.addEventListener('error', function() {
            this.style.display = 'none';
            const fallback = this.nextElementSibling;
            if (fallback) {
                fallback.style.display = 'flex';
            }
        });
    }
});
</script>
@endsection 
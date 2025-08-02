@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-lg-10">
            <div class="card shadow">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">
                        <i class="bi bi-pencil-square me-2"></i>Edit Produk
                    </h5>
                </div>

                <div class="card-body">
                    <form action="{{ route('products.update', $product) }}" method="POST" enctype="multipart/form-data" id="productForm">
                        @csrf
                        @method('PUT')

                        <div class="row">
                            <!-- Kolom Kiri - Informasi Produk -->
                            <div class="col-md-8">
                                <div class="mb-3">
                                    <label for="name" class="form-label fw-bold">Nama Produk <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control form-control-lg @error('name') is-invalid @enderror" 
                                           id="name" name="name" value="{{ old('name', $product->name) }}" required>
                                    @error('name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="description" class="form-label fw-bold">Deskripsi</label>
                                    <textarea class="form-control @error('description') is-invalid @enderror" 
                                              id="description" name="description" rows="4" 
                                              placeholder="Deskripsi produk...">{{ old('description', $product->description) }}</textarea>
                                    @error('description')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="price" class="form-label fw-bold">Harga <span class="text-danger">*</span></label>
                                            <div class="input-group">
                                                <span class="input-group-text bg-light">Rp</span>
                                                <input type="number" class="form-control @error('price') is-invalid @enderror" 
                                                       id="price" name="price" value="{{ old('price', $product->price) }}" 
                                                       min="0" step="0.01" required>
                                                @error('price')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="stock_quantity" class="form-label fw-bold">Jumlah Stok <span class="text-danger">*</span></label>
                                            <input type="number" class="form-control @error('stock_quantity') is-invalid @enderror" 
                                                   id="stock_quantity" name="stock_quantity" value="{{ old('stock_quantity', $product->stock_quantity) }}" 
                                                   min="0" required>
                                            @error('stock_quantity')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <label for="category_id" class="form-label fw-bold">Kategori <span class="text-danger">*</span></label>
                                    <select class="form-select @error('category_id') is-invalid @enderror" id="category_id" name="category_id" required>
                                        <option value="">Pilih Kategori</option>
                                        @foreach ($categories as $category)
                                            <option value="{{ $category->id }}" {{ old('category_id', $product->category_id) == $category->id ? 'selected' : '' }}>
                                                {{ $category->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('category_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <!-- Kolom Kanan - Gambar Produk -->
                            <div class="col-md-4">
                                <div class="card border">
                                    <div class="card-header bg-light">
                                        <h6 class="mb-0 fw-bold">
                                            <i class="bi bi-image me-2"></i>Gambar Produk
                                        </h6>
                                    </div>
                                    <div class="card-body">
                                        @if ($product->image)
                                            <div class="text-center mb-3">
                                                <img src="{{ asset('storage/' . $product->image) }}" 
                                                     alt="{{ $product->name }}" 
                                                     class="img-fluid rounded border" 
                                                     style="max-height: 200px; width: 100%; object-fit: cover;">
                                            </div>
                                            <div class="mb-3">
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" id="remove_image" name="remove_image" value="1">
                                                    <label class="form-check-label text-danger fw-bold" for="remove_image">
                                                        <i class="bi bi-trash me-1"></i>Hapus Gambar
                                                    </label>
                                                </div>
                                                <small class="text-muted">Centang untuk menghapus gambar saat produk diperbarui</small>
                                            </div>
                                        @endif

                                        <div class="mb-3">
                                            <label for="image" class="form-label fw-bold">Upload Gambar Baru</label>
                                            <input type="file" class="form-control @error('image') is-invalid @enderror" 
                                                   id="image" name="image" accept="image/*">
                                            @error('image')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                            <small class="form-text text-muted">
                                                Format: JPEG, PNG, JPG, GIF. Maksimal 2MB.
                                            </small>
                                        </div>

                                        <div id="image-preview" class="text-center"></div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Tombol Aksi -->
                        <div class="row mt-4">
                            <div class="col-12">
                                <div class="d-flex justify-content-between">
                                    <a href="{{ route('products.index') }}" class="btn btn-secondary btn-lg">
                                        <i class="bi bi-arrow-left me-2"></i>Kembali
                                    </a>
                                    <button type="submit" class="btn btn-primary btn-lg">
                                        <i class="bi bi-check-circle me-2"></i>Perbarui Produk
                                    </button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const form = document.getElementById('productForm');
        const nameInput = document.getElementById('name');
        const priceInput = document.getElementById('price');
        const stockInput = document.getElementById('stock_quantity');
        const categorySelect = document.getElementById('category_id');
        const imageInput = document.getElementById('image');
        const imagePreview = document.getElementById('image-preview');
        const removeImageCheckbox = document.getElementById('remove_image');

        // Handle checkbox remove image
        if (removeImageCheckbox) {
            removeImageCheckbox.addEventListener('change', function() {
                if (this.checked) {
                    Swal.fire({
                        title: 'Hapus Gambar?',
                        text: 'Gambar produk akan dihapus saat form disubmit.',
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#d33',
                        cancelButtonColor: '#3085d6',
                        confirmButtonText: 'Ya, Hapus!',
                        cancelButtonText: 'Batal'
                    }).then((result) => {
                        if (!result.isConfirmed) {
                            this.checked = false;
                        }
                    });
                }
            });
        }

        // Preview gambar saat dipilih
        imageInput.addEventListener('change', function() {
            imagePreview.innerHTML = '';
            if (this.files && this.files[0]) {
                // Validasi tipe file
                const fileType = this.files[0].type;
                const validTypes = ['image/jpeg', 'image/png', 'image/jpg', 'image/gif'];
                
                if (!validTypes.includes(fileType)) {
                    imageInput.classList.add('is-invalid');
                    Swal.fire({
                        icon: 'error',
                        title: 'Format File Tidak Didukung',
                        text: 'Pilih file gambar (JPEG, PNG, JPG, GIF)'
                    });
                    return;
                }
                
                // Validasi ukuran file (max 2MB)
                if (this.files[0].size > 2 * 1024 * 1024) {
                    imageInput.classList.add('is-invalid');
                    Swal.fire({
                        icon: 'error',
                        title: 'File Terlalu Besar',
                        text: 'Ukuran file tidak boleh lebih dari 2MB'
                    });
                    return;
                }
                
                // Tampilkan preview
                imageInput.classList.remove('is-invalid');
                const reader = new FileReader();
                reader.onload = function(e) {
                    const img = document.createElement('img');
                    img.src = e.target.result;
                    img.className = 'img-fluid rounded border mt-2';
                    img.style.maxHeight = '200px';
                    imagePreview.appendChild(img);
                }
                reader.readAsDataURL(this.files[0]);
                
                // Uncheck remove image checkbox if new image is selected
                if (removeImageCheckbox) {
                    removeImageCheckbox.checked = false;
                }
                
                // Show success message
                Swal.fire({
                    icon: 'success',
                    title: 'File Dipilih',
                    text: 'File gambar berhasil dipilih dan siap untuk diupload!',
                    timer: 2000,
                    showConfirmButton: false
                });
            }
        });

        // Validasi form sebelum submit
        form.addEventListener('submit', function(event) {
            let isValid = true;
            let errorMessage = '';

            // Validasi nama
            if (nameInput.value.trim() === '') {
                nameInput.classList.add('is-invalid');
                isValid = false;
                errorMessage = 'Nama produk harus diisi.';
            } else {
                nameInput.classList.remove('is-invalid');
            }

            // Validasi harga
            if (priceInput.value === '' || parseFloat(priceInput.value) < 0) {
                priceInput.classList.add('is-invalid');
                isValid = false;
                errorMessage = 'Harga harus diisi dengan angka lebih dari 0.';
            } else {
                priceInput.classList.remove('is-invalid');
            }

            // Validasi stok
            if (stockInput.value === '' || parseInt(stockInput.value) < 0) {
                stockInput.classList.add('is-invalid');
                isValid = false;
                errorMessage = 'Stok harus diisi dengan angka lebih dari atau sama dengan 0.';
            } else {
                stockInput.classList.remove('is-invalid');
            }

            // Validasi kategori
            if (categorySelect.value === '') {
                categorySelect.classList.add('is-invalid');
                isValid = false;
                errorMessage = 'Kategori harus dipilih.';
            } else {
                categorySelect.classList.remove('is-invalid');
            }

            if (!isValid) {
                event.preventDefault();
                Swal.fire({
                    icon: 'error',
                    title: 'Validasi Gagal',
                    text: errorMessage
                });
            } else {
                // Show loading message
                Swal.fire({
                    title: 'Memperbarui Produk...',
                    text: 'Mohon tunggu sebentar',
                    allowOutsideClick: false,
                    didOpen: () => {
                        Swal.showLoading();
                    }
                });
            }
        });
    });
</script>
@endsection

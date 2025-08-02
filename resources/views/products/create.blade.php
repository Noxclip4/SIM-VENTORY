@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Tambah Produk Baru</div>

                <div class="card-body">
                    <form action="{{ route('products.store') }}" method="POST" enctype="multipart/form-data" id="productForm">
                        @csrf

                        <div class="mb-3">
                            <label for="name" class="form-label">Nama Produk <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name') }}" required>
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <div class="invalid-feedback" id="name-error">Nama produk harus diisi.</div>
                        </div>

                        <div class="mb-3">
                            <label for="description" class="form-label">Deskripsi</label>
                            <textarea class="form-control @error('description') is-invalid @enderror" id="description" name="description" rows="3">{{ old('description') }}</textarea>
                            @error('description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="price" class="form-label">Harga <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <span class="input-group-text">Rp</span>
                                    <input type="number" class="form-control @error('price') is-invalid @enderror" id="price" name="price" value="{{ old('price') }}" min="0" step="0.01" required>
                                    @error('price')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    <div class="invalid-feedback" id="price-error">Harga harus diisi dengan angka lebih dari 0.</div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label for="stock_quantity" class="form-label">Jumlah Stok <span class="text-danger">*</span></label>
                                <input type="number" class="form-control @error('stock_quantity') is-invalid @enderror" id="stock_quantity" name="stock_quantity" value="{{ old('stock_quantity') }}" min="0" required>
                                @error('stock_quantity')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <div class="invalid-feedback" id="stock-error">Stok harus diisi dengan angka lebih dari atau sama dengan 0.</div>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="category_id" class="form-label">Kategori <span class="text-danger">*</span></label>
                            <select class="form-select @error('category_id') is-invalid @enderror" id="category_id" name="category_id" required>
                                <option value="">Pilih Kategori</option>
                                @foreach ($categories as $category)
                                    <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                                @endforeach
                            </select>
                            @error('category_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <div class="invalid-feedback" id="category-error">Kategori harus dipilih.</div>
                        </div>

                        <div class="mb-3">
                            <label for="image" class="form-label">Gambar Produk</label>
                            <input type="file" class="form-control @error('image') is-invalid @enderror" id="image" name="image" accept="image/*">
                            <small class="form-text text-muted">Format yang diizinkan: JPEG, PNG, JPG, GIF. Ukuran maksimal: 2MB.</small>
                            @error('image')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <div class="invalid-feedback" id="image-error">File harus berupa gambar dengan ukuran maksimal 2MB.</div>
                            <div class="mt-2" id="image-preview"></div>
                        </div>

                        <div class="d-flex justify-content-between">
                            <a href="{{ route('products.index') }}" class="btn btn-secondary">Kembali</a>
                            <button type="submit" class="btn btn-primary">Simpan</button>
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

        // Preview gambar saat dipilih
        imageInput.addEventListener('change', function() {
            imagePreview.innerHTML = '';
            if (this.files && this.files[0]) {
                // Validasi tipe file
                const fileType = this.files[0].type;
                const validTypes = ['image/jpeg', 'image/png', 'image/jpg', 'image/gif'];
                
                if (!validTypes.includes(fileType)) {
                    imageInput.classList.add('is-invalid');
                    document.getElementById('image-error').textContent = 'File harus berupa gambar (JPEG, PNG, JPG, GIF).';
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
                    document.getElementById('image-error').textContent = 'Ukuran file tidak boleh lebih dari 2MB.';
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
                    img.className = 'img-thumbnail mt-2';
                    img.style.maxHeight = '200px';
                    imagePreview.appendChild(img);
                }
                reader.readAsDataURL(this.files[0]);
                
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
                    title: 'Menyimpan Produk...',
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

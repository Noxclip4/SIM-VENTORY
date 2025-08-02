document.addEventListener('DOMContentLoaded', function() {
    const productsContainer = document.getElementById('products-container');
    const addProductBtn = document.getElementById('add-product');
    const totalAmountDisplay = document.getElementById('total-amount');
    const totalItemsDisplay = document.getElementById('total-items');

    // Add new product row
    addProductBtn.addEventListener('click', function() {
        const firstRow = productsContainer.querySelector('.product-row');
        const newRow = firstRow.cloneNode(true);
        
        // Clear values
        newRow.querySelector('.product-select').value = '';
        newRow.querySelector('.quantity-input').value = '';
        newRow.querySelector('.subtotal-display').value = '';
        
        // Add remove button functionality
        newRow.querySelector('.btn-remove-product').addEventListener('click', function() {
            if (productsContainer.querySelectorAll('.product-row').length > 1) {
                newRow.remove();
                calculateTotal();
            } else {
                Swal.fire({
                    icon: 'warning',
                    title: 'Tidak Bisa Dihapus',
                    text: 'Minimal harus ada satu produk dalam transaksi!'
                });
            }
        });
        
        // Add event listeners
        addEventListeners(newRow);
        productsContainer.appendChild(newRow);
    });

    // Add event listeners to first row
    addEventListeners(productsContainer.querySelector('.product-row'));

    // Add remove button functionality to first row
    productsContainer.querySelector('.btn-remove-product').addEventListener('click', function() {
        if (productsContainer.querySelectorAll('.product-row').length > 1) {
            this.closest('.product-row').remove();
            calculateTotal();
        } else {
            Swal.fire({
                icon: 'warning',
                title: 'Tidak Bisa Dihapus',
                text: 'Minimal harus ada satu produk dalam transaksi!'
            });
        }
    });

    function addEventListeners(row) {
        const productSelect = row.querySelector('.product-select');
        const quantityInput = row.querySelector('.quantity-input');
        const subtotalDisplay = row.querySelector('.subtotal-display');

        productSelect.addEventListener('change', calculateSubtotal);
        quantityInput.addEventListener('input', calculateSubtotal);

        function calculateSubtotal() {
            const selectedOption = productSelect.options[productSelect.selectedIndex];
            const price = parseFloat(selectedOption.dataset.price) || 0;
            const quantity = parseInt(quantityInput.value) || 0;
            const stock = parseInt(selectedOption.dataset.stock) || 0;

            if (quantity > stock) {
                Swal.fire({
                    icon: 'error',
                    title: 'Stok Tidak Mencukupi',
                    text: `Stok tersedia: ${stock} unit`
                });
                quantityInput.value = stock;
            }

            const subtotal = price * quantity;
            subtotalDisplay.value = `Rp ${subtotal.toLocaleString('id-ID')}`;
            calculateTotal();
        }
    }

    function calculateTotal() {
        let total = 0;
        let totalItems = 0;
        const rows = productsContainer.querySelectorAll('.product-row');
        
        rows.forEach(row => {
            const productSelect = row.querySelector('.product-select');
            const quantityInput = row.querySelector('.quantity-input');
            
            if (productSelect.value && quantityInput.value) {
                const selectedOption = productSelect.options[productSelect.selectedIndex];
                const price = parseFloat(selectedOption.dataset.price) || 0;
                const quantity = parseInt(quantityInput.value) || 0;
                total += price * quantity;
                totalItems += quantity;
            }
        });
        
        totalAmountDisplay.textContent = `Rp ${total.toLocaleString('id-ID')}`;
        totalItemsDisplay.textContent = `${totalItems} item`;
    }

    // Form validation
    document.getElementById('transactionForm').addEventListener('submit', function(e) {
        const customerName = document.getElementById('customer_name').value.trim();
        const paymentMethod = document.getElementById('payment_method').value;
        const productRows = productsContainer.querySelectorAll('.product-row');
        let hasValidProduct = false;

        // Check if at least one product is selected
        productRows.forEach(row => {
            const productSelect = row.querySelector('.product-select');
            const quantityInput = row.querySelector('.quantity-input');
            if (productSelect.value && quantityInput.value) {
                hasValidProduct = true;
            }
        });

        if (!customerName) {
            e.preventDefault();
            Swal.fire({
                icon: 'error',
                title: 'Nama Customer Diperlukan',
                text: 'Masukkan nama customer terlebih dahulu!'
            });
            return;
        }

        if (!paymentMethod) {
            e.preventDefault();
            Swal.fire({
                icon: 'error',
                title: 'Metode Pembayaran Diperlukan',
                text: 'Pilih metode pembayaran terlebih dahulu!'
            });
            return;
        }

        if (!hasValidProduct) {
            e.preventDefault();
            Swal.fire({
                icon: 'error',
                title: 'Produk Diperlukan',
                text: 'Pilih minimal satu produk untuk transaksi!'
            });
            return;
        }

        // Show loading message
        Swal.fire({
            title: 'Membuat Transaksi...',
            text: 'Mohon tunggu sebentar',
            allowOutsideClick: false,
            didOpen: () => {
                Swal.showLoading();
            }
        });
    });

    // Add smooth animations
    function addSmoothAnimations() {
        // Animate form sections on scroll
        const observerOptions = {
            threshold: 0.1,
            rootMargin: '0px 0px -50px 0px'
        };

        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.style.opacity = '1';
                    entry.target.style.transform = 'translateY(0)';
                }
            });
        }, observerOptions);

        document.querySelectorAll('.form-section').forEach(section => {
            section.style.opacity = '0';
            section.style.transform = 'translateY(20px)';
            section.style.transition = 'all 0.6s ease';
            observer.observe(section);
        });
    }

    // Initialize animations
    addSmoothAnimations();
}); 
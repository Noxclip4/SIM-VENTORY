<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'SIM-VENTORY') }}</title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">

    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <style>
        :root {
            --primary-color: #1e40af;
            --primary-dark: #1e3a8a;
            --primary-light: #3b82f6;
            --secondary-color: #475569;
            --success-color: #16a34a;
            --warning-color: #ea580c;
            --danger-color: #dc2626;
            --info-color: #0891b2;
            --light-color: #f8fafc;
            --dark-color: #0f172a;
            --white: #ffffff;
            --gray-50: #f8fafc;
            --gray-100: #f1f5f9;
            --gray-200: #e2e8f0;
            --gray-300: #cbd5e1;
            --gray-400: #94a3b8;
            --gray-500: #64748b;
            --gray-600: #475569;
            --gray-700: #334155;
            --gray-800: #1e293b;
            --gray-900: #0f172a;
        }

        body {
            font-family: 'Nunito', sans-serif;
            background-color: var(--gray-50);
            color: var(--gray-800);
        }

        .sidebar {
            min-height: 100vh;
            background: var(--dark-color);
            box-shadow: 0 0.15rem 1.75rem 0 rgba(0, 0, 0, 0.15);
            position: fixed;
            width: 250px;
            z-index: 1000;
            overflow-y: auto;
        }
        
        .sidebar .nav-link {
            color: var(--gray-200);
            transition: all 0.3s ease;
            padding: 0.75rem 1rem;
            margin: 0.25rem 0;
            border-radius: 0.35rem;
            font-weight: 500;
            text-decoration: none;
            position: relative;
            overflow: hidden;
        }
        
        .sidebar .nav-link::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255,255,255,0.15), transparent);
            transition: left 0.5s;
        }
        
        .sidebar .nav-link:hover::before {
            left: 100%;
        }
        
        .sidebar .nav-link:hover {
            color: var(--white);
            background: rgba(255, 255, 255, 0.15);
        }
        
        .sidebar .nav-link.active {
            color: var(--white);
            background: var(--primary-color);
            box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
        }

        .sidebar-section {
            margin-bottom: 1.5rem;
        }

        .sidebar-section-title {
            color: var(--gray-300);
            font-size: 0.75rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            margin-bottom: 0.5rem;
            padding: 0 1rem;
        }

        .main-content {
            margin-left: 250px;
            min-height: 100vh;
            background-color: var(--gray-50);
        }

        .border-left-primary {
            border-left: 0.25rem solid var(--primary-color) !important;
        }

        .border-left-success {
            border-left: 0.25rem solid var(--success-color) !important;
        }

        .border-left-info {
            border-left: 0.25rem solid var(--info-color) !important;
        }

        .border-left-warning {
            border-left: 0.25rem solid var(--warning-color) !important;
        }

        .border-left-secondary {
            border-left: 0.25rem solid var(--secondary-color) !important;
        }

        .text-gray-800 {
            color: var(--gray-800) !important;
        }

        .text-gray-300 {
            color: var(--gray-300) !important;
        }

        .chart-area {
            position: relative;
            height: 20rem;
            width: 100%;
        }

        .chart-pie {
            position: relative;
            height: 15rem;
            width: 100%;
        }

        .btn-group-spaced .btn {
            margin-right: 0.5rem;
            margin-bottom: 0.5rem;
        }

        .btn-group-spaced .btn:last-child {
            margin-right: 0;
        }

        .card {
            border: none;
            border-radius: 12px;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
            transition: all 0.3s ease;
            background: var(--white);
            height: 100%;
        }

        .card:hover {
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
        }

        .card-header {
            background: var(--gray-100);
            border-bottom: 1px solid var(--gray-200);
            border-radius: 12px 12px 0 0 !important;
            font-weight: 600;
            color: var(--gray-700);
        }

        .navbar {
            background: var(--white) !important;
            box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.1), 0 1px 2px 0 rgba(0, 0, 0, 0.06);
            border-radius: 0 0 12px 12px;
        }

        .dropdown-menu {
            border: none;
            border-radius: 12px;
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
            background: var(--white);
        }

        .dropdown-item {
            border-radius: 8px;
            margin: 0.25rem;
            transition: all 0.3s ease;
            color: var(--gray-700);
        }

        .dropdown-item:hover {
            background: var(--primary-color);
            color: var(--white);
        }

        /* Table Styling */
        .table {
            border-radius: 12px;
            overflow: hidden;
            background: var(--white);
            box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.1), 0 1px 2px 0 rgba(0, 0, 0, 0.06);
        }

        .table th {
            background: var(--gray-100);
            border: none;
            font-weight: 600;
            color: var(--gray-700);
            padding: 1rem;
            text-transform: uppercase;
            font-size: 0.875rem;
            letter-spacing: 0.05em;
        }

        .table td {
            padding: 1rem;
            border-bottom: 1px solid var(--gray-200);
            vertical-align: middle;
        }

        .table tbody tr {
            transition: all 0.3s ease;
        }

        .table tbody tr:hover {
            background-color: var(--gray-50);
            transform: scale(1.01);
        }

        .table tbody tr:last-child td {
            border-bottom: none;
        }

        .badge {
            border-radius: 8px;
            font-weight: 500;
            padding: 0.5rem 0.75rem;
        }

        .btn {
            border-radius: 8px;
            font-weight: 500;
            transition: all 0.3s ease;
        }

        .btn:hover {
            transform: translateY(-1px);
        }

        .form-control {
            border-radius: 8px;
            border: 2px solid var(--gray-200);
            transition: all 0.3s ease;
        }

        .form-control:focus {
            border-color: var(--primary-color);
            box-shadow: 0 0 0 0.2rem rgba(30, 64, 175, 0.25);
        }

        .form-select {
            border-radius: 8px;
            border: 2px solid var(--gray-200);
            transition: all 0.3s ease;
        }

        .form-select:focus {
            border-color: var(--primary-color);
            box-shadow: 0 0 0 0.2rem rgba(30, 64, 175, 0.25);
        }

        .form-control-color {
            width: 60px;
            height: 38px;
            border: 2px solid var(--gray-200);
            border-radius: 8px;
            cursor: pointer;
        }

        .form-control-color:hover {
            border-color: var(--primary-color);
        }

        /* Global Checkbox Styling */
        .form-check-input {
            width: 1.2em;
            height: 1.2em;
            margin-top: 0.25em;
            vertical-align: top;
            background-color: var(--white);
            background-repeat: no-repeat;
            background-position: center;
            background-size: contain;
            border: 2px solid var(--gray-400);
            appearance: none;
            color-adjust: exact;
            border-radius: 0.25em;
            transition: background-color 0.15s ease-in-out, background-position 0.15s ease-in-out, border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out;
        }

        .form-check-input:checked {
            background-color: var(--primary-color);
            border-color: var(--primary-color);
            background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 20 20'%3e%3cpath fill='none' stroke='%23fff' stroke-linecap='round' stroke-linejoin='round' stroke-width='3' d='m6 10 3 3 6-6'/%3e%3c/svg%3e");
        }

        .form-check-input:focus {
            border-color: var(--primary-color);
            outline: 0;
            box-shadow: 0 0 0 0.2rem rgba(30, 64, 175, 0.25);
        }

        .form-check-input:checked:focus {
            background-color: var(--primary-color);
            border-color: var(--primary-color);
        }

        .form-check-label {
            margin-bottom: 0;
            cursor: pointer;
            padding-left: 0.5rem;
            color: var(--gray-700);
        }

        /* Consistent container */
        .main-container {
            max-width: 1400px;
            margin: 0 auto;
            padding: 0 1rem;
        }

        /* Equal height cards */
        .row-equal-height {
            display: flex;
            flex-wrap: wrap;
        }

        .row-equal-height > [class*='col-'] {
            display: flex;
            flex-direction: column;
        }

        .row-equal-height .card {
            flex: 1;
        }

        /* Color picker improvements */
        input[type="color"] {
            -webkit-appearance: none;
            -moz-appearance: none;
            appearance: none;
            background-color: transparent;
            width: 60px;
            height: 38px;
            border: 2px solid var(--gray-200);
            border-radius: 8px;
            cursor: pointer;
        }

        input[type="color"]::-webkit-color-swatch-wrapper {
            padding: 0;
        }

        input[type="color"]::-webkit-color-swatch {
            border: none;
            border-radius: 6px;
        }

        input[type="color"]::-moz-color-swatch {
            border: none;
            border-radius: 6px;
        }

        @media (max-width: 768px) {
            .sidebar {
                position: fixed;
                top: 0;
                left: -250px;
                z-index: 1000;
                transition: left 0.3s;
            }
            
            .sidebar.show {
                left: 0;
            }
            
            .main-content {
                margin-left: 0;
            }

            .main-container {
                padding: 0 0.5rem;
            }
        }
    </style>
</head>
<body>
    <div class="d-flex">
        <!-- Sidebar -->
        <div class="sidebar d-none d-md-block">
            <div class="p-4">
                <h4 class="text-white text-center mb-4">
                    <i class="bi bi-box-seam me-2"></i> SIM-VENTORY
                </h4>
                
                <!-- Main Navigation -->
                <div class="sidebar-section">
                    <div class="sidebar-section-title">Menu Utama</div>
                    <nav class="nav flex-column">
                        <a class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}" href="{{ route('dashboard') }}">
                            <i class="bi bi-speedometer2 me-2"></i> Dashboard
                        </a>
                        
                        @auth
                            @if(auth()->user()->role === 'admin')
                                <a class="nav-link {{ request()->routeIs('products.*') ? 'active' : '' }}" href="{{ route('products.index') }}">
                                    <i class="bi bi-box me-2"></i> Produk
                                </a>
                                <a class="nav-link {{ request()->routeIs('categories.*') ? 'active' : '' }}" href="{{ route('categories.index') }}">
                                    <i class="bi bi-tags me-2"></i> Kategori
                                </a>
                            @else
                                <a class="nav-link {{ request()->routeIs('products.*') ? 'active' : '' }}" href="{{ route('products.index') }}">
                                    <i class="bi bi-box me-2"></i> Lihat Produk
                                </a>
                                <a class="nav-link {{ request()->routeIs('categories.*') ? 'active' : '' }}" href="{{ route('categories.index') }}">
                                    <i class="bi bi-tags me-2"></i> Lihat Kategori
                                </a>
                            @endif
                        @endauth
                        
                        <a class="nav-link {{ request()->routeIs('transactions.*') ? 'active' : '' }}" href="{{ route('transactions.index') }}">
                            <i class="bi bi-cart me-2"></i> Transaksi
                        </a>
                        
                        <a class="nav-link {{ request()->routeIs('reports.*') ? 'active' : '' }}" href="{{ route('reports.index') }}">
                            <i class="bi bi-graph-up me-2"></i> Laporan
                        </a>
                    </nav>
                </div>

                <!-- Admin Menu -->
                @auth
                    @if(auth()->user()->role === 'admin')
                        <div class="sidebar-section">
                            <div class="sidebar-section-title">Administrasi</div>
                            <nav class="nav flex-column">
                                <a class="nav-link" href="{{ route('transactions.excel') }}">
                                    <i class="bi bi-file-excel me-2"></i> Export Excel
                                </a>
                                <a class="nav-link {{ request()->routeIs('staff.*') ? 'active' : '' }}" href="{{ route('staff.index') }}">
                                    <i class="bi bi-people me-2"></i> Manajemen Staff
                                </a>
                                <a class="nav-link {{ request()->routeIs('settings.*') ? 'active' : '' }}" href="{{ route('settings.index') }}">
                                    <i class="bi bi-gear me-2"></i> Settings
                                </a>
                            </nav>
                        </div>
                    @endif
                @endauth
            </div>
        </div>

        <!-- Main Content -->
        <div class="main-content flex-grow-1">
            <!-- Top Navigation -->
            <nav class="navbar navbar-expand-md navbar-light">
                <div class="container-fluid">
                    <button class="navbar-toggler d-md-none" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent">
                        <span class="navbar-toggler-icon"></span>
                    </button>

                    <div class="navbar-nav ms-auto">
                        @auth
                        <div class="dropdown">
                            <a class="nav-link dropdown-toggle d-flex align-items-center" href="#" role="button" data-bs-toggle="dropdown">
                                @if(Auth::user()->profile_photo)
                                    <img src="{{ asset('storage/' . Auth::user()->profile_photo) }}" 
                                         alt="Profile" 
                                         class="rounded-circle me-2" 
                                         style="width: 32px; height: 32px; object-fit: cover; border: 2px solid #e5e7eb; display: inline-block;">
                                @else
                                    <i class="bi bi-person-circle fs-5 me-2" style="color: #6b7280;"></i>
                                @endif
                                <span class="fw-medium" style="color: #374151;">{{ Auth::user()->name }}</span>
                            </a>
                            <div class="dropdown-menu dropdown-menu-end">
                                <div class="dropdown-header">
                                    <strong>{{ Auth::user()->name }}</strong>
                                    <br>
                                    <small class="text-muted">
                                        <i class="bi bi-person-badge me-1"></i>
                                        {{ Auth::user()->role === 'admin' ? 'Administrator' : 'Staff' }}
                                    </small>
                                </div>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="{{ route('home') }}">
                                    <i class="bi bi-house me-2"></i> Home
                                </a>
                                <a class="dropdown-item" href="{{ route('settings.index') }}">
                                    <i class="bi bi-gear me-2"></i> Settings
                                </a>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="{{ route('logout') }}"
                                   onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                    <i class="bi bi-box-arrow-right me-2"></i> Logout
                                </a>
                                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                    @csrf
                                </form>
                            </div>
                        </div>
                        @endauth
                    </div>
                </div>
            </nav>

            <!-- Page Content -->
            <main class="py-4">
                <div class="main-container">
                    @yield('content')
                </div>
            </main>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>

    <!-- SweetAlert2 Notifications -->
    @if(session('success'))
    <script>
        Swal.fire({
            icon: 'success',
            title: 'Berhasil!',
            text: "{{ session('success') }}",
            timer: 3000,
            showConfirmButton: false,
            toast: true,
            position: 'top-end',
            background: '#16a34a',
            color: 'white'
        });
    </script>
    @endif

    @if(session('error'))
    <script>
        Swal.fire({
            icon: 'error',
            title: 'Error!',
            text: "{{ session('error') }}",
            timer: 3000,
            showConfirmButton: false,
            toast: true,
            position: 'top-end',
            background: '#dc2626',
            color: 'white'
        });
    </script>
    @endif

    @if(session('warning'))
    <script>
        Swal.fire({
            icon: 'warning',
            title: 'Perhatian!',
            text: "{{ session('warning') }}",
            timer: 4000,
            showConfirmButton: false,
            toast: true,
            position: 'top-end',
            background: '#ea580c',
            color: 'white'
        });
    </script>
    @endif

    @stack('scripts')
</body>
</html>

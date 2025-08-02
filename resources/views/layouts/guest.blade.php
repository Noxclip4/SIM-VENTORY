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
            background: var(--dark-color);
            min-height: 100vh;
            margin: 0;
            padding: 0;
        }

        .auth-container {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }

        .auth-card {
            background: var(--white);
            border-radius: 16px;
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25);
            overflow: hidden;
            width: 100%;
            max-width: 420px;
            animation: slideUp 0.6s ease-out;
            border: 1px solid var(--gray-200);
        }

        .auth-header {
            background: var(--primary-color);
            color: var(--white);
            padding: 40px 30px 30px;
            text-align: center;
            position: relative;
        }

        .auth-header h2 {
            font-weight: 700;
            margin-bottom: 10px;
            font-size: 1.75rem;
        }

        .auth-header p {
            opacity: 0.9;
            font-size: 0.9rem;
            line-height: 1.5;
        }

        .auth-body {
            padding: 40px 30px;
            background: var(--white);
        }

        .form-control {
            border-radius: 8px;
            border: 2px solid var(--gray-200);
            padding: 12px 16px;
            font-size: 16px;
            transition: all 0.3s ease;
            background: var(--white);
        }

        .form-control:focus {
            border-color: var(--primary-color);
            box-shadow: 0 0 0 0.2rem rgba(30, 64, 175, 0.25);
            background: var(--white);
        }

        .form-label {
            color: var(--gray-700);
            font-weight: 600;
            margin-bottom: 8px;
        }

        .btn-primary {
            background: var(--primary-color);
            border: none;
            border-radius: 8px;
            padding: 14px 24px;
            font-weight: 600;
            transition: all 0.3s ease;
            color: var(--white);
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 25px rgba(30, 64, 175, 0.3);
            background: var(--primary-dark);
        }

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

        .form-check-label {
            color: var(--gray-600);
            font-weight: 500;
        }

        .alert {
            border-radius: 8px;
            border: none;
            font-weight: 500;
        }

        .alert-danger {
            background: var(--danger-color);
            color: var(--white);
        }

        .alert-success {
            background: var(--success-color);
            color: var(--white);
        }

        .text-muted {
            color: var(--gray-500) !important;
        }

        .text-decoration-none {
            color: var(--primary-color);
            font-weight: 500;
        }

        .text-decoration-none:hover {
            color: var(--primary-dark);
        }

        .display-1 {
            font-size: 4rem;
            font-weight: 300;
            line-height: 1.2;
        }

        @keyframes slideUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @media (max-width: 576px) {
            .auth-card {
                margin: 10px;
                border-radius: 12px;
            }
            
            .auth-header {
                padding: 30px 20px 20px;
            }
            
            .auth-body {
                padding: 30px 20px;
            }
        }
    </style>
</head>
<body>
    @yield('content')

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
</body>
</html>

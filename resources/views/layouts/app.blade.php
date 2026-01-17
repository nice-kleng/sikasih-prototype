<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'SIKASIH - Sistem Informasi Integrasi Komunitas Asuhan Ibu Hamil')</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #ffeef8 0%, #fff5f9 100%);
            min-height: 100vh;
            max-width: 480px;
            margin: 0 auto;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
        }

        .header {
            background: linear-gradient(135deg, #ff6b9d 0%, #ff8fab 100%);
            padding: 15px 20px;
            color: white;
            box-shadow: 0 2px 10px rgba(255, 107, 157, 0.3);
        }

        .header h1 {
            font-size: 22px;
            font-weight: 700;
            margin: 0;
            text-align: center;
        }

        .header p {
            font-size: 12px;
            margin: 5px 0 0 0;
            text-align: center;
            opacity: 0.95;
        }

        .header-content {
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .back-btn {
            background: rgba(255, 255, 255, 0.2);
            border: none;
            color: white;
            width: 40px;
            height: 40px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: all 0.3s;
            text-decoration: none;
        }

        .back-btn:hover {
            background: rgba(255, 255, 255, 0.3);
            color: white;
        }

        .content {
            padding: 20px;
            padding-bottom: 100px;
        }

        .bottom-nav {
            position: fixed;
            bottom: 0;
            left: 50%;
            transform: translateX(-50%);
            max-width: 480px;
            width: 100%;
            background: white;
            box-shadow: 0 -2px 10px rgba(0, 0, 0, 0.1);
            display: flex;
            justify-content: space-around;
            padding: 10px 0;
            z-index: 100;
        }

        .nav-item {
            text-align: center;
            color: #999;
            cursor: pointer;
            transition: all 0.3s;
            text-decoration: none;
            flex: 1;
        }

        .nav-item.active {
            color: #ff6b9d;
        }

        .nav-item i {
            font-size: 22px;
            display: block;
            margin-bottom: 3px;
        }

        .nav-item span {
            font-size: 10px;
            display: block;
        }

        /* Additional Utilities */
        .btn-primary-custom {
            background: linear-gradient(135deg, #ff6b9d 0%, #ff8fab 100%);
            color: white;
            border: none;
            padding: 12px 24px;
            border-radius: 12px;
            font-size: 14px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s;
        }

        .btn-primary-custom:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(255, 107, 157, 0.3);
            color: white;
        }

        .btn-outline-primary {
            color: #ff6b9d;
            border: 2px solid #ff6b9d;
            border-radius: 8px;
            padding: 10px 20px;
            font-weight: 600;
            transition: all 0.3s;
        }

        .btn-outline-primary:hover {
            background: #ff6b9d;
            border-color: #ff6b9d;
            color: white;
        }

        .section-title {
            color: #ff6b9d;
            font-size: 18px;
            font-weight: 700;
            margin: 25px 0 15px 0;
            padding-left: 10px;
            border-left: 4px solid #ff6b9d;
        }

        .card-custom {
            background: white;
            border-radius: 15px;
            padding: 20px;
            margin-bottom: 20px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.08);
        }
    </style>

    @stack('styles')
</head>

<body>
    @yield('content')

    @if (!isset($hideBottomNav) || !$hideBottomNav)
        @include('layouts.bottom-nav')
    @endif

    <!-- Bootstrap JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    @stack('scripts')
</body>

</html>

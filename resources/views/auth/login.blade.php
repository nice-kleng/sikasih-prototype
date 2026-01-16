<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Login - SIKASIH</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
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
            padding: 30px 20px;
            color: white;
            text-align: center;
        }

        .logo-container {
            margin-bottom: 20px;
        }

        .logo-icon {
            width: 80px;
            height: 80px;
            background: rgba(255, 255, 255, 0.2);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 15px;
            backdrop-filter: blur(10px);
        }

        .logo-icon i {
            font-size: 40px;
            color: white;
        }

        .header h1 {
            font-size: 24px;
            font-weight: 700;
            margin: 0 0 8px 0;
        }

        .header p {
            font-size: 14px;
            margin: 0;
            opacity: 0.9;
        }

        .content {
            padding: 30px 20px;
        }

        .login-card {
            background: white;
            border-radius: 20px;
            padding: 30px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
        }

        .welcome-text {
            text-align: center;
            margin-bottom: 30px;
        }

        .welcome-text h2 {
            color: #ff6b9d;
            font-size: 20px;
            font-weight: 700;
            margin-bottom: 8px;
        }

        .welcome-text p {
            color: #666;
            font-size: 13px;
            margin: 0;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-label {
            font-size: 13px;
            font-weight: 600;
            color: #333;
            margin-bottom: 8px;
            display: block;
        }

        .input-group-custom {
            position: relative;
        }

        .input-icon {
            position: absolute;
            left: 15px;
            top: 50%;
            transform: translateY(-50%);
            color: #ff6b9d;
            font-size: 16px;
        }

        .form-control {
            width: 100%;
            padding: 14px 15px 14px 45px;
            border: 2px solid #ffe8f2;
            border-radius: 12px;
            font-size: 14px;
            transition: all 0.3s;
            background: #fff;
            color: #333;
        }

        .form-control:focus {
            outline: none;
            border-color: #ff6b9d;
            box-shadow: 0 0 0 4px rgba(255, 107, 157, 0.1);
        }

        .form-control::placeholder {
            color: #999;
            font-size: 13px;
        }

        .password-toggle {
            position: absolute;
            right: 15px;
            top: 50%;
            transform: translateY(-50%);
            color: #999;
            cursor: pointer;
            font-size: 16px;
            transition: color 0.3s;
        }

        .password-toggle:hover {
            color: #ff6b9d;
        }

        .remember-forgot {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 25px;
            font-size: 13px;
        }

        .remember-me {
            display: flex;
            align-items: center;
            gap: 8px;
            cursor: pointer;
        }

        .remember-me input[type="checkbox"] {
            width: 18px;
            height: 18px;
            accent-color: #ff6b9d;
            cursor: pointer;
        }

        .remember-me label {
            cursor: pointer;
            color: #666;
            margin: 0;
        }

        .forgot-password {
            color: #ff6b9d;
            text-decoration: none;
            font-weight: 600;
            transition: opacity 0.3s;
        }

        .forgot-password:hover {
            opacity: 0.8;
        }

        .login-btn {
            background: linear-gradient(135deg, #ff6b9d 0%, #ff8fab 100%);
            color: white;
            border: none;
            width: 100%;
            padding: 15px;
            border-radius: 12px;
            font-size: 16px;
            font-weight: 700;
            cursor: pointer;
            transition: all 0.3s;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
        }

        .login-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(255, 107, 157, 0.3);
        }

        .login-btn:disabled {
            background: #ccc;
            cursor: not-allowed;
            transform: none;
        }

        .loading-spinner {
            display: inline-block;
            width: 16px;
            height: 16px;
            border: 3px solid rgba(255, 255, 255, .3);
            border-radius: 50%;
            border-top-color: #fff;
            animation: spin 1s ease-in-out infinite;
        }

        @keyframes spin {
            to {
                transform: rotate(360deg);
            }
        }

        .divider {
            text-align: center;
            margin: 25px 0;
            position: relative;
        }

        .divider::before {
            content: '';
            position: absolute;
            left: 0;
            top: 50%;
            width: 100%;
            height: 1px;
            background: #ffe8f2;
        }

        .divider span {
            background: white;
            padding: 0 15px;
            color: #999;
            font-size: 13px;
            position: relative;
            z-index: 1;
        }

        .register-link {
            text-align: center;
            font-size: 13px;
            color: #666;
        }

        .register-link a {
            color: #ff6b9d;
            text-decoration: none;
            font-weight: 700;
            transition: opacity 0.3s;
        }

        .register-link a:hover {
            opacity: 0.8;
        }

        .alert {
            padding: 15px 20px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            gap: 12px;
            margin-bottom: 20px;
            animation: slideDown 0.3s ease;
        }

        @keyframes slideDown {
            from {
                transform: translateY(-10px);
                opacity: 0;
            }

            to {
                transform: translateY(0);
                opacity: 1;
            }
        }

        .alert-success {
            background: #d4edda;
            color: #155724;
            border-left: 4px solid #28a745;
        }

        .alert-danger {
            background: #f8d7da;
            color: #721c24;
            border-left: 4px solid #dc3545;
        }

        .alert i {
            font-size: 18px;
        }

        .info-box {
            background: #fff3e0;
            border-left: 4px solid #ff9800;
            padding: 15px;
            border-radius: 8px;
            margin-top: 20px;
            font-size: 13px;
            color: #e65100;
        }

        .info-box i {
            margin-right: 8px;
        }

        .info-box strong {
            display: block;
            margin-bottom: 5px;
        }
    </style>
</head>

<body>
    <div class="header">
        <div class="logo-container">
            <div class="logo-icon">
                <i class="fas fa-heartbeat"></i>
            </div>
            <h1>SIKASIH</h1>
            <p>Sistem Informasi Konsultasi Ibu Hamil</p>
        </div>
    </div>

    <div class="content">
        <div class="login-card">
            <div class="welcome-text">
                <h2>Selamat Datang Kembali!</h2>
                <p>Silakan masuk untuk melanjutkan konsultasi</p>
            </div>

            @if (session('success'))
                <div class="alert alert-success">
                    <i class="fas fa-check-circle"></i>
                    <span>{{ session('success') }}</span>
                </div>
            @endif

            @if ($errors->any())
                <div class="alert alert-danger">
                    <i class="fas fa-exclamation-circle"></i>
                    <span>{{ $errors->first() }}</span>
                </div>
            @endif

            <form action="{{ route('login') }}" method="POST" id="loginForm">
                @csrf

                <div class="form-group">
                    <label class="form-label">Email</label>
                    <div class="input-group-custom">
                        <i class="fas fa-envelope input-icon"></i>
                        <input type="email" name="email" class="form-control" placeholder="Masukkan email Anda"
                            value="{{ old('email') }}" required autofocus>
                    </div>
                </div>

                <div class="form-group">
                    <label class="form-label">Password</label>
                    <div class="input-group-custom">
                        <i class="fas fa-lock input-icon"></i>
                        <input type="password" name="password" id="password" class="form-control"
                            placeholder="Masukkan password Anda" required>
                        <i class="fas fa-eye password-toggle" id="togglePassword"></i>
                    </div>
                </div>

                <div class="remember-forgot">
                    <div class="remember-me">
                        <input type="checkbox" name="remember" id="remember">
                        <label for="remember">Ingat Saya</label>
                    </div>
                    <a href="#" class="forgot-password">Lupa Password?</a>
                </div>

                <button type="submit" class="login-btn" id="loginBtn">
                    <i class="fas fa-sign-in-alt"></i> Masuk
                </button>
            </form>

            <div class="divider">
                <span>Belum punya akun?</span>
            </div>

            <div class="register-link">
                Daftar sebagai ibu hamil <a href="{{ route('register') }}">di sini</a>
            </div>

            <div class="info-box">
                <i class="fas fa-info-circle"></i>
                <strong>Informasi</strong>
                Halaman ini khusus untuk ibu hamil. Admin dan staff silakan login melalui panel admin.
            </div>
        </div>
    </div>

    <script>
        // Toggle password visibility
        const togglePassword = document.getElementById('togglePassword');
        const password = document.getElementById('password');

        togglePassword.addEventListener('click', function() {
            const type = password.getAttribute('type') === 'password' ? 'text' : 'password';
            password.setAttribute('type', type);
            this.classList.toggle('fa-eye');
            this.classList.toggle('fa-eye-slash');
        });

        // Form submission with loading state
        document.getElementById('loginForm').addEventListener('submit', function() {
            const loginBtn = document.getElementById('loginBtn');
            loginBtn.disabled = true;
            loginBtn.innerHTML = '<span class="loading-spinner"></span> Memproses...';
        });
    </script>
</body>

</html>

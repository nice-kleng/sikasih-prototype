<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Pendaftaran Ibu Hamil - SIKASIH</title>
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
            padding: 20px;
            color: white;
            box-shadow: 0 2px 10px rgba(255, 107, 157, 0.3);
            position: sticky;
            top: 0;
            z-index: 100;
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
            transform: scale(1.05);
        }

        .header-title {
            flex: 1;
        }

        .header h1 {
            font-size: 18px;
            font-weight: 700;
            margin: 0;
        }

        .header p {
            font-size: 12px;
            margin: 5px 0 0 0;
            opacity: 0.9;
        }

        .content {
            padding: 20px;
            padding-bottom: 100px;
        }

        .welcome-card {
            background: white;
            border-radius: 15px;
            padding: 20px;
            margin-bottom: 20px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.08);
            text-align: center;
        }

        .welcome-icon {
            width: 80px;
            height: 80px;
            background: linear-gradient(135deg, #ffe8f2 0%, #ffeef8 100%);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 15px;
        }

        .welcome-icon i {
            font-size: 40px;
            color: #ff6b9d;
        }

        .welcome-card h3 {
            color: #ff6b9d;
            font-size: 18px;
            font-weight: 700;
            margin-bottom: 10px;
        }

        .welcome-card p {
            color: #666;
            font-size: 13px;
            line-height: 1.6;
            margin: 0;
        }

        .section-card {
            background: white;
            border-radius: 15px;
            padding: 20px;
            margin-bottom: 20px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.08);
        }

        .section-title {
            color: #ff6b9d;
            font-size: 15px;
            font-weight: 700;
            margin-bottom: 20px;
            padding-bottom: 12px;
            border-bottom: 2px solid #ffe8f2;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .section-title i {
            font-size: 18px;
        }

        .form-group {
            margin-bottom: 18px;
        }

        .form-label {
            font-size: 13px;
            font-weight: 600;
            color: #333;
            margin-bottom: 8px;
            display: block;
        }

        .form-label .required {
            color: #ff6b9d;
            margin-left: 3px;
            font-weight: 700;
        }

        .form-control,
        .form-select {
            width: 100%;
            padding: 12px 15px;
            border: 2px solid #ffe8f2;
            border-radius: 10px;
            font-size: 14px;
            transition: all 0.3s;
            background: #fff;
            color: #333;
        }

        .form-control:focus,
        .form-select:focus {
            outline: none;
            border-color: #ff6b9d;
            box-shadow: 0 0 0 4px rgba(255, 107, 157, 0.1);
        }

        .form-control.is-invalid {
            border-color: #dc3545;
        }

        .invalid-feedback {
            color: #dc3545;
            font-size: 12px;
            margin-top: 5px;
            display: block;
        }

        .form-control::placeholder {
            color: #999;
            font-size: 13px;
        }

        textarea.form-control {
            min-height: 80px;
            resize: vertical;
        }

        .radio-group {
            display: flex;
            gap: 15px;
            flex-wrap: wrap;
        }

        .radio-item {
            display: flex;
            align-items: center;
            gap: 8px;
            padding: 10px 15px;
            background: #f8f9fa;
            border-radius: 8px;
            border: 2px solid transparent;
            cursor: pointer;
            transition: all 0.3s;
        }

        .radio-item:hover {
            background: #ffe8f2;
            border-color: #ffcce0;
        }

        .radio-item input[type="radio"] {
            width: 18px;
            height: 18px;
            accent-color: #ff6b9d;
            cursor: pointer;
        }

        .radio-item label {
            cursor: pointer;
            font-size: 13px;
            color: #333;
            margin: 0;
        }

        .row-group {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 15px;
        }

        .submit-section {
            position: fixed;
            bottom: 0;
            left: 50%;
            transform: translateX(-50%);
            max-width: 480px;
            width: 100%;
            background: white;
            padding: 15px 20px;
            box-shadow: 0 -4px 15px rgba(0, 0, 0, 0.1);
            z-index: 99;
        }

        .submit-btn {
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

        .submit-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(255, 107, 157, 0.3);
        }

        .submit-btn:disabled {
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

        .alert-danger {
            background: #f8d7da;
            color: #721c24;
            border-left: 4px solid #dc3545;
        }

        .alert i {
            font-size: 18px;
        }

        .helper-text {
            margin-bottom: 15px;
            background: #fff3e0;
            padding: 10px;
            border-radius: 8px;
            color: #e65100;
            font-size: 12px;
        }

        .helper-text i {
            margin-right: 5px;
        }

        .login-link {
            text-align: center;
            margin-top: 15px;
            font-size: 13px;
            color: #666;
        }

        .login-link a {
            color: #ff6b9d;
            text-decoration: none;
            font-weight: 700;
        }
    </style>
</head>

<body>
    <div class="header">
        <div class="header-content">
            <a href="{{ route('login') }}" class="back-btn">
                <i class="fas fa-arrow-left"></i>
            </a>
            <div class="header-title">
                <h1>Pendaftaran Ibu Hamil</h1>
                <p>Lengkapi data untuk konsultasi</p>
            </div>
        </div>
    </div>

    <div class="content">
        <div class="welcome-card">
            <div class="welcome-icon">
                <i class="fas fa-clipboard-list"></i>
            </div>
            <h3>Selamat Datang di SIKASIH</h3>
            <p>Silakan lengkapi formulir pendaftaran di bawah ini untuk memulai konsultasi kehamilan dengan bidan kami.
            </p>
        </div>

        @if ($errors->any())
            <div class="alert alert-danger">
                <i class="fas fa-exclamation-circle"></i>
                <div>
                    <strong>Terdapat kesalahan:</strong>
                    <ul style="margin: 5px 0 0 0; padding-left: 20px;">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
        @endif

        <form action="{{ route('register') }}" method="POST" id="registrationForm">
            @csrf

            <div class="section-card">
                <h2 class="section-title">
                    <i class="fas fa-user-circle"></i>
                    Data Akun
                </h2>

                <div class="form-group">
                    <label class="form-label">Email <span class="required">*</span></label>
                    <input type="email" name="email" class="form-control @error('email') is-invalid @enderror"
                        placeholder="email@example.com" value="{{ old('email') }}" required>
                    @error('email')
                        <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label class="form-label">Password <span class="required">*</span></label>
                    <input type="password" name="password" class="form-control @error('password') is-invalid @enderror"
                        placeholder="Minimal 8 karakter" required>
                    @error('password')
                        <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label class="form-label">Konfirmasi Password <span class="required">*</span></label>
                    <input type="password" name="password_confirmation" class="form-control"
                        placeholder="Ulangi password" required>
                </div>
            </div>

            <div class="section-card">
                <h2 class="section-title">
                    <i class="fas fa-user-circle"></i>
                    Data Pribadi Ibu
                </h2>

                <div class="form-group">
                    <label class="form-label">Nama Lengkap <span class="required">*</span></label>
                    <input type="text" name="nama_lengkap"
                        class="form-control @error('nama_lengkap') is-invalid @enderror" placeholder="Nama lengkap ibu"
                        value="{{ old('nama_lengkap') }}" required>
                    @error('nama_lengkap')
                        <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label class="form-label">NIK <span class="required">*</span></label>
                    <input type="text" name="nik" class="form-control @error('nik') is-invalid @enderror"
                        placeholder="16 digit NIK" maxlength="16" value="{{ old('nik') }}" required>
                    @error('nik')
                        <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label class="form-label">Tanggal Lahir <span class="required">*</span></label>
                    <input type="date" name="tanggal_lahir"
                        class="form-control @error('tanggal_lahir') is-invalid @enderror"
                        value="{{ old('tanggal_lahir') }}" required>
                    @error('tanggal_lahir')
                        <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label class="form-label">Alamat Lengkap <span class="required">*</span></label>
                    <textarea name="alamat_lengkap" class="form-control @error('alamat_lengkap') is-invalid @enderror"
                        placeholder="Alamat lengkap sesuai KTP" required>{{ old('alamat_lengkap') }}</textarea>
                    @error('alamat_lengkap')
                        <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>

                <div class="row-group">
                    <div class="form-group">
                        <label class="form-label">Kelurahan <span class="required">*</span></label>
                        <input type="text" name="kelurahan"
                            class="form-control @error('kelurahan') is-invalid @enderror" placeholder="Kelurahan"
                            value="{{ old('kelurahan') }}" required>
                        @error('kelurahan')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label class="form-label">Kecamatan <span class="required">*</span></label>
                        <input type="text" name="kecamatan"
                            class="form-control @error('kecamatan') is-invalid @enderror" placeholder="Kecamatan"
                            value="{{ old('kecamatan') }}" required>
                        @error('kecamatan')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <div class="form-group">
                    <label class="form-label">Nomor Telepon/WhatsApp <span class="required">*</span></label>
                    <input type="tel" name="no_telp" class="form-control @error('no_telp') is-invalid @enderror"
                        placeholder="08xxxxxxxxxx" value="{{ old('no_telp') }}" required>
                    @error('no_telp')
                        <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label class="form-label">Golongan Darah</label>
                    <select name="golongan_darah" class="form-select @error('golongan_darah') is-invalid @enderror">
                        <option value="">Pilih Golongan Darah</option>
                        <option value="A" {{ old('golongan_darah') == 'A' ? 'selected' : '' }}>A</option>
                        <option value="B" {{ old('golongan_darah') == 'B' ? 'selected' : '' }}>B</option>
                        <option value="AB" {{ old('golongan_darah') == 'AB' ? 'selected' : '' }}>AB</option>
                        <option value="O" {{ old('golongan_darah') == 'O' ? 'selected' : '' }}>O</option>
                        <option value="Tidak Tahu" {{ old('golongan_darah') == 'Tidak Tahu' ? 'selected' : '' }}>Tidak
                            Tahu</option>
                    </select>
                </div>

                <div class="form-group">
                    <label class="form-label">Pendidikan Terakhir <span class="required">*</span></label>
                    <select name="pendidikan_terakhir"
                        class="form-select @error('pendidikan_terakhir') is-invalid @enderror" required>
                        <option value="">Pilih Pendidikan</option>
                        <option value="SD" {{ old('pendidikan_terakhir') == 'SD' ? 'selected' : '' }}>SD</option>
                        <option value="SMP" {{ old('pendidikan_terakhir') == 'SMP' ? 'selected' : '' }}>SMP
                        </option>
                        <option value="SMA/SMK" {{ old('pendidikan_terakhir') == 'SMA/SMK' ? 'selected' : '' }}>
                            SMA/SMK</option>
                        <option value="D3" {{ old('pendidikan_terakhir') == 'D3' ? 'selected' : '' }}>D3</option>
                        <option value="S1" {{ old('pendidikan_terakhir') == 'S1' ? 'selected' : '' }}>S1</option>
                        <option value="S2" {{ old('pendidikan_terakhir') == 'S2' ? 'selected' : '' }}>S2</option>
                        <option value="S3" {{ old('pendidikan_terakhir') == 'S3' ? 'selected' : '' }}>S3</option>
                    </select>
                    @error('pendidikan_terakhir')
                        <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label class="form-label">Pekerjaan</label>
                    <input type="text" name="pekerjaan" class="form-control" placeholder="Pekerjaan ibu"
                        value="{{ old('pekerjaan') }}">
                </div>

                <div class="form-group">
                    <label class="form-label">Status Pernikahan <span class="required">*</span></label>
                    <select name="status_pernikahan"
                        class="form-select @error('status_pernikahan') is-invalid @enderror" required>
                        <option value="">Pilih Status</option>
                        <option value="Menikah" {{ old('status_pernikahan') == 'Menikah' ? 'selected' : '' }}>Menikah
                        </option>
                        <option value="Belum Menikah"
                            {{ old('status_pernikahan') == 'Belum Menikah' ? 'selected' : '' }}>Belum Menikah</option>
                        <option value="Janda" {{ old('status_pernikahan') == 'Janda' ? 'selected' : '' }}>Janda
                        </option>
                    </select>
                    @error('status_pernikahan')
                        <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            <div class="section-card">
                <h2 class="section-title">
                    <i class="fas fa-user-friends"></i>
                    Data Suami
                </h2>

                <div class="form-group">
                    <label class="form-label">Nama Suami <span class="required">*</span></label>
                    <input type="text" name="nama_suami"
                        class="form-control @error('nama_suami') is-invalid @enderror"
                        placeholder="Nama lengkap suami" value="{{ old('nama_suami') }}" required>
                    @error('nama_suami')
                        <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>

                <div class="row-group">
                    <div class="form-group">
                        <label class="form-label">Umur Suami</label>
                        <input type="number" name="umur_suami" class="form-control" placeholder="Tahun"
                            min="18" max="80" value="{{ old('umur_suami') }}">
                    </div>

                    <div class="form-group">
                        <label class="form-label">Pendidikan Suami</label>
                        <select name="pendidikan_suami" class="form-select">
                            <option value="">Pilih Pendidikan</option>
                            <option value="SD" {{ old('pendidikan_suami') == 'SD' ? 'selected' : '' }}>SD</option>
                            <option value="SMP" {{ old('pendidikan_suami') == 'SMP' ? 'selected' : '' }}>SMP
                            </option>
                            <option value="SMA/SMK" {{ old('pendidikan_suami') == 'SMA/SMK' ? 'selected' : '' }}>
                                SMA/SMK</option>
                            <option value="D3" {{ old('pendidikan_suami') == 'D3' ? 'selected' : '' }}>D3</option>
                            <option value="S1" {{ old('pendidikan_suami') == 'S1' ? 'selected' : '' }}>S1</option>
                            <option value="S2" {{ old('pendidikan_suami') == 'S2' ? 'selected' : '' }}>S2</option>
                            <option value="S3" {{ old('pendidikan_suami') == 'S3' ? 'selected' : '' }}>S3</option>
                        </select>
                    </div>
                </div>

                <div class="form-group">
                    <label class="form-label">Pekerjaan Suami <span class="required">*</span></label>
                    <input type="text" name="pekerjaan_suami"
                        class="form-control @error('pekerjaan_suami') is-invalid @enderror"
                        placeholder="Pekerjaan suami" value="{{ old('pekerjaan_suami') }}" required>
                    @error('pekerjaan_suami')
                        <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label class="form-label">Peserta/Memiliki Kartu BPJS</label>
                    <div class="radio-group">
                        <div class="radio-item">
                            <input type="radio" name="is_has_bpjs" id="bpjs_ya" value="1"
                                {{ old('is_has_bpjs') == '1' ? 'checked' : '' }}>
                            <label for="bpjs_ya">Ya, Punya</label>
                        </div>
                        <div class="radio-item">
                            <input type="radio" name="is_has_bpjs" id="bpjs_tidak" value="0"
                                {{ old('is_has_bpjs', '0') == '0' ? 'checked' : '' }}>
                            <label for="bpjs_tidak">Tidak Punya</label>
                        </div>
                    </div>
                </div>
            </div>

            <div class="login-link">
                Sudah punya akun? <a href="{{ route('login') }}">Login di sini</a>
            </div>
        </form>
    </div>

    <div class="submit-section">
        <button type="submit" form="registrationForm" class="submit-btn" id="submitBtn">
            <i class="fas fa-paper-plane"></i> Kirim Pendaftaran
        </button>
    </div>

    <script>
        // Only number input for NIK
        document.querySelector('input[name="nik"]').addEventListener('input', function(e) {
            this.value = this.value.replace(/\D/g, '').slice(0, 16);
        });
    </script>
</body>

@extends('layouts.app')

@section('title', 'Pendaftaran - SIKASIH')

@push('styles')
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
            font-size: 14px;
            color: #333;
            cursor: pointer;
            margin: 0;
        }

        .radio-item input[type="radio"]:checked+label {
            color: #ff6b9d;
            font-weight: 600;
        }

        .submit-section {
            position: fixed;
            bottom: 0;
            left: 50%;
            transform: translateX(-50%);
            max-width: 480px;
            width: 100%;
            background: white;
            box-shadow: 0 -4px 15px rgba(0, 0, 0, 0.1);
            padding: 15px 20px;
            z-index: 99;
            border-radius: 20px 20px 0 0;
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
            box-shadow: 0 4px 15px rgba(255, 107, 157, 0.3);
        }

        .submit-btn:hover:not(:disabled) {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(255, 107, 157, 0.4);
        }

        .submit-btn:disabled {
            opacity: 0.6;
            cursor: not-allowed;
        }

        .alert {
            border-radius: 12px;
            padding: 15px;
            margin-bottom: 20px;
            border: none;
            font-size: 14px;
            display: flex;
            align-items: center;
            gap: 12px;
            animation: slideDown 0.3s ease;
        }

        @keyframes slideDown {
            from {
                opacity: 0;
                transform: translateY(-20px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .alert-success {
            background: #d4edda;
            color: #155724;
        }

        .alert-danger {
            background: #f8d7da;
            color: #721c24;
        }

        .alert i {
            font-size: 20px;
        }

        .info-box {
            background: linear-gradient(135deg, #e3f2fd 0%, #f0f7ff 100%);
            border-left: 4px solid #2196F3;
            padding: 15px;
            border-radius: 10px;
            margin-bottom: 20px;
            font-size: 13px;
            color: #0c5460;
            line-height: 1.6;
        }

        .info-box i {
            margin-right: 8px;
            color: #2196F3;
        }

        .loading-spinner {
            display: inline-block;
            width: 20px;
            height: 20px;
            border: 3px solid rgba(255, 255, 255, .3);
            border-radius: 50%;
            border-top-color: white;
            animation: spin 1s ease-in-out infinite;
        }

        @keyframes spin {
            to {
                transform: rotate(360deg);
            }
        }

        .row-group {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 15px;
        }

        @media (max-width: 400px) {
            .row-group {
                grid-template-columns: 1fr;
            }
        }

        .input-icon {
            position: relative;
        }

        .input-icon i {
            position: absolute;
            left: 15px;
            top: 50%;
            transform: translateY(-50%);
            color: #999;
            font-size: 16px;
        }

        .input-icon .form-control {
            padding-left: 45px;
        }

        .helper-text {
            font-size: 11px;
            color: #666;
            margin-top: 5px;
            display: flex;
            align-items: center;
            gap: 5px;
        }

        .helper-text i {
            font-size: 10px;
        }

        .progress-bar-container {
            background: #f0f0f0;
            height: 4px;
            border-radius: 2px;
            overflow: hidden;
            margin-bottom: 20px;
        }

        .progress-bar-fill {
            height: 100%;
            background: linear-gradient(90deg, #ff6b9d 0%, #ff8fab 100%);
            width: 0%;
            transition: width 0.3s ease;
        }
    </style>
@endpush

@section('content')

    <div id="alertBox"></div>

    <div class="header">
        <div class="header-content">
            {{-- <button class="back-btn" onclick="window.location.href='index.html'">
                <i class="fas fa-arrow-left"></i>
            </button> --}}
            <a href="{{ route('home') }}" class="back-btn"><i class="fas fa-arrow-left"></i></a>
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
            <p>Silakan lengkapi formulir pendaftaran di bawah ini untuk memulai konsultasi kehamilan dengan bidan kami.</p>
        </div>

        <form id="registrationForm">
            <div class="section-card">
                <h2 class="section-title">
                    <i class="fas fa-user-circle"></i>
                    Data Pribadi Ibu
                </h2>

                <div class="form-group">
                    <label class="form-label">Nama Lengkap <span class="required">*</span></label>
                    <input type="text" name="nama" class="form-control" placeholder="Nama lengkap ibu" required>
                </div>

                <div class="form-group">
                    <label class="form-label">NIK <span class="required">*</span></label>
                    <input type="text" name="nik" class="form-control" placeholder="16 digit NIK" maxlength="16"
                        required>
                </div>

                <div class="row-group">
                    <div class="form-group">
                        <label class="form-label">Tanggal Lahir <span class="required">*</span></label>
                        <input type="date" name="tanggal_lahir" class="form-control" onchange="calculateAge()" required>
                    </div>

                    <div class="form-group">
                        <label class="form-label">Umur</label>
                        <input type="number" id="umur" name="umur" class="form-control" placeholder="Tahun"
                            readonly>
                    </div>
                </div>

                <div class="form-group">
                    <label class="form-label">Alamat Lengkap <span class="required">*</span></label>
                    <textarea name="alamat" class="form-control" placeholder="Alamat lengkap sesuai KTP" required></textarea>
                </div>

                <div class="form-group">
                    <label class="form-label">Nomor Telepon/WhatsApp <span class="required">*</span></label>
                    <input type="tel" name="no_telepon" class="form-control" placeholder="08xxxxxxxxxx" required>
                </div>

                <div class="form-group">
                    <label class="form-label">Golongan Darah</label>
                    <select name="golongan_darah" class="form-select">
                        <option value="">Pilih Golongan Darah</option>
                        <option value="A">A</option>
                        <option value="B">B</option>
                        <option value="AB">AB</option>
                        <option value="O">O</option>
                        <option value="Tidak Tahu">Tidak Tahu</option>
                    </select>
                </div>

                <div class="form-group">
                    <label class="form-label">Pendidikan Terakhir</label>
                    <select name="pendidikan" class="form-select">
                        <option value="">Pilih Pendidikan</option>
                        <option value="SD">SD</option>
                        <option value="SMP">SMP</option>
                        <option value="SMA/SMK">SMA/SMK</option>
                        <option value="D3">D3</option>
                        <option value="S1">S1</option>
                        <option value="S2">S2</option>
                        <option value="S3">S3</option>
                    </select>
                </div>

                <div class="form-group">
                    <label class="form-label">Pekerjaan</label>
                    <input type="text" name="pekerjaan" class="form-control" placeholder="Pekerjaan ibu">
                </div>
            </div>

            <div class="section-card">
                <h2 class="section-title">
                    <i class="fas fa-user-friends"></i>
                    Data Suami
                </h2>

                <div class="form-group">
                    <label class="form-label">Nama Suami <span class="required">*</span></label>
                    <input type="text" name="nama_suami" class="form-control" placeholder="Nama lengkap suami" required>
                </div>

                <div class="row-group">
                    <div class="form-group">
                        <label class="form-label">Umur Suami</label>
                        <input type="number" name="umur_suami" class="form-control" placeholder="Tahun" min="18"
                            max="80">
                    </div>

                    <div class="form-group">
                        <label class="form-label">Pendidikan Suami</label>
                        <select name="pendidikan_suami" class="form-select">
                            <option value="">Pilih Pendidikan</option>
                            <option value="SD">SD</option>
                            <option value="SMP">SMP</option>
                            <option value="SMA/SMK">SMA/SMK</option>
                            <option value="D3">D3</option>
                            <option value="S1">S1</option>
                            <option value="S2">S2</option>
                            <option value="S3">S3</option>
                        </select>
                    </div>
                </div>

                <div class="form-group">
                    <label class="form-label">Pekerjaan Suami <span class="required">*</span></label>
                    <input type="text" name="pekerjaan_suami" class="form-control" placeholder="Pekerjaan suami"
                        required>
                </div>

                <div class="form-group">
                    <label class="form-label">Peserta/Memiliki Kartu BPJS</label>
                    <div class="radio-group">
                        <div class="radio-item">
                            <input type="radio" name="bpjs" id="bpjs_ya" value="Ya">
                            <label for="bpjs_ya">Ya, Punya</label>
                        </div>
                        <div class="radio-item">
                            <input type="radio" name="bpjs" id="bpjs_tidak" value="Tidak" checked>
                            <label for="bpjs_tidak">Tidak Punya</label>
                        </div>
                    </div>
                </div>
            </div>

            <div class="section-card">
                <h2 class="section-title">
                    <i class="fas fa-heartbeat"></i>
                    Data Reproduksi & Kehamilan
                </h2>

                <div class="row-group">
                    <div class="form-group">
                        <label class="form-label">Usia Saat Menikah Pertama</label>
                        <input type="number" name="usia_menikah" class="form-control" placeholder="Tahun"
                            min="16" max="50">
                    </div>

                    <div class="form-group">
                        <label class="form-label">Usia Saat Hamil Pertama</label>
                        <input type="number" name="usia_hamil_pertama" class="form-control" placeholder="Tahun"
                            min="16" max="50">
                    </div>
                </div>

                <div class="row-group">
                    <div class="form-group">
                        <label class="form-label">Jumlah Kehamilan (G) <span class="required">*</span></label>
                        <input type="number" name="gravida" class="form-control" placeholder="Gravida" min="1"
                            max="20" required>
                    </div>

                    <div class="form-group">
                        <label class="form-label">Jumlah Persalinan (P) <span class="required">*</span></label>
                        <input type="number" name="para" class="form-control" placeholder="Para" min="0"
                            max="20" required>
                    </div>
                </div>

                <div class="row-group">
                    <div class="form-group">
                        <label class="form-label">Jumlah Anak Hidup (A)</label>
                        <input type="number" name="anak_hidup" class="form-control" placeholder="Abortus"
                            min="0" max="20">
                    </div>

                    <div class="form-group">
                        <label class="form-label">Jumlah Keguguran (Ab)</label>
                        <input type="number" name="keguguran" class="form-control" placeholder="0" min="0"
                            max="10">
                    </div>
                </div>

                <div class="helper-text">
                    <i class="fas fa-lightbulb"></i>
                    <span><strong>Contoh:</strong> G2P1A1Ab0 artinya hamil ke-2, pernah melahirkan 1 kali, punya 1 anak
                        hidup, tidak pernah keguguran</span>
                </div>

                <div class="form-group">
                    <label class="form-label">Riwayat Persalinan Sebelumnya</label>
                    <textarea name="riwayat_persalinan" class="form-control"
                        placeholder="Contoh: Persalinan normal, berat bayi 3.2 kg, tidak ada komplikasi"></textarea>
                </div>

                <div class="form-group">
                    <label class="form-label">Jarak Antar Kehamilan Terakhir</label>
                    <input type="text" name="jarak_kehamilan" class="form-control"
                        placeholder="Contoh: 2 tahun 6 bulan">
                </div>

                <div class="form-group">
                    <label class="form-label">Riwayat Komplikasi Kehamilan Sebelumnya</label>
                    <textarea name="riwayat_komplikasi" class="form-control"
                        placeholder="Jelaskan jika pernah mengalami komplikasi seperti preeklampsia, perdarahan, dll. Kosongkan jika tidak ada."></textarea>
                </div>
            </div>
        </form>
    </div>

    <div class="submit-section">
        <button type="submit" form="registrationForm" class="submit-btn" id="submitBtn">
            <i class="fas fa-paper-plane"></i> Kirim Pendaftaran
        </button>
    </div>
@endsection

@push('scripts')
    <script>
        function calculateAge() {
            const birthDate = new Date(document.querySelector('input[name="tanggal_lahir"]').value);
            const today = new Date();
            let age = today.getFullYear() - birthDate.getFullYear();
            const monthDiff = today.getMonth() - birthDate.getMonth();

            if (monthDiff < 0 || (monthDiff === 0 && today.getDate() < birthDate.getDate())) {
                age--;
            }

            document.getElementById('umur').value = age > 0 ? age : '';
        }

        function showAlert(message, type = 'success') {
            const alertBox = document.getElementById('alertBox');
            const icon = type === 'success' ? 'check-circle' : 'exclamation-circle';
            alertBox.innerHTML = `
                <div class="alert alert-${type}">
                    <i class="fas fa-${icon}"></i>
                    <span>${message}</span>
                </div>
            `;

            setTimeout(() => {
                alertBox.innerHTML = '';
            }, 5000);

            window.scrollTo({
                top: 0,
                behavior: 'smooth'
            });
        }

        document.getElementById('registrationForm').addEventListener('submit', async function(e) {
            e.preventDefault();

            const submitBtn = document.getElementById('submitBtn');
            const originalText = submitBtn.innerHTML;

            submitBtn.disabled = true;
            submitBtn.innerHTML = '<span class="loading-spinner"></span> Mengirim data...';

            const formData = new FormData(this);
            const data = {};
            formData.forEach((value, key) => {
                data[key] = value;
            });

            try {
                await new Promise(resolve => setTimeout(resolve, 1500));

                const savedData = JSON.parse(localStorage.getItem('pregnancyRegistrations') || '[]');
                data.id = Date.now();
                data.tanggal_daftar = new Date().toISOString();
                savedData.push(data);
                localStorage.setItem('pregnancyRegistrations', JSON.stringify(savedData));

                showAlert(
                    '🎉 Pendaftaran berhasil! Data Anda telah tersimpan. Silakan tunggu konfirmasi dari bidan kami.',
                    'success');
                this.reset();

                setTimeout(() => {
                    window.scrollTo({
                        top: 0,
                        behavior: 'smooth'
                    });
                }, 500);

            } catch (error) {
                showAlert('❌ Terjadi kesalahan saat mengirim data. Silakan coba lagi atau hubungi admin.',
                    'danger');
            } finally {
                submitBtn.disabled = false;
                submitBtn.innerHTML = originalText;
            }
        });

        document.querySelector('input[name="nik"]').addEventListener('input', function(e) {
            this.value = this.value.replace(/[^0-9]/g, '');
        });

        document.querySelector('input[name="no_telepon"]').addEventListener('input', function(e) {
            this.value = this.value.replace(/[^0-9]/g, '');
        });

        document.querySelector('input[name="no_telepon"]').addEventListener('blur', function(e) {
            if (this.value.length > 0 && this.value.length < 10) {
                showAlert('Nomor telepon minimal 10 digit', 'danger');
                this.focus();
            }
        });
    </script>
@endpush

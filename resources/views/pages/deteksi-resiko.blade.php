@extends('layouts.app')

@section('title', 'Deteksi Risiko Kehamilan - SIKASIH')

@section('content')
    @push('styles')
        <style>
            .alert {
                padding: 15px 20px;
                margin-bottom: 20px;
                border-radius: 12px;
                font-size: 14px;
                line-height: 1.6;
                display: flex;
                align-items: flex-start;
                gap: 10px;
                box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
            }

            .alert i {
                font-size: 18px;
                margin-top: 2px;
                flex-shrink: 0;
            }

            .alert-danger {
                background: #ffebee;
                border-left: 4px solid #f44336;
                color: #c62828;
            }

            .alert-warning {
                background: #fff3e0;
                border-left: 4px solid #ff9800;
                color: #e65100;
            }

            .alert-success {
                background: #e8f5e9;
                border-left: 4px solid #4caf50;
                color: #2e7d32;
            }

            .alert small {
                display: block;
                margin-top: 5px;
                opacity: 0.9;
            }

            .d-none {
                display: none !important;
            }

            .header {
                position: sticky;
                top: 0;
                z-index: 100;
                padding: 20px;
            }

            .header-content {
                display: flex;
                align-items: center;
                gap: 15px;
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

            .header h1 {
                font-size: 18px;
                font-weight: 700;
                margin: 0;
            }

            .content {
                padding-bottom: 180px;
            }

            .info-card {
                background: white;
                border-radius: 15px;
                padding: 20px;
                margin-bottom: 20px;
                box-shadow: 0 2px 10px rgba(0, 0, 0, 0.08);
            }

            .info-card h3 {
                color: #ff6b9d;
                font-size: 16px;
                font-weight: 700;
                margin-bottom: 10px;
                display: flex;
                align-items: center;
                gap: 10px;
            }

            .info-card p {
                color: #666;
                font-size: 13px;
                line-height: 1.6;
                margin: 0;
            }

            .section-title {
                color: #333;
                font-size: 15px;
                font-weight: 700;
                margin: 25px 0 15px 0;
                padding-left: 10px;
                border-left: 4px solid #ff6b9d;
            }

            .section-card {
                background: white;
                border-radius: 15px;
                padding: 20px;
                margin-bottom: 20px;
                box-shadow: 0 2px 10px rgba(0, 0, 0, 0.08);
            }

            .risk-group {
                background: white;
                border-radius: 12px;
                padding: 15px;
                margin-bottom: 15px;
                box-shadow: 0 2px 8px rgba(0, 0, 0, 0.06);
            }

            .group-header {
                background: linear-gradient(135deg, #ff6b9d 0%, #ff8fab 100%);
                color: white;
                padding: 10px 15px;
                border-radius: 8px;
                font-weight: 700;
                font-size: 14px;
                margin-bottom: 15px;
                display: flex;
                align-items: center;
                gap: 10px;
            }

            .checkbox-item {
                display: flex;
                align-items: flex-start;
                gap: 12px;
                padding: 12px;
                border-radius: 8px;
                margin-bottom: 8px;
                transition: all 0.3s;
                border: 2px solid transparent;
            }

            .checkbox-item:hover {
                background: #fff5f9;
                border-color: #ffcce0;
            }

            .checkbox-item.checked {
                background: #ffe8f2;
                border-color: #ff6b9d;
            }

            .checkbox-item input[type="checkbox"] {
                width: 20px;
                height: 20px;
                cursor: pointer;
                accent-color: #ff6b9d;
                flex-shrink: 0;
                margin-top: 2px;
            }

            .checkbox-label {
                cursor: pointer;
                flex: 1;
                font-size: 13px;
                color: #333;
                line-height: 1.5;
            }

            .score-badge {
                background: #ff6b9d;
                color: white;
                padding: 4px 10px;
                border-radius: 20px;
                font-size: 12px;
                font-weight: 700;
                flex-shrink: 0;
            }

            .result-section {
                position: fixed;
                bottom: 60px;
                left: 50%;
                transform: translateX(-50%);
                max-width: 480px;
                width: 100%;
                background: white;
                box-shadow: 0 -4px 15px rgba(0, 0, 0, 0.1);
                padding: 20px;
                z-index: 99;
                border-radius: 20px 20px 0 0;
            }

            .total-score {
                display: flex;
                justify-content: space-between;
                align-items: center;
                margin-bottom: 15px;
            }

            .total-score span {
                font-size: 14px;
                color: #666;
                font-weight: 600;
            }

            .total-score .score {
                font-size: 28px;
                font-weight: 700;
                color: #ff6b9d;
            }

            .check-btn {
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

            .check-btn:hover {
                transform: translateY(-2px);
                box-shadow: 0 5px 15px rgba(255, 107, 157, 0.3);
            }

            .modal {
                display: none;
                position: fixed;
                top: 0;
                left: 50%;
                transform: translateX(-50%);
                max-width: 480px;
                width: 100%;
                height: 100%;
                background: rgba(0, 0, 0, 0.5);
                z-index: 1000;
                overflow-y: auto;
            }

            .modal.show {
                display: flex;
                align-items: center;
                justify-content: center;
            }

            .modal-content {
                background: white;
                border-radius: 20px;
                padding: 30px;
                margin: 20px;
                max-width: 400px;
                width: 90%;
                box-shadow: 0 10px 40px rgba(0, 0, 0, 0.2);
                animation: slideUp 0.3s ease;
            }

            @keyframes slideUp {
                from {
                    transform: translateY(50px);
                    opacity: 0;
                }

                to {
                    transform: translateY(0);
                    opacity: 1;
                }
            }

            .modal-icon {
                width: 80px;
                height: 80px;
                border-radius: 50%;
                display: flex;
                align-items: center;
                justify-content: center;
                margin: 0 auto 20px;
            }

            .modal-icon i {
                font-size: 40px;
            }

            .modal-icon.low-risk {
                background: linear-gradient(135deg, #4caf50 0%, #66bb6a 100%);
                color: white;
            }

            .modal-icon.medium-risk {
                background: linear-gradient(135deg, #ff9800 0%, #ffa726 100%);
                color: white;
            }

            .modal-icon.high-risk {
                background: linear-gradient(135deg, #f44336 0%, #ef5350 100%);
                color: white;
            }

            .modal-title {
                text-align: center;
                font-size: 20px;
                font-weight: 700;
                color: #333;
                margin-bottom: 15px;
            }

            .modal-score {
                text-align: center;
                font-size: 48px;
                font-weight: 700;
                color: #ff6b9d;
                margin-bottom: 10px;
            }

            .modal-category {
                text-align: center;
                font-size: 18px;
                font-weight: 700;
                padding: 10px 20px;
                border-radius: 25px;
                margin: 0 auto 25px;
                display: inline-block;
                width: 100%;
            }

            .modal-category.low-risk {
                background: #e8f5e9;
                color: #2e7d32;
            }

            .modal-category.medium-risk {
                background: #fff3e0;
                color: #e65100;
            }

            .modal-category.high-risk {
                background: #ffebee;
                color: #c62828;
            }

            .recommendation {
                margin: 25px 0;
            }

            .recommendation h4 {
                font-size: 15px;
                font-weight: 700;
                color: #ff6b9d;
                margin-bottom: 15px;
                display: flex;
                align-items: center;
                gap: 8px;
            }

            .recommendation ul {
                list-style: none;
                padding: 0;
                margin: 0;
            }

            .recommendation li {
                padding: 10px 0;
                border-bottom: 1px solid #f0f0f0;
                font-size: 13px;
                color: #666;
                line-height: 1.6;
                position: relative;
                padding-left: 25px;
            }

            .recommendation li:before {
                content: "✓";
                position: absolute;
                left: 0;
                color: #ff6b9d;
                font-weight: 700;
                font-size: 16px;
            }

            .recommendation li:last-child {
                border-bottom: none;
            }

            .close-modal-btn,
            .reset-btn {
                width: 100%;
                padding: 15px;
                border: none;
                border-radius: 12px;
                font-size: 15px;
                font-weight: 600;
                cursor: pointer;
                transition: all 0.3s;
                margin-top: 10px;
            }

            .close-modal-btn {
                background: linear-gradient(135deg, #ff6b9d 0%, #ff8fab 100%);
                color: white;
            }

            .reset-btn {
                background: #f5f5f5;
                color: #666;
            }

            .close-modal-btn:hover,
            .reset-btn:hover {
                transform: translateY(-2px);
                box-shadow: 0 5px 15px rgba(0, 0, 0, 0.15);
            }
        </style>
    @endpush

    <div class="header">
        <div class="header-content">
            <a class="back-btn" href="{{ route('dashboard') }}">
                <i class="fas fa-arrow-left"></i>
            </a>
            <h1>Deteksi Risiko Kehamilan</h1>
        </div>
    </div>

    <div class="content">
        <div id="saveAlert" class="alert alert-danger d-none" role="alert"></div>

        <!-- Alert untuk error validasi checkbox -->
        @if ($errors->has('checklist'))
            <div class="alert alert-warning" role="alert">
                <i class="fas fa-exclamation-triangle"></i>
                {{ $errors->first('checklist') }}
                <br><small>Jika tidak ada kondisi risiko yang sesuai, berarti ibu dalam kondisi <strong>Risiko
                        Rendah</strong>.</small>
            </div>
        @endif

        <div class="info-card">
            <h3><i class="fas fa-info-circle"></i> Petunjuk</h3>
            <p>Silakan pilih kondisi yang sesuai dengan kondisi ibu saat ini. Setiap kondisi memiliki skor risiko. Total
                skor akan menentukan tingkat risiko kehamilan dan rekomendasi tempat persalinan.</p>
        </div>

        <form id="deteksiForm" method="POST" action="{{ route('deteksi-risiko.store') }}">
            @csrf
            <input type="hidden" name="primigravida" value="1">

            <div class="section-card">
                <h2 class="section-title">
                    <i class="fas fa-heartbeat"></i>
                    Data Reproduksi & Kehamilan
                </h2>

                <div class="row-group">
                    <div class="form-group">
                        <label class="form-label">Usia Menikah Pertama</label>
                        <input type="number" name="usia_menikah" class="form-control" placeholder="Tahun" min="16"
                            max="50" value="{{ old('usia_menikah') }}">
                    </div>

                    <div class="form-group">
                        <label class="form-label">Usia Hamil Pertama</label>
                        <input type="number" name="usia_hamil_pertama" class="form-control" placeholder="Tahun"
                            min="16" max="50" value="{{ old('usia_hamil_pertama') }}">
                    </div>
                </div>

                <div class="row-group">
                    <div class="form-group">
                        <label class="form-label">Gravida (G) <span class="required">*</span></label>
                        <input type="number" name="gravida" class="form-control @error('gravida') is-invalid @enderror"
                            placeholder="Gravida" min="1" max="20" value="{{ old('gravida') }}" required>
                        @error('gravida')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label class="form-label">Para (P) <span class="required">*</span></label>
                        <input type="number" name="para" class="form-control @error('para') is-invalid @enderror"
                            placeholder="Para" min="0" max="20" value="{{ old('para') }}" required>
                        @error('para')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <div class="row-group">
                    <div class="form-group">
                        <label class="form-label">Anak Hidup (A)</label>
                        <input type="number" name="anak_hidup" class="form-control" placeholder="Abortus" min="0"
                            max="20" value="{{ old('anak_hidup') }}">
                    </div>

                    <div class="form-group">
                        <label class="form-label">Keguguran (Ab)</label>
                        <input type="number" name="keguguran" class="form-control" placeholder="0" min="0"
                            max="10" value="{{ old('keguguran') }}">
                    </div>
                </div>

                <div class="helper-text">
                    <i class="fas fa-lightbulb"></i>
                    <span><strong>Contoh:</strong> G2P1A1Ab0 artinya hamil ke-2, pernah melahirkan 1 kali, punya 1 anak
                        hidup, tidak pernah keguguran</span>
                </div>

                <div class="form-group">
                    <label class="form-label">Riwayat Persalinan Sebelumnya</label>
                    <select name="riwayat_persalinan" class="form-select @error('riwayat_persalinan') is-invalid @enderror">
                        <option value="">Pilih Jenis Persalinan</option>
                        <option value="Normal" {{ old('riwayat_persalinan') == 'Normal' ? 'selected' : '' }}>Normal
                        </option>
                        <option value="Operasi" {{ old('riwayat_persalinan') == 'Operasi' ? 'selected' : '' }}>Operasi
                        </option>
                        <option value="Tindakan Lainnya"
                            {{ old('riwayat_persalinan') == 'Tindakan Lainnya' ? 'selected' : '' }}>Tindakan Lainnya
                        </option>
                    </select>
                    @error('riwayat_persalinan')
                        <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                    <div class="helper-text">
                        <i class="fas fa-info-circle"></i>
                        <span>Lewati jika kehamilan pertama</span>
                    </div>
                </div>

                <div class="form-group">
                    <label class="form-label">Jarak Kehamilan Terakhir</label>
                    <input type="text" name="jarak_kehamilan" class="form-control" placeholder="Contoh: < 2th, > 2th"
                        value="{{ old('jarak_kehamilan') }}">
                </div>

                <div class="form-group">
                    <label class="form-label">Riwayat Komplikasi Kehamilan</label>
                    <textarea name="riwayat_komplikasi" class="form-control"
                        placeholder="Jelaskan jika pernah mengalami komplikasi. Kosongkan jika tidak ada.">{{ old('riwayat_komplikasi') }}</textarea>
                </div>
            </div>

            <div class="section-title">Kelompok Faktor Risiko I</div>
            <div class="risk-group">
                <div class="group-header">
                    <i class="fas fa-user-circle"></i> Status Dasar Ibu
                </div>

                <div class="checkbox-item {{ old('primigravida_anak_pertama') ? 'checked' : '' }}">
                    <input type="checkbox" name="primigravida_anak_pertama" value="1" data-score="2"
                        onchange="handleCheckboxChange(this)">
                    <div class="checkbox-label">Primigravida (hamil anak pertama)</div>
                    <span class="score-badge">2</span>
                </div>

                <div class="checkbox-item {{ old('primigravida_terlalu_muda') ? 'checked' : '' }}">
                    <input type="checkbox" name="primigravida_terlalu_muda" value="1" data-score="4"
                        onchange="handleCheckboxChange(this)" @checked(old('primigravida_terlalu_muda'))>
                    <div class="checkbox-label" onclick="toggleCheckFromLabel(this)">Primigravida terlalu muda, hamil ≤ 16
                        tahun</div>
                    <span class="score-badge">4</span>
                </div>

                <div class="checkbox-item {{ old('primigravida_terlalu_tua') ? 'checked' : '' }}">
                    <input type="checkbox" name="primigravida_terlalu_tua" value="1" data-score="4"
                        onchange="handleCheckboxChange(this)" @checked(old('primigravida_terlalu_tua'))>
                    <div class="checkbox-label" onclick="toggleCheckFromLabel(this)">Primigravida terlalu tua, hamil ≥ 35
                        tahun</div>
                    <span class="score-badge">4</span>
                </div>

                <div class="checkbox-item {{ old('primigravida_tua_sekunder') ? 'checked' : '' }}">
                    <input type="checkbox" name="primigravida_tua_sekunder" value="1" data-score="4"
                        onchange="handleCheckboxChange(this)" @checked(old('primigravida_tua_sekunder'))>
                    <div class="checkbox-label" onclick="toggleCheckFromLabel(this)">Primigravida tua sekunder, hamil I ≥
                        35 tahun, P ≥ 1</div>
                    <span class="score-badge">4</span>
                </div>

                <div class="checkbox-item {{ old('tinggi_badan_kurang_atau_sama_145') ? 'checked' : '' }}">
                    <input type="checkbox" name="tinggi_badan_kurang_atau_sama_145" value="1" data-score="4"
                        onchange="handleCheckboxChange(this)" @checked(old('tinggi_badan_kurang_atau_sama_145'))>
                    <div class="checkbox-label" onclick="toggleCheckFromLabel(this)">Tinggi badan ≤ 145 cm</div>
                    <span class="score-badge">4</span>
                </div>

                <div class="checkbox-item {{ old('pernah_gagal_kehamilan') ? 'checked' : '' }}">
                    <input type="checkbox" name="pernah_gagal_kehamilan" value="1" data-score="4"
                        onchange="handleCheckboxChange(this)" @checked(old('pernah_gagal_kehamilan'))>
                    <div class="checkbox-label" onclick="toggleCheckFromLabel(this)">Pernah gagal kehamilan</div>
                    <span class="score-badge">4</span>
                </div>

                <div class="checkbox-item {{ old('pernah_vakum_atau_forceps') ? 'checked' : '' }}">
                    <input type="checkbox" name="pernah_vakum_atau_forceps" value="1" data-score="4"
                        onchange="handleCheckboxChange(this)" @checked(old('pernah_vakum_atau_forceps'))>
                    <div class="checkbox-label" onclick="toggleCheckFromLabel(this)">Pernah melahirkan dengan tarikan
                        vakum/forceps</div>
                    <span class="score-badge">4</span>
                </div>

                <div class="checkbox-item {{ old('pernah_operasi_sesar') ? 'checked' : '' }}">
                    <input type="checkbox" name="pernah_operasi_sesar" value="1" data-score="4"
                        onchange="handleCheckboxChange(this)" @checked(old('pernah_operasi_sesar'))>
                    <div class="checkbox-label" onclick="toggleCheckFromLabel(this)">Pernah melahirkan dengan operasi
                        sesar</div>
                    <span class="score-badge">4</span>
                </div>
            </div>

            <div class="section-title">Kelompok Faktor Risiko II</div>
            <div class="risk-group">
                <div class="group-header">
                    <i class="fas fa-heartbeat"></i> Kondisi Medis & Kehamilan
                </div>

                <div class="checkbox-item {{ old('pernah_melahirkan_bblr') ? 'checked' : '' }}">
                    <input type="checkbox" name="pernah_melahirkan_bblr" value="1" data-score="4"
                        onchange="handleCheckboxChange(this)" @checked(old('pernah_melahirkan_bblr'))>
                    <div class="checkbox-label" onclick="toggleCheckFromLabel(this)">Pernah melahirkan bayi dengan berat
                        badan rendah &lt; 2500 gram</div>
                    <span class="score-badge">4</span>
                </div>

                <div class="checkbox-item {{ old('pernah_melahirkan_cacat_bawaan') ? 'checked' : '' }}">
                    <input type="checkbox" name="pernah_melahirkan_cacat_bawaan" value="1" data-score="4"
                        onchange="handleCheckboxChange(this)" @checked(old('pernah_melahirkan_cacat_bawaan'))>
                    <div class="checkbox-label" onclick="toggleCheckFromLabel(this)">Pernah melahirkan dengan cacat bawaan
                    </div>
                    <span class="score-badge">4</span>
                </div>

                <div class="checkbox-item {{ old('anemia_hb_kurang_11') ? 'checked' : '' }}">
                    <input type="checkbox" name="anemia_hb_kurang_11" value="1" data-score="4"
                        onchange="handleCheckboxChange(this)" @checked(old('anemia_hb_kurang_11'))>
                    <div class="checkbox-label" onclick="toggleCheckFromLabel(this)">Kurang gizi (anemia HB &lt; 11 g)
                    </div>
                    <span class="score-badge">4</span>
                </div>

                <div class="checkbox-item {{ old('riwayat_penyakit_kronis') ? 'checked' : '' }}">
                    <input type="checkbox" name="riwayat_penyakit_kronis" value="1" data-score="4"
                        onchange="handleCheckboxChange(this)" @checked(old('riwayat_penyakit_kronis'))>
                    <div class="checkbox-label" onclick="toggleCheckFromLabel(this)">Riwayat penyakit kronis (jantung,
                        paru, ginjal, dll)</div>
                    <span class="score-badge">4</span>
                </div>

                <div class="checkbox-item {{ old('riwayat_kelainan_obstetri_sebelumnya') ? 'checked' : '' }}">
                    <input type="checkbox" name="riwayat_kelainan_obstetri_sebelumnya" value="1" data-score="4"
                        onchange="handleCheckboxChange(this)" @checked(old('riwayat_kelainan_obstetri_sebelumnya'))>
                    <div class="checkbox-label" onclick="toggleCheckFromLabel(this)">Riwayat kelainan obstetri pada
                        kehamilan sebelumnya</div>
                    <span class="score-badge">4</span>
                </div>

                <div class="checkbox-item {{ old('anak_terkecil_kurang_2_tahun') ? 'checked' : '' }}">
                    <input type="checkbox" name="anak_terkecil_kurang_2_tahun" value="1" data-score="4"
                        onchange="handleCheckboxChange(this)" @checked(old('anak_terkecil_kurang_2_tahun'))>
                    <div class="checkbox-label" onclick="toggleCheckFromLabel(this)">Anak terkecil berumur &lt; 2 tahun
                    </div>
                    <span class="score-badge">4</span>
                </div>

                <div class="checkbox-item {{ old('hamil_kembar') ? 'checked' : '' }}">
                    <input type="checkbox" name="hamil_kembar" value="1" data-score="4"
                        onchange="handleCheckboxChange(this)" @checked(old('hamil_kembar'))>
                    <div class="checkbox-label" onclick="toggleCheckFromLabel(this)">Hamil kembar (gemelli)</div>
                    <span class="score-badge">4</span>
                </div>

                <div class="checkbox-item {{ old('hidramnion') ? 'checked' : '' }}">
                    <input type="checkbox" name="hidramnion" value="1" data-score="4"
                        onchange="handleCheckboxChange(this)" @checked(old('hidramnion'))>
                    <div class="checkbox-label" onclick="toggleCheckFromLabel(this)">Hamil kembar air (hidramnion)</div>
                    <span class="score-badge">4</span>
                </div>

                <div class="checkbox-item {{ old('bayi_mati_dalam_kandungan') ? 'checked' : '' }}">
                    <input type="checkbox" name="bayi_mati_dalam_kandungan" value="1" data-score="4"
                        onchange="handleCheckboxChange(this)" @checked(old('bayi_mati_dalam_kandungan'))>
                    <div class="checkbox-label" onclick="toggleCheckFromLabel(this)">Bayi mati dalam kandungan</div>
                    <span class="score-badge">4</span>
                </div>

                <div class="checkbox-item {{ old('kehamilan_lebih_bulan') ? 'checked' : '' }}">
                    <input type="checkbox" name="kehamilan_lebih_bulan" value="1" data-score="4"
                        onchange="handleCheckboxChange(this)" @checked(old('kehamilan_lebih_bulan'))>
                    <div class="checkbox-label" onclick="toggleCheckFromLabel(this)">Kehamilan lebih bulan</div>
                    <span class="score-badge">4</span>
                </div>

                <div class="checkbox-item {{ old('letak_sungsang') ? 'checked' : '' }}">
                    <input type="checkbox" name="letak_sungsang" value="1" data-score="8"
                        onchange="handleCheckboxChange(this)" @checked(old('letak_sungsang'))>
                    <div class="checkbox-label" onclick="toggleCheckFromLabel(this)">Letak sungsang</div>
                    <span class="score-badge">8</span>
                </div>

                <div class="checkbox-item {{ old('letak_lintang') ? 'checked' : '' }}">
                    <input type="checkbox" name="letak_lintang" value="1" data-score="8"
                        onchange="handleCheckboxChange(this)" @checked(old('letak_lintang'))>
                    <div class="checkbox-label" onclick="toggleCheckFromLabel(this)">Letak lintang</div>
                    <span class="score-badge">8</span>
                </div>
            </div>

            <div class="section-title">Kelompok Faktor Risiko III</div>
            <div class="risk-group">
                <div class="group-header">
                    <i class="fas fa-exclamation-triangle"></i> Komplikasi Serius
                </div>

                <div class="checkbox-item {{ old('perdarahan_dalam_kehamilan_ini') ? 'checked' : '' }}">
                    <input type="checkbox" name="perdarahan_dalam_kehamilan_ini" value="1" data-score="8"
                        onchange="handleCheckboxChange(this)" @checked(old('perdarahan_dalam_kehamilan_ini'))>
                    <div class="checkbox-label" onclick="toggleCheckFromLabel(this)">Perdarahan dalam kehamilan ini</div>
                    <span class="score-badge">8</span>
                </div>

                <div class="checkbox-item {{ old('preeklampsia') ? 'checked' : '' }}">
                    <input type="checkbox" name="preeklampsia" value="1" data-score="8"
                        onchange="handleCheckboxChange(this)" @checked(old('preeklampsia'))>
                    <div class="checkbox-label" onclick="toggleCheckFromLabel(this)">Preeklampsia (tekanan darah tinggi
                        dalam kehamilan)</div>
                    <span class="score-badge">8</span>
                </div>

                <div class="checkbox-item {{ old('eklampsia') ? 'checked' : '' }}">
                    <input type="checkbox" name="eklampsia" value="1" data-score="8"
                        onchange="handleCheckboxChange(this)" @checked(old('eklampsia'))>
                    <div class="checkbox-label" onclick="toggleCheckFromLabel(this)">Preeklampsia berat/kejang-kejang
                        (eklampsia)</div>
                    <span class="score-badge">8</span>
                </div>
            </div>
        </form>
    </div>

    <div class="result-section">
        <div class="total-score">
            <span>Total Skor:</span>
            <span class="score" id="totalScore">0</span>
        </div>
        <button class="check-btn" type="button" onclick="showResultAndSave()">
            <i class="fas fa-clipboard-check"></i> Lihat Hasil & Rekomendasi
        </button>
    </div>

    <div class="modal" id="resultModal">
        <div class="modal-content">
            <div class="modal-icon" id="modalIcon">
                <i class="fas fa-heart"></i>
            </div>
            <h2 class="modal-title">Hasil Skrining</h2>
            <div class="modal-score" id="modalScore">2</div>
            <div class="modal-category" id="modalCategory">Risiko Rendah</div>

            <div class="recommendation">
                <h4><i class="fas fa-clipboard-list"></i> Rekomendasi</h4>
                <ul id="recommendationList"></ul>
            </div>

            <button class="close-modal-btn" type="button" onclick="closeModal()">Tutup</button>
            <button class="reset-btn" type="button" onclick="resetForm()">
                <i class="fas fa-redo"></i> Mulai Ulang
            </button>
        </div>
    </div>

    @push('scripts')
        <script>
            let totalScore = 0;

            function handleCheckboxChange(checkbox) {
                const item = checkbox.closest('.checkbox-item');

                if (checkbox.checked) {
                    item.classList.add('checked');
                } else {
                    item.classList.remove('checked');
                }

                calculateTotal();
            }

            function toggleCheckFromLabel(labelElement) {
                const item = labelElement.closest('.checkbox-item');
                const checkbox = item.querySelector('input[type="checkbox"]');

                // Jangan lakukan apa-apa jika checkbox disabled
                if (checkbox.disabled) return;

                // Toggle checkbox
                checkbox.checked = !checkbox.checked;

                // Update visual
                if (checkbox.checked) {
                    item.classList.add('checked');
                } else {
                    item.classList.remove('checked');
                }

                // Hitung ulang total
                calculateTotal();
            }

            function calculateTotal() {
                // PENTING: Reset ke skor dasar primigravida setiap kali hitung ulang
                totalScore = 0;

                // Hitung ulang SEMUA checkbox yang diceklis (kecuali yang disabled)
                document.querySelectorAll('input[type="checkbox"]:checked:not([disabled])').forEach(checkbox => {
                    const score = parseInt(checkbox.dataset.score) || 0;
                    totalScore += score;
                });

                // Update tampilan total skor
                document.getElementById('totalScore').textContent = totalScore;
            }

            function resultForScore(score) {
                if (score >= 2 && score <= 6) {
                    return {
                        category: 'Risiko Rendah (KRR)',
                        iconClass: 'modal-icon low-risk',
                        iconHtml: '<i class="fas fa-check-circle"></i>',
                        categoryClass: 'modal-category low-risk',
                        recommendations: [
                            'Ibu dapat melahirkan di Puskesmas atau Polindes',
                            'Lakukan pemeriksaan kehamilan rutin minimal 4 kali (1-1-2)',
                            'Konsumsi tablet tambah darah dan vitamin sesuai anjuran',
                            'Jaga pola makan bergizi seimbang',
                            'Istirahat yang cukup dan hindari stress',
                            'Persiapkan persalinan dengan baik'
                        ]
                    };
                }

                if (score >= 8 && score <= 12) {
                    return {
                        category: 'Risiko Tinggi (KRT)',
                        iconClass: 'modal-icon medium-risk',
                        iconHtml: '<i class="fas fa-exclamation-circle"></i>',
                        categoryClass: 'modal-category medium-risk',
                        recommendations: [
                            'Ibu perlu melahirkan di Puskesmas PONED atau Rumah Sakit',
                            'Diperlukan pemeriksaan lebih intensif oleh tenaga kesehatan',
                            'Konsultasi dengan dokter spesialis kandungan',
                            'Perhatikan tanda-tanda bahaya kehamilan',
                            'Siapkan donor darah dan transportasi darurat',
                            'Pertimbangkan untuk tinggal dekat fasilitas kesehatan menjelang persalinan'
                        ]
                    };
                }

                return {
                    category: 'Risiko Sangat Tinggi (KRST)',
                    iconClass: 'modal-icon high-risk',
                    iconHtml: '<i class="fas fa-times-circle"></i>',
                    categoryClass: 'modal-category high-risk',
                    recommendations: [
                        'IBU HARUS melahirkan di Rumah Sakit',
                        'Segera konsultasi dengan dokter spesialis kandungan',
                        'Pemeriksaan dan monitoring ketat sangat diperlukan',
                        'Persiapkan biaya, donor darah, dan transportasi darurat',
                        'Jika terjadi tanda bahaya segera ke Rumah Sakit',
                        'Pertimbangkan rawat inap jika diperlukan',
                        'Keluarga harus siap mendampingi kapan saja'
                    ]
                };
            }

            function showResultWith(score) {
                const modal = document.getElementById('resultModal');
                const modalIcon = document.getElementById('modalIcon');
                const modalScore = document.getElementById('modalScore');
                const modalCategory = document.getElementById('modalCategory');
                const recommendationList = document.getElementById('recommendationList');

                const result = resultForScore(score);

                modalScore.textContent = score;
                modalIcon.className = result.iconClass;
                modalIcon.innerHTML = result.iconHtml;
                modalCategory.className = result.categoryClass;
                modalCategory.textContent = result.category;

                recommendationList.innerHTML = '';
                result.recommendations.forEach(rec => {
                    const li = document.createElement('li');
                    li.textContent = rec;
                    recommendationList.appendChild(li);
                });

                modal.classList.add('show');
                document.body.style.overflow = 'hidden';
            }

            function validateCheckboxes() {
                // Hitung checkbox yang diceklis (tidak termasuk primigravida yang disabled)
                const checkedCount = document.querySelectorAll(
                    'input[type="checkbox"]:checked:not([disabled]):not([name="primigravida_anak_pertama"])'
                ).length;

                if (checkedCount === 0) {
                    Swal.fire({
                        position: "center",
                        icon: "warning",
                        title: "Peringatan",
                        html: "Silakan pilih <strong>minimal satu kondisi risiko</strong> yang sesuai dengan kondisi ibu.<br><br>Jika tidak ada kondisi risiko yang sesuai, berarti ibu dalam kondisi <strong>Risiko Rendah</strong>.",
                        showConfirmButton: true,
                        confirmButtonText: "Mengerti",
                        confirmButtonColor: "#ff6b9d"
                    });
                    return false;
                }
                return true;
            }

            function showResultAndSave() {
                // Validasi terlebih dahulu
                if (!validateCheckboxes()) {
                    return;
                }

                saveDeteksi();
            }

            async function saveDeteksi() {
                const alertBox = document.getElementById('saveAlert');
                alertBox.classList.add('d-none');
                alertBox.textContent = '';

                const form = document.getElementById('deteksiForm');
                const formData = new FormData(form);

                const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');

                try {
                    const response = await fetch(form.action, {
                        method: 'POST',
                        headers: {
                            'Accept': 'application/json',
                            'X-CSRF-TOKEN': csrfToken || ''
                        },
                        body: formData
                    });

                    const data = await response.json().catch(() => null);

                    if (!response.ok) {
                        const message = data?.message || 'Gagal menyimpan deteksi. Silakan coba lagi.';

                        // Tampilkan error validasi checkbox jika ada
                        if (data?.errors?.checklist) {
                            Swal.fire({
                                position: "center",
                                icon: "warning",
                                title: "Peringatan",
                                html: data.errors.checklist[0] +
                                    "<br><br>Jika tidak ada kondisi risiko yang sesuai, berarti ibu dalam kondisi <strong>Risiko Rendah</strong>.",
                                showConfirmButton: true,
                                confirmButtonText: "Mengerti",
                                confirmButtonColor: "#ff6b9d"
                            });
                        } else {
                            Swal.fire({
                                position: "center",
                                icon: "error",
                                title: message,
                                showConfirmButton: true
                            });
                        }
                        return;
                    }

                    // Jika sukses, tampilkan modal hasil
                    showResultWith(totalScore);

                    // Tampilkan notifikasi sukses
                    Swal.fire({
                        position: "center",
                        icon: "success",
                        title: "Data berhasil disimpan!",
                        showConfirmButton: false,
                        timer: 1500
                    });

                } catch (e) {
                    console.error('Error:', e);
                    Swal.fire({
                        position: "center",
                        icon: "error",
                        title: "Gagal menyimpan deteksi. Silakan cek koneksi dan coba lagi.",
                        showConfirmButton: true
                    });
                }
            }

            function closeModal() {
                const modal = document.getElementById('resultModal');
                modal.classList.remove('show');
                document.body.style.overflow = 'auto';
            }

            function resetForm() {
                // Reset semua checkbox kecuali yang disabled
                document.querySelectorAll('input[type="checkbox"]:not([disabled])').forEach(checkbox => {
                    checkbox.checked = false;
                });

                // Reset semua input form
                document.querySelectorAll('input[type="number"], input[type="text"], textarea, select').forEach(input => {
                    input.value = '';
                });

                // Remove class checked dari semua checkbox item
                document.querySelectorAll('.checkbox-item').forEach(item => {
                    if (!item.querySelector('input[disabled]')) {
                        item.classList.remove('checked');
                    }
                });

                // Reset total skor dengan memanggil calculateTotal()
                // yang akan otomatis set ke nilai dasar (2)
                calculateTotal();

                closeModal();

                window.scrollTo({
                    top: 0,
                    behavior: 'smooth'
                });
            }

            // Initialize - hitung total saat pertama kali load
            calculateTotal();
        </script>

        {{-- <script>
            let totalScore = 0;

            function handleCheckboxChange(checkbox) {
                const item = checkbox.closest('.checkbox-item');
                if (checkbox.checked) {
                    item.classList.add('checked');
                } else {
                    item.classList.remove('checked');
                }
                calculateTotal();
            }

            function toggleCheckFromLabel(labelElement) {
                const item = labelElement.closest('.checkbox-item');
                const checkbox = item.querySelector('input[type="checkbox"]');
                if (checkbox.disabled) return;

                checkbox.checked = !checkbox.checked;

                if (checkbox.checked) {
                    item.classList.add('checked');
                } else {
                    item.classList.remove('checked');
                }

                calculateTotal();
            }

            function calculateTotal() {
                totalScore = 2;

                document.querySelectorAll('input[type="checkbox"]:checked:not([disabled])').forEach(checkbox => {
                    totalScore += parseInt(checkbox.dataset.score);
                });

                document.getElementById('totalScore').textContent = totalScore;
            }

            function resultForScore(score) {
                if (score >= 2 && score <= 6) {
                    return {
                        category: 'Risiko Rendah (KRR)',
                        iconClass: 'modal-icon low-risk',
                        iconHtml: '<i class="fas fa-check-circle"></i>',
                        categoryClass: 'modal-category low-risk',
                        recommendations: [
                            'Ibu dapat melahirkan di Puskesmas atau Polindes',
                            'Lakukan pemeriksaan kehamilan rutin minimal 4 kali (1-1-2)',
                            'Konsumsi tablet tambah darah dan vitamin sesuai anjuran',
                            'Jaga pola makan bergizi seimbang',
                            'Istirahat yang cukup dan hindari stress',
                            'Persiapkan persalinan dengan baik'
                        ]
                    };
                }

                if (score >= 8 && score <= 12) {
                    return {
                        category: 'Risiko Tinggi (KRT)',
                        iconClass: 'modal-icon medium-risk',
                        iconHtml: '<i class="fas fa-exclamation-circle"></i>',
                        categoryClass: 'modal-category medium-risk',
                        recommendations: [
                            'Ibu perlu melahirkan di Puskesmas PONED atau Rumah Sakit',
                            'Diperlukan pemeriksaan lebih intensif oleh tenaga kesehatan',
                            'Konsultasi dengan dokter spesialis kandungan',
                            'Perhatikan tanda-tanda bahaya kehamilan',
                            'Siapkan donor darah dan transportasi darurat',
                            'Pertimbangkan untuk tinggal dekat fasilitas kesehatan menjelang persalinan'
                        ]
                    };
                }

                return {
                    category: 'Risiko Sangat Tinggi (KRST)',
                    iconClass: 'modal-icon high-risk',
                    iconHtml: '<i class="fas fa-times-circle"></i>',
                    categoryClass: 'modal-category high-risk',
                    recommendations: [
                        'IBU HARUS melahirkan di Rumah Sakit',
                        'Segera konsultasi dengan dokter spesialis kandungan',
                        'Pemeriksaan dan monitoring ketat sangat diperlukan',
                        'Persiapkan biaya, donor darah, dan transportasi darurat',
                        'Jika terjadi tanda bahaya segera ke Rumah Sakit',
                        'Pertimbangkan rawat inap jika diperlukan',
                        'Keluarga harus siap mendampingi kapan saja'
                    ]
                };
            }

            function showResultWith(score) {
                const modal = document.getElementById('resultModal');
                const modalIcon = document.getElementById('modalIcon');
                const modalScore = document.getElementById('modalScore');
                const modalCategory = document.getElementById('modalCategory');
                const recommendationList = document.getElementById('recommendationList');

                const result = resultForScore(score);

                modalScore.textContent = score;
                modalIcon.className = result.iconClass;
                modalIcon.innerHTML = result.iconHtml;
                modalCategory.className = result.categoryClass;
                modalCategory.textContent = result.category;

                recommendationList.innerHTML = '';
                result.recommendations.forEach(rec => {
                    const li = document.createElement('li');
                    li.textContent = rec;
                    recommendationList.appendChild(li);
                });

                modal.classList.add('show');
                document.body.style.overflow = 'hidden';
            }

            function showResultAndSave() {
                saveDeteksi();
                // showResultWith(totalScore);
            }

            async function saveDeteksi() {
                const alertBox = document.getElementById('saveAlert');
                alertBox.classList.add('d-none');
                alertBox.textContent = '';

                const form = document.getElementById('deteksiForm');
                const formData = new FormData(form);

                const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');

                try {
                    const response = await fetch(form.action, {
                        method: 'POST',
                        headers: {
                            'Accept': 'application/json',
                            'X-CSRF-TOKEN': csrfToken || ''
                        },
                        body: formData
                    });

                    if (!response.ok) {
                        const data = await response.json().catch(() => null);
                        const message = data?.message || 'Gagal menyimpan deteksi. Silakan coba lagi.';
                        alertBox.textContent = message;
                        alertBox.classList.remove('d-none');
                    }

                    if (result.ok) {
                        showResultWith(totalScore);
                        resetForm();
                    }
                } catch (e) {
                    // alertBox.textContent = 'Gagal menyimpan deteksi. Silakan cek koneksi dan coba lagi.';
                    // alertBox.classList.remove('d-none');
                    Swal.fire({
                        position: "center",
                        icon: "error",
                        title: "Gagal menyimpan deteksi. Silakan cek koneksi dan coba lagi.",
                        showConfirmButton: false,
                        timer: 2000
                    });
                }
            }

            function closeModal() {
                const modal = document.getElementById('resultModal');
                modal.classList.remove('show');
                document.body.style.overflow = 'auto';
            }

            function resetForm() {
                document.querySelectorAll('input[type="checkbox"]:not([disabled])').forEach(checkbox => {
                    checkbox.checked = false;
                });

                document.querySelectorAll('.checkbox-item').forEach(item => {
                    if (!item.querySelector('input[disabled]')) {
                        item.classList.remove('checked');
                    }
                });

                totalScore = 2;
                document.getElementById('totalScore').textContent = totalScore;
                closeModal();
                window.scrollTo({
                    top: 0,
                    behavior: 'smooth'
                });
            }

            calculateTotal();
        </script> --}}
    @endpush
@endsection

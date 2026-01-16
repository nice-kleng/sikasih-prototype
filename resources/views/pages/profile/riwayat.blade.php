@extends('layouts.app')

@section('title', 'Riwayat Pemeriksaan - SIKASIH')

@push('styles')
<style>
    /* Modal Styles */
    .modal-overlay {
        position: fixed;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: rgba(0, 0, 0, 0.5);
        z-index: 1000;
        display: none;
        align-items: center;
        justify-content: center;
        backdrop-filter: blur(2px);
    }

    .modal-overlay.active {
        display: flex;
        animation: fadeIn 0.3s;
    }

    .modal-content {
        background: white;
        width: 90%;
        max-width: 400px;
        border-radius: 20px;
        padding: 25px;
        position: relative;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
        transform: translateY(20px);
        transition: all 0.3s;
        max-height: 90vh;
        overflow-y: auto;
    }

    .modal-overlay.active .modal-content {
        transform: translateY(0);
    }

    .modal-close {
        position: absolute;
        top: 15px;
        right: 15px;
        background: #f5f5f5;
        border: none;
        width: 30px;
        height: 30px;
        border-radius: 50%;
        cursor: pointer;
        color: #666;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: all 0.2s;
    }

    .modal-close:hover {
        background: #e0e0e0;
        color: #333;
    }

    .modal-header {
        text-align: center;
        margin-bottom: 20px;
        padding-bottom: 15px;
        border-bottom: 1px solid #eee;
    }

    .modal-title {
        font-size: 18px;
        font-weight: 700;
        color: #333;
        margin-bottom: 5px;
    }

    .modal-subtitle {
        font-size: 12px;
        color: #666;
    }

    .modal-body {
        font-size: 14px;
        line-height: 1.6;
        color: #333;
    }

    @keyframes fadeIn {
        from {
            opacity: 0;
        }

        to {
            opacity: 1;
        }
    }

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
    }

    .header h1 {
        font-size: 18px;
        font-weight: 700;
        margin: 0;
    }

    .content {
        padding: 20px;
        padding-bottom: 100px;
    }

    .summary-cards {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 10px;
        margin-bottom: 20px;
    }

    .summary-card {
        background: white;
        border-radius: 12px;
        padding: 15px 10px;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
        text-align: center;
    }

    .summary-card-icon {
        width: 40px;
        height: 40px;
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 8px;
    }

    .summary-card-icon.anc {
        background: linear-gradient(135deg, #e3f2fd 0%, #bbdefb 100%);
    }

    .summary-card-icon.lab {
        background: linear-gradient(135deg, #fff3e0 0%, #ffe0b2 100%);
    }

    .summary-card-icon.konsul {
        background: linear-gradient(135deg, #f3e5f5 0%, #e1bee7 100%);
    }

    .summary-card-icon i {
        font-size: 20px;
    }

    .summary-card-icon.anc i {
        color: #1976d2;
    }

    .summary-card-icon.lab i {
        color: #f57c00;
    }

    .summary-card-icon.konsul i {
        color: #7b1fa2;
    }

    .summary-card-value {
        font-size: 20px;
        font-weight: 700;
        color: #333;
        margin-bottom: 3px;
    }

    .summary-card-label {
        font-size: 11px;
        color: #666;
    }

    .filter-tabs {
        background: white;
        border-radius: 12px;
        padding: 5px;
        margin-bottom: 20px;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
        display: flex;
        gap: 5px;
    }

    .filter-tab {
        flex: 1;
        padding: 10px;
        border: none;
        background: transparent;
        color: #666;
        font-size: 13px;
        font-weight: 600;
        border-radius: 8px;
        cursor: pointer;
        transition: all 0.3s;
    }

    .filter-tab.active {
        background: linear-gradient(135deg, #ff6b9d 0%, #ff8fab 100%);
        color: white;
    }

    .timeline {
        position: relative;
        padding-left: 30px;
    }

    .timeline::before {
        content: '';
        position: absolute;
        left: 10px;
        top: 0;
        bottom: 0;
        width: 2px;
        background: linear-gradient(to bottom, #ff6b9d 0%, #ffc0cb 100%);
    }

    .timeline-item {
        position: relative;
        margin-bottom: 25px;
    }

    .timeline-dot {
        position: absolute;
        left: -24px;
        top: 5px;
        width: 20px;
        height: 20px;
        border-radius: 50%;
        background: white;
        border: 3px solid #ff6b9d;
        box-shadow: 0 2px 8px rgba(255, 107, 157, 0.3);
        z-index: 2;
    }

    .timeline-dot.completed {
        background: #ff6b9d;
    }

    .timeline-card {
        background: white;
        border-radius: 12px;
        padding: 15px;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
        transition: all 0.3s;
        cursor: pointer;
    }

    .timeline-card:hover {
        box-shadow: 0 4px 15px rgba(255, 107, 157, 0.2);
        transform: translateY(-2px);
    }

    .timeline-header {
        display: flex;
        justify-content: space-between;
        align-items: start;
        margin-bottom: 12px;
    }

    .timeline-date {
        display: flex;
        flex-direction: column;
    }

    .timeline-day {
        font-size: 16px;
        font-weight: 700;
        color: #ff6b9d;
    }

    .timeline-month {
        font-size: 11px;
        color: #666;
    }

    .timeline-badge {
        background: linear-gradient(135deg, #ffe8f2 0%, #fff0f6 100%);
        color: #ff6b9d;
        padding: 5px 12px;
        border-radius: 20px;
        font-size: 11px;
        font-weight: 600;
    }

    .timeline-badge.lab {
        background: linear-gradient(135deg, #fff3e0 0%, #ffe0b2 100%);
        color: #f57c00;
    }

    .timeline-badge.konsul {
        background: linear-gradient(135deg, #f3e5f5 0%, #e1bee7 100%);
        color: #7b1fa2;
    }

    .timeline-title {
        font-size: 15px;
        font-weight: 700;
        color: #333;
        margin-bottom: 8px;
    }

    .timeline-info {
        display: flex;
        flex-direction: column;
        gap: 6px;
        margin-bottom: 10px;
    }

    .info-item {
        display: flex;
        align-items: center;
        gap: 8px;
        font-size: 12px;
        color: #666;
    }

    .info-item i {
        width: 16px;
        color: #ff6b9d;
        font-size: 12px;
    }

    .timeline-details {
        background: #f8f9fa;
        border-radius: 8px;
        padding: 10px;
        margin-top: 10px;
        font-size: 12px;
        color: #666;
        line-height: 1.6;
    }

    .detail-row {
        display: flex;
        justify-content: space-between;
        padding: 5px 0;
        border-bottom: 1px solid #e9ecef;
    }

    .detail-row:last-child {
        border-bottom: none;
    }

    .detail-label {
        font-weight: 600;
        color: #666;
    }

    .detail-value {
        color: #333;
        font-weight: 600;
    }

    .detail-value.normal {
        color: #28a745;
    }

    .detail-value.warning {
        color: #ffc107;
    }

    .detail-value.danger {
        color: #dc3545;
    }

    .expand-btn {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 5px;
        width: 100%;
        padding: 8px;
        margin-top: 10px;
        background: #f8f9fa;
        border: none;
        border-radius: 8px;
        color: #ff6b9d;
        font-size: 12px;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s;
    }

    .expand-btn:hover {
        background: #ffe8f2;
    }

    .expand-btn i {
        transition: transform 0.3s;
    }

    .expand-btn.expanded i {
        transform: rotate(180deg);
    }

    .empty-state {
        text-align: center;
        padding: 40px 20px;
    }

    .empty-icon {
        width: 80px;
        height: 80px;
        border-radius: 50%;
        background: linear-gradient(135deg, #ffe8f2 0%, #fff0f6 100%);
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 15px;
    }

    .empty-icon i {
        font-size: 35px;
        color: #ff6b9d;
    }

    .empty-title {
        font-size: 16px;
        font-weight: 700;
        color: #333;
        margin-bottom: 8px;
    }

    .empty-text {
        font-size: 13px;
        color: #666;
        line-height: 1.6;
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

    .hidden {
        display: none;
    }
</style>
@endpush

@section('content')
<div class="header">
    <div class="header-content">
        <button class="back-btn" onclick="window.location.href='{{ route('profile') }}'">
            <i class="fas fa-arrow-left"></i>
        </button>
        <h1>Riwayat Pemeriksaan</h1>
    </div>
</div>

<div class="content">
    <div class="summary-cards">
        <div class="summary-card">
            <div class="summary-card-icon anc">
                <i class="fas fa-notes-medical"></i>
            </div>
            <div class="summary-card-value">4</div>
            <div class="summary-card-label">Kunjungan ANC</div>
        </div>

        <div class="summary-card">
            <div class="summary-card-icon lab">
                <i class="fas fa-flask"></i>
            </div>
            <div class="summary-card-value">3</div>
            <div class="summary-card-label">Hasil Lab</div>
        </div>

        <div class="summary-card">
            <div class="summary-card-icon konsul">
                <i class="fas fa-comments"></i>
            </div>
            <div class="summary-card-value">8</div>
            <div class="summary-card-label">Konsultasi</div>
        </div>
    </div>

    <div class="filter-tabs">
        <button class="filter-tab active" onclick="filterRecords('all')">Semua</button>
        <button class="filter-tab" onclick="filterRecords('anc')">ANC</button>
        <button class="filter-tab" onclick="filterRecords('lab')">Lab</button>
        <button class="filter-tab" onclick="filterRecords('konsul')">Konsultasi</button>
        <button class="filter-tab" onclick="filterRecords('risiko')">Risiko</button>
    </div>

    <div class="timeline" id="timelineContainer">
        @if(isset($risikoHistory))
        @foreach($risikoHistory as $index => $risiko)
        <div class="timeline-item" data-type="risiko">
            <div class="timeline-dot completed" style="border-color: {{ strtolower($risiko->kategori) == 'risiko tinggi' ? '#dc3545' : (strtolower($risiko->kategori) == 'risiko sedang' ? '#ffc107' : '#28a745') }}"></div>
            <div class="timeline-card">
                <div class="timeline-header">
                    <div class="timeline-date">
                        <div class="timeline-day">{{ \Carbon\Carbon::parse($risiko->waktu_deteksi)->format('d M') }}</div>
                        <div class="timeline-month">{{ \Carbon\Carbon::parse($risiko->waktu_deteksi)->format('Y') }}</div>
                    </div>
                    <div class="timeline-badge" style="background: {{ strtolower($risiko->kategori) == 'risiko tinggi' ? '#ffeaea' : (strtolower($risiko->kategori) == 'risiko sedang' ? '#fff9db' : '#e8f5e9') }}; color: {{ strtolower($risiko->kategori) == 'risiko tinggi' ? '#dc3545' : (strtolower($risiko->kategori) == 'risiko sedang' ? '#ffc107' : '#28a745') }}">
                        {{ $risiko->kategori }}
                    </div>
                </div>
                <div class="timeline-title">Deteksi Risiko Mandiri</div>
                <div class="timeline-info">
                    <div class="info-item">
                        <i class="fas fa-calculator"></i>
                        <span>Total Skor: {{ $risiko->total_skor }}</span>
                    </div>
                    <div class="info-item">
                        <i class="fas fa-clock"></i>
                        <span>{{ \Carbon\Carbon::parse($risiko->waktu_deteksi)->format('H:i') }} WIB</span>
                    </div>
                </div>

                <!-- Hidden content for modal -->
                <div id="risk-content-{{ $risiko->id }}" class="hidden">
                    <div class="detail-row">
                        <span class="detail-label">Kategori:</span>
                        <span class="detail-value" style="color: {{ strtolower($risiko->kategori) == 'risiko tinggi' ? '#dc3545' : (strtolower($risiko->kategori) == 'risiko sedang' ? '#ffc107' : '#28a745') }}">
                            {{ $risiko->kategori }}
                        </span>
                    </div>
                    <div class="detail-row">
                        <span class="detail-label">Total Skor:</span>
                        <span class="detail-value">{{ $risiko->total_skor }}</span>
                    </div>
                    <div class="detail-row">
                        <span class="detail-label">Waktu Deteksi:</span>
                        <span class="detail-value">{{ \Carbon\Carbon::parse($risiko->waktu_deteksi)->format('d F Y, H:i') }} WIB</span>
                    </div>
                    <div class="detail-row" style="flex-direction: column; gap: 5px; align-items: flex-start;">
                        <span class="detail-label">Rekomendasi:</span>
                        <div class="detail-value" style="font-weight: 400; background: #f8f9fa; padding: 10px; border-radius: 8px; width: 100%;">
                            @php
                            $rekomendasi = $risiko->rekomendasi;
                            if (is_string($rekomendasi)) {
                            $decoded = json_decode($rekomendasi, true);
                            if (json_last_error() === JSON_ERROR_NONE && is_array($decoded)) {
                            $rekomendasi = $decoded;
                            }
                            }

                            if (is_array($rekomendasi)) {
                            echo '<ul style="padding-left: 20px; margin: 0;">';
                                foreach($rekomendasi as $rec) {
                                echo '<li>' . $rec . '</li>';
                                }
                                echo '</ul>';
                            } else {
                            echo $rekomendasi;
                            }
                            @endphp
                        </div>
                    </div>
                </div>

                <button class="expand-btn" onclick="openRiskModal('{{ $risiko->id }}', '{{ $risiko->kategori }}')">
                    <span>Lihat Detail</span>
                    <i class="fas fa-eye"></i>
                </button>
            </div>
        </div>
        @endforeach
        @endif

        <!-- ANC Record 1 -->
        <div class="timeline-item" data-type="anc">
            <div class="timeline-dot completed"></div>
            <div class="timeline-card">
                <div class="timeline-header">
                    <div class="timeline-date">
                        <div class="timeline-day">28 Des</div>
                        <div class="timeline-month">2024</div>
                    </div>
                    <div class="timeline-badge">ANC ke-4</div>
                </div>
                <div class="timeline-title">Pemeriksaan Antenatal Care</div>
                <div class="timeline-info">
                    <div class="info-item">
                        <i class="fas fa-user-nurse"></i>
                        <span>Bidan Linda, S.ST</span>
                    </div>
                    <div class="info-item">
                        <i class="fas fa-map-marker-alt"></i>
                        <span>Puskesmas Sukolilo</span>
                    </div>
                    <div class="info-item">
                        <i class="fas fa-clock"></i>
                        <span>Usia Kehamilan: 16 Minggu</span>
                    </div>
                </div>

                <div class="timeline-details hidden" id="details-1">
                    <div class="detail-row">
                        <span class="detail-label">Berat Badan:</span>
                        <span class="detail-value">62 kg</span>
                    </div>
                    <div class="detail-row">
                        <span class="detail-label">Tekanan Darah:</span>
                        <span class="detail-value normal">110/70 mmHg</span>
                    </div>
                    <div class="detail-row">
                        <span class="detail-label">Tinggi Fundus:</span>
                        <span class="detail-value">16 cm</span>
                    </div>
                    <div class="detail-row">
                        <span class="detail-label">DJJ:</span>
                        <span class="detail-value normal">142 bpm</span>
                    </div>
                    <div class="detail-row">
                        <span class="detail-label">Keluhan:</span>
                        <span class="detail-value">Tidak ada</span>
                    </div>
                    <div class="detail-row">
                        <span class="detail-label">Tindakan:</span>
                        <span class="detail-value">Pemberian Tablet Fe, Edukasi nutrisi</span>
                    </div>
                </div>

                <button class="expand-btn" onclick="toggleDetails(1)">
                    <span>Lihat Detail</span>
                    <i class="fas fa-chevron-down"></i>
                </button>
            </div>
        </div>

        <!-- Lab Record -->
        <div class="timeline-item" data-type="lab">
            <div class="timeline-dot completed"></div>
            <div class="timeline-card">
                <div class="timeline-header">
                    <div class="timeline-date">
                        <div class="timeline-day">15 Des</div>
                        <div class="timeline-month">2024</div>
                    </div>
                    <div class="timeline-badge lab">Laboratorium</div>
                </div>
                <div class="timeline-title">Pemeriksaan Laboratorium</div>
                <div class="timeline-info">
                    <div class="info-item">
                        <i class="fas fa-flask"></i>
                        <span>Lab Puskesmas Sukolilo</span>
                    </div>
                    <div class="info-item">
                        <i class="fas fa-vial"></i>
                        <span>Pemeriksaan Darah Lengkap</span>
                    </div>
                </div>

                <div class="timeline-details hidden" id="details-2">
                    <div class="detail-row">
                        <span class="detail-label">Hemoglobin (Hb):</span>
                        <span class="detail-value normal">11.8 g/dL</span>
                    </div>
                    <div class="detail-row">
                        <span class="detail-label">Leukosit:</span>
                        <span class="detail-value normal">8,500 /µL</span>
                    </div>
                    <div class="detail-row">
                        <span class="detail-label">Trombosit:</span>
                        <span class="detail-value normal">245,000 /µL</span>
                    </div>
                    <div class="detail-row">
                        <span class="detail-label">Golongan Darah:</span>
                        <span class="detail-value">A</span>
                    </div>
                    <div class="detail-row">
                        <span class="detail-label">HBsAg:</span>
                        <span class="detail-value normal">Non-Reaktif</span>
                    </div>
                    <div class="detail-row">
                        <span class="detail-label">HIV:</span>
                        <span class="detail-value normal">Non-Reaktif</span>
                    </div>
                    <div class="detail-row">
                        <span class="detail-label">Kesimpulan:</span>
                        <span class="detail-value normal">Hasil lab dalam batas normal</span>
                    </div>
                </div>

                <button class="expand-btn" onclick="toggleDetails(2)">
                    <span>Lihat Detail</span>
                    <i class="fas fa-chevron-down"></i>
                </button>
            </div>
        </div>

        <!-- Konsultasi Record -->
        <div class="timeline-item" data-type="konsul">
            <div class="timeline-dot completed"></div>
            <div class="timeline-card">
                <div class="timeline-header">
                    <div class="timeline-date">
                        <div class="timeline-day">10 Des</div>
                        <div class="timeline-month">2024</div>
                    </div>
                    <div class="timeline-badge konsul">Konsultasi</div>
                </div>
                <div class="timeline-title">Konsultasi Online dengan Bidan</div>
                <div class="timeline-info">
                    <div class="info-item">
                        <i class="fas fa-user-nurse"></i>
                        <span>Bidan Linda, S.ST</span>
                    </div>
                    <div class="info-item">
                        <i class="fas fa-comment-dots"></i>
                        <span>Chat Online</span>
                    </div>
                </div>

                <div class="timeline-details hidden" id="details-3">
                    <div class="detail-row">
                        <span class="detail-label">Topik:</span>
                        <span class="detail-value">Mual dan muntah di trimester 2</span>
                    </div>
                    <div class="detail-row">
                        <span class="detail-label">Durasi:</span>
                        <span class="detail-value">15 menit</span>
                    </div>
                    <div class="detail-row">
                        <span class="detail-label">Saran:</span>
                        <span class="detail-value">Makan porsi kecil tapi sering, hindari makanan pedas, konsumsi
                            vitamin B6</span>
                    </div>
                    <div class="detail-row">
                        <span class="detail-label">Tindak Lanjut:</span>
                        <span class="detail-value">Kontrol jika keluhan berlanjut > 3 hari</span>
                    </div>
                </div>

                <button class="expand-btn" onclick="toggleDetails(3)">
                    <span>Lihat Detail</span>
                    <i class="fas fa-chevron-down"></i>
                </button>
            </div>
        </div>

        <!-- ANC Record 2 -->
        <div class="timeline-item" data-type="anc">
            <div class="timeline-dot completed"></div>
            <div class="timeline-card">
                <div class="timeline-header">
                    <div class="timeline-date">
                        <div class="timeline-day">30 Nov</div>
                        <div class="timeline-month">2024</div>
                    </div>
                    <div class="timeline-badge">ANC ke-3</div>
                </div>
                <div class="timeline-title">Pemeriksaan Antenatal Care</div>
                <div class="timeline-info">
                    <div class="info-item">
                        <i class="fas fa-user-nurse"></i>
                        <span>Bidan Sari, S.ST</span>
                    </div>
                    <div class="info-item">
                        <i class="fas fa-map-marker-alt"></i>
                        <span>Puskesmas Sukolilo</span>
                    </div>
                    <div class="info-item">
                        <i class="fas fa-clock"></i>
                        <span>Usia Kehamilan: 12 Minggu</span>
                    </div>
                </div>

                <div class="timeline-details hidden" id="details-4">
                    <div class="detail-row">
                        <span class="detail-label">Berat Badan:</span>
                        <span class="detail-value">60 kg</span>
                    </div>
                    <div class="detail-row">
                        <span class="detail-label">Tekanan Darah:</span>
                        <span class="detail-value normal">115/75 mmHg</span>
                    </div>
                    <div class="detail-row">
                        <span class="detail-label">Tinggi Fundus:</span>
                        <span class="detail-value">Belum teraba</span>
                    </div>
                    <div class="detail-row">
                        <span class="detail-label">DJJ:</span>
                        <span class="detail-value normal">148 bpm (Doppler)</span>
                    </div>
                    <div class="detail-row">
                        <span class="detail-label">Keluhan:</span>
                        <span class="detail-value">Mual ringan</span>
                    </div>
                    <div class="detail-row">
                        <span class="detail-label">Tindakan:</span>
                        <span class="detail-value">Pemberian vitamin, Edukasi tanda bahaya</span>
                    </div>
                </div>

                <button class="expand-btn" onclick="toggleDetails(4)">
                    <span>Lihat Detail</span>
                    <i class="fas fa-chevron-down"></i>
                </button>
            </div>
        </div>

        <!-- ANC Record 3 -->
        <div class="timeline-item" data-type="anc">
            <div class="timeline-dot completed"></div>
            <div class="timeline-card">
                <div class="timeline-header">
                    <div class="timeline-date">
                        <div class="timeline-day">15 Okt</div>
                        <div class="timeline-month">2024</div>
                    </div>
                    <div class="timeline-badge">ANC ke-2</div>
                </div>
                <div class="timeline-title">Pemeriksaan Antenatal Care + USG</div>
                <div class="timeline-info">
                    <div class="info-item">
                        <i class="fas fa-user-nurse"></i>
                        <span>Bidan Linda, S.ST</span>
                    </div>
                    <div class="info-item">
                        <i class="fas fa-map-marker-alt"></i>
                        <span>Puskesmas Sukolilo</span>
                    </div>
                    <div class="info-item">
                        <i class="fas fa-clock"></i>
                        <span>Usia Kehamilan: 8 Minggu</span>
                    </div>
                </div>

                <div class="timeline-details hidden" id="details-5">
                    <div class="detail-row">
                        <span class="detail-label">Berat Badan:</span>
                        <span class="detail-value">58 kg</span>
                    </div>
                    <div class="detail-row">
                        <span class="detail-label">Tekanan Darah:</span>
                        <span class="detail-value normal">110/70 mmHg</span>
                    </div>
                    <div class="detail-row">
                        <span class="detail-label">Hasil USG:</span>
                        <span class="detail-value normal">Janin tunggal, intrauterin, DJJ (+)</span>
                    </div>
                    <div class="detail-row">
                        <span class="detail-label">Usia Gestasi USG:</span>
                        <span class="detail-value">8 minggu 3 hari</span>
                    </div>
                    <div class="detail-row">
                        <span class="detail-label">Keluhan:</span>
                        <span class="detail-value">Mual muntah</span>
                    </div>
                    <div class="detail-row">
                        <span class="detail-label">Tindakan:</span>
                        <span class="detail-value">Vitamin B6, Edukasi nutrisi trimester 1</span>
                    </div>
                </div>

                <button class="expand-btn" onclick="toggleDetails(5)">
                    <span>Lihat Detail</span>
                    <i class="fas fa-chevron-down"></i>
                </button>
            </div>
        </div>

        <!-- ANC Record 4 - First Visit -->
        <div class="timeline-item" data-type="anc">
            <div class="timeline-dot completed"></div>
            <div class="timeline-card">
                <div class="timeline-header">
                    <div class="timeline-date">
                        <div class="timeline-day">20 Sep</div>
                        <div class="timeline-month">2024</div>
                    </div>
                    <div class="timeline-badge">ANC ke-1</div>
                </div>
                <div class="timeline-title">Kunjungan Pertama - Pendaftaran</div>
                <div class="timeline-info">
                    <div class="info-item">
                        <i class="fas fa-user-nurse"></i>
                        <span>Bidan Linda, S.ST</span>
                    </div>
                    <div class="info-item">
                        <i class="fas fa-map-marker-alt"></i>
                        <span>Puskesmas Sukolilo</span>
                    </div>
                    <div class="info-item">
                        <i class="fas fa-clock"></i>
                        <span>Usia Kehamilan: 6 Minggu</span>
                    </div>
                </div>

                <div class="timeline-details hidden" id="details-6">
                    <div class="detail-row">
                        <span class="detail-label">HPHT:</span>
                        <span class="detail-value">10 Agustus 2024</span>
                    </div>
                    <div class="detail-row">
                        <span class="detail-label">HPL:</span>
                        <span class="detail-value">17 Mei 2025</span>
                    </div>
                    <div class="detail-row">
                        <span class="detail-label">Berat Badan:</span>
                        <span class="detail-value">57 kg</span>
                    </div>
                    <div class="detail-row">
                        <span class="detail-label">Tinggi Badan:</span>
                        <span class="detail-value">158 cm</span>
                    </div>
                    <div class="detail-row">
                        <span class="detail-label">Tekanan Darah:</span>
                        <span class="detail-value normal">110/70 mmHg</span>
                    </div>
                    <div class="detail-row">
                        <span class="detail-label">Status Risiko:</span>
                        <span class="detail-value normal">Risiko Rendah (KRR)</span>
                    </div>
                    <div class="detail-row">
                        <span class="detail-label">Tindakan:</span>
                        <span class="detail-value">Pembukaan Buku KIA, Edukasi kehamilan, Jadwal ANC</span>
                    </div>
                </div>

                <button class="expand-btn" onclick="toggleDetails(6)">
                    <span>Lihat Detail</span>
                    <i class="fas fa-chevron-down"></i>
                </button>
            </div>
        </div>
    </div>

    <!-- Empty State (hidden by default) -->
    <div class="empty-state hidden" id="emptyState">
        <div class="empty-icon">
            <i class="fas fa-folder-open"></i>
        </div>
        <div class="empty-title">Belum Ada Riwayat</div>
        <div class="empty-text">Riwayat pemeriksaan Anda akan muncul di sini setelah melakukan pemeriksaan</div>
    </div>
</div>

<!-- Modal Container -->
<div class="modal-overlay" id="riskModal">
    <div class="modal-content">
        <button class="modal-close" onclick="closeRiskModal()">
            <i class="fas fa-times"></i>
        </button>
        <div class="modal-header">
            <div class="modal-title" id="modalTitle">Detail Risiko</div>
            <div class="modal-subtitle">Hasil Deteksi Risiko Mandiri</div>
        </div>
        <div class="modal-body" id="modalBody">
            <!-- Content will be injected here -->
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    function openRiskModal(id, category) {
        const content = document.getElementById('risk-content-' + id).innerHTML;
        document.getElementById('modalBody').innerHTML = content;

        // Update header color based on category
        const title = document.getElementById('modalTitle');
        const catLower = category.toLowerCase();

        if (catLower === 'risiko tinggi') {
            title.style.color = '#dc3545';
        } else if (catLower === 'risiko sedang') {
            title.style.color = '#ffc107';
        } else {
            title.style.color = '#28a745';
        }

        const modal = document.getElementById('riskModal');
        modal.classList.add('active');
        document.body.style.overflow = 'hidden'; // Prevent scrolling background
    }

    function closeRiskModal() {
        const modal = document.getElementById('riskModal');
        modal.classList.remove('active');
        document.body.style.overflow = ''; // Restore scrolling
    }

    // Close modal when clicking outside
    const riskModal = document.getElementById('riskModal');
    if (riskModal) {
        riskModal.addEventListener('click', function(e) {
            if (e.target === this) {
                closeRiskModal();
            }
        });
    }

    function toggleDetails(id) {
        const details = document.getElementById(`details-${id}`);
        const btn = details.nextElementSibling;
        const icon = btn.querySelector('i');
        const text = btn.querySelector('span');

        if (details.classList.contains('hidden')) {
            details.classList.remove('hidden');
            btn.classList.add('expanded');
            text.textContent = 'Tutup Detail';
        } else {
            details.classList.add('hidden');
            btn.classList.remove('expanded');
            text.textContent = 'Lihat Detail';
        }
    }

    function filterRecords(type) {
        const items = document.querySelectorAll('.timeline-item');
        const emptyState = document.getElementById('emptyState');
        const timelineContainer = document.getElementById('timelineContainer');
        const tabs = document.querySelectorAll('.filter-tab');

        // Update active tab
        tabs.forEach(tab => tab.classList.remove('active'));
        event.target.classList.add('active');

        let visibleCount = 0;

        items.forEach(item => {
            if (type === 'all') {
                item.style.display = 'block';
                visibleCount++;
            } else if (item.dataset.type === type) {
                item.style.display = 'block';
                visibleCount++;
            } else {
                item.style.display = 'none';
            }
        });

        // Show/hide empty state
        if (visibleCount === 0) {
            timelineContainer.style.display = 'none';
            emptyState.classList.remove('hidden');
        } else {
            timelineContainer.style.display = 'block';
            emptyState.classList.add('hidden');
        }
    }

    // Load data from localStorage if available
    window.addEventListener('load', function() {
        console.log('Riwayat pemeriksaan loaded');
        // In production, load actual data from backend/database
    });
</script>
@endpush

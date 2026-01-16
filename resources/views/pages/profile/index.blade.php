@extends('layouts.app')

@section('title', 'Profil Saya - SIKASIH')

@push('styles')
<style>
    .profile-header {
        background: white;
        border-radius: 15px;
        padding: 25px;
        margin-bottom: 20px;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.08);
        text-align: center;
    }

    .profile-avatar {
        width: 100px;
        height: 100px;
        border-radius: 50%;
        background: linear-gradient(135deg, #ff6b9d 0%, #ff8fab 100%);
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 15px;
        border: 4px solid #fff;
        box-shadow: 0 4px 15px rgba(255, 107, 157, 0.3);
        position: relative;
    }

    .profile-avatar i {
        font-size: 50px;
        color: white;
    }

    .profile-name {
        font-size: 20px;
        font-weight: 700;
        color: #333;
        margin-bottom: 5px;
    }

    .profile-status {
        font-size: 13px;
        color: #ff6b9d;
        font-weight: 600;
        background: #ffe8f2;
        padding: 5px 15px;
        border-radius: 20px;
        display: inline-block;
        margin-top: 5px;
    }

    .info-cards {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 12px;
        margin-bottom: 20px;
    }

    .info-card {
        background: white;
        border-radius: 12px;
        padding: 15px;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
        text-align: center;
    }

    .info-card-icon {
        width: 45px;
        height: 45px;
        border-radius: 12px;
        background: linear-gradient(135deg, #ffe8f2 0%, #fff0f6 100%);
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 10px;
    }

    .info-card-icon i {
        font-size: 22px;
        color: #ff6b9d;
    }

    .info-card-value {
        font-size: 18px;
        font-weight: 700;
        color: #333;
        margin-bottom: 3px;
    }

    .info-card-label {
        font-size: 11px;
        color: #666;
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
        font-size: 16px;
        font-weight: 700;
        margin-bottom: 15px;
        padding-bottom: 10px;
        border-bottom: 2px solid #ffe8f2;
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .info-row {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 12px 0;
        border-bottom: 1px solid #f5f5f5;
    }

    .info-row:last-child {
        border-bottom: none;
    }

    .info-label {
        font-size: 13px;
        color: #666;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .info-label i {
        width: 20px;
        color: #ff6b9d;
    }

    .info-value {
        font-size: 13px;
        color: #333;
        font-weight: 600;
    }

    .info-value.normal {
        color: #28a745;
    }

    .menu-list {
        list-style: none;
        padding: 0;
        margin: 0;
    }

    .menu-item {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 15px 0;
        border-bottom: 1px solid #f5f5f5;
        cursor: pointer;
        transition: all 0.3s;
        text-decoration: none;
        color: inherit;
    }

    .menu-item:hover {
        padding-left: 5px;
    }

    .menu-item-left {
        display: flex;
        align-items: center;
        gap: 12px;
    }

    .menu-icon {
        width: 40px;
        height: 40px;
        border-radius: 10px;
        background: linear-gradient(135deg, #ffe8f2 0%, #fff0f6 100%);
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .menu-icon i {
        font-size: 18px;
        color: #ff6b9d;
    }

    .menu-text {
        display: flex;
        flex-direction: column;
    }

    .menu-title {
        font-size: 14px;
        font-weight: 600;
        color: #333;
        margin-bottom: 2px;
    }

    .menu-subtitle {
        font-size: 11px;
        color: #999;
    }

    .menu-arrow {
        color: #ccc;
        font-size: 16px;
    }

    .edit-btn {
        background: linear-gradient(135deg, #ff6b9d 0%, #ff8fab 100%);
        color: white;
        border: none;
        width: 100%;
        padding: 12px;
        border-radius: 12px;
        font-size: 14px;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        margin-top: 15px;
    }

    .edit-btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(255, 107, 157, 0.3);
    }

    .logout-btn {
        background: white;
        color: #dc3545;
        border: 2px solid #dc3545;
    }

    .logout-btn:hover {
        background: #dc3545;
        color: white;
    }

    .badge {
        background: #ff6b9d;
        color: white;
        font-size: 10px;
        padding: 2px 6px;
        border-radius: 10px;
        margin-left: 5px;
    }
</style>
@endpush

@section('content')
<div class="header">
    <h1>Profil Saya</h1>
    <p>Informasi Data Pribadi & Kehamilan</p>
</div>

<div class="content">
    <div class="profile-header">
        <div class="profile-avatar">
            <i class="fas fa-user"></i>
        </div>
        <div class="profile-name">{{ $profil['nama'] }}</div>
        <div class="profile-status"><i class="fas fa-check-circle"></i> Ibu Hamil Aktif</div>
    </div>

    <div class="info-cards">
        <div class="info-card">
            <div class="info-card-icon">
                <i class="fas fa-calendar-alt"></i>
            </div>
            <div class="info-card-value">{{ $profil['umur'] }} Tahun</div>
            <div class="info-card-label">Usia Ibu</div>
        </div>

        <div class="info-card">
            <div class="info-card-icon">
                <i class="fas fa-baby"></i>
            </div>
            <div class="info-card-value">{{ $profil['usia_kehamilan'] }} {{ $profil['satuan_kehamilan'] }}</div>
            <div class="info-card-label">Usia Kehamilan</div>
        </div>

        <div class="info-card">
            <div class="info-card-icon">
                <i class="fas fa-heartbeat"></i>
            </div>
            <div class="info-card-value">{{ $profil['status_obstetri'] }}</div>
            <div class="info-card-label">Status Obstetri</div>
        </div>

        <div class="info-card">
            <div class="info-card-icon">
                <i class="fas fa-notes-medical"></i>
            </div>
            <div class="info-card-value">{{ $profil['jumlah_anc'] }} Kali</div>
            <div class="info-card-label">Pemeriksaan ANC</div>
        </div>
    </div>

    <div class="section-card">
        <h2 class="section-title">
            <i class="fas fa-user-circle"></i>
            Data Pribadi
        </h2>

        <div class="info-row">
            <div class="info-label">
                <i class="fas fa-id-card"></i>
                NIK
            </div>
            <div class="info-value">{{ $profil['nik'] }}</div>
        </div>

        <div class="info-row">
            <div class="info-label">
                <i class="fas fa-birthday-cake"></i>
                Tanggal Lahir
            </div>
            <div class="info-value">{{ $profil['tanggal_lahir'] }}</div>
        </div>

        <div class="info-row">
            <div class="info-label">
                <i class="fas fa-map-marker-alt"></i>
                Alamat
            </div>
            <div class="info-value">{{ $profil['alamat'] }}</div>
        </div>

        <div class="info-row">
            <div class="info-label">
                <i class="fas fa-phone"></i>
                No. Telepon
            </div>
            <div class="info-value">{{ $profil['no_telepon'] }}</div>
        </div>

        <div class="info-row">
            <div class="info-label">
                <i class="fas fa-tint"></i>
                Golongan Darah
            </div>
            <div class="info-value">{{ $profil['golongan_darah'] }}</div>
        </div>

        <a href="{{ route('profile.edit') }}" class="edit-btn">
            <i class="fas fa-edit"></i> Edit Data Pribadi
        </a>
    </div>

    <div class="section-card">
        <h2 class="section-title">
            <i class="fas fa-pregnant"></i>
            Data Kehamilan
        </h2>

        <div class="info-row">
            <div class="info-label">
                <i class="fas fa-calendar-check"></i>
                HPHT
            </div>
            <div class="info-value">{{ $profil['hpht'] }}</div>
        </div>

        <div class="info-row">
            <div class="info-label">
                <i class="fas fa-calendar-star"></i>
                HPL (Taksiran Persalinan)
            </div>
            <div class="info-value">{{ $profil['hpl'] }}</div>
        </div>

        <div class="info-row">
            <div class="info-label">
                <i class="fas fa-weight"></i>
                Berat Badan Terakhir
            </div>
            <div class="info-value">{{ $profil['berat_badan'] }} kg</div>
        </div>

        <div class="info-row">
            <div class="info-label">
                <i class="fas fa-ruler-vertical"></i>
                Tinggi Badan
            </div>
            <div class="info-value">{{ $profil['tinggi_badan'] }} cm</div>
        </div>

        <div class="info-row">
            <div class="info-label">
                <i class="fas fa-shield-alt"></i>
                Status Risiko
            </div>
            <div class="info-value {{ $profil['status_risiko_class'] }}">{{ $profil['status_risiko'] }}</div>
        </div>

        {{-- <button class="edit-btn">
            <i class="fas fa-edit"></i> Edit Data Kehamilan
        </button> --}}
    </div>

    <div class="section-card">
        <h2 class="section-title">
            <i class="fas fa-cog"></i>
            Menu Lainnya
        </h2>

        <ul class="menu-list">
            <a href="{{ route('riwayat') }}" class="menu-item">
                <div class="menu-item-left">
                    <div class="menu-icon">
                        <i class="fas fa-history"></i>
                    </div>
                    <div class="menu-text">
                        <div class="menu-title">Riwayat Pemeriksaan</div>
                        <div class="menu-subtitle">Lihat riwayat ANC & konsultasi</div>
                    </div>
                </div>
                <i class="fas fa-chevron-right menu-arrow"></i>
            </a>

            <a href="#" class="menu-item">
                <div class="menu-item-left">
                    <div class="menu-icon">
                        <i class="fas fa-file-medical"></i>
                    </div>
                    <div class="menu-text">
                        <div class="menu-title">Hasil Laboratorium</div>
                        <div class="menu-subtitle">Lihat hasil lab & USG</div>
                    </div>
                </div>
                <i class="fas fa-chevron-right menu-arrow"></i>
            </a>

            <a href="#" class="menu-item">
                <div class="menu-item-left">
                    <div class="menu-icon">
                        <i class="fas fa-bell"></i>
                    </div>
                    <div class="menu-text">
                        <div class="menu-title">Pengingat <span class="badge">3</span></div>
                        <div class="menu-subtitle">Jadwal periksa & minum obat</div>
                    </div>
                </div>
                <i class="fas fa-chevron-right menu-arrow"></i>
            </a>

            <a href="#" class="menu-item">
                <div class="menu-item-left">
                    <div class="menu-icon">
                        <i class="fas fa-book"></i>
                    </div>
                    <div class="menu-text">
                        <div class="menu-title">Buku KIA Digital</div>
                        <div class="menu-subtitle">Catatan kesehatan ibu & anak</div>
                    </div>
                </div>
                <i class="fas fa-chevron-right menu-arrow"></i>
            </a>

            <a href="#" class="menu-item">
                <div class="menu-item-left">
                    <div class="menu-icon">
                        <i class="fas fa-question-circle"></i>
                    </div>
                    <div class="menu-text">
                        <div class="menu-title">Bantuan & Panduan</div>
                        <div class="menu-subtitle">FAQ & cara penggunaan</div>
                    </div>
                </div>
                <i class="fas fa-chevron-right menu-arrow"></i>
            </a>

            <a href="#" class="menu-item">
                <div class="menu-item-left">
                    <div class="menu-icon">
                        <i class="fas fa-info-circle"></i>
                    </div>
                    <div class="menu-text">
                        <div class="menu-title">Tentang SIKASIH</div>
                        <div class="menu-subtitle">Versi 1.0.0</div>
                    </div>
                </div>
                <i class="fas fa-chevron-right menu-arrow"></i>
            </a>
        </ul>

        <button class="edit-btn logout-btn" onclick="confirmLogout()">
            <i class="fas fa-sign-out-alt"></i> Keluar
        </button>
        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
            @csrf
        </form>
    </div>
</div>

@push('scripts')
<script>
    function confirmLogout() {
        if (confirm('Apakah Anda yakin ingin keluar dari aplikasi?')) {
            document.getElementById('logout-form').submit();
        }
    }
</script>
@endpush
@endsection

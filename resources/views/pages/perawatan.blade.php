@extends('layouts.app')

@section('title', 'Perawatan Kehamilan - SIKASIH')

@push('styles')
<style>
    .content {
        padding: 20px;
        padding-bottom: 100px;
        background: white;
        border-radius: 0 0 15px 15px;
    }

    .care-list {
        list-style: none;
        padding-left: 0;
        margin-bottom: 30px;
    }

    .care-item {
        display: flex;
        align-items: flex-start;
        margin-bottom: 15px;
        padding: 10px;
        background: #fff0f6;
        border-left: 4px solid #ff6b9d;
        border-radius: 5px;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.05);
    }

    .care-icon {
        color: #ff6b9d;
        font-size: 16px;
        margin-right: 10px;
        margin-top: 2px;
        flex-shrink: 0;
    }

    .care-text {
        font-size: 14px;
        color: #333;
        line-height: 1.5;
    }

    .important-note {
        color: #d9534f;
        font-weight: 600;
    }
</style>
@endpush

@section('content')
<div class="header">
    <h1>Perawatan Ibu Hamil</h1>
    <p>Panduan Hal-Hal Yang Harus Dilakukan Selama Kehamilan</p>
</div>

<div class="content">

    <h2 class="section-title"><i class="fas fa-baby"></i> Trimester I (1-3 Bulan)</h2>
    <ul class="care-list">
        <li class="care-item">
            <i class="care-icon fas fa-notes-medical"></i>
            <span class="care-text">Periksa kehamilan (AMC Terpadu) ke Puskesmas <strong>paling sedikit satu kali</strong>, termasuk USG dan laboratorium lengkap.</span>
        </li>
        <li class="care-item">
            <i class="care-icon fas fa-utensils"></i>
            <span class="care-text">Makan dengan <strong>porsi lebih kecil tapi sering</strong> (3 kali makanan utama dan 2 kali makanan selingan).</span>
        </li>
        <li class="care-item">
            <i class="care-icon fas fa-pills"></i>
            <span class="care-text">Minum <strong>Tablet Tambah Darah (TTD)/ Multivitamin</strong> setiap hari selama kehamilan.</span>
        </li>
        <li class="care-item">
            <i class="care-icon fas fa-exclamation-triangle important-note"></i>
            <span class="care-text"><span class="important-note">Kenali dan cek tanda bahaya</span> (disarankan untuk melihat gambar tanda bahaya).</span>
        </li>
        <li class="care-item">
            <i class="care-icon fas fa-ambulance important-note"></i>
            <span class="care-text">Jika mengalami tanda bahaya, <strong>segera pergi ke fasilitas pelayanan kesehatan</strong>.</span>
        </li>
    </ul>

    <hr>

    <h2 class="section-title"><i class="fas fa-heartbeat"></i> Trimester II (4-6 Bulan)</h2>
    <ul class="care-list">
        <li class="care-item">
            <i class="care-icon fas fa-user-md"></i>
            <span class="care-text">Periksa kehamilan ke dokter atau bidan <strong>paling sedikit dua kali</strong>.</span>
        </li>
        <li class="care-item">
            <i class="care-icon fas fa-mitten"></i>
            <span class="care-text"><strong>Pantau gerak bayi</strong> secara rutin.</span>
        </li>
        <li class="care-item">
            <i class="care-icon fas fa-utensils"></i>
            <span class="care-text">Makan dengan porsi lebih kecil tapi sering (3 kali makanan utama ditambah <strong>1-2 kali kudapan</strong>).</span>
        </li>
        <li class="care-item">
            <i class="care-icon fas fa-pills"></i>
            <span class="care-text">Minum <strong>Tablet Tambah Darah (TTD)/ Multivitamin</strong> setiap hari selama kehamilan.</span>
        </li>
        <li class="care-item">
            <i class="care-icon fas fa-exclamation-triangle important-note"></i>
            <span class="care-text"><span class="important-note">Kenali dan cek tanda bahaya</span> trimester 2.</span>
        </li>
        <li class="care-item">
            <i class="care-icon fas fa-ambulance important-note"></i>
            <span class="care-text">Jika mengalami tanda bahaya, <strong>segera pergi ke fasilitas pelayanan kesehatan</strong>.</span>
        </li>
        <li class="care-item">
            <i class="care-icon fas fa-comments"></i>
            <span class="care-text">Mulai <strong>merencanakan proses melahirkan</strong> melalui diskusi.</span>
        </li>
    </ul>

    <p style="font-size: 12px; color: #999; text-align: center; margin-top: 20px;">*Lihat tabel porsi makan dan minum Ibu Hamil untuk detail nutrisi.</p>
</div>
@endsection

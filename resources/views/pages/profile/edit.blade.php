@extends('layouts.app')

@section('title', 'Edit Profil - SIKASIH')

@push('styles')
<style>
    .form-group {
        margin-bottom: 20px;
    }

    .form-label {
        display: block;
        margin-bottom: 8px;
        font-weight: 600;
        color: #333;
        font-size: 14px;
    }

    .form-control {
        width: 100%;
        padding: 12px;
        border: 1px solid #ddd;
        border-radius: 10px;
        font-size: 14px;
        transition: all 0.3s;
    }

    .form-control:focus {
        border-color: #ff6b9d;
        outline: none;
        box-shadow: 0 0 0 3px rgba(255, 107, 157, 0.1);
    }

    .section-title {
        color: #ff6b9d;
        font-size: 16px;
        font-weight: 700;
        margin: 25px 0 15px;
        padding-bottom: 10px;
        border-bottom: 2px solid #ffe8f2;
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .btn-submit {
        background: linear-gradient(135deg, #ff6b9d 0%, #ff8fab 100%);
        color: white;
        border: none;
        width: 100%;
        padding: 14px;
        border-radius: 12px;
        font-size: 16px;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s;
        margin-top: 20px;
        box-shadow: 0 4px 15px rgba(255, 107, 157, 0.3);
    }

    .btn-submit:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(255, 107, 157, 0.4);
    }

    .header-content {
        display: flex;
        align-items: center;
        gap: 15px;
        padding: 20px;
        background: white;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
        position: sticky;
        top: 0;
        z-index: 100;
    }

    .back-btn {
        background: #f5f5f5;
        border: none;
        color: #333;
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
        background: #e0e0e0;
    }
</style>
@endpush

@section('content')
<div class="header-content">
    <button class="back-btn" onclick="window.location.href='{{ route('profile') }}'">
        <i class="fas fa-arrow-left"></i>
    </button>
    <h1 style="font-size: 18px; margin: 0;">Edit Profil</h1>
</div>

<div class="content" style="padding: 20px; padding-bottom: 100px;">
    <form action="{{ route('profile.update') }}" method="POST">
        @csrf
        @method('PUT')

        <div class="section-title">
            <i class="fas fa-user"></i> Data Pribadi
        </div>

        <div class="form-group">
            <label class="form-label">Nama Lengkap</label>
            <input type="text" name="nama" class="form-control" value="{{ old('nama', $profil['nama']) }}" required>
            @error('nama') <span class="text-danger" style="font-size: 12px;">{{ $message }}</span> @enderror
        </div>

        <div class="form-group">
            <label class="form-label">NIK</label>
            <input type="text" name="nik" class="form-control" value="{{ old('nik', $profil['nik']) }}" required maxlength="16">
            @error('nik') <span class="text-danger" style="font-size: 12px;">{{ $message }}</span> @enderror
        </div>

        <div class="form-group">
            <label class="form-label">Tanggal Lahir</label>
            <input type="date" name="tanggal_lahir" class="form-control" value="{{ old('tanggal_lahir', $profil['tanggal_lahir']) }}" required>
            @error('tanggal_lahir') <span class="text-danger" style="font-size: 12px;">{{ $message }}</span> @enderror
        </div>

        <div class="form-group">
            <label class="form-label">Alamat Lengkap</label>
            <textarea name="alamat" class="form-control" rows="3" required>{{ old('alamat', $profil['alamat']) }}</textarea>
            @error('alamat') <span class="text-danger" style="font-size: 12px;">{{ $message }}</span> @enderror
        </div>

        <div class="form-group">
            <label class="form-label">No. Telepon</label>
            <input type="tel" name="no_telepon" class="form-control" value="{{ old('no_telepon', $profil['no_telepon']) }}" required>
            @error('no_telepon') <span class="text-danger" style="font-size: 12px;">{{ $message }}</span> @enderror
        </div>

        <div class="form-group">
            <label class="form-label">Golongan Darah</label>
            <select name="golongan_darah" class="form-control">
                <option value="">Pilih Golongan Darah</option>
                @foreach(['A', 'B', 'AB', 'O'] as $goldar)
                <option value="{{ $goldar }}" {{ old('golongan_darah', $profil['golongan_darah']) == $goldar ? 'selected' : '' }}>{{ $goldar }}</option>
                @endforeach
            </select>
        </div>

        <div class="form-group">
            <label class="form-label">Pendidikan Terakhir</label>
            <select name="pendidikan" class="form-control">
                <option value="">Pilih Pendidikan</option>
                @foreach(['SD', 'SMP', 'SMA', 'D3', 'S1', 'S2', 'S3'] as $p)
                <option value="{{ $p }}" {{ old('pendidikan', $profil['pendidikan']) == $p ? 'selected' : '' }}>{{ $p }}</option>
                @endforeach
            </select>
        </div>

        <div class="form-group">
            <label class="form-label">Pekerjaan</label>
            <input type="text" name="pekerjaan" class="form-control" value="{{ old('pekerjaan', $profil['pekerjaan']) }}">
        </div>

        <div class="section-title">
            <i class="fas fa-user-friends"></i> Data Suami
        </div>

        <div class="form-group">
            <label class="form-label">Nama Suami</label>
            <input type="text" name="nama_suami" class="form-control" value="{{ old('nama_suami', $profil['nama_suami']) }}">
        </div>

        <div class="form-group">
            <label class="form-label">Pekerjaan Suami</label>
            <input type="text" name="pekerjaan_suami" class="form-control" value="{{ old('pekerjaan_suami', $profil['pekerjaan_suami']) }}">
        </div>

        <button type="submit" class="btn-submit">
            <i class="fas fa-save"></i> Simpan Perubahan
        </button>
    </form>
</div>
@endsection

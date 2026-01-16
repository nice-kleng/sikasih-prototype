<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class RiwayatController extends Controller
{
    public function index()
    {
        // Data dummy riwayat pemeriksaan
        $riwayat = [
            [
                'id' => 1,
                'tanggal' => '2024-12-28',
                'hari' => '28 Des',
                'bulan' => '2024',
                'tipe' => 'anc',
                'badge' => 'ANC ke-4',
                'judul' => 'Pemeriksaan Antenatal Care',
                'petugas' => 'Bidan Linda, S.ST',
                'lokasi' => 'Puskesmas Sukolilo',
                'usia_kehamilan' => '16 Minggu',
                'details' => [
                    'Berat Badan' => ['value' => '62 kg', 'class' => ''],
                    'Tekanan Darah' => ['value' => '110/70 mmHg', 'class' => 'normal'],
                    'Tinggi Fundus' => ['value' => '16 cm', 'class' => ''],
                    'DJJ' => ['value' => '142 bpm', 'class' => 'normal'],
                    'Keluhan' => ['value' => 'Tidak ada', 'class' => ''],
                    'Tindakan' => ['value' => 'Pemberian Tablet Fe, Edukasi nutrisi', 'class' => ''],
                ]
            ],
            [
                'id' => 2,
                'tanggal' => '2024-12-15',
                'hari' => '15 Des',
                'bulan' => '2024',
                'tipe' => 'lab',
                'badge' => 'Laboratorium',
                'judul' => 'Pemeriksaan Laboratorium',
                'petugas' => 'Lab Puskesmas Sukolilo',
                'lokasi' => 'Pemeriksaan Darah Lengkap',
                'usia_kehamilan' => null,
                'details' => [
                    'Hemoglobin (Hb)' => ['value' => '11.8 g/dL', 'class' => 'normal'],
                    'Leukosit' => ['value' => '8,500 /µL', 'class' => 'normal'],
                    'Trombosit' => ['value' => '245,000 /µL', 'class' => 'normal'],
                    'Golongan Darah' => ['value' => 'A', 'class' => ''],
                    'HBsAg' => ['value' => 'Non-Reaktif', 'class' => 'normal'],
                    'HIV' => ['value' => 'Non-Reaktif', 'class' => 'normal'],
                    'Kesimpulan' => ['value' => 'Hasil lab dalam batas normal', 'class' => 'normal'],
                ]
            ],
            [
                'id' => 3,
                'tanggal' => '2024-12-10',
                'hari' => '10 Des',
                'bulan' => '2024',
                'tipe' => 'konsul',
                'badge' => 'Konsultasi',
                'judul' => 'Konsultasi Online dengan Bidan',
                'petugas' => 'Bidan Linda, S.ST',
                'lokasi' => 'Chat Online',
                'usia_kehamilan' => null,
                'details' => [
                    'Topik' => ['value' => 'Mual dan muntah di trimester 2', 'class' => ''],
                    'Durasi' => ['value' => '15 menit', 'class' => ''],
                    'Saran' => ['value' => 'Makan porsi kecil tapi sering, hindari makanan pedas, konsumsi vitamin B6', 'class' => ''],
                    'Tindak Lanjut' => ['value' => 'Kontrol jika keluhan berlanjut > 3 hari', 'class' => ''],
                ]
            ],
            [
                'id' => 4,
                'tanggal' => '2024-11-30',
                'hari' => '30 Nov',
                'bulan' => '2024',
                'tipe' => 'anc',
                'badge' => 'ANC ke-3',
                'judul' => 'Pemeriksaan Antenatal Care',
                'petugas' => 'Bidan Sari, S.ST',
                'lokasi' => 'Puskesmas Sukolilo',
                'usia_kehamilan' => '12 Minggu',
                'details' => [
                    'Berat Badan' => ['value' => '60 kg', 'class' => ''],
                    'Tekanan Darah' => ['value' => '115/75 mmHg', 'class' => 'normal'],
                    'Tinggi Fundus' => ['value' => 'Belum teraba', 'class' => ''],
                    'DJJ' => ['value' => '148 bpm (Doppler)', 'class' => 'normal'],
                    'Keluhan' => ['value' => 'Mual ringan', 'class' => ''],
                    'Tindakan' => ['value' => 'Pemberian vitamin, Edukasi tanda bahaya', 'class' => ''],
                ]
            ],
        ];

        // Hitung statistik
        $statistik = [
            'total_anc' => collect($riwayat)->where('tipe', 'anc')->count(),
            'total_lab' => collect($riwayat)->where('tipe', 'lab')->count(),
            'total_konsul' => collect($riwayat)->where('tipe', 'konsul')->count(),
        ];

        return view('pages.profile.riwayat', compact('riwayat', 'statistik'));
    }

    public function show($id)
    {
        // Detail riwayat pemeriksaan
        // Dalam implementasi nyata, ambil dari database
        return view('pages.profil.riwayat-detail', compact('id'));
    }
}

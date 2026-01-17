<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DeteksiRisiko extends Model
{
    use HasFactory;

    protected $fillable = [
        'puskesmas_id',
        'ibu_hamil_id',
        'primigravida',
        'primigravida_terlalu_muda',
        'primigravida_terlalu_tua',
        'primigravida_tua_sekunder',
        'tinggi_badan_kurang_atau_sama_145',
        'pernah_gagal_kehamilan',
        'pernah_vakum_atau_forceps',
        'pernah_operasi_sesar',
        'pernah_melahirkan_bblr',
        'pernah_melahirkan_cacat_bawaan',
        'anemia_hb_kurang_11',
        'riwayat_penyakit_kronis',
        'riwayat_kelainan_obstetri_sebelumnya',
        'anak_terkecil_kurang_2_tahun',
        'hamil_kembar',
        'hidramnion',
        'bayi_mati_dalam_kandungan',
        'kehamilan_lebih_bulan',
        'letak_sungsang',
        'letak_lintang',
        'perdarahan_dalam_kehamilan_ini',
        'preeklampsia',
        'eklampsia',
        'total_skor',
        'kategori',
        'rekomendasi',
        'waktu_deteksi',
    ];

    protected $casts = [
        'primigravida' => 'boolean',
        'primigravida_terlalu_muda' => 'boolean',
        'primigravida_terlalu_tua' => 'boolean',
        'primigravida_tua_sekunder' => 'boolean',
        'tinggi_badan_kurang_atau_sama_145' => 'boolean',
        'pernah_gagal_kehamilan' => 'boolean',
        'pernah_vakum_atau_forceps' => 'boolean',
        'pernah_operasi_sesar' => 'boolean',
        'pernah_melahirkan_bblr' => 'boolean',
        'pernah_melahirkan_cacat_bawaan' => 'boolean',
        'anemia_hb_kurang_11' => 'boolean',
        'riwayat_penyakit_kronis' => 'boolean',
        'riwayat_kelainan_obstetri_sebelumnya' => 'boolean',
        'anak_terkecil_kurang_2_tahun' => 'boolean',
        'hamil_kembar' => 'boolean',
        'hidramnion' => 'boolean',
        'bayi_mati_dalam_kandungan' => 'boolean',
        'kehamilan_lebih_bulan' => 'boolean',
        'letak_sungsang' => 'boolean',
        'letak_lintang' => 'boolean',
        'perdarahan_dalam_kehamilan_ini' => 'boolean',
        'preeklampsia' => 'boolean',
        'eklampsia' => 'boolean',
        'rekomendasi' => 'array',
        'waktu_deteksi' => 'datetime',
    ];

    public function ibuHamil()
    {
        return $this->belongsTo(IbuHamil::class, 'ibu_hamil_id');
    }

    public function dataReproduksi()
    {
        return $this->hasOne(DataReproduksi::class, 'deteksi_risiko_id');
    }

    public function puskesmas()
    {
        return $this->belongsTo(Puskesmas::class, 'puskesmas_id');
    }
}

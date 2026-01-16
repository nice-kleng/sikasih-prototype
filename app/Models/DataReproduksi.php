<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DataReproduksi extends Model
{
    use HasFactory;

    protected $fillable = [
        'deteksi_risiko_id',
        'usia_pertama_menikah',
        'usia_hamil_pertama',
        'jumlah_kehamilan',
        'jumlah_persalinan',
        'jumlah_anak_hidup',
        'jumlah_keguguran',
        'riwayat_persalinan_sebelumnya',
    ];

    public function deteksiRisiko()
    {
        return $this->belongsTo(DeteksiRisiko::class);
    }
}

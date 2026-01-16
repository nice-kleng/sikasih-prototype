<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class IbuHamil extends Model
{
    use HasFactory;

    protected $table = 'ibu_hamils';
    protected $fillable = [
        'puskesmas_id',
        'user_id',
        'nama_lengkap',
        'nik',
        'tanggal_lahir',
        'alamat_lengkap',
        'kelurahan',
        'kecamatan',
        'no_telp',
        'pendidikan_terakhir',
        'pekerjaan',
        'status_pernikahan',
    ];

    public function akun()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function dataSuami()
    {
        return $this->hasOne(DataSuami::class, 'ibu_hamil_id');
    }

    public function puskesmas()
    {
        return $this->belongsTo(Puskesmas::class);
    }

    public function deteksiRisiko()
    {
        return $this->hasMany(DeteksiRisiko::class, 'ibu_hamil_id');
    }
}

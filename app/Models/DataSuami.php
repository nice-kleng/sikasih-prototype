<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DataSuami extends Model
{
    use HasFactory;

    protected $table = 'data_suamis';
    protected $fillable = [
        'ibu_hamil_id',
        'nama_lengkap',
        'umur',
        'pendidikan_terakhir',
        'pekerjaan',
        'is_has_bpjs',
    ];

    public function ibuHamil()
    {
        return $this->belongsTo(IbuHamil::class, 'ibu_hamil_id');
    }
}

<?php

namespace App\Models\Setup;

use App\Enums\Setup\JenisRekAkun;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class RekAkun extends Model
{
    use SoftDeletes;

    protected $table = 'rek_akun';

    protected $fillable = [
        'kode',
        'nama',
        'jenis'
    ];

    protected $appends = [
        'kode_lengkap',
    ];

    protected $casts = [
        'jenis' => JenisRekAkun::class
    ];

    public function getKodeLengkapAttribute()
    {
        return str_pad($this->kode, 1, '0', STR_PAD_LEFT);
    }

    public function rek_kelompok()
    {
        return $this->hasMany(RekKelompok::class);
    }

    public function scopeBelanja()
    {
        return $this->where('jenis', JenisRekAkun::Belanja);
    }
}

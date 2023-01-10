<?php

namespace App\Models\Setup;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class RekJenis extends Model
{
    use SoftDeletes;

    protected $table = 'rek_jenis';

    protected $fillable = [
        'rek_kelompok_id',
        'kode',
        'nama'
    ];

    protected $with = [
        'rek_kelompok'
    ];

    public function rek_kelompok()
    {
        return $this->belongsTo(RekKelompok::class);
    }

    public function rek_objek()
    {
        return $this->hasMany(RekObjek::class);
    }

    protected $appends = [
        'kode_lengkap',
        'kode_lengkap_nama',
    ];

    public function getKodeLengkapAttribute()
    {
        return $this->rek_kelompok->kode_lengkap . '.' . str_pad($this->kode, 2, '0', STR_PAD_LEFT);
    }

    public function getKodeLengkapNamaAttribute()
    {
        return '[' . $this->kode_lengkap . ']' . ' ' . $this->nama;
    }
}

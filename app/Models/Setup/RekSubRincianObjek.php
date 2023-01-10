<?php

namespace App\Models\Setup;

use App\Models\Anggaran\BelanjaRkaPd;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class RekSubRincianObjek extends Model
{
    use SoftDeletes;

    protected $table = 'rek_sub_rincian_objek';

    protected $fillable = [
        'rek_rincian_objek_id',
        'kode',
        'nama'
    ];

    protected $with = [
        'rek_rincian_objek',
    ];

    public function rek_rincian_objek()
    {
        return $this->belongsTo(RekRincianObjek::class);
    }


    public function belanja_rka_pd()
    {
        return $this->hasMany(BelanjaRkaPd::class);
    }

    protected $appends = [
        'kode_lengkap',
        'kode_lengkap_nama',
    ];


    public function getKodeLengkapAttribute()
    {
        return $this->rek_rincian_objek->kode_lengkap . '.' . str_pad($this->kode, 4, '0', STR_PAD_LEFT);
    }

    public function getKodeLengkapNamaAttribute()
    {
        return '[' . $this->kode_lengkap . ']' . ' ' . $this->nama;
    }
}

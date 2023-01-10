<?php

namespace App\Models\Setup;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SubKegiatan extends Model
{
    use SoftDeletes;

    protected $table = 'sub_kegiatan';

    protected $fillable = [
        'kegiatan_id',
        'kode',
        'nama'
    ];

    protected $with = [
        'kegiatan',
    ];

    public function kegiatan()
    {
        return $this->belongsTo(Kegiatan::class);
    }

    protected $appends = [
        'kode_lengkap',
        'kode_lengkap_nama',
    ];

    public function getKodeLengkapAttribute()
    {
        return $this->kegiatan->kode_lengkap . '.' . str_pad($this->kode, 3, '0', STR_PAD_LEFT);
    }

    public function getKodeLengkapNamaAttribute()
    {
        return '[' . $this->kode_lengkap . ']' . ' ' . $this->nama;
    }
}

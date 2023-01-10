<?php

namespace App\Models\Setup;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Program extends Model
{
    use SoftDeletes;

    protected $table = 'program';

    protected $fillable = [
        'bidang_id',
        'kode',
        'nama'
    ];

    protected $with = [
        'bidang'
    ];

    public function bidang()
    {
        return $this->belongsTo(Bidang::class);
    }

    public function kegiatan()
    {
        return $this->hasMany(Kegiatan::class);
    }

    protected $appends = [
        'kode_lengkap',
    ];

    public function getKodeLengkapAttribute()
    {
        return $this->bidang->kode_lengkap . '.' . str_pad($this->kode, 2, '0', STR_PAD_LEFT);
    }
}

<?php

namespace App\Models\Setup;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Bidang extends Model
{
    use SoftDeletes;

    protected $table = 'bidang';

    protected $fillable = [
        'urusan_id',
        'kode',
        'nama'
    ];

    protected $with = [
        'urusan'
    ];

    public function urusan()
    {
        return $this->belongsTo(Urusan::class);
    }

    public function program()
    {
        return $this->hasMany(Program::class);
    }

    public function unit_kerja()
    {
        return $this->hasMany(UnitKerja::class);
    }

    protected $appends = [
        'kode_lengkap',
    ];

    public function getKodeLengkapAttribute()
    {
        return $this->urusan->kode_lengkap . '.' . str_pad($this->kode, 2, '0', STR_PAD_LEFT);
    }
}

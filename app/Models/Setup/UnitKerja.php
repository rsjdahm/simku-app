<?php

namespace App\Models\Setup;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class UnitKerja extends Model
{
    use SoftDeletes;

    protected $table = 'unit_kerja';

    protected $fillable = [
        'bidang_id',
        'kode',
        'nama'
    ];

    protected $with = [
        'bidang',
    ];

    public function bidang()
    {
        return $this->belongsTo(Bidang::class);
    }

    public function sub_unit_kerja()
    {
        return $this->hasMany(SubunitKerja::class);
    }

    protected $appends = [
        'kode_lengkap',
    ];

    public function getKodeLengkapAttribute()
    {
        return $this->bidang->kode_lengkap . '.00-00.00-00.' . str_pad($this->kode, 2, '0', STR_PAD_LEFT);
    }
}

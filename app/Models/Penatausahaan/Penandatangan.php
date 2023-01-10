<?php

namespace App\Models\Penatausahaan;

use App\Enums\Penatausahaan\JabatanPenandatangan;
use App\Enums\Penatausahaan\JenisDokumenDitandatangani;
use App\Models\Setup\SubUnitKerja;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Penandatangan extends Model
{
    use SoftDeletes;

    protected $table = 'penandatangan';

    protected $fillable = [
        'sub_unit_kerja_id',
        'nama',
        'nip',
        'jabatan'
    ];

    protected $with = [
        'sub_unit_kerja'
    ];

    public function sub_unit_kerja()
    {
        return $this->belongsTo(SubUnitKerja::class);
    }

    protected $casts = [
        'jabatan' => JabatanPenandatangan::class
    ];
}

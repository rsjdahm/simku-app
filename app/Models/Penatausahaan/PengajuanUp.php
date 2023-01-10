<?php

namespace App\Models\Penatausahaan;

use App\Enums\Penatausahaan\StatusPosting;
use App\Models\Setup\RekSubRincianObjek;
use App\Models\Setup\SubUnitKerja;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PengajuanUp extends Model
{
    use SoftDeletes;

    protected $table = 'pengajuan_up';

    protected $fillable = [
        'sub_unit_kerja_id',
        'rek_sub_rincian_objek_id',
        'nomor',
        'tanggal',
        'uraian',
        'nilai',
        'status'
    ];

    protected $casts = [
        'status' => StatusPosting::class
    ];

    protected $with = [
        'sub_unit_kerja',
        'rek_sub_rincian_objek'
    ];

    public function sub_unit_kerja()
    {
        return $this->belongsTo(SubUnitKerja::class);
    }

    public function rek_sub_rincian_objek()
    {
        return $this->belongsTo(RekSubRincianObjek::class);
    }

    public function spp()
    {
        return $this->hasOne(Spp::class);
    }
}

<?php

namespace App\Models\Penatausahaan;

use App\Enums\Penatausahaan\JenisPengeluaran;
use App\Enums\Penatausahaan\StatusPosting;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Spp extends Model
{
    use SoftDeletes;

    protected $table = 'spp';

    protected $fillable = [
        'jenis',
        'pengajuan_up_id',
        'spj_gu_id',
        'belanja_ls_id',
        'nomor',
        'tanggal',
        'uraian',
        'status'
    ];

    protected $casts = [
        'jenis' => JenisPengeluaran::class,
        'status' => StatusPosting::class,
    ];

    protected $with = [
        'pengajuan_up',
        'spj_gu',
        'belanja_ls',
    ];

    public function spm()
    {
        return $this->hasOne(Spm::class);
    }

    public function pengajuan_up()
    {
        return $this->belongsTo(PengajuanUp::class);
    }

    public function spj_gu()
    {
        return $this->belongsTo(SpjGu::class);
    }

    public function belanja_ls()
    {
        return $this->belongsTo(BelanjaLs::class);
    }
}

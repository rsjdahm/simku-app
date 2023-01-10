<?php

namespace App\Models\Penatausahaan;

use App\Enums\Penatausahaan\StatusPosting;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SpjGu extends Model
{
    use SoftDeletes;

    protected $table = 'spj_gu';

    protected $fillable = [
        'nomor',
        'tanggal',
        'uraian',
        'status',
    ];

    protected $casts = [
        'status' => StatusPosting::class,
    ];

    public function bukti_spj_gu()
    {
        return $this->hasMany(BuktiSpjGu::class);
    }

    public function spp()
    {
        return $this->hasOne(Spp::class);
    }
}

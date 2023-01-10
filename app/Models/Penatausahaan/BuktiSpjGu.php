<?php

namespace App\Models\Penatausahaan;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class BuktiSpjGu extends Model
{
    use SoftDeletes;

    protected $table = 'bukti_spj_gu';

    protected $fillable = [
        'spj_gu_id',
        'bukti_gu_id',
    ];

    protected $with = [
        'spj_gu',
        'bukti_gu'
    ];

    public function spj_gu()
    {
        return $this->belongsTo(SpjGu::class);
    }

    public function bukti_gu()
    {
        return $this->belongsTo(BuktiGu::class);
    }
}

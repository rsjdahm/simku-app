<?php

namespace App\Models\Penatausahaan;

use App\Enums\Penatausahaan\JenisPengeluaran;
use App\Enums\Penatausahaan\StatusPosting;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Sp2d extends Model
{
    use SoftDeletes;

    protected $table = 'sp2d';

    protected $fillable = [
        'spm_id',
        'nomor',
        'tanggal',
        'status',
        'nomor_cek'
    ];

    protected $casts = [
        'status' => StatusPosting::class,
    ];

    protected $with = [
        'spm',
    ];

    public function spm()
    {
        return $this->belongsTo(Spm::class);
    }
}

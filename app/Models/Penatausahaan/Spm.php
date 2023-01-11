<?php

namespace App\Models\Penatausahaan;

use App\Enums\Penatausahaan\JenisPengeluaran;
use App\Enums\Penatausahaan\StatusPosting;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Spm extends Model
{
    use SoftDeletes;

    protected $table = 'spm';

    protected $fillable = [
        'spp_id',
        'nomor',
        'tanggal',
        'status'
    ];

    protected $casts = [
        'status' => StatusPosting::class,
    ];

    protected $with = [
        'spp',
    ];

    public function spp()
    {
        return $this->belongsTo(Spp::class);
    }
}

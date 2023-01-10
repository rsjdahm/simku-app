<?php

namespace App\Models\Penatausahaan;

use App\Enums\Penatausahaan\StatusSetor;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PotonganBuktiGu extends Model
{
    use SoftDeletes;

    protected $table = 'potongan_bukti_gu';

    protected $fillable = [
        'bukti_gu_id',
        'potongan_pfk_id',
        'nilai',
        'nomor_billing',
        'nomor_penyetoran',
        'status',
        'tanggal_setor',
        'tanggal_buku'
    ];

    protected $casts = [
        'status' => StatusSetor::class
    ];

    protected $with = [
        'potongan_pfk'
    ];

    public function bukti_gu()
    {
        return $this->belongsTo(BuktiGu::class);
    }

    public function potongan_pfk()
    {
        return $this->belongsTo(PotonganPfk::class);
    }
}

<?php

namespace App\Models\Penatausahaan;

use App\Enums\Penatausahaan\StatusSetor;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PotonganBelanjaLs extends Model
{
    use SoftDeletes;

    protected $table = 'potongan_belanja_ls';

    protected $fillable = [
        'belanja_ls_id',
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

    public function belanja_ls()
    {
        return $this->belongsTo(BelanjaLs::class);
    }

    public function potongan_pfk()
    {
        return $this->belongsTo(PotonganPfk::class);
    }
}

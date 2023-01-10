<?php

namespace App\Models\Penatausahaan;

use App\Enums\Penatausahaan\JenisBelanjaLs;
use App\Enums\Penatausahaan\MetodePembayaran;
use App\Enums\Penatausahaan\StatusPosting;
use App\Enums\Penatausahaan\StatusPending;
use App\Models\Anggaran\BelanjaRkaPd;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class BelanjaLs extends Model
{
    use SoftDeletes;

    protected $table = 'belanja_ls';

    protected $fillable = [
        'belanja_rka_pd_id',
        'status_pending',
        'nomor',
        'tanggal',
        'tanggal_bayar',
        'uraian',
        'nilai',
        'metode_pembayaran',
        'status',
        'nama',
        'alamat',
        'npwp',
        'bank_id',
        'nomor_rekening',
        'jenis'
    ];

    protected $casts = [
        'status_pending' => StatusPending::class,
        'metode_pembayaran' => MetodePembayaran::class,
        'status' => StatusPosting::class,
        'jenis' => JenisBelanjaLs::class,
    ];

    protected $with = [
        'belanja_rka_pd'
    ];

    public function belanja_rka_pd()
    {
        return $this->belongsTo(BelanjaRkaPd::class);
    }

    public function bank()
    {
        return $this->belongsTo(Bank::class);
    }

    public function potongan_belanja_ls()
    {
        return $this->hasMany(PotonganBelanjaLs::class);
    }

    public function bukti_spj_gu()
    {
        return $this->hasOne(BuktiSpjGu::class);
    }

    public function spp()
    {
        return $this->hasOne(Spp::class);
    }
}

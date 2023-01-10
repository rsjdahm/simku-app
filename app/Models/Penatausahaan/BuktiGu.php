<?php

namespace App\Models\Penatausahaan;

use App\Enums\Penatausahaan\JenisBuktiGu;
use App\Enums\Penatausahaan\MetodePembayaran;
use App\Enums\Penatausahaan\StatusPosting;
use App\Enums\Penatausahaan\StatusPending;
use App\Models\Anggaran\BelanjaRkaPd;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class BuktiGu extends Model
{
    use SoftDeletes;

    protected $table = 'bukti_gu';

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
        'jenis' => JenisBuktiGu::class,
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

    public function potongan_bukti_gu()
    {
        return $this->hasMany(PotonganBuktiGu::class);
    }

    public function bukti_spj_gu()
    {
        return $this->hasOne(BuktiSpjGu::class);
    }
}

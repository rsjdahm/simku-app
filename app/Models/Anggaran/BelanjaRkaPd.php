<?php

namespace App\Models\Anggaran;

use App\Models\Penatausahaan\BelanjaLs;
use App\Models\Penatausahaan\BuktiGu;
use App\Models\Setup\RekSubRincianObjek;
use App\Models\Setup\SubKegiatan;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class BelanjaRkaPd extends Model
{
    use SoftDeletes;

    protected $table = 'belanja_rka_pd';

    protected $fillable = [
        'rka_pd_id',
        'sub_kegiatan_id',
        'rek_sub_rincian_objek_id',
        'uraian',
        'harga_satuan',
        'volume',
        'satuan'
    ];

    protected $with = [
        'rka_pd',
        'sub_kegiatan',
        'rek_sub_rincian_objek'
    ];

    public function rka_pd()
    {
        return $this->belongsTo(RkaPd::class);
    }

    public function sub_kegiatan()
    {
        return $this->belongsTo(SubKegiatan::class);
    }

    public function rek_sub_rincian_objek()
    {
        return $this->belongsTo(RekSubRincianObjek::class);
    }

    public function bukti_gu()
    {
        return $this->hasMany(BuktiGu::class);
    }

    public function belanja_ls()
    {
        return $this->hasMany(BelanjaLs::class);
    }

    protected $appends = [
        'nilai'
    ];

    public function getNilaiAttribute()
    {
        return $this->harga_satuan * $this->volume;
    }
}

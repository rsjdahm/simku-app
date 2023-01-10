<?php

namespace App\Models\Anggaran;

use App\Enums\Anggaran\StatusRkaPd;
use App\Models\Setup\SubUnitKerja;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class RkaPd extends Model
{
    use SoftDeletes;

    protected $table = 'rka_pd';

    protected $fillable = [
        'sub_unit_kerja_id',
        'nomor',
        'uraian',
        'status',
        'tanggal',
        'pagu_pendapatan',
        'pagu_pengeluaran',
        'pagu_pembiayaan',
    ];

    protected $casts = [
        'status' => StatusRkaPd::class
    ];

    protected $with = [
        'sub_unit_kerja'
    ];

    public function sub_unit_kerja()
    {
        return $this->belongsTo(SubUnitKerja::class);
    }

    public function belanja_rka_pd()
    {
        return $this->hasMany(BelanjaRkaPd::class);
    }
}

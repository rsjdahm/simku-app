<?php

namespace App\Models\Penatausahaan;

use App\Enums\Penatausahaan\JenisPotonganPfk;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PotonganPfk extends Model
{
    use SoftDeletes;

    protected $table = 'potongan_pfk';

    protected $fillable = [
        'kode_map',
        'nama',
        'jenis'
    ];

    protected $casts = [
        'jenis' => JenisPotonganPfk::class,
    ];
}

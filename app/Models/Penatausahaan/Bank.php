<?php

namespace App\Models\Penatausahaan;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Bank extends Model
{
    use SoftDeletes;

    protected $table = 'bank';

    protected $fillable = [
        'kode',
        'nama',
    ];
}

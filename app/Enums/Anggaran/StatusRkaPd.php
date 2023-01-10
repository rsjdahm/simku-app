<?php

namespace App\Enums\Anggaran;

enum StatusRkaPd: string
{
    case Murni = 'Murni';
    case Pergeseran = 'Pergeseran';
    case Perubahan = 'Perubahan';
    case AmbangBatas = 'Ambang Batas';
}

<?php

namespace App\Enums\Penatausahaan;

enum MetodePembayaran: string
{
    case Transfer = 'Transfer';
    case Tunai = 'Tunai';
}

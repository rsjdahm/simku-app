<?php

namespace App\Enums\Penatausahaan;

enum JabatanPenandatangan: string
{
    case PA = 'Pengguna Anggaran';
    case KPA = 'Kuasa Pengguna Anggaran BLUD';
    case BPengeluaran = 'Bendahara Pengeluaran BLUD';
    case BPenerimaan = 'Bendahara Penerimaan';
    case PPKSKPD = 'PPK SKPD';
    case PPTK = 'PPTK BLUD';
}

<?php

use App\Http\Controllers\Penatausahaan\LaporanPenatausahaanController;
use App\Http\Controllers\Penatausahaan\BankController;
use App\Http\Controllers\Penatausahaan\BelanjaLsController;
use App\Http\Controllers\Penatausahaan\BuktiGuController;
use App\Http\Controllers\Penatausahaan\BuktiSpjGuController;
use App\Http\Controllers\Penatausahaan\PenandatanganController;
use App\Http\Controllers\Penatausahaan\PengajuanUpController;
use App\Http\Controllers\Penatausahaan\PotonganBelanjaLsController;
use App\Http\Controllers\Penatausahaan\PotonganBuktiGuController;
use App\Http\Controllers\Penatausahaan\PotonganPfkController;
use App\Http\Controllers\Penatausahaan\Sp2dController;
use App\Http\Controllers\Penatausahaan\SpjGuController;
use App\Http\Controllers\Penatausahaan\SpmController;
use App\Http\Controllers\Penatausahaan\SppController;
use Illuminate\Support\Facades\Route;

Route::prefix('/penatausahaan')->group(function () {
    Route::resource('/bank', BankController::class);
    Route::resource('/potongan-pfk', PotonganPfkController::class);
    Route::resource('/penandatangan', PenandatanganController::class);

    Route::resource('/pengajuan-up', PengajuanUpController::class);
    Route::get('/print-pengajuan-up/{pengajuan_up}', [PengajuanUpController::class, 'printPdfPengajuanUp'])->name('pengajuan-up.pdf-pengajuan-up');

    Route::resource('/bukti-gu', BuktiGuController::class);
    Route::get('/print-sbpb/bukti-gu/{bukti_gu}', [BuktiGuController::class, 'printPdfSbpb'])->name('bukti-gu.pdf-sbpb');
    Route::get('/print-kwitansi/bukti-gu/{bukti_gu}', [BuktiGuController::class, 'printPdfKwitansi'])->name('bukti-gu.pdf-kwitansi');
    Route::get('/bukti-gu-nomor-by-sistem', [BuktiGuController::class, 'getNomorBuktiGuOtomatis'])->name('bukti-gu.nomor-bukti-gu-otomatis');
    Route::get('/bukti-gu-penerima', [BuktiGuController::class, 'penerimaIndex'])->name('bukti-gu.penerima-index');

    Route::resource('/potongan-bukti-gu', PotonganBuktiGuController::class);

    Route::resource('/spj-gu', SpjGuController::class);
    Route::resource('/bukti-spj-gu', BuktiSpjGuController::class);
    Route::get('/print-spj-gu/{spj_gu}', [SpjGuController::class, 'printPdfSpjGu'])->name('spj-gu.pdf-spj-gu');

    Route::resource('/belanja-ls', BelanjaLsController::class);
    Route::get('/print-sbpb/belanja-ls/{belanja_ls}', [BelanjaLsController::class, 'printPdfSbpb'])->name('belanja-ls.pdf-sbpb');
    Route::get('/print-kwitansi/belanja-ls/{belanja_ls}', [BelanjaLsController::class, 'printPdfKwitansi'])->name('belanja-ls.pdf-kwitansi');

    Route::resource('/potongan-belanja-ls', PotonganBelanjaLsController::class);

    Route::resource('/spp', SppController::class);
    Route::get('/print-spp/{spp}', [SppController::class, 'printPdfSpp'])->name('spp.pdf-spp');
    Route::get('/print-pengantar-spp/{spp}', [SppController::class, 'printPdfPengantarSpp'])->name('spp.pdf-pengantar-spp');
    Route::get('/print-kelengkapan-spp/{spp}', [SppController::class, 'printPdfKelengkapanSpp'])->name('spp.pdf-kelengkapan-spp');
    Route::get('/print-pernyataan-spp/{spp}', [SppController::class, 'printPdfPernyataanSpp'])->name('spp.pdf-pernyataan-spp');

    Route::resource('/spm', SpmController::class);
    Route::get('/print-spm/{spm}', [SpmController::class, 'printPdfSpm'])->name('spm.pdf-spm');
    Route::get('/print-pengantar-spm/{spm}', [SpmController::class, 'printPdfPengantarSpm'])->name('spm.pdf-pengantar-spm');

    Route::resource('/sp2d', Sp2dController::class);
    Route::get('/print-sp2d/{sp2d}', [Sp2dController::class, 'printPdfSp2d'])->name('sp2d.pdf-sp2d');
    Route::get('/print-pengantar-sp2d/{sp2d}', [Sp2dController::class, 'printPdfPengantarSp2d'])->name('sp2d.pdf-pengantar-sp2d');
    Route::get('/print-kelengkapan-sp2d/{sp2d}', [Sp2dController::class, 'printPdfKelengkapanSp2d'])->name('sp2d.pdf-kelengkapan-sp2d');
    Route::get('/print-pernyataan-sp2d/{sp2d}', [Sp2dController::class, 'printPdfPernyataanSp2d'])->name('sp2d.pdf-pernyataan-sp2d');
    Route::get('/print-lembar-kendali-cek/{sp2d}', [Sp2dController::class, 'printPdfLembarKendaliCek'])->name('sp2d.pdf-lembar-kendali-cek');

    Route::get('/laporan-realisasi', [LaporanPenatausahaanController::class, 'index'])->name('laporan-realisasi.index');
    Route::post('/laporan-realisasi/show', [LaporanPenatausahaanController::class, 'show'])->name('laporan-realisasi.show');
    Route::get('/print-laporan-realisasi', [LaporanPenatausahaanController::class, 'printPdfRealisasi'])->name('laporan.pdf-realisasi');
});

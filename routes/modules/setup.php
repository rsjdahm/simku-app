<?php

use App\Http\Controllers\Setup\BidangController;
use App\Http\Controllers\Setup\KegiatanController;
use App\Http\Controllers\Setup\ProgramController;
use App\Http\Controllers\Setup\RekAkunController;
use App\Http\Controllers\Setup\RekJenisController;
use App\Http\Controllers\Setup\RekKelompokController;
use App\Http\Controllers\Setup\RekObjekController;
use App\Http\Controllers\Setup\RekRincianObjekController;
use App\Http\Controllers\Setup\RekSubRincianObjekController;
use App\Http\Controllers\Setup\SubKegiatanController;
use App\Http\Controllers\Setup\SubUnitKerjaController;
use App\Http\Controllers\Setup\UnitKerjaController;
use App\Http\Controllers\Setup\UrusanController;
use Illuminate\Support\Facades\Route;

Route::prefix('/setup/nomenklatur')->group(function () {
    Route::resource('/urusan', UrusanController::class);
    Route::resource('/bidang', BidangController::class);
    Route::resource('/program', ProgramController::class);
    Route::resource('/kegiatan', KegiatanController::class);
    Route::resource('/sub-kegiatan', SubKegiatanController::class);
});

Route::prefix('/setup/unit-kerja')->group(function () {
    Route::resource('/unit-kerja', UnitKerjaController::class);
    Route::resource('/sub-unit-kerja', SubUnitKerjaController::class);
});

Route::prefix('/setup/rekening')->group(function () {
    Route::resource('/rek-akun', RekAkunController::class);

    Route::resource('/rek-kelompok', RekKelompokController::class);

    Route::resource('/rek-jenis', RekJenisController::class);
    Route::get('/print/rek-jenis', [RekJenisController::class, 'printPdfDaftar'])->name('rek-jenis.pdf-daftar');

    Route::resource('/rek-objek', RekObjekController::class);
    Route::get('/print/rek-objek', [RekObjekController::class, 'printPdfDaftar'])->name('rek-objek.pdf-daftar');


    Route::resource('/rek-rincian-objek', RekRincianObjekController::class);
    Route::get('/print/rek-rincian-objek', [RekRincianObjekController::class, 'printPdfDaftar'])->name('rek-rincian-objek.pdf-daftar');

    Route::resource('/rek-sub-rincian-objek', RekSubRincianObjekController::class);
    Route::get('/print/rek-sub-rincian-objek', [RekSubRincianObjekController::class, 'printPdfDaftar'])->name('rek-sub-rincian-objek.pdf-daftar');
});

<?php

namespace App\Http\Controllers\Penatausahaan;

use App\Enums\Penatausahaan\StatusPosting;
use App\Http\Controllers\Controller;
use App\Models\Anggaran\BelanjaRkaPd;
use App\Models\Anggaran\RkaPd;
use App\Models\Setup\RekAkun;
use App\Models\Setup\RekJenis;
use App\Models\Setup\RekKelompok;
use App\Models\Setup\RekObjek;
use App\Models\Setup\RekRincianObjek;
use App\Models\Setup\RekSubRincianObjek;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

class LaporanPenatausahaanController extends Controller
{
    public function index()
    {
        return view('pages.penatausahaan.laporan-realisasi.index');
    }

    public function show(Request $request)
    {
        $tgl_start = $request->tgl_start;
        $tgl_end = $request->tgl_end;

        $rka_pd = RkaPd::first();

        $belanja_rka_pd = BelanjaRkaPd::withSum(['bukti_gu' => function ($q) use ($tgl_start, $tgl_end) {
            return $q->whereBetween('tanggal', [$tgl_start, $tgl_end])->whereNotNull('tanggal')->where('status', StatusPosting::Posting);
        }], 'nilai')
            ->withSum(['belanja_ls' => function ($q) use ($tgl_start, $tgl_end) {
                return $q->whereBetween('tanggal', [$tgl_start, $tgl_end])->whereNotNull('tanggal')->where('status', StatusPosting::Posting);
            }], 'nilai')
            ->get();

        $rek_sub_rincian_objek = RekSubRincianObjek::whereIn('id', $belanja_rka_pd->pluck('rek_sub_rincian_objek_id'))
            ->get()
            ->sortBy('kode_lengkap');

        $rek_rincian_objek = RekRincianObjek::whereIn('id', $rek_sub_rincian_objek->pluck('rek_rincian_objek_id'))
            ->get()
            ->sortBy('kode_lengkap');

        $rek_objek = RekObjek::whereIn('id', $rek_rincian_objek->pluck('rek_objek_id'))
            ->get()
            ->sortBy('kode_lengkap');

        $rek_jenis = RekJenis::whereIn('id', $rek_objek->pluck('rek_jenis_id'))
            ->get()
            ->sortBy('kode_lengkap');

        $rek_kelompok = RekKelompok::whereIn('id', $rek_jenis->pluck('rek_kelompok_id'))
            ->get()
            ->sortBy('kode_lengkap');

        $rek_akun = RekAkun::whereIn('id', $rek_kelompok->pluck('rek_akun_id'))
            ->get()
            ->sortBy('kode_lengkap');

        switch ($request->jenis) {
            case 'Periodik':
                $view = 'pages.penatausahaan.laporan-realisasi.show-periodik';
                break;
            case 'Bulanan':
                $view = 'pages.penatausahaan.laporan-realisasi.show-bulanan';
                break;
            case 'Triwulanan':
                $view = 'pages.penatausahaan.laporan-realisasi.show-triwulanan';
                break;
            default:
                $view = 'pages.penatausahaan.laporan-realisasi.show-periodik';
                break;
        }

        return view(
            $view,
            compact(
                'rka_pd',
                'belanja_rka_pd',
                'rek_sub_rincian_objek',
                'rek_rincian_objek',
                'rek_objek',
                'rek_jenis',
                'rek_kelompok',
                'rek_akun',
                'tgl_start',
                'tgl_end'
            )
        );
    }

    public function printPdfRealisasi(Request $request)
    {
        $tgl_start = $request->tgl_start;
        $tgl_end = $request->tgl_end;

        $rka_pd = RkaPd::first();

        // $belanja_rka_pd = BelanjaRkaPd::whereHas('bukti_gu')->orWhereHas('belanja_ls')->get();
        $belanja_rka_pd = BelanjaRkaPd::withSum(['bukti_gu' => function ($q) use ($tgl_start, $tgl_end) {
            return $q->whereBetween('tanggal', [$tgl_start, $tgl_end])->whereNotNull('tanggal')->where('status', StatusPosting::Posting);
        }], 'nilai')
            ->withSum(['belanja_ls' => function ($q) use ($tgl_start, $tgl_end) {
                return $q->whereBetween('tanggal', [$tgl_start, $tgl_end])->whereNotNull('tanggal')->where('status', StatusPosting::Posting);
            }], 'nilai')
            ->get();

        $rek_sub_rincian_objek = RekSubRincianObjek::whereIn('id', $belanja_rka_pd->pluck('rek_sub_rincian_objek_id'))
            ->get()
            ->sortBy('kode_lengkap');

        $rek_rincian_objek = RekRincianObjek::whereIn('id', $rek_sub_rincian_objek->pluck('rek_rincian_objek_id'))
            ->get()
            ->sortBy('kode_lengkap');

        $rek_objek = RekObjek::whereIn('id', $rek_rincian_objek->pluck('rek_objek_id'))
            ->get()
            ->sortBy('kode_lengkap');

        $rek_jenis = RekJenis::whereIn('id', $rek_objek->pluck('rek_jenis_id'))
            ->get()
            ->sortBy('kode_lengkap');

        $rek_kelompok = RekKelompok::whereIn('id', $rek_jenis->pluck('rek_kelompok_id'))
            ->get()
            ->sortBy('kode_lengkap');

        $rek_akun = RekAkun::whereIn('id', $rek_kelompok->pluck('rek_akun_id'))
            ->get()
            ->sortBy('kode_lengkap');


        return Pdf::loadView('pages.penatausahaan.laporan-realisasi.pdf-realisasi', compact(
            'rka_pd',
            'belanja_rka_pd',
            'rek_sub_rincian_objek',
            'rek_rincian_objek',
            'rek_objek',
            'rek_jenis',
            'rek_kelompok',
            'rek_akun',
            'tgl_start',
            'tgl_end'
        ))
            ->setPaper('a4', 'landscape')
            ->stream('Pagu Belanja.pdf');
    }
}

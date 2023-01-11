<?php

namespace App\Http\Controllers\Penatausahaan;

use App\Enums\Penatausahaan\JenisPengeluaran;
use App\Enums\Penatausahaan\StatusPosting;
use App\Http\Controllers\Controller;
use App\Http\Requests\Penatausahaan\SppRequest;
use App\Models\Anggaran\BelanjaRkaPd;
use App\Models\Penatausahaan\BelanjaLs;
use App\Models\Penatausahaan\PengajuanUp;
use App\Models\Penatausahaan\SpjGu;
use App\Models\Penatausahaan\Spp;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Yajra\DataTables\Html\Builder;

class SppController extends Controller
{
    public function index(Builder $builder, Request $request)
    {
        if ($request->wantsJson()) :

            $data = Spp::get();

            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('action', '<div class="btn-group btn-group-sm" role="group"><button type="button" class="btn btn-warning dropdown-toggle" data-toggle="dropdown"><i class="fas fa-wrench"></i></button><div class="dropdown-menu"><a data-load="modal" data-size="lg" title="Edit Spp" href="{{ route("spp.edit", $id) }}" class="dropdown-item">Edit</a><a data-action="delete" href="{{ route("spp.destroy", $id) }}" class="dropdown-item text-danger">Hapus</a></div></div>')
                ->editColumn('jenis', function ($i) {
                    switch ($i->jenis) {
                        case JenisPengeluaran::UP:
                            $badge = '<span class="badge badge-dark">' . JenisPengeluaran::UP->value . '</span>';
                            break;
                        case JenisPengeluaran::GU:
                            $badge = '<span class="badge badge-success">' . JenisPengeluaran::GU->value . '</span>';
                            break;
                        case JenisPengeluaran::LS:
                            $badge = '<span class="badge badge-info">' . JenisPengeluaran::LS->value . '</span>';
                            break;
                        default:
                            $badge = '<span class="badge badge-secondary">-</span>';
                            break;
                    }
                    return $badge;
                })
                ->editColumn('status', function ($i) {
                    switch ($i->status) {
                        case StatusPosting::Posting:
                            $badge = '<span class="badge badge-success">' . StatusPosting::Posting->value . '</span>';
                            break;
                        case StatusPosting::BelumPosting:
                            $badge = '<span class="badge badge-warning">' . StatusPosting::BelumPosting->value . '</span>';
                            break;
                        default:
                            $badge = '<span class="badge badge-secondary">-</span>';
                            break;
                    }
                    return $badge;
                })
                ->addColumn('action2', function ($i) {
                    return '<div class="btn-group btn-group-sm ml-1" role="group"><button type="button" title="Cetak Dokumen" class="btn btn-secondary dropdown-toggle" data-toggle="dropdown"><i class="fas fa-print"></i></button><div class="dropdown-menu">
                    <a data-load="modal-pdf" title="Cetak Form Penelitian Kelengkapan SPP-' . $i->jenis->value . ' Nomor: ' . $i->nomor . '" href="' . route("spp.pdf-kelengkapan-spp", $i->id) . '" class="dropdown-item">1. Form Kelengkapan SPP-' . $i->jenis->value . '</a>
                    <a data-load="modal-pdf" title="Cetak SPP-' . $i->jenis->value . ' Nomor: ' . $i->nomor . '" href="' . route("spp.pdf-pengantar-spp", $i->id) . '" class="dropdown-item">2. Surat Pengantar SPP-' . $i->jenis->value . '</a>
                    <a data-load="modal-pdf" title="Cetak SPP-' . $i->jenis->value . ' Nomor: ' . $i->nomor . '" href="' . route("spp.pdf-spp", $i->id) . '" class="dropdown-item">3. SPP-' . $i->jenis->value . '</a>
                    <a data-load="modal-pdf" title="Cetak Surat Pernyataan Pengajuan SPP-' . $i->jenis->value . ' Nomor: ' . $i->nomor . '" href="' . route("spp.pdf-pernyataan-spp", $i->id) . '" class="dropdown-item">4. Surat Pernyataan SPP-' . $i->jenis->value . ' (KPA)</a>
                    </div></div>';
                })
                ->rawColumns(['action', 'action2', 'jenis', 'status'])
                ->toJson();
        else :

            $table = $builder->ajax(route('spp.index'))
                ->addAction(['title' => '', 'style' => 'width: 1%;', 'orderable' => false])
                ->addColumn(['data' => 'tanggal', 'title' => 'Tanggal SPP', 'class' => 'text-center', 'style' => 'width: 1%;', 'defaultContent' => '-'])
                ->addColumn(['data' => 'jenis', 'title' => 'Jenis SPP', 'class' => 'text-center', 'style' => 'width: 1%;', 'defaultContent' => '-'])
                ->addColumn(['data' => 'nomor', 'title' => 'Nomor SPP', 'class' => 'text-center font-weight-bold', 'defaultContent' => '-'])
                ->addColumn(['data' => 'uraian', 'title' => 'Uraian', 'defaultContent' => '-'])
                ->addColumn(['data' => 'pengajuan_up.nomor', 'title' => 'Nomor Pengajuan UP', 'defaultContent' => '-'])
                ->addColumn(['data' => 'spj_gu.nomor', 'title' => 'Nomor SPJ GU', 'defaultContent' => '-'])
                ->addColumn(['data' => 'belanja_ls.nomor', 'title' => 'Nomor Belanja LS', 'defaultContent' => '-'])
                ->addAction(['data' => 'action2', 'title' => '', 'class' => 'text-nowrap', 'style' => 'width: 1%;', 'orderable' => false])
                ->addColumn(['data' => 'status', 'title' => 'Status', 'class' => 'text-center', 'style' => 'width: 1%;', 'defaultContent' => '-'])
                ->orders([
                    [
                        1, 'asc'
                    ]
                ])
                ->columnDefs([
                    [
                        'targets' => [1],
                        'render' => 'function (data) {
                            if (data) {
                                return moment(data).format("DD/MM/YYYY");
                            }
                        }'
                    ],
                ]);

            return view('pages.penatausahaan.spp.index', [
                'table' => $table
            ]);

        endif;
    }

    public function create()
    {
        return view('pages.penatausahaan.spp.create', [
            'pengajuan_up' => PengajuanUp::doesntHave('spp')->where('status', StatusPosting::Posting)->orderBy('nomor', 'desc')->get(),
            'spj_gu' => SpjGu::doesntHave('spp')->where('status', StatusPosting::Posting)->orderBy('nomor', 'desc')->get(),
            'belanja_ls' => BelanjaLs::doesntHave('spp')->where('status', StatusPosting::Posting)->orderBy('nomor', 'desc')->get()
        ]);
    }

    public function store(SppRequest $request)
    {
        Spp::create($request->validated());

        return response()->json(['message' => 'Surat Permohonan Pembayaran berhasil ditambah.']);
    }

    public function edit(Spp $spp)
    {
        return view('pages.penatausahaan.spp.edit', [
            'spp' => $spp,
            'pengajuan_up' => PengajuanUp::where('status', StatusPosting::Posting)->orderBy('nomor', 'desc')->get(),
            'spj_gu' => SpjGu::where('status', StatusPosting::Posting)->orderBy('nomor', 'desc')->get(),
            'belanja_ls' => BelanjaLs::where('status', StatusPosting::Posting)->orderBy('nomor', 'desc')->get()
        ]);
    }

    public function update(Spp $spp, SppRequest $request)
    {
        $spp->update($request->validated());

        return response()->json(['message' => 'Surat Permohonan Pembayaran berhasil diubah.']);
    }

    public function destroy(Spp $spp)
    {
        $spp->delete();

        return response()->json(['message' => 'Surat Permohonan Pembayaran berhasil dihapus.']);
    }

    public function printPdfSpp(Spp $spp)
    {

        switch ($spp->jenis) {
            case JenisPengeluaran::UP:
                $view = 'pages.penatausahaan.spp.pdf-spp-up';
                break;
            case JenisPengeluaran::GU:
                $view = 'pages.penatausahaan.spp.pdf-spp-gu';
                break;
            case JenisPengeluaran::LS:
                $view = 'pages.penatausahaan.spp.pdf-spp-ls';
                break;
        }

        return Pdf::loadView($view, compact(
            'spp',
        ))
            ->setPaper('a4', 'potrait')
            ->stream('SPP.pdf');
    }

    public function printPdfPernyataanSpp(Spp $spp)
    {

        switch ($spp->jenis) {
            case JenisPengeluaran::UP:
                $view = 'pages.penatausahaan.spp.pdf-pernyataan-spp-up';
                break;
                // case JenisPengeluaran::GU:
                //     $view = 'pages.penatausahaan.spp.pdf-spp-gu';
                //     break;
                // case JenisPengeluaran::LS:
                //     $view = 'pages.penatausahaan.spp.pdf-spp-ls';
                //     break;
        }

        return Pdf::loadView($view, compact(
            'spp',
        ))
            ->setPaper('a4', 'potrait')
            ->stream('Surat Pernyataan Pengajuan SPP.pdf');
    }

    public function printPdfPengantarSpp(Spp $spp)
    {

        switch ($spp->jenis) {
            case JenisPengeluaran::UP:
                $view = 'pages.penatausahaan.spp.pdf-pengantar-spp-up';
                break;
                // case JenisPengeluaran::GU:
                //     $view = 'pages.penatausahaan.spp.pdf-spp-gu';
                //     break;
                // case JenisPengeluaran::LS:
                //     $view = 'pages.penatausahaan.spp.pdf-spp-ls';
                //     break;
        }

        return Pdf::loadView($view, [
            'spp' => $spp,
            'sum_belanja_rka_pd' => BelanjaRkaPd::get()->sum('nilai'),
        ])
            ->setPaper('a4', 'potrait')
            ->stream('Surat Pengantar SPP.pdf');
    }

    public function printPdfKelengkapanSpp(Spp $spp)
    {

        // switch ($spp->jenis) {
        //     case JenisPengeluaran::UP:
        //         $view = 'pages.penatausahaan.spp.pdf-spp-up';
        //         break;
        //     case JenisPengeluaran::GU:
        //         $view = 'pages.penatausahaan.spp.pdf-spp-gu';
        //         break;
        //     case JenisPengeluaran::LS:
        //         $view = 'pages.penatausahaan.spp.pdf-spp-ls';
        //         break;
        // }

        return Pdf::loadView('pages.penatausahaan.spp.pdf-kelengkapan-spp', compact(
            'spp',
        ))
            ->setPaper('a4', 'potrait')
            ->stream('Kelengkapan SPP.pdf');
    }
}

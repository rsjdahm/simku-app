<?php

namespace App\Http\Controllers\Penatausahaan;

use App\Enums\Penatausahaan\JenisPengeluaran;
use App\Enums\Penatausahaan\StatusPosting;
use App\Http\Controllers\Controller;
use App\Http\Requests\Penatausahaan\Sp2dRequest;
use App\Models\Penatausahaan\Spm;
use App\Models\Penatausahaan\Sp2d;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Yajra\DataTables\Html\Builder;

class Sp2dController extends Controller
{
    public function index(Builder $builder, Request $request)
    {
        if ($request->wantsJson()) :

            $data = Sp2d::get();

            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('action', '<div class="btn-group btn-group-sm" role="group"><button type="button" class="btn btn-warning dropdown-toggle" data-toggle="dropdown"><i class="fas fa-wrench"></i></button><div class="dropdown-menu"><a data-load="modal" data-size="lg" title="Edit Sp2d" href="{{ route("sp2d.edit", $id) }}" class="dropdown-item">Edit</a><a data-action="delete" href="{{ route("sp2d.destroy", $id) }}" class="dropdown-item text-danger">Hapus</a></div></div>')
                ->addColumn('jenis', function ($i) {
                    switch ($i->spm->spp->jenis) {
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
                    <a data-load="modal-pdf" title="Cetak SP2D-' . $i->spm->spp->jenis->value . ' Nomor: ' . $i->nomor . '" href="' . route("sp2d.pdf-sp2d", $i->id) . '" class="dropdown-item">1. SP2D-' . $i->spm->spp->jenis->value . '</a>
                    <a data-load="modal-pdf" title="Cetak Lembar Kendali Permintaan Cek" href="' . route("sp2d.pdf-lembar-kendali-cek", $i->id) . '" class="dropdown-item">2. Lembar Kendali Cek</a>
                    </div></div>';
                })
                ->rawColumns(['action', 'action2', 'jenis', 'status'])
                ->toJson();
        else :

            $table = $builder->ajax(route('sp2d.index'))
                ->addAction(['title' => '', 'style' => 'width: 1%;', 'orderable' => false])
                ->addColumn(['data' => 'tanggal', 'title' => 'Tanggal SP2D', 'class' => 'text-center', 'style' => 'width: 1%;', 'defaultContent' => '-'])
                ->addColumn(['data' => 'jenis', 'title' => 'Jenis SP2D', 'class' => 'text-center', 'style' => 'width: 1%;', 'defaultContent' => '-'])
                ->addColumn(['data' => 'nomor', 'title' => 'Nomor SP2D', 'class' => 'text-center font-weight-bold', 'defaultContent' => '-'])
                ->addColumn(['data' => 'spm.spp.uraian', 'title' => 'Uraian', 'defaultContent' => '-'])
                ->addColumn(['data' => 'spm.spp.nomor', 'title' => 'Nomor SPM', 'defaultContent' => '-'])
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

            return view('pages.penatausahaan.sp2d.index', [
                'table' => $table
            ]);

        endif;
    }

    public function create()
    {
        return view('pages.penatausahaan.sp2d.create', [
            'spm' => Spm::doesntHave('sp2d')->where('status', StatusPosting::Posting)->orderBy('nomor', 'desc')->get(),
        ]);
    }

    public function store(Sp2dRequest $request)
    {
        Sp2d::create($request->validated());

        return response()->json(['message' => 'Surat Perintah Membayar berhasil ditambah.']);
    }

    public function edit(Sp2d $sp2d)
    {
        return view('pages.penatausahaan.sp2d.edit', [
            'sp2d' => $sp2d,
            'spm' => Spm::where('status', StatusPosting::Posting)->orderBy('nomor', 'desc')->get(),
        ]);
    }

    public function update(Sp2d $sp2d, Sp2dRequest $request)
    {
        $sp2d->update($request->validated());

        return response()->json(['message' => 'Surat Perintah Membayar berhasil diubah.']);
    }

    public function destroy(Sp2d $sp2d)
    {
        $sp2d->delete();

        return response()->json(['message' => 'Surat Perintah Membayar berhasil dihapus.']);
    }

    public function printPdfSp2d(Sp2d $sp2d)
    {

        switch ($sp2d->spm->spp->jenis) {
            case JenisPengeluaran::UP:
                $view = 'pages.penatausahaan.sp2d.pdf-sp2d-up';
                break;
            case JenisPengeluaran::GU:
                $view = 'pages.penatausahaan.sp2d.pdf-sp2d-gu';
                break;
            case JenisPengeluaran::LS:
                $view = 'pages.penatausahaan.sp2d.pdf-sp2d-ls';
                break;
        }

        return Pdf::loadView($view, compact(
            'sp2d',
        ))
            ->setPaper('a4', 'potrait')
            ->stream('SP2D.pdf');
    }

    public function printPdfLembarKendaliCek(Sp2d $sp2d)
    {
        switch ($sp2d->spm->spp->jenis) {
            case JenisPengeluaran::UP:
                $view = 'pages.penatausahaan.sp2d.pdf-lembar-kendali-cek-up';
                break;
            case JenisPengeluaran::GU:
                $view = 'pages.penatausahaan.sp2d.pdf-lembar-kendali-cek-gu';
                break;
            case JenisPengeluaran::LS:
                $view = 'pages.penatausahaan.sp2d.pdf-lembar-kendali-cek-ls';
                break;
        }

        return Pdf::loadView($view, compact(
            'sp2d',
        ))
            ->setPaper('a4', 'landscape')
            ->stream('Lembar kendali Cek.pdf');
    }
}

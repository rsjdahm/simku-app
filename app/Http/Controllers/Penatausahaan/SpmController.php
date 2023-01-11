<?php

namespace App\Http\Controllers\Penatausahaan;

use App\Enums\Penatausahaan\JenisPengeluaran;
use App\Enums\Penatausahaan\StatusPosting;
use App\Http\Controllers\Controller;
use App\Http\Requests\Penatausahaan\SpmRequest;
use App\Models\Anggaran\BelanjaRkaPd;
use App\Models\Penatausahaan\Spp;
use App\Models\Penatausahaan\Spm;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Yajra\DataTables\Html\Builder;

class SpmController extends Controller
{
    public function index(Builder $builder, Request $request)
    {
        if ($request->wantsJson()) :

            $data = Spm::get();

            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('action', '<div class="btn-group btn-group-sm" role="group"><button type="button" class="btn btn-warning dropdown-toggle" data-toggle="dropdown"><i class="fas fa-wrench"></i></button><div class="dropdown-menu"><a data-load="modal" data-size="lg" title="Edit Spm" href="{{ route("spm.edit", $id) }}" class="dropdown-item">Edit</a><a data-action="delete" href="{{ route("spm.destroy", $id) }}" class="dropdown-item text-danger">Hapus</a></div></div>')
                ->addColumn('jenis', function ($i) {
                    switch ($i->spp->jenis) {
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
                    <a data-load="modal-pdf" title="Cetak Surat Pengantar SPM-' . $i->spp->jenis->value . ' Nomor: ' . $i->nomor . '" href="' . route("spm.pdf-pengantar-spm", $i->id) . '" class="dropdown-item">1. Surat Pengantar SPM-' . $i->spp->jenis->value . '</a>
                    <a data-load="modal-pdf" title="Cetak SPM-' . $i->spp->jenis->value . ' Nomor: ' . $i->nomor . '" href="' . route("spm.pdf-spm", $i->id) . '" class="dropdown-item">2. SPM-' . $i->spp->jenis->value . '</a>
                    </div></div>';
                })
                ->rawColumns(['action', 'action2', 'jenis', 'status'])
                ->toJson();
        else :

            $table = $builder->ajax(route('spm.index'))
                ->addAction(['title' => '', 'style' => 'width: 1%;', 'orderable' => false])
                ->addColumn(['data' => 'tanggal', 'title' => 'Tanggal SPM', 'class' => 'text-center', 'style' => 'width: 1%;', 'defaultContent' => '-'])
                ->addColumn(['data' => 'jenis', 'title' => 'Jenis SPM', 'class' => 'text-center', 'style' => 'width: 1%;', 'defaultContent' => '-'])
                ->addColumn(['data' => 'nomor', 'title' => 'Nomor SPM', 'class' => 'text-center font-weight-bold', 'defaultContent' => '-'])
                ->addColumn(['data' => 'spp.uraian', 'title' => 'Uraian', 'defaultContent' => '-'])
                ->addColumn(['data' => 'spp.nomor', 'title' => 'Nomor SPP', 'defaultContent' => '-'])
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

            return view('pages.penatausahaan.spm.index', [
                'table' => $table
            ]);

        endif;
    }

    public function create()
    {
        return view('pages.penatausahaan.spm.create', [
            'spp' => Spp::doesntHave('spm')->where('status', StatusPosting::Posting)->orderBy('nomor', 'desc')->get(),
        ]);
    }

    public function store(SpmRequest $request)
    {
        Spm::create($request->validated());

        return response()->json(['message' => 'Surat Perintah Membayar berhasil ditambah.']);
    }

    public function edit(Spm $spm)
    {
        return view('pages.penatausahaan.spm.edit', [
            'spm' => $spm,
            'spp' => Spp::where('status', StatusPosting::Posting)->orderBy('nomor', 'desc')->get(),
        ]);
    }

    public function update(Spm $spm, SpmRequest $request)
    {
        $spm->update($request->validated());

        return response()->json(['message' => 'Surat Perintah Membayar berhasil diubah.']);
    }

    public function destroy(Spm $spm)
    {
        $spm->delete();

        return response()->json(['message' => 'Surat Perintah Membayar berhasil dihapus.']);
    }

    public function printPdfSpm(Spm $spm)
    {

        switch ($spm->spp->jenis) {
            case JenisPengeluaran::UP:
                $view = 'pages.penatausahaan.spm.pdf-spm-up';
                break;
            case JenisPengeluaran::GU:
                $view = 'pages.penatausahaan.spm.pdf-spm-gu';
                break;
            case JenisPengeluaran::LS:
                $view = 'pages.penatausahaan.spm.pdf-spm-ls';
                break;
        }

        return Pdf::loadView($view, compact(
            'spm',
        ))
            ->setPaper('a4', 'landscape')
            ->stream('SPM.pdf');
    }

    public function printPdfPengantarSpm(Spm $spm)
    {

        switch ($spm->spp->jenis) {
            case JenisPengeluaran::UP:
                $view = 'pages.penatausahaan.spm.pdf-pengantar-spm-up';
                break;
        }

        return Pdf::loadView($view, [
            'spm' => $spm,
        ])
            ->setPaper('a4', 'potrait')
            ->stream('Surat Pengantar SPM.pdf');
    }
}

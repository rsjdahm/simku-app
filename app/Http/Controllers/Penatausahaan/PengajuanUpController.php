<?php

namespace App\Http\Controllers\Penatausahaan;

use App\Enums\Penatausahaan\StatusPosting;
use App\Http\Controllers\Controller;
use App\Http\Requests\Penatausahaan\PengajuanUpRequest;
use App\Models\Penatausahaan\PengajuanUp;
use App\Models\Setup\RekSubRincianObjek;
use App\Models\Setup\SubUnitKerja;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Yajra\DataTables\Html\Builder;

class PengajuanUpController extends Controller
{
    public function index(Builder $builder, Request $request)
    {
        if ($request->wantsJson()) :

            $data = PengajuanUp::get();

            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('action', '<div class="btn-group btn-group-sm" role="group"><button type="button" class="btn btn-warning dropdown-toggle" data-toggle="dropdown"><i class="fas fa-wrench"></i></button><div class="dropdown-menu"><a data-load="modal" data-size="lg" title="Edit Pengajuan UP" href="{{ route("pengajuan-up.edit", $id) }}" class="dropdown-item">Edit</a><a data-action="delete" href="{{ route("pengajuan-up.destroy", $id) }}" class="dropdown-item text-danger">Hapus</a></div></div>')
                ->editColumn('status', function ($i) {
                    switch ($i->status) {
                        case StatusPosting::Posting:
                            $badge = '<span class="badge badge-success"><i class="mr-1 fas fa-check"></i> Posting</span>';
                            break;
                        case StatusPosting::BelumPosting:
                            $badge = '<span class="badge badge-warning"><i class="mr-1 fas fa-exclamation"></i> Draft</span>';
                            break;
                        default:
                            $badge = '<span class="badge badge-secondary">-</span>';
                            break;
                    }
                    return $badge;
                })
                ->addColumn('action2', function ($i) {
                    return '<div class="btn-group btn-group-sm ml-1" role="group"><button type="button" title="Cetak Dokumen" class="btn btn-secondary dropdown-toggle" data-toggle="dropdown"><i class="fas fa-print"></i></button><div class="dropdown-menu">
                    <a data-load="modal-pdf" title="Cetak Surat Pengajuan UP Nomor: ' . $i->nomor . '" href="' . route("pengajuan-up.pdf-pengajuan-up", $i->id) . '" class="dropdown-item">Surat Pengajuan/Permintaan</a>
                    </div></div>';
                })
                ->rawColumns(['action', 'action2', 'status'])
                ->toJson();
        else :

            $table = $builder->ajax(route('pengajuan-up.index'))
                ->addAction(['title' => '', 'style' => 'width: 1%;', 'orderable' => false])
                ->addColumn(['data' => 'tanggal', 'title' => 'Tanggal', 'class' => 'text-center', 'width' => '1%', 'defaultContent' => '-'])
                ->addColumn(['data' => 'nomor', 'title' => 'Nomor Pengajuan', 'class' => 'text-center', 'defaultContent' => '-'])
                ->addColumn(['data' => 'uraian', 'title' => 'Uraian', 'defaultContent' => '-'])
                ->addColumn(['data' => 'nilai', 'title' => 'Nilai', 'class' => 'text-right', 'defaultContent' => '-'])
                ->addAction(['data' => 'action2', 'title' => '', 'class' => 'text-nowrap', 'style' => 'width: 1%;', 'orderable' => false])
                ->addColumn(['data' => 'status', 'title' => 'Status', 'class' => 'text-center', 'style' => 'width: 1%;', 'defaultContent' => '-'])
                ->parameters([
                    'order' => [
                        1, 'asc'
                    ],
                    'columnDefs' => [
                        [
                            'targets' => [4],
                            'render' => '$.fn.dataTable.render.number(".", ",", 2, "")'
                        ],
                        [
                            'targets' => [1],
                            'render' => 'function (data) {
                                if (data) {
                                    return moment(data).format("DD/MM/YYYY");
                                }
                            }'
                        ],
                    ],
                ]);

            return view('pages.penatausahaan.pengajuan-up.index', [
                'table' => $table
            ]);

        endif;
    }

    public function create()
    {
        return view(
            'pages.penatausahaan.pengajuan-up.create',
            [
                'sub_unit_kerja' => SubUnitKerja::get(),
                'rek_sub_rincian_objek' => RekSubRincianObjek::get()
            ]
        );
    }

    public function store(PengajuanUpRequest $request)
    {
        PengajuanUp::create($request->validated());

        return response()->json(['message' => 'Pengajuan UP berhasil ditambah.']);
    }

    public function edit(PengajuanUp $pengajuan_up)
    {
        return view('pages.penatausahaan.pengajuan-up.edit', [
            'pengajuan_up' => $pengajuan_up,
            'sub_unit_kerja' => SubUnitKerja::get(),
            'rek_sub_rincian_objek' => RekSubRincianObjek::get()
        ]);
    }

    public function update(PengajuanUp $pengajuan_up, PengajuanUpRequest $request)
    {
        $pengajuan_up->update($request->validated());

        return response()->json(['message' => 'Pengajuan UP berhasil diubah.']);
    }

    public function destroy(PengajuanUp $pengajuan_up)
    {
        $pengajuan_up->delete();

        return response()->json(['message' => 'Pengajuan UP berhasil dihapus.']);
    }

    public function printPdfPengajuanUp(PengajuanUp $pengajuan_up)
    {
        return Pdf::loadView('pages.penatausahaan.pengajuan-up.pdf-pengajuan-up', compact(
            'pengajuan_up',
        ))
            ->setPaper('a4', 'potrait')
            ->stream('SPM.pdf');
    }
}

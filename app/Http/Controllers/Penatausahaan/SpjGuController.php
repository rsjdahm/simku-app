<?php

namespace App\Http\Controllers\Penatausahaan;

use App\Enums\Penatausahaan\StatusPosting;
use App\Http\Controllers\Controller;
use App\Http\Requests\Penatausahaan\SpjGuRequest;
use App\Models\Penatausahaan\SpjGu;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Yajra\DataTables\Html\Builder;

class SpjGuController extends Controller
{
    public function index(Builder $builder, Request $request)
    {
        if ($request->wantsJson()) :

            $data = SpjGu::withCount(['bukti_spj_gu'])
                ->with(['bukti_spj_gu' => function ($q) {
                    return $q->with(['bukti_gu' => function ($q) {
                        return $q->withSum('potongan_bukti_gu', 'nilai');
                    }]);
                }])
                ->get();

            // return response()->json($data);

            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('action', '<div class="btn-group btn-group-sm" role="group"><button type="button" class="btn btn-warning dropdown-toggle" data-toggle="dropdown"><i class="fas fa-wrench"></i></button><div class="dropdown-menu"><a data-load="modal" title="Edit SpjGu" href="{{ route("spj-gu.edit", $id) }}" class="dropdown-item">Edit</a><a data-action="delete" href="{{ route("spj-gu.destroy", $id) }}" class="dropdown-item text-danger">Hapus</a></div></div>')
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
                    $action = '<div class="btn-group btn-group-sm" role="group"><button type="button" title="Tambah Data Pendukung" class="btn btn-primary dropdown-toggle" data-toggle="dropdown"><i class="fas fa-plus"></i></button><div class="dropdown-menu"><a data-load="modal" data-size="xl" title="Daftar Bukti Pengeluaran pada SPJ Nomor: ' . $i->nomor . '" href="' . route('bukti-spj-gu.index', ['spj_gu_id' => $i->id]) . '" class="dropdown-item">Daftar Bukti Pengeluaran (' . $i->bukti_spj_gu_count . ')</a></div></div><div class="btn-group btn-group-sm ml-1" role="group"><button type="button" title="Cetak Dokumen" class="btn btn-secondary dropdown-toggle" data-toggle="dropdown"><i class="fas fa-print"></i></button><div class="dropdown-menu">
                    <a data-load="modal-pdf" href="' . route("spj-gu.pdf-spj-gu", $i->id) . '" class="dropdown-item">SPJ GU</a>
                    </div></div>';
                    return $action;
                })
                ->addColumn('nilai', function ($i) {
                    return $i->bukti_spj_gu->sum('bukti_gu.nilai');
                })
                ->addColumn('nilai_potongan', function ($i) {
                    return $i->bukti_spj_gu->sum('bukti_gu.potongan_bukti_gu_sum_nilai');
                })
                ->rawColumns(['action', 'action2', 'status'])
                ->toJson();
        else :

            $table = $builder->ajax(route('spj-gu.index'))
                ->addAction(['title' => '', 'style' => 'width: 1%;', 'orderable' => false])
                ->addColumn(['data' => 'tanggal', 'title' => 'Tanggal LPJ', 'class' => 'text-center', 'defaultContent' => '-'])
                ->addColumn(['data' => 'nomor', 'title' => 'Nomor SPJ', 'class' => 'text-center font-weight-bold'])
                ->addColumn(['data' => 'uraian', 'title' => 'Uraian'])
                ->addColumn(['data' => 'nilai', 'title' => 'Jumlah Belanja',  'class' => 'text-right'])
                ->addColumn(['data' => 'nilai_potongan', 'title' => 'Jumlah Potongan', 'class' => 'text-right'])
                ->addAction(['data' => 'action2', 'title' => '', 'class' => 'text-nowrap', 'style' => 'width: 1%;', 'orderable' => false])
                ->addColumn(['data' => 'status', 'title' => 'Status', 'class' => 'text-center', 'style' => 'width: 1%;'])
                ->columnDefs([
                    [
                        'targets' => [1],
                        'render' => 'function (data) {
                            if (data) {
                                return moment(data).format("DD/MM/YYYY");
                            }
                        }'
                    ],
                    [
                        'targets' => [4, 5],
                        'render' => '$.fn.dataTable.render.number(".", ",", 2, "")'
                    ],
                ])
                ->orders([
                    [
                        1, 'asc'
                    ]
                ]);

            return view('pages.penatausahaan.spj-gu.index', [
                'table' => $table
            ]);

        endif;
    }

    public function create()
    {
        return view('pages.penatausahaan.spj-gu.create');
    }

    public function store(SpjGuRequest $request)
    {
        SpjGu::create($request->validated());

        return response()->json(['message' => 'Surat Pertanggungjawaban GU berhasil ditambah.']);
    }

    public function edit(SpjGu $spj_gu)
    {
        return view('pages.penatausahaan.spj-gu.edit', [
            'spj_gu' => $spj_gu
        ]);
    }

    public function update(SpjGu $spj_gu, SpjGuRequest $request)
    {
        $spj_gu->update($request->validated());

        return response()->json(['message' => 'Surat Pertanggungjawaban GU berhasil diubah.']);
    }

    public function destroy(SpjGu $spj_gu)
    {
        $spj_gu->delete();

        return response()->json(['message' => 'Surat Pertanggungjawaban GU berhasil dihapus.']);
    }

    public function printPdfSpjGu(SpjGu $spj_gu)
    {
        return Pdf::loadView('pages.penatausahaan.spj-gu.pdf-spj-gu', [
            'spj_gu' => $spj_gu
        ])
            ->setPaper('a4', 'landscape')
            ->stream('spj-gu-' . $spj_gu->nomor . '.pdf');
    }
}

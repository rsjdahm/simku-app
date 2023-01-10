<?php

namespace App\Http\Controllers\Penatausahaan;

use App\Enums\Penatausahaan\JenisPotonganPfk;
use App\Enums\Penatausahaan\StatusSetor;
use App\Http\Controllers\Controller;
use App\Http\Requests\Penatausahaan\PotonganBelanjaLsRequest;
use App\Models\Penatausahaan\BelanjaLs;
use App\Models\Penatausahaan\PotonganBelanjaLs;
use App\Models\Penatausahaan\PotonganPfk;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Yajra\DataTables\Html\Builder;

class PotonganBelanjaLsController extends Controller
{
    public function index(Builder $builder, Request $request)
    {
        if ($request->wantsJson()) :

            $data = PotonganBelanjaLs::when($request->belanja_ls_id, function ($q) use ($request) {
                return $q->where('belanja_ls_id', $request->belanja_ls_id);
            })->get();

            return DataTables::of($data)
                ->with('total_nilai', $data->sum(function ($i) {
                    return $i->nilai;
                }))
                ->with('total_nilai_penyetoran', $data->where('status', StatusSetor::Setor)->sum(function ($i) {
                    return $i->nilai;
                }))
                ->addIndexColumn()
                ->addColumn('action',  function ($i) {
                    return '<div class="btn-group btn-group-sm" role="group"><button type="button" class="btn btn-warning dropdown-toggle" data-toggle="dropdown"><i class="fas fa-wrench"></i></button><div class="dropdown-menu"><a data-load="modal" title="Edit Potongan PFK" href="' . route("potongan-belanja-ls.edit", $i->id) . '" class="dropdown-item">Edit</a><a data-action="delete" href="' . route("potongan-belanja-ls.destroy", $i->id) . '" class="dropdown-item text-danger">Hapus</a></div></div>';
                })
                ->editColumn('status', function ($i) {
                    switch ($i->status) {
                        case StatusSetor::BelumSetor:
                            return '<span class="badge badge-warning">' . StatusSetor::BelumSetor->value . '</span>';
                            break;
                        case StatusSetor::Setor:
                            return '<span class="badge badge-success">' . StatusSetor::Setor->value . '</span>';
                            break;
                        default:
                            return '<span class="badge badge-secondary">-</span>';
                            break;
                    }
                })
                ->editColumn('potongan_pfk.jenis', function ($i) {
                    switch ($i->potongan_pfk->jenis) {
                        case JenisPotonganPfk::PPh21:
                            return '<span class="badge badge-primary">' . JenisPotonganPfk::PPh21->value . '</span>';
                            break;
                        case JenisPotonganPfk::PPh22:
                            return '<span class="badge badge-info">' . JenisPotonganPfk::PPh22->value . '</span>';
                            break;
                        case JenisPotonganPfk::PPh23:
                            return '<span class="badge badge-warning">' . JenisPotonganPfk::PPh23->value . '</span>';
                            break;
                        case JenisPotonganPfk::PPN:
                            return '<span class="badge badge-success">' . JenisPotonganPfk::PPN->value . '</span>';
                            break;
                        case JenisPotonganPfk::Lainnya:
                            return '<span class="badge badge-danger">' . JenisPotonganPfk::Lainnya->value . '</span>';
                            break;
                        default:
                            return '<span class="badge badge-secondary">-</span>';
                            break;
                    }
                })
                ->rawColumns(['action', 'status', 'potongan_pfk.jenis'])
                ->toJson();
        else :

            $table = $builder->ajax(route('potongan-belanja-ls.index', ['belanja_ls_id' => $request->belanja_ls_id]))
                ->addAction(['title' => '', 'style' => 'width: 1%;', 'orderable' => false])
                ->addColumn(['data' => 'potongan_pfk.jenis', 'title' => 'Jenis Potongan', 'class' => 'text-center', 'style' => 'width: 1%;'])
                ->addColumn(['data' => 'potongan_pfk.nama', 'title' => 'Potongan'])
                ->addColumn(['data' => 'nilai', 'title' => 'Nilai Potongan', 'class' => 'text-right'])
                ->addColumn(['data' => 'status', 'title' => 'Status Penyetoran', 'class' => 'text-center', 'style' => 'width: 1%;'])
                ->addColumn(['data' => 'nomor_billing', 'title' => 'Nomor Billing'])
                ->addColumn(['data' => 'nomor_penyetoran', 'title' => 'NTPN/Nomor Penyetoran'])
                ->parameters([
                    'order' => [
                        2, 'asc'
                    ],
                    'columnDefs' => [
                        [
                            'targets' => [3],
                            'render' => '$.fn.dataTable.render.number(".", ",", 2, "")'
                        ],
                    ],
                    "footerCallback" => "function (row, data, start, end, display) {
                        var api = this.api();
                        var json = api.ajax.json();

                        $(api.column(0).footer()).remove();
                        $(api.column(1).footer()).remove();
                        $(api.column(2).footer()).attr('colspan', '3').html('Total Nilai Potongan').parent().addClass('bg-primary text-white');
                        $(api.column(3).footer()).html(json.total_nilai.toLocaleString('id-ID', { minimumFractionDigits: 2, maximumFractionDigits: 2 }));
                        $(api.column(4).footer()).removeClass('text-center').addClass('text-right').html(json.total_nilai_penyetoran.toLocaleString('id-ID', { minimumFractionDigits: 2, maximumFractionDigits: 2 }));
                    }",
                ]);

            return view('pages.penatausahaan.potongan-belanja-ls.index', [
                'belanja_ls' => BelanjaLs::findOrFail($request->belanja_ls_id),
                'table' => $table
            ]);

        endif;
    }

    public function create(Request $request)
    {
        return view('pages.penatausahaan.potongan-belanja-ls.create', [
            'belanja_ls' => BelanjaLs::findOrFail($request->belanja_ls_id),
            'potongan_pfk' => PotonganPfk::get(),
        ]);
    }

    public function store(PotonganBelanjaLsRequest $request)
    {
        PotonganBelanjaLs::create($request->validated());

        return response()->json(['message' => 'Potongan pada Belanja LS berhasil ditambah.']);
    }

    public function edit(PotonganBelanjaLs $potongan_belanja_ls)
    {
        return view('pages.penatausahaan.potongan-belanja-ls.edit', [
            'potongan_belanja_ls' => $potongan_belanja_ls,
            'potongan_pfk' => PotonganPfk::get()
        ]);
    }

    public function update(PotonganBelanjaLs $potongan_belanja_ls, PotonganBelanjaLsRequest $request)
    {
        $potongan_belanja_ls->update($request->validated());

        return response()->json(['message' => 'Potongan pada Belanja LS berhasil diubah.']);
    }

    public function destroy(PotonganBelanjaLs $potongan_belanja_ls)
    {
        $potongan_belanja_ls->delete();

        return response()->json(['message' => 'Potongan pada Belanja LS berhasil dihapus.']);
    }
}

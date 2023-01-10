<?php

namespace App\Http\Controllers\Penatausahaan;

use App\Enums\Penatausahaan\JenisPotonganPfk;
use App\Http\Controllers\Controller;
use App\Http\Requests\Penatausahaan\PotonganPfkRequest;
use App\Models\Penatausahaan\PotonganPfk;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Yajra\DataTables\Html\Builder;

class PotonganPfkController extends Controller
{
    public function index(Builder $builder, Request $request)
    {
        if ($request->wantsJson()) :

            $data = PotonganPfk::get();

            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('action', '<div class="btn-group btn-group-sm" role="group"><button type="button" class="btn btn-warning dropdown-toggle" data-toggle="dropdown"><i class="fas fa-wrench"></i></button><div class="dropdown-menu"><a data-load="modal" title="Edit Potongan PFK" href="{{ route("potongan-pfk.edit", $id) }}" class="dropdown-item">Edit</a><a data-action="delete" href="{{ route("potongan-pfk.destroy", $id) }}" class="dropdown-item text-danger">Hapus</a></div></div>')
                ->rawColumns(['action', 'jenis'])
                ->editColumn('jenis', function ($i) {
                    switch ($i->jenis) {
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
                ->toJson();
        else :

            $table = $builder->ajax(route('potongan-pfk.index'))
                ->addAction(['title' => '', 'style' => 'width: 1%;', 'orderable' => false])
                ->addColumn(['data' => 'kode_map', 'title' => 'Kode MAP', 'class' => 'text-center font-weight-bold', 'style' => 'width: 1%;'])
                ->addColumn(['data' => 'nama', 'title' => 'Nama Potongan PFK'])
                ->addColumn(['data' => 'jenis', 'title' => 'Jenis Potongan', 'class' => 'text-center', 'style' => 'width: 1%;'])
                ->parameters([
                    'order' => [
                        2, 'asc'
                    ]
                ]);

            return view('pages.penatausahaan.potongan-pfk.index', [
                'table' => $table
            ]);

        endif;
    }

    public function create()
    {
        return view('pages.penatausahaan.potongan-pfk.create');
    }

    public function store(PotonganPfkRequest $request)
    {
        PotonganPfk::create($request->validated());

        return response()->json(['message' => 'Referensi Potongan PFK berhasil ditambah.']);
    }

    public function edit(PotonganPfk $potongan_pfk)
    {
        return view('pages.penatausahaan.potongan-pfk.edit', [
            'potongan_pfk' => $potongan_pfk
        ]);
    }

    public function update(PotonganPfk $potongan_pfk, PotonganPfkRequest $request)
    {
        $potongan_pfk->update($request->validated());

        return response()->json(['message' => 'Referensi Potongan PFK berhasil diubah.']);
    }

    public function destroy(PotonganPfk $potongan_pfk)
    {
        $potongan_pfk->delete();

        return response()->json(['message' => 'Referensi Potongan PFK berhasil dihapus.']);
    }
}

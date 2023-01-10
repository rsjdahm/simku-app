<?php

namespace App\Http\Controllers\Penatausahaan;

use App\Http\Controllers\Controller;
use App\Http\Requests\Penatausahaan\PenandatanganRequest;
use App\Models\Penatausahaan\Penandatangan;
use App\Models\Setup\SubUnitKerja;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Yajra\DataTables\Html\Builder;

class PenandatanganController extends Controller
{
    public function index(Builder $builder, Request $request)
    {
        if ($request->wantsJson()) :

            $data = Penandatangan::get();

            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('action', '<div class="btn-group btn-group-sm" role="group"><button type="button" class="btn btn-warning dropdown-toggle" data-toggle="dropdown"><i class="fas fa-wrench"></i></button><div class="dropdown-menu"><a data-load="modal" title="Edit Penandatangan" href="{{ route("penandatangan.edit", $id) }}" class="dropdown-item">Edit</a><a data-action="delete" href="{{ route("penandatangan.destroy", $id) }}" class="dropdown-item text-danger">Hapus</a></div></div>')
                ->toJson();
        else :

            $table = $builder->ajax(route('penandatangan.index'))
                ->addAction(['title' => '', 'style' => 'width: 1%;', 'orderable' => false])
                ->addColumn(['data' => 'nip', 'title' => 'NIP', 'class' => 'text-center'])
                ->addColumn(['data' => 'nama', 'title' => 'Nama Penandatangan'])
                ->addColumn(['data' => 'jabatan', 'title' => 'Jabatan'])
                ->addColumn(['data' => 'sub_unit_kerja.nama', 'title' => 'Sub Unit Kerja'])
                ->parameters([
                    'order' => [
                        2, 'asc'
                    ]
                ]);

            return view('pages.penatausahaan.penandatangan.index', [
                'table' => $table
            ]);

        endif;
    }

    public function create()
    {
        return view(
            'pages.penatausahaan.penandatangan.create',
            [
                'sub_unit_kerja' => SubUnitKerja::get()
            ]
        );
    }

    public function store(PenandatanganRequest $request)
    {
        Penandatangan::create($request->validated());

        return response()->json(['message' => 'Referensi Penandatangan berhasil ditambah.']);
    }

    public function edit(Penandatangan $penandatangan)
    {
        return view('pages.penatausahaan.penandatangan.edit', [
            'penandatangan' => $penandatangan,
            'sub_unit_kerja' => SubUnitKerja::get()
        ]);
    }

    public function update(Penandatangan $penandatangan, PenandatanganRequest $request)
    {
        $penandatangan->update($request->validated());

        return response()->json(['message' => 'Referensi Penandatangan berhasil diubah.']);
    }

    public function destroy(Penandatangan $penandatangan)
    {
        $penandatangan->delete();

        return response()->json(['message' => 'Referensi Penandatangan berhasil dihapus.']);
    }
}

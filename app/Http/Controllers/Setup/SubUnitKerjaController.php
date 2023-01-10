<?php

namespace App\Http\Controllers\Setup;

use App\Http\Controllers\Controller;
use App\Http\Requests\Setup\SubUnitKerjaRequest;
use App\Models\Setup\Bidang;
use App\Models\Setup\SubUnitKerja;
use App\Models\Setup\UnitKerja;
use App\Models\Setup\Urusan;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Yajra\DataTables\Html\Builder;

class SubUnitKerjaController extends Controller
{
    public function index(Builder $builder, Request $request)
    {
        if ($request->wantsJson()) {
            $data = SubUnitKerja::whereHas('unit_kerja.bidang.urusan', function ($q) use ($request) {
                $q->when($request->filled('urusan_id'), function ($q) use ($request) {
                    $q->where('id', $request->urusan_id);
                });
            })->whereHas('unit_kerja.bidang', function ($q) use ($request) {
                $q->when($request->filled('bidang_id'), function ($q) use ($request) {
                    $q->where('id', $request->bidang_id);
                });
            })->whereHas('unit_kerja', function ($q) use ($request) {
                $q->when($request->filled('unit_kerja_id'), function ($q) use ($request) {
                    $q->where('id', $request->unit_kerja_id);
                });
            })
                ->get();

            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('action', '<div class="btn-group btn-group-sm" role="group"><button type="button" class="btn btn-warning dropdown-toggle" data-toggle="dropdown"><i class="fas fa-wrench"></i></button><div class="dropdown-menu"><a data-load="modal" title="Edit Sub Unit Kerja" href="{{ route("sub-unit-kerja.edit", $id) }}" class="dropdown-item">Edit</a><a data-action="delete" href="{{ route("sub-unit-kerja.destroy", $id) }}" class="dropdown-item text-danger">Hapus</a></div></div>')
                ->addColumn('kode_lengkap', '{{ $kode_lengkap }}')
                ->toJson();
        }

        $table = $builder->ajax([
            'url' => route('sub-unit-kerja.index'),
            'data' => 'function(d) {
                d.urusan_id = $("select[name=\'urusan_id_filter\']").val();
                d.bidang_id = $("select[name=\'bidang_id_filter\']").val();
                d.unit_kerja_id = $("select[name=\'unit_kerja_id_filter\']").val();
            }',
        ])
            ->addAction(['title' => '', 'style' => 'width: 1%;', 'orderable' => false])
            ->addIndex(['title' => 'No.', 'style' => 'width: 1%;', 'class' => 'text-center', 'orderable' => false])
            ->addColumn(['data' => 'kode_lengkap', 'title' => 'Kode Sub Unit Kerja', 'class' => 'text-nowrap font-weight-bold', 'style' => 'width: 1%;'])
            ->addColumn(['data' => 'nama', 'title' => 'Sub Unit Kerja'])
            ->parameters([
                'order' => [
                    2, 'asc'
                ]
            ]);

        $urusan = Urusan::all();
        $bidang = Bidang::all();
        $unit_kerja = UnitKerja::all();

        return view('pages.setup.sub-unit-kerja.index', compact(
            'table',
            'urusan',
            'bidang',
            'unit_kerja'
        ));
    }

    public function create()
    {
        $urusan = Urusan::with([
            'bidang',
            'bidang.unit_kerja'
        ])
            ->get();

        return view('pages.setup.sub-unit-kerja.create', compact(
            'urusan',
        ));
    }

    public function store(SubUnitKerjaRequest $request)
    {
        SubUnitKerja::create($request->validated());

        return response()->json(['message' => 'Data berhasil ditambah.']);
    }

    public function edit(SubUnitKerja $sub_unit_kerja)
    {
        $urusan = Urusan::with([
            'bidang',
            'bidang.unit_kerja'
        ])
            ->get();

        return view('pages.setup.sub-unit-kerja.edit', compact(
            'sub_unit_kerja',
            'urusan'
        ));
    }

    public function update(SubUnitKerja $sub_unit_kerja, SubUnitKerjaRequest $request)
    {
        $sub_unit_kerja->update($request->validated());

        return response()->json(['message' => 'Data berhasil diubah.']);
    }

    public function destroy(SubUnitKerja $sub_unit_kerja)
    {
        $sub_unit_kerja->delete();

        return response()->json(['message' => 'Data berhasil dihapus.']);
    }
}

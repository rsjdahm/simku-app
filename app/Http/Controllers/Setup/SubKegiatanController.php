<?php

namespace App\Http\Controllers\Setup;

use App\Http\Controllers\Controller;
use App\Http\Requests\Setup\SubKegiatanRequest;
use App\Models\Setup\Bidang;
use App\Models\Setup\Kegiatan;
use App\Models\Setup\SubKegiatan;
use App\Models\Setup\Program;
use App\Models\Setup\Urusan;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Yajra\DataTables\Html\Builder;

class SubKegiatanController extends Controller
{
    public function index(Builder $builder, Request $request)
    {
        if ($request->wantsJson()) {
            $data = SubKegiatan::whereHas('kegiatan.program.bidang.urusan', function ($q) use ($request) {
                $q->when($request->filled('urusan_id'), function ($q) use ($request) {
                    $q->where('id', $request->urusan_id);
                });
            })->whereHas('kegiatan.program.bidang', function ($q) use ($request) {
                $q->when($request->filled('bidang_id'), function ($q) use ($request) {
                    $q->where('id', $request->bidang_id);
                });
            })->whereHas('kegiatan.program', function ($q) use ($request) {
                $q->when($request->filled('program_id'), function ($q) use ($request) {
                    $q->where('id', $request->program_id);
                });
            })->whereHas('kegiatan', function ($q) use ($request) {
                $q->when($request->filled('kegiatan_id'), function ($q) use ($request) {
                    $q->where('id', $request->kegiatan_id);
                });
            })
                ->get();


            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('action', '<div class="btn-group btn-group-sm" role="group"><button type="button" class="btn btn-warning dropdown-toggle" data-toggle="dropdown"><i class="fas fa-wrench"></i></button><div class="dropdown-menu"><a data-load="modal" title="Edit Nomenklatur Sub Kegiatan" href="{{ route("sub-kegiatan.edit", $id) }}" class="dropdown-item">Edit</a><a data-action="delete" href="{{ route("sub-kegiatan.destroy", $id) }}" class="dropdown-item text-danger">Hapus</a></div></div>')
                ->addColumn('kode_lengkap', '{{ $kode_lengkap }}')
                ->toJson();
        }

        $table = $builder->ajax([
            'url' => route('sub-kegiatan.index'),
            'data' => 'function(d) {
                d.urusan_id = $("select[name=\'urusan_id_filter\']").val();
                d.bidang_id = $("select[name=\'bidang_id_filter\']").val();
                d.program_id = $("select[name=\'program_id_filter\']").val();
                d.kegiatan_id = $("select[name=\'kegiatan_id_filter\']").val();
            }',
        ])
            ->addAction(['title' => '', 'style' => 'width: 1%;', 'orderable' => false])
            ->addIndex(['title' => 'No.', 'style' => 'width: 1%;', 'class' => 'text-center', 'orderable' => false])
            ->addColumn(['data' => 'kode_lengkap', 'title' => 'Kode Sub Kegiatan', 'class' => 'text-nowrap font-weight-bold', 'style' => 'width: 1%;'])
            ->addColumn(['data' => 'nama', 'title' => 'Nomenklatur Sub Kegiatan'])
            ->parameters([
                'order' => [
                    2, 'asc'
                ]
            ]);

        $urusan = Urusan::all();
        $bidang = Bidang::all();
        $program = Program::all();
        $kegiatan = Kegiatan::all();

        return view('pages.setup.sub-kegiatan.index', compact(
            'table',
            'urusan',
            'bidang',
            'program',
            'kegiatan'
        ));
    }

    public function create()
    {
        $urusan = Urusan::all();
        $bidang = Bidang::all();
        $program = Program::all();
        $kegiatan = Kegiatan::all();

        return view('pages.setup.sub-kegiatan.create', compact(
            'urusan',
            'bidang',
            'program',
            'kegiatan'
        ));
    }

    public function store(SubKegiatanRequest $request)
    {
        SubKegiatan::create($request->validated());

        return response()->json(['message' => 'Data berhasil ditambah.']);
    }

    public function edit(SubKegiatan $sub_kegiatan)
    {
        $urusan = Urusan::all();
        $bidang = Bidang::all();
        $program = Program::all();
        $kegiatan = Kegiatan::all();

        return view('pages.setup.sub-kegiatan.edit', compact(
            'sub_kegiatan',
            'urusan',
            'bidang',
            'program',
            'kegiatan'
        ));
    }

    public function update(SubKegiatan $sub_kegiatan, SubKegiatanRequest $request)
    {
        $sub_kegiatan->update($request->validated());

        return response()->json(['message' => 'Data berhasil diubah.']);
    }

    public function destroy(SubKegiatan $sub_kegiatan)
    {
        $sub_kegiatan->delete();

        return response()->json(['message' => 'Data berhasil dihapus.']);
    }
}

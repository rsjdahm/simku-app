<?php

namespace App\Http\Controllers\Setup;

use App\Http\Controllers\Controller;
use App\Http\Requests\Setup\KegiatanRequest;
use App\Models\Setup\Bidang;
use App\Models\Setup\Kegiatan;
use App\Models\Setup\Program;
use App\Models\Setup\Urusan;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Yajra\DataTables\Html\Builder;

class KegiatanController extends Controller
{
    public function __construct(
        Urusan $urusan,
        Bidang $bidang,
        Program $program,
        Kegiatan $kegiatan
    ) {
        $this->urusan = $urusan;
        $this->bidang = $bidang;
        $this->program = $program;
        $this->kegiatan = $kegiatan;
    }

    public function index(Builder $builder, Request $request)
    {
        if ($request->wantsJson()) {
            $data = $this->kegiatan
                ->whereHas('program.bidang.urusan', function ($q) use ($request) {
                    $q->when($request->filled('urusan_id'), function ($q) use ($request) {
                        $q->where('id', $request->urusan_id);
                    });
                })->whereHas('program.bidang', function ($q) use ($request) {
                    $q->when($request->filled('bidang_id'), function ($q) use ($request) {
                        $q->where('id', $request->bidang_id);
                    });
                })->whereHas('program', function ($q) use ($request) {
                    $q->when($request->filled('program_id'), function ($q) use ($request) {
                        $q->where('id', $request->program_id);
                    });
                })
                ->get();

            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('action', '<div class="btn-group btn-group-sm" role="group"><button type="button" class="btn btn-warning dropdown-toggle" data-toggle="dropdown"><i class="fas fa-wrench"></i></button><div class="dropdown-menu"><a data-load="modal" title="Edit Nomenklatur Kegiatan" href="{{ route("kegiatan.edit", $id) }}" class="dropdown-item">Edit</a><a data-action="delete" href="{{ route("kegiatan.destroy", $id) }}" class="dropdown-item text-danger">Hapus</a></div></div>')
                ->addColumn('kode_lengkap', '{{ $kode_lengkap }}')
                ->toJson();
        }

        $table = $builder->ajax([
            'url' => route('kegiatan.index'),
            'data' => 'function(d) {
                d.urusan_id = $("select[name=\'urusan_id_filter\']").val();
                d.bidang_id = $("select[name=\'bidang_id_filter\']").val();
                d.program_id = $("select[name=\'program_id_filter\']").val();
            }',
        ])
            ->addAction(['title' => '', 'style' => 'width: 1%;', 'orderable' => false])
            ->addIndex(['title' => 'No.', 'style' => 'width: 1%;', 'class' => 'text-center', 'orderable' => false])
            ->addColumn(['data' => 'kode_lengkap', 'title' => 'Kode Kegiatan', 'class' => 'text-nowrap font-weight-bold', 'style' => 'width: 1%;'])
            ->addColumn(['data' => 'nama', 'title' => 'Nomenklatur Kegiatan'])
            ->parameters([
                'order' => [
                    2, 'asc'
                ]
            ]);

        $urusan = Urusan::all();
        $bidang = Bidang::all();
        $program = Program::all();

        return view('pages.setup.kegiatan.index', compact(
            'table',
            'urusan',
            'bidang',
            'program'
        ));
    }

    public function create()
    {
        $urusan = Urusan::all();
        $bidang = Bidang::all();
        $program = Program::all();

        return view('pages.setup.kegiatan.create', compact(
            'urusan',
            'bidang',
            'program'
        ));
    }

    public function store(KegiatanRequest $request)
    {
        $this->kegiatan->create($request->validated());

        return response()->json(['message' => 'Data berhasil ditambah.']);
    }

    public function edit(Kegiatan $kegiatan)
    {
        $urusan = Urusan::all();
        $bidang = Bidang::all();
        $program = Program::all();

        return view('pages.setup.kegiatan.edit', compact(
            'kegiatan',
            'urusan',
            'bidang',
            'program'
        ));
    }

    public function update(Kegiatan $kegiatan, KegiatanRequest $request)
    {
        $kegiatan->update($request->validated());

        return response()->json(['message' => 'Data berhasil diubah.']);
    }

    public function destroy(Kegiatan $kegiatan)
    {
        $kegiatan->delete();

        return response()->json(['message' => 'Data berhasil dihapus.']);
    }
}

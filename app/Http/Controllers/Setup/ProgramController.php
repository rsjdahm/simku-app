<?php

namespace App\Http\Controllers\Setup;

use App\Http\Controllers\Controller;
use App\Http\Requests\Setup\ProgramRequest;
use App\Models\Setup\Bidang;
use App\Models\Setup\Program;
use App\Models\Setup\Urusan;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Yajra\DataTables\Html\Builder;

class ProgramController extends Controller
{
    public function __construct(
        Urusan $urusan,
        Bidang $bidang,
        Program $program
    ) {
        $this->urusan = $urusan;
        $this->bidang = $bidang;
        $this->program = $program;
    }


    public function index(Builder $builder, Request $request)
    {
        if ($request->wantsJson()) {
            $data = $this->program
                ->whereHas('bidang.urusan', function ($q) use ($request) {
                    $q->when($request->urusan_id, function ($q) use ($request) {
                        $q->where('id', $request->urusan_id);
                    });
                })->whereHas('bidang', function ($q) use ($request) {
                    $q->when($request->bidang_id, function ($q) use ($request) {
                        $q->where('id', $request->bidang_id);
                    });
                })
                ->get();

            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('action', '<div class="btn-group btn-group-sm" role="group"><button type="button" class="btn btn-warning dropdown-toggle" data-toggle="dropdown"><i class="fas fa-wrench"></i></button><div class="dropdown-menu"><a data-load="modal" title="Edit Nomenklatur Program" href="{{ route("program.edit", $id) }}" class="dropdown-item">Edit</a><a data-action="delete" href="{{ route("program.destroy", $id) }}" class="dropdown-item text-danger">Hapus</a></div></div>')
                ->addColumn('kode_lengkap', '{{ $kode_lengkap }}')
                ->toJson();
        }

        $table = $builder->ajax([
            'url' => route('program.index'),
            'data' => 'function(d) {
                d.urusan_id = $("select[name=\'urusan_id_filter\']").val();
                d.bidang_id = $("select[name=\'bidang_id_filter\']").val();
            }',
        ])
            ->addAction(['title' => '', 'style' => 'width: 1%;', 'orderable' => false])
            ->addIndex(['title' => 'No.', 'style' => 'width: 1%;', 'class' => 'text-center', 'orderable' => false])
            ->addColumn(['data' => 'kode_lengkap', 'title' => 'Kode Program', 'class' => 'font-weight-bold', 'style' => 'width: 1%;'])
            ->addColumn(['data' => 'nama', 'title' => 'Nomenklatur Program'])
            ->parameters([
                'order' => [
                    2, 'asc'
                ]
            ]);
        return view('pages.setup.program.index', [
            'table' => $table,
            'urusan' => $this->urusan->get(),
            'bidang' => $this->bidang->get()
        ]);
    }

    public function create()
    {
        return view('pages.setup.program.create', [
            'urusan' => $this->urusan->get(),
            'bidang' => $this->bidang->get()
        ]);
    }

    public function store(ProgramRequest $request)
    {
        $this->program->create($request->validated());

        return response()->json(['message' => 'Data berhasil ditambah.']);
    }

    public function edit(Program $program)
    {
        return view('pages.setup.program.edit', [
            'program' => $program,
            'urusan' => $this->urusan->get(),
            'bidang' => $this->bidang->get()
        ]);
    }

    public function update(Program $program, ProgramRequest $request)
    {
        $program->update($request->validated());

        return response()->json(['message' => 'Data berhasil diubah.']);
    }

    public function destroy(Program $program)
    {
        $program->delete();

        return response()->json(['message' => 'Data berhasil dihapus.']);
    }
}

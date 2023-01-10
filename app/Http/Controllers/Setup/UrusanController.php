<?php

namespace App\Http\Controllers\Setup;

use App\Http\Controllers\Controller;
use App\Http\Requests\Setup\UrusanRequest;
use App\Models\Setup\Urusan;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Yajra\DataTables\Html\Builder;

class UrusanController extends Controller
{
    public function __construct(
        Urusan $urusan
    ) {
        $this->urusan = $urusan;
    }

    public function index(Builder $builder, Request $request)
    {
        if ($request->wantsJson()) :

            $data = $this->urusan->get();

            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('action', '<div class="btn-group btn-group-sm" role="group"><button type="button" class="btn btn-warning dropdown-toggle" data-toggle="dropdown"><i class="fas fa-wrench"></i></button><div class="dropdown-menu"><a data-load="modal" title="Edit Nomenklatur Urusan" href="{{ route("urusan.edit", $id) }}" class="dropdown-item">Edit</a><a data-action="delete" href="{{ route("urusan.destroy", $id) }}" class="dropdown-item text-danger">Hapus</a></div></div>')
                ->addColumn('kode_lengkap', '{{ $kode_lengkap }}')
                ->toJson();
        else :

            $table = $builder->ajax(route('urusan.index'))
                ->addAction(['title' => '', 'style' => 'width: 1%;', 'orderable' => false])
                ->addColumn(['data' => 'kode_lengkap', 'title' => 'Kode Urusan', 'class' => 'text-center font-weight-bold', 'style' => 'width: 1%;'])
                ->addColumn(['data' => 'nama', 'title' => 'Nomenklatur Urusan'])
                ->parameters([
                    'order' => [
                        1, 'asc'
                    ]
                ]);

            return view('pages.setup.urusan.index', [
                'table' => $table
            ]);

        endif;
    }

    public function create()
    {
        return view('pages.setup.urusan.create');
    }

    public function store(UrusanRequest $request)
    {
        $this->urusan->create($request->validated());

        return response()->json(['message' => 'Data Urusan berhasil ditambah.']);
    }

    public function edit(Urusan $urusan)
    {
        return view('pages.setup.urusan.edit', [
            'urusan' => $urusan
        ]);
    }

    public function update(Urusan $urusan, UrusanRequest $request)
    {
        $urusan->update($request->validated());

        return response()->json(['message' => 'Data Urusan berhasil diubah.']);
    }

    public function destroy(Urusan $urusan)
    {
        $urusan->delete();

        return response()->json(['message' => 'Data Urusan berhasil dihapus.']);
    }
}

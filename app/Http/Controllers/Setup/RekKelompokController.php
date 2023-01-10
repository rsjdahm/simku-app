<?php

namespace App\Http\Controllers\Setup;

use App\Http\Controllers\Controller;
use App\Http\Requests\Setup\RekKelompokRequest;
use App\Models\Setup\RekKelompok;
use App\Models\Setup\RekAkun;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Yajra\DataTables\Html\Builder;

class RekKelompokController extends Controller
{
    public function index(Builder $builder, Request $request)
    {
        if ($request->wantsJson()) :
            $data = RekKelompok::whereHas('rek_akun', function ($q) use ($request) {
                $q->when($request->filled('rek_akun_id'), function ($q) use ($request) {
                    $q->where('id', $request->rek_akun_id);
                });
            })
                ->get();

            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('action', '<div class="btn-group btn-group-sm" role="group"><button type="button" class="btn btn-warning dropdown-toggle" data-toggle="dropdown"><i class="fas fa-wrench"></i></button><div class="dropdown-menu"><a data-load="modal" title="Edit Rekening Kelompok" href="{{ route("rek-kelompok.edit", $id) }}" class="dropdown-item">Edit</a><a data-action="delete" href="{{ route("rek-kelompok.destroy", $id) }}" class="dropdown-item text-danger">Hapus</a></div></div>')
                ->addColumn('kode_lengkap', '{{ $kode_lengkap }}')
                ->toJson();
        else :

            $table = $builder->ajax([
                'url' => route('rek-kelompok.index'),
                'data' => 'function(d) {
                d.rek_akun_id = $("select[name=\'rek_akun_id_filter\']").val();
            }',
            ])
                ->addAction(['title' => '', 'style' => 'width: 1%;', 'orderable' => false])
                ->addIndex(['title' => 'No.', 'style' => 'width: 1%;', 'class' => 'text-center', 'orderable' => false])
                ->addColumn(['data' => 'kode_lengkap', 'title' => 'Kode Rekening Kelompok', 'class' => 'font-weight-bold text-center', 'style' => 'width: 1%;'])
                ->addColumn(['data' => 'nama', 'title' => 'Rekening Kelompok'])
                ->parameters([
                    'order' => [
                        2, 'asc'
                    ]
                ]);

            $rek_akun = RekAkun::all();

            return view('pages.setup.rek-kelompok.index', compact(
                'table',
                'rek_akun'
            ));
        endif;
    }

    public function create()
    {
        $rek_akun = RekAkun::all();
        return view('pages.setup.rek-kelompok.create', compact('rek_akun'));
    }

    public function store(RekKelompokRequest $request)
    {
        RekKelompok::create($request->validated());

        return response()->json(['message' => 'Data berhasil ditambah.']);
    }

    public function edit(RekKelompok $rek_kelompok)
    {
        $rek_akun = RekAkun::all();
        return view('pages.setup.rek-kelompok.edit', compact('rek_kelompok', 'rek_akun'));
    }

    public function update(RekKelompok $rek_kelompok, RekKelompokRequest $request)
    {
        $rek_kelompok->update($request->validated());

        return response()->json(['message' => 'Data berhasil diubah.']);
    }

    public function destroy(RekKelompok $rek_kelompok)
    {
        $rek_kelompok->delete();

        return response()->json(['message' => 'Data berhasil dihapus.']);
    }
}

<?php

namespace App\Http\Controllers\Setup;

use App\Enums\Setup\JenisRekAkun;
use App\Http\Controllers\Controller;
use App\Http\Requests\Setup\RekAkunRequest;
use App\Models\Setup\RekAkun;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Yajra\DataTables\Html\Builder;

class RekAkunController extends Controller
{
    public function __construct(
        RekAkun $rek_akun
    ) {
        $this->rek_akun = $rek_akun;
    }

    public function index(Builder $builder, Request $request)
    {
        if ($request->wantsJson()) :
            $data = $this->rek_akun->get();

            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('action', '<div class="btn-group btn-group-sm" role="group"><button type="button" class="btn btn-warning dropdown-toggle" data-toggle="dropdown"><i class="fas fa-wrench"></i></button><div class="dropdown-menu"><a data-load="modal" title="Edit Nomenklatur Rekening Akun" href="{{ route("rek-akun.edit", $id) }}" class="dropdown-item">Edit</a><a data-action="delete" href="{{ route("rek-akun.destroy", $id) }}" class="dropdown-item text-danger">Hapus</a></div></div>')
                ->addColumn('kode_lengkap', '{{ $kode_lengkap }}')
                ->editColumn('jenis', function ($i) {
                    switch ($i->jenis) {
                        case JenisRekAkun::Belanja:
                            return '<span class="badge badge-danger"><i class="fas fa-sign-out-alt"></i> Belanja</span>';
                            break;
                        case JenisRekAkun::Pendapatan:
                            return '<span class="badge badge-success"><i class="fas fa-sign-in-alt"></i> Pendapatan</span>';
                            break;
                    }
                })
                ->rawColumns(['action', 'jenis'])
                ->toJson();
        endif;

        $table = $builder->ajax(route('rek-akun.index'))
            ->addAction(['title' => '', 'style' => 'width: 1%;', 'orderable' => false])
            ->addColumn(['data' => 'kode_lengkap', 'title' => 'Kode Rekening Akun', 'class' => 'font-weight-bold text-center', 'style' => 'width: 1%;'])
            ->addColumn(['data' => 'nama', 'title' => 'Uraian Rekening Akun'])
            ->addColumn(['data' => 'jenis', 'title' => 'Jenis Rekening'])
            ->parameters([
                'order' => [
                    1, 'asc'
                ]
            ]);

        return view('pages.setup.rek-akun.index', compact('table'));
    }

    public function create()
    {
        return view('pages.setup.rek-akun.create', [
            'jenis' => JenisRekAkun::cases()
        ]);
    }

    public function store(RekAkunRequest $request)
    {
        $this->rek_akun->create($request->validated());

        return response()->json(['message' => 'Data berhasil ditambah.']);
    }

    public function edit(RekAkun $rek_akun)
    {
        return view('pages.setup.rek-akun.edit', [
            'rek_akun' => $rek_akun,
            'jenis' => JenisRekAkun::cases()
        ]);
    }

    public function update(RekAkun $rek_akun, RekAkunRequest $request)
    {
        $rek_akun->update($request->validated());

        return response()->json(['message' => 'Data berhasil diubah.']);
    }

    public function destroy(RekAkun $rek_akun)
    {
        $rek_akun->delete();

        return response()->json(['message' => 'Data berhasil dihapus.']);
    }
}

<?php

namespace App\Http\Controllers\Setup;

use App\Http\Controllers\Controller;
use App\Http\Requests\Setup\RekObjekRequest;
use App\Models\Setup\RekObjek;
use App\Models\Setup\RekAkun;
use App\Models\Setup\RekJenis;
use App\Models\Setup\RekKelompok;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Yajra\DataTables\Html\Builder;

class RekObjekController extends Controller
{
    public function index(Builder $builder, Request $request)
    {
        if ($request->wantsJson()) {
            $data = RekObjek::whereHas('rek_jenis.rek_kelompok.rek_akun', function ($q) use ($request) {
                $q->when($request->filled('rek_akun_id'), function ($q) use ($request) {
                    $q->where('id', $request->rek_akun_id);
                });
            })->whereHas('rek_jenis.rek_kelompok', function ($q) use ($request) {
                $q->when($request->filled('rek_kelompok_id'), function ($q) use ($request) {
                    $q->where('id', $request->rek_kelompok_id);
                });
            })->whereHas('rek_jenis', function ($q) use ($request) {
                $q->when($request->filled('rek_jenis_id'), function ($q) use ($request) {
                    $q->where('id', $request->rek_jenis_id);
                });
            })
                ->get();

            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('action', '<div class="btn-group btn-group-sm" role="group"><button type="button" class="btn btn-warning dropdown-toggle" data-toggle="dropdown"><i class="fas fa-wrench"></i></button><div class="dropdown-menu"><a data-load="modal" title="Edit Rekening Objek" href="{{ route("rek-objek.edit", $id) }}" class="dropdown-item">Edit</a><a data-action="delete" href="{{ route("rek-objek.destroy", $id) }}" class="dropdown-item text-danger">Hapus</a></div></div>')
                ->addColumn('kode_lengkap', '{{ $kode_lengkap }}')
                ->toJson();
        }

        $table = $builder->ajax([
            'url' => route('rek-objek.index'),
            'data' => 'function(d) {
                d.rek_akun_id = $("select[name=\'rek_akun_id_filter\']").val();
                d.rek_kelompok_id = $("select[name=\'rek_kelompok_id_filter\']").val();
                d.rek_jenis_id = $("select[name=\'rek_jenis_id_filter\']").val();
            }',
        ])
            ->addAction(['title' => '', 'style' => 'width: 1%;', 'orderable' => false])
            ->addIndex(['title' => 'No.', 'style' => 'width: 1%;', 'class' => 'text-center', 'orderable' => false])
            ->addColumn(['data' => 'kode_lengkap', 'title' => 'Kode Rekening Objek', 'class' => 'font-weight-bold text-center', 'style' => 'width: 1%;'])
            ->addColumn(['data' => 'nama', 'title' => 'Rekening Objek'])
            ->parameters([
                'order' => [
                    2, 'asc'
                ]
            ]);

        $rek_akun = RekAkun::all();
        $rek_kelompok = RekKelompok::all();
        $rek_jenis = RekJenis::all();

        return view('pages.setup.rek-objek.index', compact(
            'table',
            'rek_akun',
            'rek_kelompok',
            'rek_jenis'
        ));
    }

    public function create()
    {
        $rek_akun = RekAkun::with([
            'rek_kelompok',
            'rek_kelompok.rek_jenis',
        ])
            ->get();

        return view('pages.setup.rek-objek.create', compact(
            'rek_akun',
        ));
    }

    public function store(RekObjekRequest $request)
    {
        RekObjek::create($request->validated());

        return response()->json(['message' => 'Data berhasil ditambah.']);
    }

    public function edit(RekObjek $rek_objek)
    {
        $rek_akun = RekAkun::with([
            'rek_kelompok',
            'rek_kelompok.rek_jenis',
        ])
            ->get();

        return view('pages.setup.rek-objek.edit', compact(
            'rek_objek',
            'rek_akun',
        ));
    }

    public function update(RekObjek $rek_objek, RekObjekRequest $request)
    {
        $rek_objek->update($request->validated());

        return response()->json(['message' => 'Data berhasil diubah.']);
    }

    public function destroy(RekObjek $rek_objek)
    {
        $rek_objek->delete();

        return response()->json(['message' => 'Data berhasil dihapus.']);
    }

    public function printPdfDaftar()
    {
        $rek_akun = RekAkun::get();

        $pdf = Pdf::loadView('pages.setup.rek-objek.pdf-daftar', compact(
            'rek_akun',
        ));
        return $pdf->stream('Daftar Rekening Standar.pdf');
    }
}

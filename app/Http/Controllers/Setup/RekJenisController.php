<?php

namespace App\Http\Controllers\Setup;

use App\Http\Controllers\Controller;
use App\Http\Requests\Setup\RekJenisRequest;
use App\Models\Setup\RekJenis;
use App\Models\Setup\RekAkun;
use App\Models\Setup\RekKelompok;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Yajra\DataTables\Html\Builder;

class RekJenisController extends Controller
{
    public function index(Builder $builder, Request $request)
    {
        if ($request->wantsJson()) {
            $data = RekJenis::whereHas('rek_kelompok.rek_akun', function ($q) use ($request) {
                $q->when($request->filled('rek_akun_id'), function ($q) use ($request) {
                    $q->where('id', $request->rek_akun_id);
                });
            })->whereHas('rek_kelompok', function ($q) use ($request) {
                $q->when($request->filled('rek_kelompok_id'), function ($q) use ($request) {
                    $q->where('id', $request->rek_kelompok_id);
                });
            })
                ->get();

            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('action', '<div class="btn-group btn-group-sm" role="group"><button type="button" class="btn btn-warning dropdown-toggle" data-toggle="dropdown"><i class="fas fa-wrench"></i></button><div class="dropdown-menu"><a data-load="modal" title="Edit Rekening Jenis" href="{{ route("rek-jenis.edit", $id) }}" class="dropdown-item">Edit</a><a data-action="delete" href="{{ route("rek-jenis.destroy", $id) }}" class="dropdown-item text-danger">Hapus</a></div></div>')
                ->addColumn('kode_lengkap', '{{ $kode_lengkap }}')
                ->toJson();
        }

        $table = $builder->ajax([
            'url' => route('rek-jenis.index'),
            'data' => 'function(d) {
                d.rek_akun_id = $("select[name=\'rek_akun_id_filter\']").val();
                d.rek_kelompok_id = $("select[name=\'rek_kelompok_id_filter\']").val();
            }',
        ])
            ->addAction(['title' => '', 'style' => 'width: 1%;', 'orderable' => false])
            ->addIndex(['title' => 'No.', 'style' => 'width: 1%;', 'class' => 'text-center', 'orderable' => false])
            ->addColumn(['data' => 'kode_lengkap', 'title' => 'Kode Rekening Jenis', 'class' => 'font-weight-bold text-center', 'style' => 'width: 1%;'])
            ->addColumn(['data' => 'nama', 'title' => 'Rekening Jenis'])
            ->parameters([
                'order' => [
                    2, 'asc'
                ]
            ]);

        $rek_akun = RekAkun::all();
        $rek_kelompok = RekKelompok::all();

        return view('pages.setup.rek-jenis.index', compact(
            'table',
            'rek_akun',
            'rek_kelompok'
        ));
    }

    public function create()
    {
        $rek_akun = RekAkun::with([
            'rek_kelompok'
        ])
            ->get();

        return view('pages.setup.rek-jenis.create', compact(
            'rek_akun',
        ));
    }

    public function store(RekJenisRequest $request)
    {
        RekJenis::create($request->validated());

        return response()->json(['message' => 'Data berhasil ditambah.']);
    }

    public function edit(RekJenis $rek_jeni)
    {
        $rek_jenis = $rek_jeni;
        $rek_akun = RekAkun::with([
            'rek_kelompok'
        ])
            ->get();

        return view('pages.setup.rek-jenis.edit', compact(
            'rek_jenis',
            'rek_akun',
        ));
    }

    public function update(RekJenis $rek_jeni, RekJenisRequest $request)
    {
        $rek_jenis = $rek_jeni;
        $rek_jenis->update($request->validated());

        return response()->json(['message' => 'Data berhasil diubah.']);
    }

    public function destroy(RekJenis $rek_jeni)
    {
        $rek_jenis = $rek_jeni;
        $rek_jenis->delete();

        return response()->json(['message' => 'Data berhasil dihapus.']);
    }

    public function printPdfDaftar()
    {
        $rek_akun = RekAkun::get();

        $pdf = Pdf::loadView('pages.setup.rek-jenis.pdf-daftar', compact(
            'rek_akun',
        ));
        return $pdf->stream('Daftar Rekening Standar.pdf');
    }
}

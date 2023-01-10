<?php

namespace App\Http\Controllers\Anggaran;

use App\Enums\Anggaran\StatusRkaPd;
use App\Http\Controllers\Controller;
use App\Http\Requests\Anggaran\RkaPdRequest;
use App\Models\Anggaran\BelanjaRkaPd;
use App\Models\Anggaran\RkaPd;
use App\Models\Setup\RekAkun;
use App\Models\Setup\RekJenis;
use App\Models\Setup\RekKelompok;
use App\Models\Setup\RekObjek;
use App\Models\Setup\RekRincianObjek;
use App\Models\Setup\RekSubRincianObjek;
use App\Models\Setup\SubUnitKerja;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Yajra\DataTables\Html\Builder;

class RkaPdController extends Controller
{
    public function __construct(
        SubUnitKerja $sub_unit_kerja,
        RkaPd $rka_pd,
        // BelanjaRkaPd $belanja_rka_pd,
        RekAkun $rek_akun
    ) {
        $this->sub_unit_kerja = $sub_unit_kerja;
        $this->rka_pd = $rka_pd;
        // $this->belanja_rka_pd = $belanja_rka_pd;
        $this->rek_akun = $rek_akun;
    }

    public function index(Builder $builder, Request $request)
    {
        if ($request->wantsJson()) :

            $data = $this->rka_pd
                ->with('belanja_rka_pd')
                ->whereHas('sub_unit_kerja', function ($q) use ($request) {
                    $q->when($request->filled('sub_unit_kerja_id'), function ($q) use ($request) {
                        $q->where('id', $request->sub_unit_kerja_id);
                    });
                })
                ->get();

            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('action', '<button type="button" class="btn btn-sm btn-warning dropdown-toggle" data-toggle="dropdown"><i class="fas fa-wrench"></i></button><div class="dropdown-menu"><a data-load="modal" data-size="lg" title="Edit Rencana Anggaran" href="{{ route("rka-pd.edit", $id) }}" class="dropdown-item">Edit</a><a data-action="delete" href="{{ route("rka-pd.destroy", $id) }}" class="dropdown-item text-danger">Hapus</a></div>')
                ->addColumn('print', '<a data-load="modal-pdf" title="Cetak Rincian Anggaran" href="{{ route("rka-pd.pdf-pagu-belanja", $id) }}" class="btn btn-sm btn-success"><i class="fas fa-print"></i></a>')
                ->editColumn('status', function ($i) {
                    switch ($i->status) {
                        case StatusRkaPd::Murni:
                            return '<span class="badge badge-primary">Murni</span>';
                            break;
                        case StatusRkaPd::Pergeseran:
                            return '<span class="badge badge-info">Pergeseran</span>';
                            break;
                        case StatusRkaPd::Perubahan:
                            return '<span class="badge badge-success">Perubahan</span>';
                            break;
                        case StatusRkaPd::AmbangBatas:
                            return '<span class="badge badge-warning">Ambang Batas</span>';
                            break;
                        default:
                            return '<span class="badge badge-secondary">-</span>';
                            break;
                    }
                })
                ->editColumn('pagu_belanja', function ($i) {
                    return $i->belanja_rka_pd->sum('nilai');
                })
                ->rawColumns(['action', 'status', 'print'])
                ->toJson();

        else :

            $table = $builder->ajax([
                'url' => route('rka-pd.index'),
                'data' => 'function(d) {
                    d.sub_unit_kerja_id = $("select[name=\'sub_unit_kerja_id_filter\']").val();
                }',
            ])
                ->addAction(['title' => '', 'style' => 'width: 1%;', 'orderable' => false])
                ->addIndex(['title' => 'No.', 'style' => 'width: 1%;', 'class' => 'text-center', 'orderable' => false])
                ->addColumn(['data' => 'sub_unit_kerja.nama', 'title' => 'Nama SKPD'])
                ->addColumn(['data' => 'nomor', 'title' => 'Nomor Dokumen', 'class' => 'text-center'])
                ->addColumn(['data' => 'tanggal', 'title' => 'Tanggal Dokumen', 'class' => 'text-center'])
                ->addColumn(['data' => 'uraian', 'title' => 'Uraian Dokumen Rencana Anggaran'])
                ->addColumn(['data' => 'print', 'title' => '', 'class' => 'text-center', 'orderable' => false])
                ->addColumn(['data' => 'pagu_pendapatan', 'title' => 'Pendapatan', 'class' => 'text-right'])
                ->addColumn(['data' => 'pagu_belanja', 'title' => 'Belanja', 'class' => 'text-right'])
                ->addColumn(['data' => 'pagu_pembiayaan', 'title' => 'Pembiayaan', 'class' => 'text-right'])
                ->addColumn(['data' => 'status', 'title' => 'Status Rencana Anggaran', 'class' => 'text-center'])
                ->parameters([
                    "initComplete" => "function(settings, json) {
                    //menambah rowspan ke kolom yg tidak digeser
                    $('#rka-pd-table thead tr:nth-child(1) th').filter(':nth-child(1),:nth-child(2),:nth-child(3),:nth-child(4),:nth-child(5),:nth-child(6),:nth-child(7),:nth-child(11)').attr('rowspan', '2');
                    //menambah tr baru setelah tr lama
                    $('#rka-pd-table thead').append('<tr role=\"row\"></tr>');
                    //menggeser kolom yg tidak dirowspan ke tr baru
                    $('#rka-pd-table thead tr:nth-child(1) th').filter(':nth-child(8),:nth-child(9),:nth-child(10)').prependTo('#rka-pd-table thead tr:nth-child(2)');
                    //menambah kolom colspan ke tr lama
                    $('<th colspan=\"3\" class=\"text-center align-middle\">Pagu Anggaran</th>').insertAfter('#rka-pd-table thead tr:nth-child(1) th:nth-child(7)');
                }",
                    'order' => [
                        2, 'asc'
                    ],
                    'columnDefs' => [
                        [
                            'targets' => [4],
                            'render' => 'function (data) {
                                if (data) {
                                    return moment(data).format("DD/MM/YYYY");
                                }
                            }'
                        ],
                        [
                            'targets' => [7, 8, 9],
                            'render' => '$.fn.dataTable.render.number(".", ",", 2, "")'
                        ],
                    ]
                ]);

            return view('pages.anggaran.rka-pd.index', [
                'table' => $table,
                'sub_unit_kerja' => $this->sub_unit_kerja->get()
            ]);

        endif;
    }

    public function create()
    {
        return view('pages.anggaran.rka-pd.create', [
            'sub_unit_kerja' => $this->sub_unit_kerja->get(),
            'status' => StatusRkaPd::cases()
        ]);
    }

    public function store(RkaPdRequest $request)
    {
        $this->rka_pd->create($request->validated());

        return response()->json(['message' => 'Data berhasil ditambah.']);
    }

    public function edit(RkaPd $rka_pd)
    {
        return view('pages.anggaran.rka-pd.edit', [
            'rka_pd' => $rka_pd,
            'sub_unit_kerja' => $this->sub_unit_kerja->get(),
            'status' => StatusRkaPd::cases()
        ]);
    }

    public function update(RkaPd $rka_pd, RkaPdRequest $request)
    {
        $rka_pd->update($request->validated());

        return response()->json(['message' => 'Data berhasil diubah.']);
    }

    public function destroy(RkaPd $rka_pd)
    {
        $rka_pd->delete();

        return response()->json(['message' => 'Data berhasil dihapus.']);
    }

    public function printPdfPaguBelanja($rka_pd_id = null)
    {
        $rka_pd = RkaPd::where('id', $rka_pd_id)->first();

        $belanja_rka_pd = BelanjaRkaPd::when($rka_pd_id, function ($q) use ($rka_pd_id) {
            $q->where('rka_pd_id', $rka_pd_id);
        })
            ->get();

        $rek_sub_rincian_objek = RekSubRincianObjek::whereIn('id', $belanja_rka_pd->pluck('rek_sub_rincian_objek_id'))
            ->get()
            ->sortBy('kode_lengkap');

        $rek_rincian_objek = RekRincianObjek::whereIn('id', $rek_sub_rincian_objek->pluck('rek_rincian_objek_id'))
            ->get()
            ->sortBy('kode_lengkap');

        $rek_objek = RekObjek::whereIn('id', $rek_rincian_objek->pluck('rek_objek_id'))
            ->get()
            ->sortBy('kode_lengkap');

        $rek_jenis = RekJenis::whereIn('id', $rek_objek->pluck('rek_jenis_id'))
            ->get()
            ->sortBy('kode_lengkap');

        $rek_kelompok = RekKelompok::whereIn('id', $rek_jenis->pluck('rek_kelompok_id'))
            ->get()
            ->sortBy('kode_lengkap');

        $rek_akun = RekAkun::whereIn('id', $rek_kelompok->pluck('rek_akun_id'))
            ->get()
            ->sortBy('kode_lengkap');


        return Pdf::loadView('pages.anggaran.rka-pd.pdf-pagu-belanja', compact(
            'rka_pd',
            'belanja_rka_pd',
            'rek_sub_rincian_objek',
            'rek_rincian_objek',
            'rek_objek',
            'rek_jenis',
            'rek_kelompok',
            'rek_akun',
        ))
            ->setPaper('a4', 'landscape')
            ->stream('Pagu Belanja.pdf');
    }
}

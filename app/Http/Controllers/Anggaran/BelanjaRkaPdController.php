<?php

namespace App\Http\Controllers\Anggaran;

use App\Enums\Anggaran\StatusRkaPd;
use App\Http\Controllers\Controller;
use App\Http\Requests\Anggaran\BelanjaRkaPdRequest;
use App\Models\Anggaran\BelanjaRkaPd;
use App\Models\Anggaran\RkaPd;
use App\Models\Setup\RekAkun;
use App\Models\Setup\SubKegiatan;
use App\Models\Setup\SubUnitKerja;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Yajra\DataTables\Html\Builder;

class BelanjaRkaPdController extends Controller
{
    public function __construct(
        SubUnitKerja $sub_unit_kerja,
        RkaPd $rka_pd,
        SubKegiatan $sub_kegiatan,
        RekAkun $rek_akun,
        BelanjaRkaPd $belanja_rka_pd
    ) {
        $this->sub_unit_kerja = $sub_unit_kerja;
        $this->rka_pd = $rka_pd;
        $this->sub_kegiatan = $sub_kegiatan;
        $this->rek_akun = $rek_akun;
        $this->belanja_rka_pd = $belanja_rka_pd;
    }

    public function index(Builder $builder, Request $request)
    {
        if ($request->wantsJson()) :

            $data = $this->belanja_rka_pd
                ->whereHas('rka_pd.sub_unit_kerja', function ($q) use ($request) {
                    $q->when($request->sub_unit_kerja_id, function ($q) use ($request) {
                        $q->where('id', $request->sub_unit_kerja_id);
                    });
                })->whereHas('rka_pd', function ($q) use ($request) {
                    $q->when($request->rka_pd_id, function ($q) use ($request) {
                        $q->where('id', $request->rka_pd_id);
                    });
                })
                ->get()
                ->sortBy('rek_sub_rincian_objek.kode_lengkap');

            return DataTables::of($data)
                ->with('total_nilai', $data->sum(function ($i) {
                    return $i->nilai;
                }))
                ->addIndexColumn()
                ->addColumn('action', '<div class="btn-group btn-group-sm" role="group"><button type="button" class="btn btn-warning dropdown-toggle" data-toggle="dropdown"><i class="fas fa-wrench"></i></button><div class="dropdown-menu"><a data-load="modal" data-size="lg" title="Edit Rincian Belanja" href="{{ route("belanja-rka-pd.edit", $id) }}" class="dropdown-item">Edit</a><a data-action="delete" href="{{ route("belanja-rka-pd.destroy", $id) }}" class="dropdown-item text-danger">Hapus</a></div></div>')
                ->editColumn('rka_pd.status', function ($i) {
                    switch ($i->rka_pd->status) {
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
                ->rawColumns(['action', 'rka_pd.status'])
                ->toJson();

        else :

            $table = $builder->ajax([
                'url' => route('belanja-rka-pd.index'),
                'data' => 'function(d) {
                d.sub_unit_kerja_id = $("select[name=\'sub_unit_kerja_id_filter\']").val();
                d.rka_pd_id = $("select[name=\'rka_pd_id_filter\']").val();
            }',
            ])
                ->addAction(['title' => '', 'style' => 'width: 1%;', 'orderable' => false])
                ->addIndex(['title' => 'No.', 'style' => 'width: 1%;', 'class' => 'text-center', 'orderable' => false])
                ->addColumn(['data' => 'sub_kegiatan.kode_lengkap_nama', 'title' => 'Sub Kegiatan'])
                ->addColumn(['data' => 'rek_sub_rincian_objek.rek_rincian_objek.rek_objek.rek_jenis.rek_kelompok.kode_lengkap_nama', 'title' => 'Kode Rekening'])
                ->addColumn(['data' => 'rek_sub_rincian_objek.rek_rincian_objek.rek_objek.rek_jenis.kode_lengkap_nama', 'title' => 'Kode Rekening'])
                ->addColumn(['data' => 'rek_sub_rincian_objek.rek_rincian_objek.rek_objek.kode_lengkap_nama', 'title' => 'Kode Rekening'])
                ->addColumn(['data' => 'rek_sub_rincian_objek.kode_lengkap_nama', 'title' => 'Kode Rekening'])
                ->addColumn(['data' => 'uraian', 'title' => 'Uraian Belanja', 'class' => 'Uraian Belanja'])
                ->addColumn(['data' => 'harga_satuan', 'title' => 'Harga Satuan', 'class' => 'text-right'])
                ->addColumn(['data' => 'volume', 'title' => 'Volume', 'class' => 'text-right'])
                ->addColumn(['data' => 'satuan', 'title' => 'Satuan'])
                ->addColumn(['data' => 'nilai', 'title' => 'Nilai Pagu Belanja', 'class' => 'text-right'])
                ->addColumn(['data' => 'rka_pd.status', 'title' => 'Status', 'class' => 'text-center'])
                ->parameters([
                    'order' => [
                        2, 'asc'
                    ],
                    'columnDefs' => [
                        [
                            'targets' => [8, 9, 11],
                            'render' => '$.fn.dataTable.render.number(".", ",", 2, "")'
                        ],
                        [
                            "targets" => [2, 3, 4, 5, 6],
                            "visible" => false
                        ]
                    ],
                    "footerCallback" => "function (row, data, start, end, display) {
                        var api = this.api();
                        var json = api.ajax.json();

                        $(api.column(0).footer()).remove();
                        $(api.column(1).footer()).remove();
                        $(api.column(7).footer()).remove();
                        $(api.column(8).footer()).remove();
                        $(api.column(9).footer()).remove();
                        $(api.column(10).footer()).attr('colspan', '6').html('Total Anggaran Belanja').parent().addClass('bg-primary text-white');
                        $(api.column(11).footer()).html(json.total_nilai.toLocaleString('id-ID', { minimumFractionDigits: 2 }));
                    }",
                    "drawCallback" => "function(settings) {
                        var api = this.api();
                        var rows = api.rows({
                            page: 'current'
                        }).nodes();
                        var last = null;

                        api.column(2, {
                            page: 'current'
                        }).data().each(function(group, i) {
                            if (last !== group) {
                                $(rows).eq(i).before('<tr><td colspan=\"8\" class=\"bg-success text-white font-weight-bold\">' + group + '</td></tr>');
                                last = group;
                            }
                        });
                        api.column(3, {
                            page: 'current'
                        }).data().each(function(group, i) {
                            if (last !== group) {
                                $(rows).eq(i).before('<tr><td colspan=\"8\" class=\"text-primary font-weight-bold\">' + group + '</td></tr>');
                                last = group;
                            }
                        });
                        api.column(4, {
                            page: 'current'
                        }).data().each(function(group, i) {
                            if (last !== group) {
                                $(rows).eq(i).before('<tr><td colspan=\"8\" class=\"font-weight-bold\">' + group + '</td></tr>');
                                last = group;
                            }
                        });
                        api.column(5, {
                            page: 'current'
                        }).data().each(function(group, i) {
                            if (last !== group) {
                                $(rows).eq(i).before('<tr><td colspan=\"8\"  class=\"font-weight-bold\">' + group + '</td></tr>');
                                last = group;
                            }
                        });
                        api.column(6, {
                            page: 'current'
                        }).data().each(function(group, i) {
                            if (last !== group) {
                                $(rows).eq(i).before('<tr><td colspan=\"8\"  class=\"font-weight-bold\">' + group + '</td></tr>');
                                last = group;
                            }
                        });
                    }",
                ]);

            return view('pages.anggaran.belanja-rka-pd.index', [
                'table' => $table,
                'sub_unit_kerja' => $this->sub_unit_kerja->get(),
                'rka_pd' => $this->rka_pd->get(),
            ]);

        endif;
    }

    public function create()
    {
        return view('pages.anggaran.belanja-rka-pd.create', [
            'rka_pd' => $this->rka_pd->get(),
            'sub_kegiatan' => $this->sub_kegiatan->get(),
            'rek_akun' => $this->rek_akun->belanja()->with([
                'rek_kelompok',
                'rek_kelompok.rek_jenis',
                'rek_kelompok.rek_jenis.rek_objek',
                'rek_kelompok.rek_jenis.rek_objek.rek_rincian_objek',
                'rek_kelompok.rek_jenis.rek_objek.rek_rincian_objek.rek_sub_rincian_objek',
            ])->get(),
        ]);
    }

    public function store(BelanjaRkaPdRequest $request)
    {
        $this->belanja_rka_pd->create($request->validated());

        return response()->json(['message' => 'Data berhasil ditambah.']);
    }

    public function edit(BelanjaRkaPd $belanja_rka_pd)
    {
        return view('pages.anggaran.belanja-rka-pd.edit', [
            'belanja_rka_pd' => $belanja_rka_pd,
            'rka_pd' => $this->rka_pd->get(),
            'sub_kegiatan' => $this->sub_kegiatan->get(),
            'rek_akun' => $this->rek_akun->belanja()->with([
                'rek_kelompok',
                'rek_kelompok.rek_jenis',
                'rek_kelompok.rek_jenis.rek_objek',
                'rek_kelompok.rek_jenis.rek_objek.rek_rincian_objek',
                'rek_kelompok.rek_jenis.rek_objek.rek_rincian_objek.rek_sub_rincian_objek',
            ])->get(),
        ]);
    }

    public function update(BelanjaRkaPd $belanja_rka_pd, BelanjaRkaPdRequest $request)
    {
        $belanja_rka_pd->update($request->validated());

        return response()->json(['message' => 'Data berhasil diubah.']);
    }

    public function destroy(BelanjaRkaPd $belanja_rka_pd)
    {
        $belanja_rka_pd->delete();

        return response()->json(['message' => 'Data berhasil dihapus.']);
    }
}

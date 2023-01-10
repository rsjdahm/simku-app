<?php

namespace App\Http\Controllers\Penatausahaan;

use App\Enums\Penatausahaan\JenisPotonganPfk;
use App\Enums\Penatausahaan\StatusPosting;
use App\Http\Controllers\Controller;
use App\Http\Requests\Penatausahaan\BuktiSpjGuRequest;
use App\Models\Penatausahaan\BuktiGu;
use App\Models\Penatausahaan\BuktiSpjGu;
use App\Models\Penatausahaan\SpjGu;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Yajra\DataTables\Html\Builder;

class BuktiSpjGuController extends Controller
{
    public function index(Builder $builder, Request $request)
    {
        if ($request->wantsJson()) :

            $data = BuktiSpjGu::where('spj_gu_id', $request->spj_gu_id)
                ->with([
                    'bukti_gu' => function ($q) {
                        return $q->withSum('potongan_bukti_gu', 'nilai');
                    },
                ])
                ->get();

            return DataTables::of($data)
                ->with('sum_nilai', $data->sum(function ($i) {
                    return $i->bukti_gu->nilai;
                }))
                ->with('sum_nilai_potongan', $data->sum(function ($i) {
                    return $i->bukti_gu->potongan_bukti_gu_sum_nilai;
                }))
                ->with('sum_nilai_potongan_pph21', $data->sum(function ($i) {
                    return $i->bukti_gu->potongan_bukti_gu->where('potongan_pfk.jenis', JenisPotonganPfk::PPh21)->sum('nilai');
                }))
                ->with('sum_nilai_potongan_pph22', $data->sum(function ($i) {
                    return $i->bukti_gu->potongan_bukti_gu->where('potongan_pfk.jenis', JenisPotonganPfk::PPh22)->sum('nilai');
                }))
                ->with('sum_nilai_potongan_pph23', $data->sum(function ($i) {
                    return $i->bukti_gu->potongan_bukti_gu->where('potongan_pfk.jenis', JenisPotonganPfk::PPh23)->sum('nilai');
                }))
                ->with('sum_nilai_potongan_ppn', $data->sum(function ($i) {
                    return $i->bukti_gu->potongan_bukti_gu->where('potongan_pfk.jenis', JenisPotonganPfk::PPN)->sum('nilai');
                }))
                ->with('sum_nilai_potongan_lainnya', $data->sum(function ($i) {
                    return $i->bukti_gu->potongan_bukti_gu->where('potongan_pfk.jenis', JenisPotonganPfk::Lainnya)->sum('nilai');
                }))
                ->addIndexColumn()
                ->addColumn('action', function ($i) {
                    return '<a data-action="delete" data-title="Hapus Bukti Pengeluaran?" data-text="Periksa data kembali sebelum menghapus Bukti Pengeluaran Nomor: ' . $i->bukti_gu->nomor . ' ini pada Surat Pertanggungjawaban Nomor: ' . $i->spj_gu->nomor . '" href="' . route("bukti-spj-gu.destroy", $i->id) . '" class="btn btn-danger btn-sm text-nowrap"><i class="fas fa-trash"></i> Hapus</a>';
                })
                ->addColumn('potongan_bukti_gu_pph21', function ($i) {
                    $nilai = $i->bukti_gu->potongan_bukti_gu->where('potongan_pfk.jenis', JenisPotonganPfk::PPh21)->sum('nilai');
                    if ($nilai == 0) return null;
                    return $nilai;
                })
                ->addColumn('potongan_bukti_gu_pph22', function ($i) {
                    $nilai = $i->bukti_gu->potongan_bukti_gu->where('potongan_pfk.jenis', JenisPotonganPfk::PPh22)->sum('nilai');
                    if ($nilai == 0) return null;
                    return $nilai;
                })
                ->addColumn('potongan_bukti_gu_pph23', function ($i) {
                    $nilai = $i->bukti_gu->potongan_bukti_gu->where('potongan_pfk.jenis', JenisPotonganPfk::PPh23)->sum('nilai');
                    if ($nilai == 0) return null;
                    return $nilai;
                })
                ->addColumn('potongan_bukti_gu_ppn', function ($i) {
                    $nilai = $i->bukti_gu->potongan_bukti_gu->where('potongan_pfk.jenis', JenisPotonganPfk::PPN)->sum('nilai');
                    if ($nilai == 0) return null;
                    return $nilai;
                })
                ->addColumn('potongan_bukti_gu_lainnya', function ($i) {
                    $nilai = $i->bukti_gu->potongan_bukti_gu->where('potongan_pfk.jenis', JenisPotonganPfk::Lainnya)->sum('nilai');
                    if ($nilai == 0) return null;
                    return $nilai;
                })
                ->toJson();
        else :

            $table = $builder->ajax(route('bukti-spj-gu.index', ['spj_gu_id' => $request->spj_gu_id]))
                ->addAction(['title' => '', 'style' => 'width: 1%;', 'orderable' => false])
                ->addIndex(['title' => 'No.', 'style' => 'width: 1%;', 'class' => 'text-center', 'orderable' => false])
                ->addColumn(['data' => 'bukti_gu.belanja_rka_pd.rek_sub_rincian_objek.kode_lengkap_nama', 'title' => 'Kode Rekening'])
                ->addColumn(['data' => 'bukti_gu.nomor', 'title' => 'Nomor Bukti', 'class' => 'text-center font-weight-bold'])
                ->addColumn(['data' => 'bukti_gu.tanggal', 'title' => 'Tanggal', 'class' => 'text-center', 'defaultContent' => '-'])
                ->addColumn(['data' => 'bukti_gu.uraian', 'title' => 'Uraian', 'defaultContent' => '-'])
                ->addColumn(['data' => 'bukti_gu.nilai', 'title' => 'Jumlah', 'class' => 'text-right font-weight-bold', 'defaultContent' => '-'])
                ->addColumn(['data' => 'potongan_bukti_gu_pph21', 'title' => JenisPotonganPfk::PPh21->value, 'class' => 'text-right', 'defaultContent' => '-'])
                ->addColumn(['data' => 'potongan_bukti_gu_pph22', 'title' => JenisPotonganPfk::PPh22->value, 'class' => 'text-right', 'defaultContent' => '-'])
                ->addColumn(['data' => 'potongan_bukti_gu_pph23', 'title' => JenisPotonganPfk::PPh23->value, 'class' => 'text-right', 'defaultContent' => '-'])
                ->addColumn(['data' => 'potongan_bukti_gu_ppn', 'title' => JenisPotonganPfk::PPN->value, 'class' => 'text-right', 'defaultContent' => '-'])
                ->addColumn(['data' => 'potongan_bukti_gu_lainnya', 'title' => JenisPotonganPfk::Lainnya->value, 'class' => 'text-right', 'defaultContent' => '-'])
                ->addColumn(['data' => 'bukti_gu.potongan_bukti_gu_sum_nilai', 'title' => 'Jumlah Potongan', 'class' => 'text-right', 'defaultContent' => '-'])
                ->columnDefs([
                    [
                        'targets' => [4],
                        'render' => 'function (data) {
                            if (data) {
                                return moment(data).format("DD/MM/YYYY");
                            }
                        }'
                    ],
                    [
                        'targets' => [6, 7, 8, 9, 10, 11, 12],
                        'render' => '$.fn.dataTable.render.number(".", ",", 2, "")'
                    ],
                ])
                ->orders([
                    [
                        3, 'asc'
                    ]
                ])
                ->footerCallback("function (row, data, start, end, display) {
                    var api = this.api();
                    var json = api.ajax.json();

                    $(api.column(0).footer()).remove();
                    $(api.column(1).footer()).remove();
                    $(api.column(2).footer()).remove();
                    $(api.column(3).footer()).remove();
                    $(api.column(4).footer()).remove();
                    $(api.column(5).footer()).removeClass('text-center').attr('colspan', '6').html('Total').parent().addClass('bg-primary text-white');
                    $(api.column(6).footer()).html(json.sum_nilai.toLocaleString('id-ID', { minimumFractionDigits: 2, maximumFractionDigits: 2 }));
                    $(api.column(7).footer()).html(json.sum_nilai_potongan_pph21.toLocaleString('id-ID', { minimumFractionDigits: 2, maximumFractionDigits: 2 }));
                    $(api.column(8).footer()).html(json.sum_nilai_potongan_pph22.toLocaleString('id-ID', { minimumFractionDigits: 2, maximumFractionDigits: 2 }));
                    $(api.column(9).footer()).html(json.sum_nilai_potongan_pph23.toLocaleString('id-ID', { minimumFractionDigits: 2, maximumFractionDigits: 2 }));
                    $(api.column(10).footer()).html(json.sum_nilai_potongan_ppn.toLocaleString('id-ID', { minimumFractionDigits: 2, maximumFractionDigits: 2 }));
                    $(api.column(11).footer()).html(json.sum_nilai_potongan_lainnya.toLocaleString('id-ID', { minimumFractionDigits: 2, maximumFractionDigits: 2 }));
                    $(api.column(12).footer()).html(json.sum_nilai_potongan.toLocaleString('id-ID', { minimumFractionDigits: 2, maximumFractionDigits: 2 }));
                }")
                ->initComplete("function(settings, json) {
                    //menambah rowspan ke kolom yg tidak digeser
                    $('#bukti-spj-gu-table thead tr:nth-child(1) th').filter(':nth-child(1),:nth-child(2),:nth-child(3),:nth-child(4),:nth-child(5),:nth-child(6),:nth-child(7),:nth-child(13)').attr('rowspan', '2');
                    //menambah tr baru setelah tr lama
                    $('#bukti-spj-gu-table thead').append('<tr role=\"row\"></tr>');
                    //menggeser kolom yg tidak dirowspan ke tr baru
                    $('#bukti-spj-gu-table thead tr:nth-child(1) th').filter(':nth-child(8),:nth-child(9),:nth-child(10),:nth-child(11),:nth-child(12)').prependTo('#bukti-spj-gu-table thead tr:nth-child(2)');
                    //menambah kolom colspan ke tr lama
                    $('<th colspan=\"5\" class=\"text-center align-middle\">Potongan</th>').insertAfter('#bukti-spj-gu-table thead tr:nth-child(1) th:nth-child(7)');
                }");

            return view('pages.penatausahaan.bukti-spj-gu.index', [
                'table' => $table
            ]);

        endif;
    }

    public function create(Builder $builder, Request $request)
    {
        if ($request->wantsJson()) :

            $spj_gu = SpjGu::findOrFail($request->spj_gu_id);

            $data = BuktiGu::where('status', StatusPosting::Posting)
                ->withSum('potongan_bukti_gu', 'nilai')
                ->doesntHave('bukti_spj_gu')
                ->get();

            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($i) use ($request, $spj_gu) {
                    return '<a data-action="post" data-title="Tambahkan Bukti Pengeluaran?" data-text="Periksa data kembali sebelum menambahkan Bukti Pengeluaran Nomor: ' . $i->nomor . ' ini pada Surat Pertanggungjawaban Nomor: ' . $spj_gu->nomor . '" data-button="Tambahkan" href="' . route("bukti-spj-gu.store") . '" data-formdata=\'{"bukti_gu_id":' . $i->id . ',"spj_gu_id":' . $request->spj_gu_id . '}\' class="btn btn-success btn-sm text-nowrap"><i class="fas fa-plus"></i> Tambahkan BP</a>';
                })
                ->toJson();
        endif;

        $table = $builder->ajax(route('bukti-spj-gu.create', ['spj_gu_id' => $request->spj_gu_id]))
            ->addAction(['title' => '', 'style' => 'width: 1%;', 'orderable' => false])
            ->addIndex(['title' => 'No.', 'style' => 'width: 1%;', 'class' => 'text-center', 'orderable' => false])
            ->addColumn(['data' => 'belanja_rka_pd.rek_sub_rincian_objek.kode_lengkap_nama', 'title' => 'Kode Rekening'])
            ->addColumn(['data' => 'nomor', 'title' => 'Nomor Bukti Pengeluaran', 'class' => 'text-center'])
            ->addColumn(['data' => 'tanggal', 'title' => 'Tanggal Bukti Pengeluaran', 'class' => 'text-center', 'defaultContent' => '-'])
            ->addColumn(['data' => 'uraian', 'title' => 'Uraian'])
            ->addColumn(['data' => 'nilai', 'title' => 'Jumlah', 'class' => 'text-right'])
            ->addColumn(['data' => 'potongan_bukti_gu_sum_nilai', 'title' => 'Jumlah Potongan', 'class' => 'text-right', 'defaultContent' => '0,00'])
            ->columnDefs([
                [
                    'targets' => [4],
                    'render' => 'function (data) {
                            if (data) {
                                return moment(data).format("DD/MM/YYYY");
                            }
                        }'
                ],
                [
                    'targets' => [6, 7],
                    'render' => '$.fn.dataTable.render.number(".", ",", 2, "")'
                ],
            ])
            ->orders([
                [
                    3, 'asc'
                ]
            ]);

        return view('pages.penatausahaan.bukti-spj-gu.create', [
            'table' => $table
        ]);
    }

    public function store(BuktiSpjGuRequest $request)
    {
        BuktiSpjGu::create($request->validated());

        return response()->json(['message' => 'Item Bukti GU untuk SPJ GU berhasil ditambah.']);
    }

    public function edit(BuktiSpjGu $bukti_spj_gu)
    {
        return view('pages.penatausahaan.bukti-spj-gu.edit', [
            'bukti_spj_gu' => $bukti_spj_gu
        ]);
    }

    public function update(BuktiSpjGu $bukti_spj_gu, BuktiSpjGuRequest $request)
    {
        $bukti_spj_gu->update($request->validated());

        return response()->json(['message' => 'Item Bukti GU untuk SPJ GU berhasil diubah.']);
    }

    public function destroy(BuktiSpjGu $bukti_spj_gu)
    {
        $bukti_spj_gu->delete();

        return response()->json(['message' => 'Item Bukti GU untuk SPJ GU berhasil dihapus.']);
    }
}

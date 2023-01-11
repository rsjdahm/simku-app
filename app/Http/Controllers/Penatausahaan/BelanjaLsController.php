<?php

namespace App\Http\Controllers\Penatausahaan;

use App\Enums\Penatausahaan\JenisBelanjaLs;
use App\Enums\Penatausahaan\MetodePembayaran;
use App\Enums\Penatausahaan\StatusPosting;
use App\Enums\Penatausahaan\StatusPending;
use App\Http\Controllers\Controller;
use App\Http\Requests\Penatausahaan\BelanjaLsRequest;
use App\Models\Penatausahaan\Bank;
use App\Models\Penatausahaan\BelanjaLs;
use App\Models\Setup\RekAkun;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Yajra\DataTables\Html\Builder;

class BelanjaLsController extends Controller
{
    public function __construct(RekAkun $rek_akun)
    {
        $this->rek_akun = $rek_akun;
    }
    public function index(Builder $builder, Request $request)
    {
        if ($request->wantsJson()) :

            // $data = BelanjaLs::withSum(['potongan_belanja_ls' => function ($q) {
            //     return $q->where('status', StatusPotonganBelanjaLs::Setor);
            // }], 'nilai')
            $data = BelanjaLs::withSum('potongan_belanja_ls', 'nilai')
                ->withCount('potongan_belanja_ls')
                ->when($request->status_pending, function ($q) use ($request) {
                    return $q->where('status_pending', $request->status_pending);
                })
                ->when($request->bulan, function ($q) use ($request) {
                    return $q->whereMonth('tanggal', $request->bulan);
                })

                ->get();

            return DataTables::of($data)
                ->with('belanja_ls_normal_count', function () {
                    return BelanjaLs::where('status_pending', StatusPending::Normal)->count();
                })
                ->with('belanja_ls_pending_count', function () {
                    return BelanjaLs::where('status_pending', StatusPending::Pending)->count();
                })
                ->with('sum_nilai', $data->sum(function ($i) {
                    return $i->nilai;
                }))
                ->with('sum_nilai_potongan', $data->sum(function ($i) {
                    return $i->potongan_belanja_ls_sum_nilai;
                }))
                ->addIndexColumn()
                ->addColumn('action', function ($i) {
                    return '<div class="btn-group btn-group-sm" role="group"><button type="button" title="Aksi" class="btn btn-warning dropdown-toggle" data-toggle="dropdown"><i class="fas fa-wrench"></i></button><div class="dropdown-menu"><a data-load="modal" data-size="lg" title="Edit Belanja LS" href="' . route("belanja-ls.edit", $i->id) . '" class="dropdown-item">Edit</a><a data-action="delete" href="' . route("belanja-ls.destroy", $i->id) . '" class="dropdown-item text-danger">Hapus</a></div></div>';
                })
                ->addColumn('action2', function ($i) {
                    $action = '<div class="btn-group btn-group-sm" role="group"><button type="button" title="Tambah Data Pendukung" class="btn btn-primary dropdown-toggle" data-toggle="dropdown"><i class="fas fa-plus"></i></button><div class="dropdown-menu"><a data-load="modal" data-size="lg" title="Potongan pada Belanja LS Nomor: ' . $i->nomor . '" href="' . route('potongan-belanja-ls.index', ['belanja_ls_id' => $i->id]) . '" class="dropdown-item">Potongan (' . $i->potongan_belanja_ls_count . ')</a></div></div>';

                    // if ($i->status == StatusPosting::Posting) :
                    $action .= '<div class="btn-group btn-group-sm ml-1" role="group"><button type="button" title="Cetak Dokumen" class="btn btn-secondary dropdown-toggle" data-toggle="dropdown"><i class="fas fa-print"></i></button><div class="dropdown-menu">
                        <a data-load="modal-pdf" title="Cetak Kwitansi Belanja LS Nomor: ' . $i->nomor . '" href="' . route("belanja-ls.pdf-kwitansi", $i->id) . '" class="dropdown-item">Kwitansi</a>
                        </div></div>';
                    // endif;
                    return $action;
                })
                ->editColumn('uraian', function ($i) {
                    return '<div class="border-bottom mb-1"><small><strong>' . $i->belanja_rka_pd->rek_sub_rincian_objek->kode_lengkap_nama . '</strong> - <i>' . $i->belanja_rka_pd->uraian . '</i></small></div>' . $i->uraian;
                })
                ->addColumn('rek_sub_rincian_objek', function ($i) {
                    return '[' . $i->belanja_rka_pd->rek_sub_rincian_objek->kode_lengkap . '] ' . $i->belanja_rka_pd->rek_sub_rincian_objek->nama;
                })
                ->editColumn('jenis', function ($i) {
                    switch ($i->jenis) {
                        case JenisBelanjaLs::PihakKetiga:
                            return '<span class="badge badge-primary">' . JenisBelanjaLs::PihakKetiga->value . '</span>';
                            break;
                        case JenisBelanjaLs::Pegawai:
                            return '<span class="badge badge-info">' . JenisBelanjaLs::Pegawai->value . '</span>';
                            break;
                        default:
                            return '<span class="badge badge-secondary">-</span>';
                            break;
                    }
                })
                ->editColumn('metode_pembayaran', function ($i) {
                    switch ($i->metode_pembayaran) {
                        case MetodePembayaran::Tunai:
                            return '<span class="badge badge-success">' . MetodePembayaran::Tunai->value . '</span>';
                            break;
                        case MetodePembayaran::Transfer:
                            return '<span class="badge badge-danger">' . MetodePembayaran::Transfer->value . '</span>';
                            break;
                        default:
                            return '<span class="badge badge-secondary">-</span>';
                            break;
                    }
                })
                ->editColumn('status', function ($i) {
                    switch ($i->status) {
                        case StatusPosting::Posting:
                            $badge = '<span class="badge badge-success">' . StatusPosting::Posting->value . '</span>';
                            break;
                        case StatusPosting::BelumPosting:
                            $badge = '<span class="badge badge-warning">' . StatusPosting::BelumPosting->value . '</span>';
                            break;
                        default:
                            $badge = '<span class="badge badge-secondary">-</span>';
                            break;
                    }
                    return $badge;
                })
                ->editColumn('status_pending', function ($i) {
                    switch ($i->status_pending) {
                        case StatusPending::Pending:
                            $badge = '<span class="badge badge-warning">' . StatusPending::Pending->value . '</span>';
                            break;
                        case StatusPending::Normal:
                            $badge = '<span class="badge badge-success">' . StatusPending::Normal->value . '</span>';
                            break;
                        default:
                            $badge = '<span class="badge badge-secondary">-</span>';
                            break;
                    }
                    return $badge;
                })
                ->rawColumns(['action', 'jenis', 'status', 'status_pending', 'metode_pembayaran', 'action2', 'uraian'])
                ->toJson();
        else :

            $table = $builder->ajax([
                'url' => route('belanja-ls.index'),
                'data' => 'function(d) {
                    d.status_pending = $("[name=\'status_pending_filter_datatable_belanja-ls-table\']:checked").val();
                    d.bulan = $("[name=\'bulan_filter\']").val();
                }',
            ])
                ->addAction(['title' => '', 'style' => 'width: 1%;', 'orderable' => false])
                ->addColumn(['data' => 'status_pending', 'title' => 'Status Pending', 'class' => 'text-center', 'style' => 'width: 1%;'])
                ->addColumn(['data' => 'tanggal', 'title' => 'Tanggal', 'class' => 'text-center', 'defaultContent' => '-'])
                ->addColumn(['data' => 'nomor', 'title' => 'Nomor Bukti Pengeluaran', 'class' => 'text-center font-weight-bold', 'style' => 'width: 1%;', 'defaultContent' => '-'])
                ->addColumn(['data' => 'jenis', 'title' => 'Jenis Penerima', 'class' => 'text-center', 'style' => 'width: 1%;'])
                ->addColumn(['data' => 'uraian', 'title' => 'Uraian', 'defaultContent' => '-'])
                ->addColumn(['data' => 'metode_pembayaran', 'title' => 'Metode Pembayaran', 'class' => 'text-center', 'style' => 'width: 1%;'])
                ->addColumn(['data' => 'nilai', 'title' => 'Nilai Belanja', 'class' => 'text-right', 'defaultContent' => '-'])
                ->addColumn(['data' => 'potongan_belanja_ls_sum_nilai', 'title' => 'Nilai Potongan', 'class' => 'text-right', 'defaultContent' => '-'])
                ->addAction(['data' => 'action2', 'title' => '', 'class' => 'text-nowrap', 'style' => 'width: 1%;', 'orderable' => false])
                ->addColumn(['data' => 'status', 'title' => 'Status', 'class' => 'text-center', 'style' => 'width: 1%;'])
                ->drawCallback("function (row, data, start, end, display) {
                    var api = this.api();
                    var json = api.ajax.json();

                    $('[name$=\"_filter_datatable_belanja-ls-table\"][value=\"" . StatusPending::Normal->value . "\"]').siblings('strong').html('<span>' + json.belanja_ls_normal_count + '</span>');
                    $('[name$=\"_filter_datatable_belanja-ls-table\"][value=\"" . StatusPending::Pending->value . "\"]').siblings('strong').html('<span>' + json.belanja_ls_pending_count + '</span>');
                }")
                ->footerCallback("function (row, data, start, end, display) {
                    var api = this.api();
                    var json = api.ajax.json();

                    $(api.column(0).footer()).remove();
                    $(api.column(1).footer()).remove();
                    $(api.column(2).footer()).remove();
                    $(api.column(3).footer()).remove();
                    $(api.column(4).footer()).remove();
                    $(api.column(5).footer()).remove();
                    $(api.column(6).footer()).removeClass('text-center').attr('colspan', '7').html('Total Nilai Potongan').parent().addClass('bg-primary text-white');
                    $(api.column(7).footer()).html(json.sum_nilai.toLocaleString('id-ID', { minimumFractionDigits: 2, maximumFractionDigits: 2 }));
                    $(api.column(8).footer()).html(json.sum_nilai_potongan.toLocaleString('id-ID', { minimumFractionDigits: 2, maximumFractionDigits: 2 }));
                }")
                ->orders([[
                    3, 'desc'
                ]])
                ->columnDefs([
                    [
                        'targets' => [7, 8],
                        'render' => '$.fn.dataTable.render.number(".", ",", 2, "")'
                    ],
                    [
                        'targets' => [2],
                        'render' => 'function (data) {
                                if (data) {
                                    return moment(data).format("DD/MM/YYYY");
                                }
                            }'
                    ],
                ]);

            return view('pages.penatausahaan.belanja-ls.index', [
                'table' => $table
            ]);

        endif;
    }

    public function create()
    {
        return view('pages.penatausahaan.belanja-ls.create', [
            'rek_akun' => $this->rek_akun->belanja()->with([
                'rek_kelompok',
                'rek_kelompok.rek_jenis.rek_objek.rek_rincian_objek.rek_sub_rincian_objek.belanja_rka_pd',
                'rek_kelompok.rek_jenis',
                'rek_kelompok.rek_jenis.rek_objek',
                'rek_kelompok.rek_jenis.rek_objek.rek_rincian_objek',
                'rek_kelompok.rek_jenis.rek_objek.rek_rincian_objek.rek_sub_rincian_objek',
            ])
                ->has('rek_kelompok.rek_jenis.rek_objek.rek_rincian_objek.rek_sub_rincian_objek.belanja_rka_pd')
                ->get(),
            'bank' => Bank::get()
        ]);
    }

    public function store(BelanjaLsRequest $request)
    {
        BelanjaLs::create($request->validated());

        return response()->json(['message' => 'Data Belanja LS berhasil ditambah.']);
    }

    public function edit(BelanjaLs $belanja_ls)
    {
        return view('pages.penatausahaan.belanja-ls.edit', [
            'belanja_ls' => $belanja_ls,
            'rek_akun' => $this->rek_akun->belanja()->with([
                'rek_kelompok',
                'rek_kelompok.rek_jenis.rek_objek.rek_rincian_objek.rek_sub_rincian_objek.belanja_rka_pd',
                'rek_kelompok.rek_jenis',
                'rek_kelompok.rek_jenis.rek_objek',
                'rek_kelompok.rek_jenis.rek_objek.rek_rincian_objek',
                'rek_kelompok.rek_jenis.rek_objek.rek_rincian_objek.rek_sub_rincian_objek',
            ])
                ->has('rek_kelompok.rek_jenis.rek_objek.rek_rincian_objek.rek_sub_rincian_objek.belanja_rka_pd')
                ->get(),
            'bank' => Bank::get()
        ]);
    }

    public function update(BelanjaLs $belanja_ls, BelanjaLsRequest $request)
    {
        $belanja_ls->update($request->validated());

        return response()->json(['message' => 'Data Belanja LS berhasil diubah.']);
    }

    public function destroy(BelanjaLs $belanja_ls)
    {
        $belanja_ls->delete();

        return response()->json(['message' => 'Data Belanja LS berhasil dihapus.']);
    }

    public function printPdfKwitansi(BelanjaLs $belanja_ls)
    {

        return Pdf::loadView('pages.penatausahaan.belanja-ls.pdf-kwitansi', compact(
            'belanja_ls',
        ))
            ->setPaper('a4', 'potrait')
            ->stream('Kwitansi.pdf');
    }
}

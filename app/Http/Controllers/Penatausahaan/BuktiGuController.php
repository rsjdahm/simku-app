<?php

namespace App\Http\Controllers\Penatausahaan;

use App\Enums\Penatausahaan\JenisBuktiGu;
use App\Enums\Penatausahaan\MetodePembayaran;
use App\Enums\Penatausahaan\StatusPosting;
use App\Enums\Penatausahaan\StatusPending;
use App\Http\Controllers\Controller;
use App\Http\Requests\Penatausahaan\BuktiGuRequest;
use App\Models\Penatausahaan\Bank;
use App\Models\Penatausahaan\BuktiGu;
use App\Models\Setup\RekAkun;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;
use Yajra\DataTables\Html\Builder;

class BuktiGuController extends Controller
{
    public function index(Builder $builder, Request $request)
    {
        if ($request->wantsJson()) :

            // $data = BuktiGu::withSum(['potongan_bukti_gu' => function ($q) {
            //     return $q->where('status', StatusPotonganBuktiGu::Setor);
            // }], 'nilai')
            $data = BuktiGu::withSum('potongan_bukti_gu', 'nilai')
                ->withCount('potongan_bukti_gu')
                ->when($request->status_pending, function ($q) use ($request) {
                    return $q->where('status_pending', $request->status_pending);
                })
                ->when($request->bulan, function ($q) use ($request) {
                    return $q->whereMonth('tanggal', $request->bulan);
                })
                ->when(Auth::user()->role == 'operator', function ($q) use ($request) {
                    return $q->where('user_id', Auth::user()->id);
                })
                ->get();

            return DataTables::of($data)
                ->with('bukti_gu_normal_count', function () {
                    return BuktiGu::where('status_pending', StatusPending::Normal)->count();
                })
                ->with('bukti_gu_pending_count', function () {
                    return BuktiGu::where('status_pending', StatusPending::Pending)->count();
                })
                ->with('sum_nilai', $data->sum(function ($i) {
                    return $i->nilai;
                }))
                ->with('sum_nilai_potongan', $data->sum(function ($i) {
                    return $i->potongan_bukti_gu_sum_nilai;
                }))
                ->addIndexColumn()
                ->addColumn('action', function ($i) {
                    return '<div class="btn-group btn-group-sm" role="group"><button type="button" title="Aksi" class="btn btn-warning dropdown-toggle" data-toggle="dropdown"><i class="fas fa-wrench"></i></button><div class="dropdown-menu"><a data-load="modal" data-size="lg" title="Edit Bukti GU" href="' . route("bukti-gu.edit", $i->id) . '" class="dropdown-item">Edit</a><a data-action="delete" href="' . route("bukti-gu.destroy", $i->id) . '" class="dropdown-item text-danger">Hapus</a></div></div>';
                })
                ->addColumn('action2', function ($i) {
                    $action = '<div class="btn-group btn-group-sm" role="group"><button type="button" title="Tambah Data Pendukung" class="btn btn-primary dropdown-toggle" data-toggle="dropdown"><i class="fas fa-plus"></i></button><div class="dropdown-menu"><a data-load="modal" data-size="lg" title="Potongan pada Bukti GU Nomor: ' . $i->nomor . '" href="' . route('potongan-bukti-gu.index', ['bukti_gu_id' => $i->id]) . '" class="dropdown-item">Potongan (' . $i->potongan_bukti_gu_count . ')</a></div></div>';

                    // if ($i->status == StatusPosting::Posting) :
                    $action .= '<div class="btn-group btn-group-sm ml-1" role="group"><button type="button" title="Cetak Dokumen" class="btn btn-secondary dropdown-toggle" data-toggle="dropdown"><i class="fas fa-print"></i></button><div class="dropdown-menu">
                        <a data-load="modal-pdf" title="Cetak Surat Bukti Pengeluaran/Belanja Bukti GU Nomor: ' . $i->nomor . '" href="' . route("bukti-gu.pdf-sbpb", $i->id) . '" class="dropdown-item">SBPB</a>
                        <a data-load="modal-pdf" title="Cetak Kwitansi Bukti GU Nomor: ' . $i->nomor . '" href="' . route("bukti-gu.pdf-kwitansi", $i->id) . '" class="dropdown-item">Kwitansi</a>
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
                        case JenisBuktiGu::PihakKetiga:
                            return '<span class="badge badge-primary">' . JenisBuktiGu::PihakKetiga->value . '</span>';
                            break;
                        case JenisBuktiGu::Pegawai:
                            return '<span class="badge badge-info">' . JenisBuktiGu::Pegawai->value . '</span>';
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
                'url' => route('bukti-gu.index'),
                'data' => 'function(d) {
                    d.status_pending = $("[name=\'status_pending_filter_datatable_bukti-gu-table\']:checked").val();
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
                ->addColumn(['data' => 'potongan_bukti_gu_sum_nilai', 'title' => 'Nilai Potongan', 'class' => 'text-right', 'defaultContent' => '-'])
                ->addAction(['data' => 'action2', 'title' => '', 'class' => 'text-nowrap', 'style' => 'width: 1%;', 'orderable' => false])
                ->addColumn(['data' => 'status', 'title' => 'Status', 'class' => 'text-center', 'style' => 'width: 1%;'])
                ->drawCallback("function (row, data, start, end, display) {
                    var api = this.api();
                    var json = api.ajax.json();

                    $('[name$=\"_filter_datatable_bukti-gu-table\"][value=\"" . StatusPending::Normal->value . "\"]').siblings('strong').html('<span>' + json.bukti_gu_normal_count + '</span>');
                    $('[name$=\"_filter_datatable_bukti-gu-table\"][value=\"" . StatusPending::Pending->value . "\"]').siblings('strong').html('<span>' + json.bukti_gu_pending_count + '</span>');
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
                    $(api.column(6).footer()).removeClass('text-center').attr('colspan', '7').html('Total Nilai').parent().addClass('bg-primary text-white');
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

            return view('pages.penatausahaan.bukti-gu.index', [
                'table' => $table
            ]);

        endif;
    }

    public function create()
    {
        return view('pages.penatausahaan.bukti-gu.create', [
            'rek_akun' => RekAkun::with([
                'rek_kelompok',
                'rek_kelompok.rek_jenis.rek_objek.rek_rincian_objek.rek_sub_rincian_objek.belanja_rka_pd',
                'rek_kelompok.rek_jenis',
                'rek_kelompok.rek_jenis.rek_objek',
                'rek_kelompok.rek_jenis.rek_objek.rek_rincian_objek',
                'rek_kelompok.rek_jenis.rek_objek.rek_rincian_objek.rek_sub_rincian_objek',
            ])
                ->has('rek_kelompok.rek_jenis.rek_objek.rek_rincian_objek.rek_sub_rincian_objek.belanja_rka_pd')
                ->belanja()
                ->get(),
            'bank' => Bank::get()
        ]);
    }

    public function store(BuktiGuRequest $request)
    {
        BuktiGu::create($request->safe()->merge(['user_id' => Auth::user()->id])->all());

        return response()->json(['message' => 'Bukti Transaksi GU berhasil ditambah.']);
    }

    public function edit(BuktiGu $bukti_gu)
    {
        return view('pages.penatausahaan.bukti-gu.edit', [
            'bukti_gu' => $bukti_gu,
            'rek_akun' => RekAkun::with([
                'rek_kelompok',
                'rek_kelompok.rek_jenis.rek_objek.rek_rincian_objek.rek_sub_rincian_objek.belanja_rka_pd',
                'rek_kelompok.rek_jenis',
                'rek_kelompok.rek_jenis.rek_objek',
                'rek_kelompok.rek_jenis.rek_objek.rek_rincian_objek',
                'rek_kelompok.rek_jenis.rek_objek.rek_rincian_objek.rek_sub_rincian_objek',
            ])
                ->has('rek_kelompok.rek_jenis.rek_objek.rek_rincian_objek.rek_sub_rincian_objek.belanja_rka_pd')
                ->belanja()
                ->get(),
            'bank' => Bank::get()
        ]);
    }

    public function update(BuktiGu $bukti_gu, BuktiGuRequest $request)
    {
        $bukti_gu->update($request->safe()->all());
        // $bukti_gu->update($request->safe()->merge(['user_id' => Auth::user()->id])->all());

        return response()->json(['message' => 'Bukti Transaksi GU berhasil diubah.']);
    }

    public function destroy(BuktiGu $bukti_gu)
    {
        $bukti_gu->delete();

        return response()->json(['message' => 'Bukti Transaksi GU berhasil dihapus.']);
    }

    public function printPdfSbpb(BuktiGu $bukti_gu)
    {

        return Pdf::loadView('pages.penatausahaan.bukti-gu.pdf-sbpb', compact(
            'bukti_gu',
        ))
            ->setPaper('a4', 'potrait')
            ->stream('SBPB.pdf');
    }

    public function printPdfKwitansi(BuktiGu $bukti_gu)
    {

        return Pdf::loadView('pages.penatausahaan.bukti-gu.pdf-kwitansi', compact(
            'bukti_gu',
        ))
            ->setPaper('a4', 'potrait')
            ->stream('Kwitansi.pdf');
    }

    public function getNomorBuktiGuOtomatis()
    {
        return ((int) BuktiGu::whereNotNull('nomor')->orderBy('nomor', 'desc')->first()->nomor) + 1;
    }

    public function penerimaIndex(Builder $builder, Request $request)
    {
        if ($request->wantsJson()) :
            $data = BuktiGu::with(['bank'])
                ->when($request->jenis, function ($q) use ($request) {
                    return $q->where('jenis', $request->jenis);
                })
                ->get()
                ->unique('nama');

            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($i) {
                    return '<button type="button" class="btn btn-success btn-sm text-nowrap"><i class="fas fa-check"></i> Pilih</button>';
                })
                ->rawColumns(['action'])
                ->toJson();
        else :

            $table = $builder->ajax([
                'url' => route('bukti-gu.penerima-index'),
                'data' => 'function(d) {
                    d.jenis = $("[name=\'jenis_filter\']").val();
                }',
            ])
                ->addAction(['title' => '', 'style' => 'width: 1%;', 'orderable' => false])
                ->addColumn(['data' => 'nama', 'title' => 'Nama Penerima', 'defaultContent' => '-'])
                ->addColumn(['data' => 'jenis', 'title' => 'Jenis Penerima', 'defaultContent' => '-'])
                ->addColumn(['data' => 'alamat', 'title' => 'Alamat', 'defaultContent' => '-'])
                ->addColumn(['data' => 'npwp', 'title' => 'NPWP', 'class' => 'text-center', 'style' => 'width: 1%;', 'defaultContent' => '-'])
                ->addColumn(['data' => 'bank.nama', 'title' => 'Nama Bank', 'class' => 'text-center', 'defaultContent' => '-'])
                ->addColumn(['data' => 'nomor_rekening', 'title' => 'Nomor Rekening', 'defaultContent' => '-'])
                ->orders([[
                    1, 'asc'
                ]])
                ->drawCallback("function (row, data, start, end, display) {
                    let api = this.api();
                    let table = window.LaravelDataTables['bukti-gu-penerima-table'];
                    $('#bukti-gu-penerima-table tbody').on('click', 'button', function () {
                        const data = table.row($(this).parents('tr')).data();

                        $('[name=\"nama\"]').val(data.nama);
                        $('[name=\"jenis\"]').val(data.jenis).trigger('change')
                        $('[name=\"alamat\"]').val(data.alamat);
                        $('[name=\"npwp\"]').val(data.npwp);
                        $('[name=\"bank_id\"]').val(data.bank_id).trigger('change')
                        $('[name=\"nomor_rekening\"]').val(data.nomor_rekening);

                        $(this).closest('div.modal').modal('hide');
                    });
                }");

            return view('pages.penatausahaan.bukti-gu.penerima-index', [
                'table' => $table
            ]);

        endif;
    }
}

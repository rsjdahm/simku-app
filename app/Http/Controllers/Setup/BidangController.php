<?php

namespace App\Http\Controllers\Setup;

use App\Http\Controllers\Controller;
use App\Http\Requests\Setup\BidangRequest;
use App\Models\Setup\Bidang;
use App\Models\Setup\Urusan;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Yajra\DataTables\Html\Builder;

class BidangController extends Controller
{
    public function __construct(
        Urusan $urusan,
        Bidang $bidang
    ) {
        $this->urusan = $urusan;
        $this->bidang = $bidang;
    }

    public function index(Builder $builder, Request $request)
    {
        if ($request->wantsJson()) :

            $data = $this->bidang
                ->whereHas('urusan', function ($q) use ($request) {
                    $q->when($request->urusan_id, function ($q) use ($request) {
                        $q->where('id', $request->urusan_id);
                    });
                })
                ->get();

            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('action', '<div class="btn-group btn-group-sm" role="group"><button type="button" class="btn btn-warning dropdown-toggle" data-toggle="dropdown"><i class="fas fa-wrench"></i></button><div class="dropdown-menu"><a data-load="modal" title="Edit Nomenklatur Bidang" href="{{ route("bidang.edit", $id) }}" class="dropdown-item">Edit</a><a data-action="delete" href="{{ route("bidang.destroy", $id) }}" class="dropdown-item text-danger">Hapus</a></div></div>')
                ->addColumn('kode_lengkap', '{{ $kode_lengkap }}')
                ->toJson();
        else :

            $table = $builder->ajax([
                'url' => route('bidang.index'),
                'data' => 'function(d) {
                    d.urusan_id = $("select[name=\'urusan_id_filter\']").val();
                }',
            ])
                ->addAction(['title' => '', 'style' => 'width: 1%;', 'orderable' => false])
                ->addIndex(['title' => 'No.', 'style' => 'width: 1%;', 'class' => 'text-center', 'orderable' => false])
                ->addColumn(['data' => 'kode_lengkap', 'title' => 'Kode Bidang', 'class' => 'text-center font-weight-bold', 'style' => 'width: 1%;'])
                ->addColumn(['data' => 'nama', 'title' => 'Nomenklatur Bidang'])
                ->parameters([
                    'order' => [
                        2, 'asc'
                    ]
                ]);

            return view('pages.setup.bidang.index', [
                'table' => $table,
                'urusan' => $this->urusan->get()
            ]);

        endif;
    }

    public function create()
    {
        return view('pages.setup.bidang.create', [
            'urusan' => $this->urusan->get()
        ]);
    }

    public function store(BidangRequest $request)
    {
        $this->bidang->create($request->validated());

        return response()->json(['message' => 'Data Bidang berhasil ditambah.']);
    }

    public function edit(Bidang $bidang)
    {
        return view('pages.setup.bidang.edit', [
            'bidang' => $bidang,
            'urusan' => $this->urusan->get()
        ]);
    }

    public function update(Bidang $bidang, BidangRequest $request)
    {
        $bidang->update($request->validated());

        return response()->json(['message' => 'Data Bidang berhasil diubah.']);
    }

    public function destroy(Bidang $bidang)
    {
        $bidang->delete();

        return response()->json(['message' => 'Data Bidang berhasil dihapus.']);
    }
}

<?php

namespace App\Http\Controllers\Penatausahaan;

use App\Http\Controllers\Controller;
use App\Http\Requests\Penatausahaan\BankRequest;
use App\Models\Penatausahaan\Bank;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Yajra\DataTables\Html\Builder;

class BankController extends Controller
{
    public function index(Builder $builder, Request $request)
    {
        if ($request->wantsJson()) :

            $data = Bank::get();

            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('action', '<div class="btn-group btn-group-sm" role="group"><button type="button" class="btn btn-warning dropdown-toggle" data-toggle="dropdown"><i class="fas fa-wrench"></i></button><div class="dropdown-menu"><a data-load="modal" title="Edit Bank" href="{{ route("bank.edit", $id) }}" class="dropdown-item">Edit</a><a data-action="delete" href="{{ route("bank.destroy", $id) }}" class="dropdown-item text-danger">Hapus</a></div></div>')
                ->toJson();
        else :

            $table = $builder->ajax(route('bank.index'))
                ->addAction(['title' => '', 'style' => 'width: 1%;', 'orderable' => false])
                ->addColumn(['data' => 'kode', 'title' => 'Kode Bank', 'class' => 'text-center font-weight-bold', 'style' => 'width: 1%;', 'defaultContent' => '-'])
                ->addColumn(['data' => 'nama', 'title' => 'Nama Bank', 'defaultContent' => '-'])
                ->parameters([
                    'order' => [
                        1, 'asc'
                    ]
                ]);

            return view('pages.penatausahaan.bank.index', [
                'table' => $table
            ]);

        endif;
    }

    public function create()
    {
        return view('pages.penatausahaan.bank.create');
    }

    public function store(BankRequest $request)
    {
        Bank::create($request->validated());

        return response()->json(['message' => 'Referensi Bank berhasil ditambah.']);
    }

    public function edit(Bank $bank)
    {
        return view('pages.penatausahaan.bank.edit', [
            'bank' => $bank
        ]);
    }

    public function update(Bank $bank, BankRequest $request)
    {
        $bank->update($request->validated());

        return response()->json(['message' => 'Referensi Bank berhasil diubah.']);
    }

    public function destroy(Bank $bank)
    {
        $bank->delete();

        return response()->json(['message' => 'Referensi Bank berhasil dihapus.']);
    }
}

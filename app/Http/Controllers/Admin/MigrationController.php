<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin\Migration;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Yajra\DataTables\Facades\DataTables;
use Yajra\DataTables\Html\Builder;

class MigrationController extends Controller
{
    public function index(Builder $builder, Request $request)
    {

        $migration_db = Migration::all();

        $identifier_migration = Migration::orderBy('batch', 'desc')->first();

        $migration_files = collect(array_slice(scandir(database_path('/migrations')), 2))
            ->reverse()
            ->map(function ($item) use ($migration_db, $identifier_migration) {
                $migration = $migration_db->firstWhere('migration', str_replace('.php', '', $item));

                return (object)[
                    'migration' => $migration?->migration,
                    'tgl' => substr($item, 0, 16),
                    'migration_file' => str_replace('.php', '', $item),
                    'batch' => $migration?->batch,
                    'rollback' => ($migration?->migration == $identifier_migration->migration) ? true : false
                ];
            });

        if ($request->wantsJson()) {
            return DataTables::of($migration_files)
                ->addIndexColumn()
                ->addColumn('action', '@if($batch) <div class="btn-group btn-group-sm"><a data-load="modal" title="Edit Migration" href="{{ route("migration.edit", ["migration" => $migration]) }}" class="btn btn-warning"><i class="fas fa-edit"></i></a></div> @endif')
                ->addColumn('migrate', '@if($batch && $rollback) <a data-action="delete" href="{{ route("migration.destroy", ["migration" => $migration]) }}" class="btn btn-danger btn-sm"><i class="fas fa-arrow-left"></i> Rollback</a> @endif @if(!$batch) <a data-action="post" href="{{ route("migration.store", ["migration" => $migration_file]) }}" class="btn btn-success btn-sm"><i class="fas fa-arrow-right"></i> Migrate</a> @endif')
                ->editColumn('tgl', '@if($batch) <span class="badge badge-success">{{ $tgl }}</span> @else <span class="badge badge-warning">{{ $tgl }}</span> @endif')
                ->editColumn('migration_file', '{{ substr($migration_file, 18) }}')
                ->rawColumns(['tgl', 'action', 'migrate'])
                ->toJson();
        }

        $table = $builder->minifiedAjax(route('migration.index'))
            ->addAction(['title' => '', 'style' => 'width: 1%;', 'orderable' => false])
            ->addColumn(['data' => 'tgl', 'title' => 'Stamp', 'style' => 'width: 1%;'])
            ->addColumn(['data' => 'migration_file', 'title' => 'Migration Files'])
            ->addColumn(['data' => 'migrate', 'title' => '', 'class' => 'text-nowrap', 'style' => 'width: 1%;', 'orderable' => false])
            ->addColumn(['data' => 'batch', 'title' => 'Batch'])
            ->parameters([
                'order' => [
                    1, 'desc'
                ]
            ]);

        return view('pages.admin.migration.index', compact('table'));
    }

    public function store($migration)
    {
        Artisan::call(
            'migrate',
            [
                '--path' => 'database/migrations/' . $migration . '.php',
            ]
        );

        return response()->json(['message' => 'Data berhasil ditambah.']);
    }

    public function edit($migration)
    {
        $item = Migration::where('migration', $migration)->firstOrFail();

        return view('pages.admin.migration.edit', compact('item'));
    }

    public function update($migration, Request $request)
    {
        $item = Migration::where('migration', $migration)->firstOrFail();
        $item->update($request->all());

        return response()->json(['message' => 'Data berhasil diubah.']);
    }

    public function destroy($migration)
    {
        Artisan::call(
            'migrate:rollback',
            [
                '--step' => 1
            ]
        );

        return response()->json(['message' => 'Data berhasil dihapus.']);
    }
}

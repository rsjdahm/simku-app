<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <h4>Nomenklatur Urusan</h4>
                <a data-action="reload" class="btn btn-primary btn-sm float-right text-white"><i
                        class="fas fa-sync-alt"></i></a>
                <ol class="breadcrumb m-0">
                    <li class="breadcrumb-item">Setup</li>
                    <li class="breadcrumb-item">Nomenklatur</li>
                    <li class="breadcrumb-item active">Urusan</li>
                </ol>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <a data-load="modal" title="Tambah Nomenklatur Urusan" href="{{ route('urusan.create') }}"
                class="btn btn-success mb-3"><i class="fas fa-plus mr-2"></i> Tambah</a>
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <div class="card mb-3">
                <div class="card-body">
                    <div class="table-responsive">
                        {!! $table->table(['id' => Str::random(10)]) !!}
                        {!! $table->scripts() !!}
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>

<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <h4>Pengajuan UP</h4>
                <a data-action="reload" class="btn btn-primary btn-sm float-right text-white"><i
                        class="fas fa-sync-alt"></i></a>
                <ol class="breadcrumb m-0">
                    <li class="breadcrumb-item">Penatausahaan</li>
                    <li class="breadcrumb-item">Tata Usaha</li>
                    <li class="breadcrumb-item active">Pengajuan UP</li>
                </ol>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <a data-load="modal" data-size="lg" title="Tambah Pengajuan UP" href="{{ route('pengajuan-up.create') }}"
                class="btn btn-success mb-3"><i class="fas fa-plus mr-2"></i> Tambah Pengajuan</a>
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

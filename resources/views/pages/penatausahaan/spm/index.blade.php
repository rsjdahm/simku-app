<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <h4>Surat Perintah Membayar (SPM)</h4>
                <ol class="breadcrumb m-0">
                    <li class="breadcrumb-item">Penatausahaan</li>
                    <li class="breadcrumb-item">Pengeluaran</li>
                    <li class="breadcrumb-item active">Surat Perintah Membayar (SPM)</li>
                </ol>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <a data-load="modal" data-size="lg" title="Buat SPM" href="{{ route('spm.create') }}"
                class="btn btn-success mb-3"><i class="fas fa-plus mr-2"></i> Buat SPM</a>
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

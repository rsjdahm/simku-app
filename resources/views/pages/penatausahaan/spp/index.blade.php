<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <h4>Surat Permohonan Pembayaran (SPP)</h4>
                <ol class="breadcrumb m-0">
                    <li class="breadcrumb-item">Penatausahaan</li>
                    <li class="breadcrumb-item">Pengeluaran</li>
                    <li class="breadcrumb-item active">Surat Permohonan Pembayaran (SPP)</li>
                </ol>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <a data-load="modal" data-size="lg" title="Buat SPP" href="{{ route('spp.create') }}"
                class="btn btn-success mb-3"><i class="fas fa-plus mr-2"></i> Buat SPP</a>
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

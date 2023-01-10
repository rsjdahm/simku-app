<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <h4>Rencana Anggaran</h4>
                <a data-action="reload" class="btn btn-primary btn-sm float-right text-white"><i
                        class="fas fa-sync-alt"></i></a>
                <ol class="breadcrumb m-0">
                    <li class="breadcrumb-item">Anggaran</li>
                    <li class="breadcrumb-item">Penganggaran</li>
                    <li class="breadcrumb-item active">Rencana Anggaran</li>
                </ol>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <a data-load="modal" data-size="lg" title="Tambah Rencana Anggaran" href="{{ route('rka-pd.create') }}"
                class="btn btn-success mb-3"><i class="fas fa-plus mr-2"></i> Tambah</a>
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <div class="card bg-light mb-3">
                <div class="card-body p-2">
                    <div class="form-group mb-0">
                        <div class="row">
                            <div class="col-lg-2">
                                <label><i class="fas fa-filter"></i> Sub Unit Kerja PD:</label>
                            </div>
                            <div class="col-lg-10">
                                <select name="sub_unit_kerja_id_filter" class="form-control"
                                    data-filter-datatable="#rka-pd-table">
                                    @foreach ($sub_unit_kerja as $sub_unit_kerja_item)
                                        <option value="{{ $sub_unit_kerja_item->id }}">
                                            [{{ $sub_unit_kerja_item->kode_lengkap }}]
                                            {{ $sub_unit_kerja_item->nama }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card mb-3">
                <div class="card-body">
                    <div class="table-responsive">
                        {!! $table->table(['id' => 'rka-pd-table']) !!}
                        {!! $table->scripts() !!}
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>

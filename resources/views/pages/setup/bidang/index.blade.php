<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <h4>Nomenklatur Bidang</h4>
                <a data-action="reload" class="btn btn-primary btn-sm float-right text-white"><i
                        class="fas fa-sync-alt"></i></a>
                <ol class="breadcrumb m-0">
                    <li class="breadcrumb-item">Setup</li>
                    <li class="breadcrumb-item">Nomenklatur</li>
                    <li class="breadcrumb-item active">Bidang</li>
                </ol>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <a data-load="modal" title="Tambah Nomenklatur Bidang" href="{{ route('bidang.create') }}"
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
                                <label><i class="fas fa-filter"></i> Urusan:</label>
                            </div>
                            <div class="col-lg-10">
                                <select name="urusan_id_filter" class="form-control"
                                    data-filter-datatable="#{{ $rand = Str::random(10) }}">
                                    <option value="" selected>Semua Urusan</option>
                                    @foreach ($urusan as $urusan_item)
                                        <option value="{{ $urusan_item->id }}">
                                            [{{ $urusan_item->kode_lengkap }}]
                                            {{ $urusan_item->nama }}
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
                        {!! $table->table(['id' => $rand]) !!}
                        {!! $table->scripts() !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

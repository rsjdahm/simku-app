<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <h4>Nomenklatur Kegiatan</h4>
                <a data-action="reload" class="btn btn-primary btn-sm float-right text-white"><i
                        class="fas fa-sync-alt"></i></a>
                <ol class="breadcrumb m-0">
                    <li class="breadcrumb-item">Setup</li>
                    <li class="breadcrumb-item">Nomenklatur</li>
                    <li class="breadcrumb-item active">Kegiatan</li>
                </ol>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <a data-load="modal" title="Tambah Nomenklatur Kegiatan" href="{{ route('kegiatan.create') }}"
                class="btn btn-success mb-3"><i class="fas fa-plus mr-2"></i> Tambah</a>
        </div>
    </div>
    <div class="row">
        <div class="col-12">

            <div class="card bg-light mb-3">
                <div class="card-body p-2">
                    <div class="form-group mb-2">
                        <div class="row">
                            <div class="col-lg-2">
                                <label><i class="fas fa-filter"></i> Urusan:</label>
                            </div>
                            <div class="col-lg-10">
                                <select name="urusan_id_filter" class="form-control"
                                    data-filter-datatable="#{{ $rand = Str::random(10) }}">
                                    <option value="">Semua Urusan</option>
                                    @foreach ($urusan as $urusan_item)
                                        <option value="{{ $urusan_item->id }}">
                                            [{{ $urusan_item->kode_lengkap }}] {{ $urusan_item->nama }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="form-group mb-2">
                        <div class="row">
                            <div class="col-lg-2">
                                <label><i class="fas fa-filter"></i> Bidang:</label>
                            </div>
                            <div class="col-lg-10">
                                <select name="bidang_id_filter" class="form-control"
                                    data-filter-datatable="#{{ $rand }}">
                                    <option value="">Semua Bidang</option>
                                    @foreach ($bidang as $bidang_item)
                                        <option value="{{ $bidang_item->id }}"
                                            data-urusan_id="{{ $bidang_item->urusan_id }}" class="d-none">
                                            [{{ $bidang_item->kode_lengkap }}] {{ $bidang_item->nama }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="form-group mb-0">
                        <div class="row">
                            <div class="col-lg-2">
                                <label><i class="fas fa-filter"></i> Program:</label>
                            </div>
                            <div class="col-lg-10">
                                <select name="program_id_filter" class="form-control"
                                    data-filter-datatable="#{{ $rand }}">
                                    <option value="">Semua Program</option>
                                    @foreach ($program as $program_item)
                                        <option value="{{ $program_item->id }}"
                                            data-bidang_id="{{ $program_item->bidang_id }}" class="d-none">
                                            [{{ $program_item->kode_lengkap }}] {{ $program_item->nama }}
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

<script>
    $("select[name='urusan_id_filter']").change(function(event) {
        $("select[name='bidang_id_filter']").val('').trigger('change');
        $("select[name='bidang_id_filter'] option").removeClass('d-none');
        $("select[name='bidang_id_filter'] option[data-urusan_id]:not([data-urusan_id='" + $(
                "select[name='urusan_id_filter']")
            .val() + "'])").addClass('d-none');
    });
    $("select[name='bidang_id_filter']").change(function(event) {
        $("select[name='program_id_filter']").val('').trigger('change');
        $("select[name='program_id_filter'] option").removeClass('d-none');
        $("select[name='program_id_filter'] option[data-bidang_id]:not([data-bidang_id='" + $(
                "select[name='bidang_id_filter']")
            .val() + "'])").addClass('d-none');
    });
</script>

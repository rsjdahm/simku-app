<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <h4>Rekening Objek</h4>
                <a data-action="reload" class="btn btn-primary btn-sm float-right text-white"><i
                        class="fas fa-sync-alt"></i></a>
                <ol class="breadcrumb m-0">
                    <li class="breadcrumb-item">Setup</li>
                    <li class="breadcrumb-item">Rekening</li>
                    <li class="breadcrumb-item active">Rekening Objek</li>
                </ol>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <a data-load="modal" title="Tambah Rekening Objek" href="{{ route('rek-objek.create') }}"
                class="btn btn-success mb-3"><i class="fas fa-plus mr-2"></i> Tambah</a>
            <a data-load="modal-pdf" title="Cetak Daftar Rekening Standar" href="{{ route('rek-objek.pdf-daftar') }}"
                class="btn btn-secondary mb-3"><i class="fas fa-print mr-2"></i> Cetak Daftar</a>
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <div class="card bg-light mb-3">
                <div class="card-body p-2">
                    <div class="form-group mb-2">
                        <div class="row">
                            <div class="col-lg-2">
                                <label><i class="fas fa-filter"></i> Rekening Akun:</label>
                            </div>
                            <div class="col-lg-10">
                                <select name="rek_akun_id_filter" class="form-control"
                                    data-filter-datatable="#{{ $rand = Str::random(10) }}">
                                    <option value="" selected>Semua Rekening Akun</option>
                                    @foreach ($rek_akun as $rek_akun_item)
                                        <option value="{{ $rek_akun_item->id }}">
                                            [{{ $rek_akun_item->kode_lengkap }}]
                                            {{ $rek_akun_item->nama }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="form-group mb-2">
                        <div class="row">
                            <div class="col-lg-2">
                                <label><i class="fas fa-filter"></i> Rekening Kelompok:</label>
                            </div>
                            <div class="col-lg-10">
                                <select name="rek_kelompok_id_filter" class="form-control"
                                    data-filter-datatable="#{{ $rand }}">
                                    <option value="" selected>Semua Rekening Kelompok</option>
                                    @foreach ($rek_kelompok as $rek_kelompok_item)
                                        <option value="{{ $rek_kelompok_item->id }}"
                                            data-rek_akun_id="{{ $rek_kelompok_item->rek_akun_id }}" class="d-none">
                                            [{{ $rek_kelompok_item->kode_lengkap }}]
                                            {{ $rek_kelompok_item->nama }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="form-group mb-0">
                        <div class="row">
                            <div class="col-lg-2">
                                <label><i class="fas fa-filter"></i> Rekening Jenis:</label>
                            </div>
                            <div class="col-lg-10">
                                <select name="rek_jenis_id_filter" class="form-control"
                                    data-filter-datatable="#{{ $rand }}">
                                    <option value="" selected>Semua Rekening Jenis</option>
                                    @foreach ($rek_jenis as $rek_jenis_item)
                                        <option value="{{ $rek_jenis_item->id }}"
                                            data-rek_kelompok_id="{{ $rek_jenis_item->rek_kelompok_id }}"
                                            class="d-none">
                                            [{{ $rek_jenis_item->kode_lengkap }}]
                                            {{ $rek_jenis_item->nama }}
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
    $("select[name='rek_akun_id_filter']").change(function(event) {
        $("select[name='rek_kelompok_id_filter']").val('').trigger('change');
        $("select[name='rek_kelompok_id_filter'] option").removeClass('d-none');
        $("select[name='rek_kelompok_id_filter'] option[data-rek_akun_id]:not([data-rek_akun_id='" + $(
                "select[name='rek_akun_id_filter']")
            .val() + "'])").addClass('d-none');
    });
    $("select[name='rek_kelompok_id_filter']").change(function(event) {
        $("select[name='rek_jenis_id_filter']").val('').trigger('change');
        $("select[name='rek_jenis_id_filter'] option").removeClass('d-none');
        $("select[name='rek_jenis_id_filter'] option[data-rek_kelompok_id]:not([data-rek_kelompok_id='" + $(
                "select[name='rek_kelompok_id_filter']")
            .val() + "'])").addClass('d-none');
    });
</script>

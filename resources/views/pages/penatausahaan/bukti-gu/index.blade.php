<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <h4>Bukti Pengeluaran</h4>
                <a data-action="reload" class="btn btn-primary btn-sm float-right text-white"><i
                        class="fas fa-sync-alt"></i></a>
                <ol class="breadcrumb m-0">
                    <li class="breadcrumb-item">Penatausahaan</li>
                    <li class="breadcrumb-item">Belanja</li>
                    <li class="breadcrumb-item active">Bukti Pengeluaran</li>
                </ol>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <a data-load="modal" data-size="lg" title="Tambah Bukti Pengeluaran" href="{{ route('bukti-gu.create') }}"
                class="btn btn-success mb-3"><i class="fas fa-plus mr-2"></i> Tambah Bukti GU</a>
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <div class="card mb-3">
                <div class="card-body">
                    <div class="form-group mb-2">
                        <div class="row">
                            <div class="col-md-3">
                                <label class="d-block">Status Pending:</label>
                                <div class="btn-group btn-group-sm btn-group-toggle" data-toggle="buttons">
                                    @if (Auth::user()->modul != 'admin-blud')
                                        <label class="btn btn-primary active">
                                            <input type="radio" name="status_pending_filter_datatable_bukti-gu-table"
                                                value="{{ App\Enums\Penatausahaan\StatusPending::Normal }}"
                                                autocomplete="off" checked=""> Normal
                                            <strong class="text-light bg-success ml-2 rounded px-2"></strong>
                                        </label>
                                    @endif
                                    <label class="btn btn-primary">
                                        <input type="radio" name="status_pending_filter_datatable_bukti-gu-table"
                                            value="{{ App\Enums\Penatausahaan\StatusPending::Pending }}"
                                            autocomplete="off" @if (Auth::user()->modul == 'admin-blud') checked="" @endif>
                                        Pending
                                        <strong class="text-light bg-warning ml-2 rounded px-2"></strong>
                                    </label>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <label>Bulan:</label>
                                <select name="bulan_filter" data-filter-datatable="#bukti-gu-table"
                                    class="form-control">
                                    <option value="">Semua Bulan...</option>
                                    @for ($bulan = 1; $bulan <= 12; $bulan++)
                                        <option value="{{ $bulan }}">
                                            {{ Carbon\Carbon::create()->month($bulan)->translatedFormat('F') }}
                                        </option>
                                    @endfor
                                </select>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
            <div class="card mb-3">
                <div class="card-body">
                    <div class="table-responsive">
                        {!! $table->table(['id' => 'bukti-gu-table'], true) !!}
                        {!! $table->scripts() !!}
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-12">
        <a data-load="modal" data-size="xl" title="Tambah Bukti Pengeluaran untuk SPJ GU"
            href="{{ route('bukti-spj-gu.create', ['spj_gu_id' => request()->spj_gu_id]) }}"
            class="btn btn-success mb-3"><i class="fas fa-plus mr-2"></i>
            Tambah Bukti Pengeluaran</a>
    </div>
</div>
<div class="row">
    <div class="col-12">
        <div class="table-responsive">
            {!! $table->table(['id' => 'bukti-spj-gu-table'], true) !!}
            {!! $table->scripts() !!}
        </div>
    </div>
</div>

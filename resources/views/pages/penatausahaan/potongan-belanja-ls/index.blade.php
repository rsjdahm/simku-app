@if ($belanja_ls->status == App\Enums\Penatausahaan\StatusPosting::BelumPosting)
    <a data-load="modal" title="Tambah Potongan"
        href="{{ route('potongan-belanja-ls.create', ['belanja_ls_id' => $belanja_ls->id]) }}"
        class="btn btn-success mb-3"><i class="fas fa-plus mr-2"></i> Tambah</a>
@endif
<div class="table-responsive">
    {!! $table->table(['id' => Str::random(10)], true) !!}
    {!! $table->scripts() !!}
</div>

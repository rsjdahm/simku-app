<div class="form-group">
    <label>Jenis Penerima:</label>
    <select name="jenis_filter" data-filter-datatable="#bukti-gu-penerima-table" class="form-control">
        <option value="">Semua Jenis...</option>
        @foreach (App\Enums\Penatausahaan\JenisBuktiGu::cases() as $jenis)
            <option value="{{ $jenis }}">
                {{ $jenis }}
            </option>
        @endforeach
    </select>
</div>

<div class="table-responsive">
    {!! $table->table(['id' => 'bukti-gu-penerima-table']) !!}
    {!! $table->scripts() !!}
</div>

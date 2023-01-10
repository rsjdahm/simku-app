<form method="post" action="{{ route('sub-unit-kerja.store') }}">
    @csrf
    <div class="form-group">
        <label class="form-label">Unit Kerja</label>
        <select name="unit_kerja_id" class="form-control">
            <option value="" disabled selected>Pilih Unit Kerja...</option>
            @foreach ($urusan as $urusan_item)
                <option class="bg-light text-primary font-weight-bold" disabled>[{{ $urusan_item->kode }}]
                    {{ $urusan_item->nama }}</option>
                @foreach ($urusan_item->bidang as $bidang_item)
                    <option class="bg-light text-dark" style="padding-left: 1.5rem;" disabled>
                        [{{ $bidang_item->kode_lengkap }}]
                        {{ $bidang_item->nama }}
                    </option>
                    @foreach ($bidang_item->unit_kerja as $unit_kerja_item)
                        <option style="padding-left: 1.5rem;" value="{{ $unit_kerja_item->id }}">
                            [{{ $unit_kerja_item->kode_lengkap }}]
                            {{ $unit_kerja_item->nama }}
                        </option>
                    @endforeach
                @endforeach
            @endforeach
        </select>
    </div>
    <div class="form-group">
        <label class="form-label">Kode Unit kerja</label>
        <input type="number" name="kode" class="form-control">
    </div>
    <div class="form-group">
        <label class="form-label">Unit kerja</label>
        <textarea name="nama" class="form-control"></textarea>
    </div>
    <div class="form-group">
        <button type="submit" class="btn btn-success"><i class="fas fa-save"></i> Simpan</button>
    </div>
</form>

<script>
    $("select[name='unit_kerja_id']").val($("select[name='unit_kerja_id_filter']").val()).trigger('change');

    $("form[action='{{ route('sub-unit-kerja.store') }}']").on("submit", function(event) {
        event.preventDefault();
        const form = $(this);
        const data = new FormData($(this)[0]);
        $.ajax({
            data,
            url: form.attr("action"),
            type: form.attr("method"),
            processData: false,
            contentType: false,
            beforeSend: function() {
                NProgress.start();
            },
            success: function(response) {
                toastr.success(response.message);
                $('table.datatable').DataTable().ajax.reload(null, false);
                form.closest('div.modal').modal("hide");
                NProgress.done();
            }
        });
        return false;
    });
</script>

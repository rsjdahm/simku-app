<form method="post" action="{{ route('unit-kerja.store') }}">
    @csrf
    <div class="form-group">
        <label class="form-label">Bidang</label>
        <select name="bidang_id" class="form-control">
            <option value="" disabled selected>Pilih Bidang...</option>
            @foreach ($urusan as $urusan_item)
                <option class="bg-light text-primary font-weight-bold" disabled>[{{ $urusan_item->kode }}]
                    {{ $urusan_item->nama }}</option>
                @foreach ($urusan_item->bidang as $bidang_item)
                    <option style="padding-left: 1.5rem;" value="{{ $bidang_item->id }}">
                        [{{ $bidang_item->kode_lengkap }}]
                        {{ $bidang_item->nama }}
                    </option>
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
    $("select[name='bidang_id']").val($("select[name='bidang_id_filter']").val()).trigger('change');

    $("form[action='{{ route('unit-kerja.store') }}']").on("submit", function(event) {
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

<form method="post" action="{{ route('program.store') }}">
    @csrf
    <div class="form-group">
        <label class="form-label">Bidang</label>
        <select name="bidang_id" class="form-control">
            <option value="" disabled selected>Pilih Bidang...</option>
            @foreach ($urusan as $urusan_item)
                <option class="bg-light text-primary font-weight-bold" disabled>[{{ $urusan_item->kode_lengkap }}]
                    {{ $urusan_item->nama }}</option>
                @foreach ($bidang as $bidang_item)
                    @if ($bidang_item->urusan_id == $urusan_item->id)
                        <option style="padding-left: 1.5rem;" value="{{ $bidang_item->id }}">
                            [{{ $bidang_item->kode_lengkap }}]
                            {{ $bidang_item->nama }}
                        </option>
                    @endif
                @endforeach
            @endforeach
        </select>
    </div>
    <div class="form-group">
        <label class="form-label">Kode Program</label>
        <input type="number" name="kode" class="form-control">
    </div>
    <div class="form-group">
        <label class="form-label">Nomenklatur Program</label>
        <textarea name="nama" class="form-control"></textarea>
    </div>
    <div class="form-group">
        <button type="submit" class="btn btn-success"><i class="fas fa-save"></i> Simpan</button>
    </div>
</form>

<script>
    $("select[name='bidang_id']").val($("select[name='bidang_id_filter']").val()).trigger('change');

    $("form[action='{{ route('program.store') }}']").on("submit", function(event) {
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

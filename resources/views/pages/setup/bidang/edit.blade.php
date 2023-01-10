<form method="post" action="{{ route('bidang.update', $bidang->id) }}">
    @csrf
    @method('put')
    <div class="form-group">
        <label class="form-label">Urusan</label>
        <select name="urusan_id" class="form-control">
            <option value="" disabled>Pilih Urusan...</option>
            @foreach ($urusan as $urusan_item)
                <option @selected($urusan_item->id == $bidang->urusan_id) value="{{ $urusan_item->id }}">[{{ $urusan_item->kode_lengkap }}]
                    {{ $urusan_item->nama }}</option>
            @endforeach
        </select>
    </div>
    <div class="form-group">
        <label class="form-label">Kode Bidang</label>
        <input type="number" name="kode" class="form-control" value="{{ $bidang->kode }}">
    </div>
    <div class="form-group">
        <label class="form-label">Nomenklatur Bidang</label>
        <textarea name="nama" class="form-control">{{ $bidang->nama }}</textarea>
    </div>
    <div class="form-group">
        <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Simpan</button>
    </div>
</form>

<script>
    $("form[action='{{ route('bidang.update', $bidang->id) }}']").on("submit", function(event) {
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

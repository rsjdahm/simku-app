<form method="post" action="{{ route('bank.update', $bank->id) }}">
    @csrf
    @method('put')
    <div class="form-group">
        <label class="form-label">Kode</label>
        <input autofocus type="number" name="kode" class="form-control" value="{{ $bank->kode }}">
    </div>
    <div class="form-group">
        <label class="form-label">Nama</label>
        <textarea name="nama" class="form-control">{{ $bank->nama }}</textarea>
    </div>
    <div class="form-group">
        <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Simpan</button>
    </div>
</form>

<script>
    $("form[action='{{ route('bank.update', $bank->id) }}']").on("submit", function(event) {
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

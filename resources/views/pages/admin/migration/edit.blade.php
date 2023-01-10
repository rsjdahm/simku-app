<form id="{{ time() }}_form" method="post"
    action="{{ route('migration.update', ['migration' => $item->migration]) }}">
    @csrf
    @method('put')
    <div class="form-group">
        <label class="form-label">Nama Migration</label>
        <input readonly type="text" name="migration" class="form-control" value="{{ $item->migration }}">
    </div>
    <div class="form-group">
        <label class="form-label">Batch</label>
        <input type="number" name="batch" class="form-control" value="{{ $item->batch }}">
    </div>
    <div class="form-group">
        <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Simpan</button>
    </div>
</form>

<script>
    $("form#{{ time() }}_form").on("submit", function(event) {
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

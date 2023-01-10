<form method="post" action="{{ route('spj-gu.update', $spj_gu->id) }}">
    @csrf
    @method('put')
    <div class="form-group">
        <label class="form-label">Nomor SPJ <span class="text-warning">*</span></label>
        <input autofocus name="nomor" class="form-control" value="{{ $spj_gu->nomor }}">
    </div>
    <div class="form-group">
        <label class="form-label">Tanggal LPJ <span class="text-warning">*</span></label>
        <input type="date" name="tanggal" class="form-control" value="{{ $spj_gu->tanggal }}">
    </div>
    <div class="form-group">
        <label class="form-label">Uraian</label>
        <textarea name="uraian" class="form-control">{{ $spj_gu->uraian }}</textarea>
    </div>
    <div class="form-group">
        <label class="form-label">Status <span class="text-danger">*</span></label>
        <select name="status" class="form-control">
            @foreach (App\Enums\Penatausahaan\StatusPosting::cases() as $status)
                <option value="{{ $status }}" @selected($spj_gu->status == $status)>{{ $status }}</option>
            @endforeach
        </select>
    </div>
    <div class="form-group">
        <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Simpan</button>
    </div>
</form>

<script>
    $("form[action='{{ route('spj-gu.update', $spj_gu->id) }}']").on("submit", function(event) {
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

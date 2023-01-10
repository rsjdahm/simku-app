<form method="post" action="{{ route('rek-akun.store') }}">
    @csrf
    <div class="form-group">
        <label class="form-label">Kode Rekening Akun</label>
        <input type="number" name="kode" class="form-control">
    </div>
    <div class="form-group">
        <label class="form-label">Uraian Rekening Akun</label>
        <textarea name="nama" class="form-control"></textarea>
    </div>
    <div class="form-group">
        <label class="form-label">Jenis Rekening Akun</label>
        <select name="jenis" class="form-control">
            <option value="" disabled selected>Pilih Jenis Rekening Akun...</option>
            @foreach ($jenis as $jenis_item)
                <option value="{{ $jenis_item }}">{{ $jenis_item }}</option>
            @endforeach
        </select>
    </div>
    <div class="form-group">
        <button type="submit" class="btn btn-success"><i class="fas fa-save"></i> Simpan</button>
    </div>
</form>

<script>
    $("form[action='{{ route('rek-akun.store') }}']").on("submit", function(event) {
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

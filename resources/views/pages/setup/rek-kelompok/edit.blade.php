<form method="post" action="{{ route('rek-kelompok.update', $rek_kelompok->id) }}">
    @csrf
    @method('put')
    <div class="form-group">
        <label class="form-label">Rekening Kelompok</label>
        <select name="rek_akun_id" class="form-control">
            <option value="" disabled>Pilih Rekening Kelompok...</option>
            @foreach ($rek_akun as $rek_akun_item)
                <option @selected($rek_akun_item->id == $rek_kelompok->rek_akun_id) value="{{ $rek_akun_item->id }}">
                    [{{ $rek_akun_item->kode_lengkap }}]
                    {{ $rek_akun_item->nama }}</option>
            @endforeach
        </select>
    </div>
    <div class="form-group">
        <label class="form-label">Kode Rekening Kelompok</label>
        <input type="number" name="kode" class="form-control" value="{{ $rek_kelompok->kode }}">
    </div>
    <div class="form-group">
        <label class="form-label">Uraian Rekening Kelompok</label>
        <textarea name="nama" class="form-control">{{ $rek_kelompok->nama }}</textarea>
    </div>
    <div class="form-group">
        <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Simpan</button>
    </div>
</form>

<script>
    $("form[action='{{ route('rek-kelompok.update', $rek_kelompok->id) }}']").on("submit", function(event) {
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

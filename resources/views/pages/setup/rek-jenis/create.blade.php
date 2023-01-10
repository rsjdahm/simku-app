<form method="post" action="{{ route('rek-jenis.store') }}">
    @csrf
    <div class="form-group">
        <label class="form-label">Rekening Kelompok</label>
        <select name="rek_kelompok_id" class="form-control">
            <option value="" disabled selected>Pilih Rekening Kelompok...</option>
            @foreach ($rek_akun->sortBy('kode_lengkap') as $rek_akun_item)
                <option class="bg-light text-primary font-weight-bold" disabled>[{{ $rek_akun_item->kode }}]
                    {{ $rek_akun_item->nama }}</option>
                @foreach ($rek_akun_item->rek_kelompok->sortBy('kode_lengkap') as $rek_kelompok_item)
                    <option style="padding-left: 1.5rem;" value="{{ $rek_kelompok_item->id }}">
                        [{{ $rek_kelompok_item->kode_lengkap }}]
                        {{ $rek_kelompok_item->nama }}
                    </option>
                @endforeach
            @endforeach
        </select>
    </div>
    <div class="form-group">
        <label class="form-label">Kode Rekening Jenis</label>
        <input type="number" name="kode" class="form-control">
    </div>
    <div class="form-group">
        <label class="form-label">Uraian Rekening Jenis</label>
        <textarea name="nama" class="form-control"></textarea>
    </div>
    <div class="form-group">
        <button type="submit" class="btn btn-success"><i class="fas fa-save"></i> Simpan</button>
    </div>
</form>

<script>
    $("select[name='rek_kelompok_id']").val($("select[name='rek_kelompok_id_filter']").val()).trigger('change');

    $("form[action='{{ route('rek-jenis.store') }}']").on("submit", function(event) {
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

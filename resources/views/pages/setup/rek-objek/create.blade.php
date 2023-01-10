<form method="post" action="{{ route('rek-objek.store') }}">
    @csrf
    <div class="form-group">
        <label class="form-label">Rekening Jenis</label>
        <select name="rek_jenis_id" class="form-control">
            <option value="" disabled selected>Pilih Rekening Jenis...</option>
            @foreach ($rek_akun->sortBy('kode_lengkap') as $rek_akun_item)
                <option class="bg-light text-primary font-weight-bold" disabled>[{{ $rek_akun_item->kode_lengkap }}]
                    {{ $rek_akun_item->nama }}</option>
                @foreach ($rek_akun_item->rek_kelompok->sortBy('kode_lengkap') as $rek_kelompok_item)
                    <option class="bg-light text-dark font-weight-bold" style="padding-left: 1.5rem;" disabled>
                        [{{ $rek_kelompok_item->kode_lengkap }}]
                        {{ $rek_kelompok_item->nama }}</option>
                    @foreach ($rek_kelompok_item->rek_jenis->sortBy('kode_lengkap') as $rek_jenis_item)
                        <option style="padding-left: 2rem;" value="{{ $rek_jenis_item->id }}">
                            [{{ $rek_jenis_item->kode_lengkap }}]
                            {{ $rek_jenis_item->nama }}
                        </option>
                    @endforeach
                @endforeach
            @endforeach
        </select>
    </div>
    <div class="form-group">
        <label class="form-label">Kode Rekening Objek</label>
        <input type="number" name="kode" class="form-control">
    </div>
    <div class="form-group">
        <label class="form-label">Uraian Rekening Objek</label>
        <textarea name="nama" class="form-control"></textarea>
    </div>
    <div class="form-group">
        <button type="submit" class="btn btn-success"><i class="fas fa-save"></i> Simpan</button>
    </div>
</form>

<script>
    $("select[name='rek_jenis_id']").val($("select[name='rek_jenis_id_filter']").val()).trigger('change');

    $("form[action='{{ route('rek-objek.store') }}']").on("submit", function(event) {
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

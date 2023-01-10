<form method="post" action="{{ route('rek-rincian-objek.update', $rek_rincian_objek->id) }}">
    @csrf
    @method('put')
    <div class="form-group">
        <label class="form-label">Rekening Objek</label>
        <select name="rek_objek_id" class="form-control">
            <option value="" disabled selected>Pilih Rekening Objek...</option>
            @foreach ($rek_akun->sortBy('kode_lengkap') as $rek_akun_item)
                <option class="bg-light text-primary font-weight-bold" disabled>[{{ $rek_akun_item->kode_lengkap }}]
                    {{ $rek_akun_item->nama }}</option>
                @foreach ($rek_akun_item->rek_kelompok->sortBy('kode_lengkap') as $rek_kelompok_item)
                    <option class="bg-light text-dark font-weight-bold" style="padding-left: 1.5rem;" disabled>
                        [{{ $rek_kelompok_item->kode_lengkap }}]
                        {{ $rek_kelompok_item->nama }}</option>
                    @foreach ($rek_kelompok_item->rek_jenis->sortBy('kode_lengkap') as $rek_jenis_item)
                        <option class="bg-light text-dark" style="padding-left: 2rem;" disabled>
                            [{{ $rek_jenis_item->kode_lengkap }}]
                            {{ $rek_jenis_item->nama }}
                        </option>
                        @foreach ($rek_jenis_item->rek_objek->sortBy('kode_lengkap') as $rek_objek_item)
                            <option @selected($rek_objek_item->id == $rek_rincian_objek->rek_objek_id) style="padding-left: 2.5rem;"
                                value="{{ $rek_objek_item->id }}">
                                [{{ $rek_objek_item->kode_lengkap }}]
                                {{ $rek_objek_item->nama }}
                            </option>
                        @endforeach
                    @endforeach
                @endforeach
            @endforeach
        </select>
    </div>
    <div class="form-group">
        <label class="form-label">Kode Rekening Objek</label>
        <input type="number" name="kode" class="form-control" value="{{ $rek_rincian_objek->kode }}">
    </div>
    <div class="form-group">
        <label class="form-label">Uraian Rekening Objek</label>
        <textarea name="nama" class="form-control">{{ $rek_rincian_objek->nama }}</textarea>
    </div>
    <div class="form-group">
        <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Simpan</button>
    </div>
</form>

<script>
    $("form[action='{{ route('rek-rincian-objek.update', $rek_rincian_objek->id) }}']").on("submit", function(event) {
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

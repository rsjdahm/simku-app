<form method="post" action="{{ route('penandatangan.update', $penandatangan->id) }}">
    @csrf
    @method('put')
    <div class="form-group">
        <label class="form-label">Sub Unit Kerja</label>
        <select name="sub_unit_kerja_id" class="form-control">
            @foreach ($sub_unit_kerja as $sub_unit_kerja_item)
                <option value="{{ $sub_unit_kerja_item->id }}" @selected($penandatangan->sub_unit_kerja_id == $sub_unit_kerja_item->id)>
                    [{{ $sub_unit_kerja_item->kode_lengkap }}]
                    {{ $sub_unit_kerja_item->nama }}
                </option>
            @endforeach
        </select>
    </div>
    <div class="form-group">
        <label class="form-label">Nama</label>
        <input autofocus name="nama" class="form-control" value="{{ $penandatangan->nama }}">
    </div>
    <div class="form-group">
        <label class="form-label">NIP</label>
        <input name="nip" class="form-control" value="{{ $penandatangan->nip }}">
    </div>
    <div class="form-group">
        <label class="form-label">Jabatan</label>
        <select name="jabatan" class="form-control">
            <option value="" disabled selected>Pilih Jabatan...</option>
            @foreach (App\Enums\Penatausahaan\JabatanPenandatangan::cases() as $jabatan)
                <option value="{{ $jabatan }}" @selected($penandatangan->jabatan == $jabatan)>
                    {{ $jabatan }}
                </option>
            @endforeach
        </select>
    </div>
    <div class="form-group">
        <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Simpan</button>
    </div>
</form>

<script>
    $("form[action='{{ route('penandatangan.update', $penandatangan->id) }}']").on("submit", function(event) {
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

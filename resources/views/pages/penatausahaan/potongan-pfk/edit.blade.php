<form method="post" action="{{ route('potongan-pfk.update', $potongan_pfk->id) }}">
    @csrf
    @method('put')
    <div class="form-group">
        <label class="form-label">Kode MAP</label>
        <input autofocus type="number" name="kode_map" class="form-control" value="{{ $potongan_pfk->kode_map }}">
    </div>
    <div class="form-group">
        <label class="form-label">Nama</label>
        <textarea name="nama" class="form-control">{{ $potongan_pfk->nama }}</textarea>
    </div>
    <div class="form-group">
        <label class="form-label">Jenis Potongan</label>
        <select name="jenis" class="form-control">
            <option value="" disabled selected>Pilih Jenis Potongan...</option>
            @foreach (\App\Enums\Penatausahaan\JenisPotonganPfk::cases() as $jenis)
                <option value="{{ $jenis }}" @selected($potongan_pfk->jenis == $jenis)>{{ $jenis }}</option>
            @endforeach
        </select>
    </div>
    <div class="form-group">
        <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Simpan</button>
    </div>
</form>

<script>
    $("form[action='{{ route('potongan-pfk.update', $potongan_pfk->id) }}']").on("submit", function(event) {
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

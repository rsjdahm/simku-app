<form method="post" action="{{ route('sp2d.update', $sp2d->id) }}">
    @csrf
    @method('put')
    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                <label class="form-label">Nomor SP2D <span class="text-warning">*</span></label>
                <input autofocus name="nomor" class="form-control" value="{{ $sp2d->nomor }}">
            </div>
            <div class="form-group">
                <label class="form-label">Tanggal SP2D <span class="text-warning">*</span></label>
                <input type="date" name="tanggal" class="form-control" value="{{ $sp2d->tanggal }}">
            </div>
            <div class="form-group">
                <label class="form-label">Nomor Cek <span class="text-warning">*</span></label>
                <input autofocus name="nomor_cek" class="form-control" value="{{ $sp2d->nomor_cek }}">
            </div>
        </div>
        <div class="col-md-6">
            <div class="card">
                <div class="card-body">
                    <div class="form-group">
                        <label class="form-label">Dokumen SPM</label>
                        <select name="spm_id" class="form-control">
                            <option value="" selected>Pilih Dokumen...</option>
                            @foreach ($spm as $spm_item)
                                <option value="{{ $spm_item->id }}" @selected($sp2d->spm_id == $spm_item->id)>
                                    [{{ $spm_item->nomor }}]
                                    {{ $spm_item->spp->uraian }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Status <span class="text-danger">*</span></label>
                        <select name="status" class="form-control">
                            @foreach (App\Enums\Penatausahaan\StatusPosting::cases() as $status)
                                <option value="{{ $status }}" @selected($sp2d->status == $status)>{{ $status }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>

        </div>
    </div>
    <div class="form-group">
        <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Simpan</button>
    </div>
</form>

<script>
    $("form[action='{{ route('sp2d.update', $sp2d->id) }}']").on("submit", function(event) {
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

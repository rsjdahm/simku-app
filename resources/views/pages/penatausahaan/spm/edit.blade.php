<form method="post" action="{{ route('spm.update', $spm->id) }}">
    @csrf
    @method('put')
    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                <label class="form-label">Nomor SPM <span class="text-warning">*</span></label>
                <input autofocus name="nomor" class="form-control" value="{{ $spm->nomor }}">
            </div>
            <div class="form-group">
                <label class="form-label">Tanggal SPM <span class="text-warning">*</span></label>
                <input type="date" name="tanggal" class="form-control" value="{{ $spm->tanggal }}">
            </div>
        </div>
        <div class="col-md-6">
            <div class="card">
                <div class="card-body">
                    <div class="form-group">
                        <label class="form-label">Dokumen SPP</label>
                        <select name="spp_id" class="form-control">
                            <option value="" selected>Pilih Dokumen...</option>
                            @foreach ($spp as $spp_item)
                                <option value="{{ $spp_item->id }}" @selected($spm->spp_id == $spp_item->id)>
                                    [{{ $spp_item->nomor }}]
                                    {{ $spp_item->uraian }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Status <span class="text-danger">*</span></label>
                        <select name="status" class="form-control">
                            @foreach (App\Enums\Penatausahaan\StatusPosting::cases() as $status)
                                <option value="{{ $status }}" @selected($spm->status == $status)>{{ $status }}
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
    $("form[action='{{ route('spm.update', $spm->id) }}']").on("submit", function(event) {
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

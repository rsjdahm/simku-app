<form method="post" action="{{ route('spp.store') }}">
    @csrf
    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                <label class="form-label">Jenis SPP</label>
                <select name="jenis" class="form-control">
                    <option value="" disabled selected>Pilih Jenis SPP...</option>
                    @foreach (\App\Enums\Penatausahaan\JenisPengeluaran::cases() as $jenis)
                        <option value="{{ $jenis }}">{{ $jenis }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label class="form-label">Nomor SPP <span class="text-warning">*</span></label>
                <input autofocus name="nomor" class="form-control">
            </div>
            <div class="form-group">
                <label class="form-label">Tanggal SPP <span class="text-warning">*</span></label>
                <input type="date" name="tanggal" class="form-control">
            </div>
            <div class="form-group">
                <label class="form-label">Uraian</label>
                <textarea name="uraian" class="form-control"></textarea>
            </div>

        </div>
        <div class="col-md-6">
            <div class="card">
                <div class="card-body">
                    <div class="form-group">
                        <label class="form-label">Dokumen Pengajuan UP</label>
                        <select name="pengajuan_up_id" class="form-control">
                            <option value="" selected>Pilih Dokumen...</option>
                            @foreach ($pengajuan_up as $pengajuan_up_item)
                                <option value="{{ $pengajuan_up_item->id }}">
                                    [{{ $pengajuan_up_item->nomor }}]
                                    {{ $pengajuan_up_item->uraian }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Dokumen SPJ GU</label>
                        <select name="spj_gu_id" class="form-control">
                            <option value="" selected>Pilih Dokumen...</option>
                            @foreach ($spj_gu as $spj_gu_item)
                                <option value="{{ $spj_gu_item->id }}">
                                    [{{ $spj_gu_item->nomor }}]
                                    {{ $spj_gu_item->uraian }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Dokumen Belanja LS</label>
                        <select name="belanja_ls_id" class="form-control">
                            <option value="" selected>Pilih Dokumen...</option>
                            @foreach ($belanja_ls as $belanja_ls_item)
                                <option value="{{ $belanja_ls_item->id }}">
                                    [{{ $belanja_ls_item->nomor }}]
                                    {{ $belanja_ls_item->uraian }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Status <span class="text-danger">*</span></label>
                        <select name="status" class="form-control">
                            @foreach (App\Enums\Penatausahaan\StatusPosting::cases() as $status)
                                <option value="{{ $status }}">{{ $status }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>

        </div>
    </div>

    <div class="form-group">
        <button type="submit" class="btn btn-success"><i class="fas fa-save"></i> Simpan</button>
    </div>
</form>

<script>
    $("form[action='{{ route('spp.store') }}']").on("submit", function(event) {
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

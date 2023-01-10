<form method="post" action="{{ route('potongan-belanja-ls.update', $potongan_belanja_ls->id) }}">
    @csrf
    @method('put')
    <div class="row">
        <div class="col-md-6">
            <input type="hidden" name="belanja_ls_id" value="{{ $potongan_belanja_ls->belanja_ls_id }}">
            <div class="form-group">
                <label class="form-label">Jenis Potongan</label>
                <select name="potongan_pfk_id" class="form-control">
                    <option value="">Pilih Jenis Potongan...</option>
                    @foreach ($potongan_pfk as $potongan_pfk_item)
                        <option value="{{ $potongan_pfk_item->id }}" @selected($potongan_belanja_ls->potongan_pfk_id == $potongan_pfk_item->id)>
                            {{ $potongan_pfk_item->nama }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label class="form-label">Nilai Potongan</label>
                <input name="nilai" class="form-control" value="{{ $potongan_belanja_ls->nilai }}">
            </div>
            <div class="form-group">
                <label class="form-label">Nomor Billing</label>
                <input name="nomor_billing" class="form-control" value="{{ $potongan_belanja_ls->nomor_billing }}">
            </div>
        </div>
        <div class="col-md-6">
            <div class="card">
                <div class="card-body">
                    <div class="form-group">
                        <label class="form-label">Tanggal Setor</label>
                        <input type="date" name="tanggal_setor" class="form-control"
                            value="{{ $potongan_belanja_ls->tanggal_setor }}">
                    </div>
                    <div class="form-group">
                        <label class="form-label">Tanggal Buku</label>
                        <input type="date" name="tanggal_buku" class="form-control"
                            value="{{ $potongan_belanja_ls->tanggal_buku }}">
                    </div>
                    <div class="form-group">
                        <label class="form-label">NTPN/Nomor Penyetoran</label>
                        <input name="nomor_penyetoran" class="form-control"
                            value="{{ $potongan_belanja_ls->nomor_penyetoran }}">
                    </div>
                    <div class="form-group">
                        <label class="form-label">Status</label>
                        <select name="status" class="form-control">
                            @foreach (\App\Enums\Penatausahaan\StatusSetor::cases() as $status)
                                <option value="{{ $status }}" @selected($potongan_belanja_ls->status == $status)>{{ $status }}
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
    $("form[action='{{ route('potongan-belanja-ls.update', $potongan_belanja_ls->id) }}']").on("submit", function(
        event) {
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

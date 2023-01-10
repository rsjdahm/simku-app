<form method="post" action="{{ route('rka-pd.update', $rka_pd->id) }}">
    @csrf
    @method('put')
    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                <label class="form-label">Sub Unit Kerja</label>
                <select name="sub_unit_kerja_id" class="form-control">
                    <option value="" disabled selected>Pilih Sub Unit Kerja...</option>
                    @foreach ($sub_unit_kerja as $sub_unit_kerja_item)
                        <option @selected($sub_unit_kerja_item->id == $rka_pd->sub_unit_kerja_id) value="{{ $sub_unit_kerja_item->id }}">
                            [{{ $sub_unit_kerja_item->kode_lengkap }}]
                            {{ $sub_unit_kerja_item->nama }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label class="form-label">Nomor Dokumen</label>
                <input name="nomor" class="form-control" value="{{ $rka_pd->nomor }}">
            </div>
            <div class="form-group">
                <label class="form-label">Status</label>
                <select name="status" class="form-control">
                    <option value="" disabled selected>Pilih Status...</option>
                    @foreach ($status as $status_item)
                        <option @selected($status_item == $rka_pd->status) value="{{ $status_item }}">{{ $status_item }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label class="form-label">Tanggal Dokumen</label>
                <input type="date" name="tanggal" class="form-control" value="{{ $rka_pd->tanggal }}">
            </div>
            <div class="form-group">
                <label class="form-label">Uraian Dokumen</label>
                <textarea name="uraian" class="form-control">{{ $rka_pd->uraian }}</textarea>
            </div>
        </div>
        <div class="col-md-6">

            <div class="form-group">
                <label class="form-label">Nilai Pagu Pendapatan</label>
                <input name="pagu_pendapatan" class="form-control" value="{{ $rka_pd->pagu_pendapatan }}">
            </div>
            <div class="form-group">
                <label class="form-label">Nilai Pagu Pengeluaran</label>
                <input name="pagu_pengeluaran" class="form-control" value="{{ $rka_pd->pagu_pengeluaran }}">
            </div>
            <div class="form-group">
                <label class="form-label">Nilai Pagu Pembiayaan</label>
                <input name="pagu_pembiayaan" class="form-control" value="{{ $rka_pd->pagu_pembiayaan }}">
            </div>
        </div>
    </div>
    <div class="form-group">
        <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Simpan</button>
    </div>
</form>

<script>
    $("form[action='{{ route('rka-pd.update', $rka_pd->id) }}']").on("submit", function(event) {
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

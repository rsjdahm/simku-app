<form method="post" action="{{ route('pengajuan-up.update', $pengajuan_up->id) }}">
    @csrf
    @method('put')
    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                <label class="form-label">Sub Unit Kerja</label>
                <select name="sub_unit_kerja_id" class="form-control">
                    <option value="" disabled selected>Pilih Sub Unit Kerja...</option>
                    @foreach ($sub_unit_kerja as $sub_unit_kerja_item)
                        <option value="{{ $sub_unit_kerja_item->id }}" @selected($pengajuan_up->sub_unit_kerja_id == $sub_unit_kerja_item->id)>
                            [{{ $sub_unit_kerja_item->kode_lengkap }}]
                            {{ $sub_unit_kerja_item->nama }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label class="form-label">Rekening Sub Rincian Objek</label>
                <select name="rek_sub_rincian_objek_id" class="form-control">
                    <option value="" disabled selected>Pilih Rekening Sub Rincian Objek...</option>
                    @foreach ($rek_sub_rincian_objek as $rek_sub_rincian_objek_item)
                        <option value="{{ $rek_sub_rincian_objek_item->id }}" @selected($pengajuan_up->rek_sub_rincian_objek_id == $rek_sub_rincian_objek_item->id)>
                            [{{ $rek_sub_rincian_objek_item->kode_lengkap }}]
                            {{ $rek_sub_rincian_objek_item->nama }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label class="form-label">Nomor</label>
                <input autofocus name="nomor" class="form-control" value="{{ $pengajuan_up->nomor }}">
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label class="form-label">Tanggal</label>
                <input type="date" name="tanggal" class="form-control" value="{{ $pengajuan_up->tanggal }}">
            </div>
            <div class="form-group">
                <label class="form-label">Uraian</label>
                <textarea name="uraian" class="form-control">{{ $pengajuan_up->uraian }}</textarea>
            </div>
            <div class="form-group">
                <label class="form-label">Nilai</label>
                <input type="number" name="nilai" step="0.0001" class="form-control"
                    value="{{ $pengajuan_up->nilai }}">
            </div>
            <div class="form-group">
                <label class="form-label">Status</label>
                <select name="status" class="form-control">
                    @foreach (\App\Enums\Penatausahaan\StatusPosting::cases() as $status)
                        <option value="{{ $status }}" @selected($pengajuan_up->status == $status)>{{ $status }}</option>
                    @endforeach
                </select>
            </div>
        </div>
    </div>
    <div class="form-group">
        <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Simpan</button>
    </div>
</form>

<script>
    $("form[action='{{ route('pengajuan-up.update', $pengajuan_up->id) }}']").on("submit", function(event) {
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

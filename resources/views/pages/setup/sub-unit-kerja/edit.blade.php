<form method="post" action="{{ route('sub-unit-kerja.update', $sub_unit_kerja->id) }}">
    @csrf
    @method('put')
    <div class="form-group">
        <label class="form-label">Bidang</label>
        <select name="unit_kerja_id" class="form-control">
            <option value="" disabled selected>Pilih Unit Kerja...</option>
            @foreach ($urusan as $urusan_item)
                <option class="bg-light text-primary font-weight-bold" disabled>[{{ $urusan_item->kode }}]
                    {{ $urusan_item->nama }}</option>
                @foreach ($urusan_item->bidang as $bidang_item)
                    <option class="bg-light text-dark" style="padding-left: 1.5rem;" disabled>
                        [{{ $bidang_item->kode_lengkap }}]
                        {{ $bidang_item->nama }}
                    </option>
                    @foreach ($bidang_item->unit_kerja as $unit_kerja_item)
                        <option @selected($unit_kerja_item->id == $sub_unit_kerja->unit_kerja_id) style="padding-left: 1.5rem;"
                            value="{{ $unit_kerja_item->id }}">
                            [{{ $unit_kerja_item->kode_lengkap }}]
                            {{ $unit_kerja_item->nama }}
                        </option>
                    @endforeach
                @endforeach
            @endforeach
        </select>
    </div>
    <div class="form-group">
        <label class="form-label">Kode Sub Unit Kerja</label>
        <input type="number" name="kode" class="form-control" value="{{ $sub_unit_kerja->kode }}">
    </div>
    <div class="form-group">
        <label class="form-label">Sub Unit Kerja</label>
        <textarea name="nama" class="form-control">{{ $sub_unit_kerja->nama }}</textarea>
    </div>
    <div class="form-group">
        <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Simpan</button>
    </div>
</form>

<script>
    $("form[action='{{ route('sub-unit-kerja.update', $sub_unit_kerja->id) }}']").on("submit", function(event) {
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

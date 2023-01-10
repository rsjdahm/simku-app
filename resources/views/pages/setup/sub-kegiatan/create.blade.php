<form method="post" action="{{ route('sub-kegiatan.store') }}">
    @csrf
    <div class="form-group">
        <label class="form-label">Kegiatan</label>
        <select name="kegiatan_id" class="form-control">
            <option value="" disabled selected>Pilih Kegiatan...</option>
            @foreach ($urusan as $urusan_item)
                <option class="bg-light text-primary font-weight-bold" disabled>[{{ $urusan_item->kode_lengkap }}]
                    {{ $urusan_item->nama }}</option>
                @foreach ($bidang as $bidang_item)
                    @if ($bidang_item->urusan_id == $urusan_item->id)
                        <option class="bg-light text-dark font-weight-bold" style="padding-left: 1.5rem;" disabled>
                            [{{ $bidang_item->kode_lengkap }}]
                            {{ $bidang_item->nama }}</option>
                        @foreach ($program as $program_item)
                            @if ($program_item->bidang_id == $bidang_item->id)
                                <option class="bg-light text-dark" style="padding-left: 2rem;"
                                    value="{{ $program_item->id }}" disabled>
                                    [{{ $program_item->kode_lengkap }}]
                                    {{ $program_item->nama }}
                                </option>
                                @foreach ($kegiatan as $kegiatan_item)
                                    @if ($kegiatan_item->program_id == $program_item->id)
                                        <option style="padding-left: 2.5rem;" value="{{ $kegiatan_item->id }}">
                                            [{{ $kegiatan_item->kode_lengkap }}]
                                            {{ $kegiatan_item->nama }}
                                        </option>
                                    @endif
                                @endforeach
                            @endif
                        @endforeach
                    @endif
                @endforeach
            @endforeach
        </select>
    </div>
    <div class="form-group">
        <label class="form-label">Kode Sub Kegiatan</label>
        <input type="number" name="kode" class="form-control">
    </div>
    <div class="form-group">
        <label class="form-label">Nomenklatur Sub Kegiatan</label>
        <textarea name="nama" class="form-control"></textarea>
    </div>
    <div class="form-group">
        <button type="submit" class="btn btn-success"><i class="fas fa-save"></i> Simpan</button>
    </div>
</form>

<script>
    $("select[name='kegiatan_id']").val($("select[name='kegiatan_id_filter']").val()).trigger('change');

    $("form[action='{{ route('sub-kegiatan.store') }}']").on("submit", function(event) {
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

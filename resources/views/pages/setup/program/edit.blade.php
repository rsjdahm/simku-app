<form method="post" action="{{ route('program.update', $program->id) }}">
    @csrf
    @method('put')
    <div class="form-group">
        <label class="form-label">Program</label>
        <select name="urusan_id" class="form-control">
            <option value="" disabled selected>Pilih Bidang...</option>
            @foreach ($urusan as $urusan_item)
                <option class="bg-light text-primary font-weight-bold" disabled>[{{ $urusan_item->kode_lengkap }}]
                    {{ $urusan_item->nama }}</option>
                @foreach ($bidang as $bidang_item)
                    @if ($bidang_item->urusan_id == $urusan_item->id)
                        <option @selected($urusan_item->id == $program->bidang_id) style="padding-left: 1.5rem;" value="{{ $bidang_item->id }}">
                            [{{ $bidang_item->kode_lengkap }}] {{ $bidang_item->nama }}
                        </option>
                    @endif
                @endforeach
            @endforeach
        </select>
    </div>
    <div class="form-group">
        <label class="form-label">Kode Program</label>
        <input type="number" name="kode" class="form-control" value="{{ $program->kode }}">
    </div>
    <div class="form-group">
        <label class="form-label">Nomenklatur Program</label>
        <textarea name="nama" class="form-control">{{ $program->nama }}</textarea>
    </div>
    <div class="form-group">
        <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Simpan</button>
    </div>
</form>

<script>
    $("form[action='{{ route('program.update', $program->id) }}']").on("submit", function(event) {
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

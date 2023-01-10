<form method="post" action="{{ route('belanja-rka-pd.update', $belanja_rka_pd->id) }}">
    @csrf
    @method('put')
    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                <label class="form-label">Rencana Anggaran</label>
                <select name="rka_pd_id" class="form-control">
                    <option value="" disabled selected>Pilih Rencana Anggaran...</option>
                    @foreach ($rka_pd as $rka_pd_item)
                        <option @selected($rka_pd_item->id == $belanja_rka_pd->rka_pd_id) value="{{ $rka_pd_item->id }}">
                            [{{ $rka_pd_item->status }}]
                            {{ $rka_pd_item->uraian }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label class="form-label">Sub Kegiatan</label>
                <select name="sub_kegiatan_id" class="form-control">
                    <option value="" disabled selected>Pilih Sub Kegiatan...</option>
                    @foreach ($sub_kegiatan as $sub_kegiatan_item)
                        <option @selected($sub_kegiatan_item->id == $belanja_rka_pd->sub_kegiatan_id) value="{{ $sub_kegiatan_item->id }}">
                            [{{ $sub_kegiatan_item->kode_lengkap }}]
                            {{ $sub_kegiatan_item->nama }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label class="form-label">Pilih Rekening Belanja</label>
                <select name="rek_sub_rincian_objek_id" class="form-control">
                    <option value="" disabled selected>Pilih Rekening Belanja...</option>
                    @foreach ($rek_akun->sortBy('kode_lengkap') as $rek_akun_item)
                        <option class="bg-light text-primary font-weight-bold" disabled>
                            [{{ $rek_akun_item->kode_lengkap }}]
                            {{ $rek_akun_item->nama }}</option>
                        @foreach ($rek_akun_item->rek_kelompok->sortBy('kode_lengkap') as $rek_kelompok_item)
                            <option class="bg-light text-dark font-weight-bold" style="padding-left: 1.5rem;" disabled>
                                [{{ $rek_kelompok_item->kode_lengkap }}]
                                {{ $rek_kelompok_item->nama }}</option>
                            @foreach ($rek_kelompok_item->rek_jenis->sortBy('kode_lengkap') as $rek_jenis_item)
                                <option class="bg-light text-dark font-weight-bold" style="padding-left: 2rem;"
                                    disabled>
                                    [{{ $rek_jenis_item->kode_lengkap }}]
                                    {{ $rek_jenis_item->nama }}
                                </option>
                                @foreach ($rek_jenis_item->rek_objek->sortBy('kode_lengkap') as $rek_objek_item)
                                    <option class="bg-light text-dark font-weight-bold" style="padding-left: 2.5rem;"
                                        disabled>
                                        [{{ $rek_objek_item->kode_lengkap }}]
                                        {{ $rek_objek_item->nama }}
                                    </option>
                                    @foreach ($rek_objek_item->rek_rincian_objek->sortBy('kode_lengkap') as $rek_rincian_objek_item)
                                        <option class="bg-light text-dark font-weight-bold" style="padding-left: 3rem;"
                                            value="{{ $rek_rincian_objek_item->id }}" disabled>
                                            [{{ $rek_rincian_objek_item->kode_lengkap }}]
                                            {{ $rek_rincian_objek_item->nama }}
                                        </option>
                                        @foreach ($rek_rincian_objek_item->rek_sub_rincian_objek->sortBy('kode_lengkap') as $rek_sub_rincian_objek_item)
                                            <option @selected($rek_sub_rincian_objek_item->id == $belanja_rka_pd->rek_sub_rincian_objek_id) style="padding-left: 3.5rem;"
                                                value="{{ $rek_sub_rincian_objek_item->id }}">
                                                [{{ $rek_sub_rincian_objek_item->kode_lengkap }}]
                                                {{ $rek_sub_rincian_objek_item->nama }}
                                            </option>
                                        @endforeach
                                    @endforeach
                                @endforeach
                            @endforeach
                        @endforeach
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label class="form-label">Uraian Belanja</label>
                <textarea name="uraian" class="form-control">{{ $belanja_rka_pd->uraian }}</textarea>
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label class="form-label">Harga Satuan</label>
                <input name="harga_satuan" class="form-control" value="{{ $belanja_rka_pd->harga_satuan }}">
            </div>
            <div class="form-group">
                <label class="form-label">Volume</label>
                <input name="volume" class="form-control" value="{{ $belanja_rka_pd->volume }}">
            </div>
            <div class="form-group">
                <label class="form-label">Satuan</label>
                <input name="satuan" class="form-control" value="{{ $belanja_rka_pd->satuan }}">
            </div>
        </div>
    </div>
    <div class="form-group">
        <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Simpan</button>
    </div>
</form>

<script>
    $("form[action='{{ route('belanja-rka-pd.update', $belanja_rka_pd->id) }}']").on("submit", function(event) {
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

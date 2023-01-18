<form method="post" action="{{ route('bukti-gu.store') }}">
    @csrf
    <div class="row">
        <div class="col-md-6">
            @if (Auth::user()->modul != 'admin-blud' && Auth::user()->modul != 'admin-blud2')
                <div class="form-group bg-light rounded border p-3">
                    <label class="form-label">Status Pending <span class="text-danger">*</span></label>
                    @foreach (App\Enums\Penatausahaan\StatusPending::cases() as $status_pending)
                        <div class="form-check">
                            <label class="form-check-label">
                                <input type="radio" class="form-check-input" name="status_pending"
                                    value="{{ $status_pending }}" @checked($status_pending == App\Enums\Penatausahaan\StatusPending::Normal)>
                                {{ $status_pending }}
                            </label>
                        </div>
                    @endforeach
                </div>
            @else
                <input type="hidden" name="status_pending"
                    value="{{ App\Enums\Penatausahaan\StatusPending::Pending->value }}">
            @endif
            <div class="form-group">
                <label class="form-label">Kode Rekening <span class="text-danger">*</span></label>
                <select name="belanja_rka_pd_id" class="form-control">
                    <option value="" disabled selected>Pilih Rekening Belanja...</option>
                    @foreach ($rek_akun->sortBy('kode_lengkap') as $rek_akun_item)
                        @foreach ($rek_akun_item->rek_kelompok->sortBy('kode_lengkap') as $rek_kelompok_item)
                            <option class="bg-warning font-weight-bold text-white" disabled>
                                {{ $rek_kelompok_item->kode_lengkap_nama }}</option>
                            @foreach ($rek_kelompok_item->rek_jenis->sortBy('kode_lengkap') as $rek_jenis_item)
                                <option class="bg-light text-primary font-weight-bold" style="padding-left: 1rem;"
                                    disabled>
                                    {{ $rek_jenis_item->kode_lengkap_nama }}
                                </option>
                                @foreach ($rek_jenis_item->rek_objek->sortBy('kode_lengkap') as $rek_objek_item)
                                    <option class="bg-light text-dark font-weight-bold" style="padding-left: 1.5rem;"
                                        disabled>
                                        {{ $rek_objek_item->kode_lengkap_nama }}
                                    </option>
                                    @foreach ($rek_objek_item->rek_rincian_objek->sortBy('kode_lengkap') as $rek_rincian_objek_item)
                                        <option class="bg-light text-dark font-weight-bold" style="padding-left: 2rem;"
                                            value="{{ $rek_rincian_objek_item->id }}" disabled>
                                            {{ $rek_rincian_objek_item->kode_lengkap_nama }}
                                        </option>
                                        @foreach ($rek_rincian_objek_item->rek_sub_rincian_objek->sortBy('kode_lengkap') as $rek_sub_rincian_objek_item)
                                            <option class="bg-light text-dark font-weight-bold"
                                                style="padding-left: 2.5rem;"
                                                value="{{ $rek_sub_rincian_objek_item->id }}" disabled>
                                                {{ $rek_sub_rincian_objek_item->kode_lengkap_nama }}
                                            </option>
                                            @foreach ($rek_sub_rincian_objek_item->belanja_rka_pd->sortBy('kode_lengkap') as $belanja_rka_pd_item)
                                                <option style="padding-left: 3rem;"
                                                    value="{{ $belanja_rka_pd_item->id }}">
                                                    {{ $belanja_rka_pd_item->uraian }}
                                                    [Rp.{{ number_format($belanja_rka_pd_item->nilai, 2, ',', '.') }}]
                                                </option>
                                            @endforeach
                                        @endforeach
                                    @endforeach
                                @endforeach
                            @endforeach
                        @endforeach
                    @endforeach
                </select>
            </div>
            @if (Auth::user()->modul != 'admin-blud' && Auth::user()->modul != 'admin-blud2')
                <div class="form-group">
                    <label class="form-label">Nomor Bukti <span class="text-warning">*</span></label>
                    <div class="input-group">
                        <input autofocus name="nomor" class="form-control">
                        <div class="input-group-append">
                            <span class="input-group-text">
                                <button onclick="return getNomorBuktiGuOtomatis()" type="button"
                                    class="btn btn-sm btn-success"><i class="fas fa-edit"></i>By Sistem</button>
                            </span>
                            <script>
                                function getNomorBuktiGuOtomatis() {
                                    NProgress.start();
                                    $.get("{{ route('bukti-gu.nomor-bukti-gu-otomatis') }}", function(data, status) {
                                        $("input[name='nomor']").val(data.padStart(4, "0"));
                                        NProgress.done();
                                    });
                                }
                            </script>
                        </div>
                    </div>
                </div>
            @endif
            <div class="form-group">
                <label class="form-label">Tanggal <span class="text-warning">*</span></label>
                <input type="date" name="tanggal" class="form-control">
            </div>
            <div class="form-group">
                <label class="form-label">Uraian <span class="text-danger">*</span></label>
                <textarea name="uraian" class="form-control"></textarea>
            </div>
            <div class="form-group">
                <label class="form-label">Nilai <span class="text-danger">*</span></label>
                <input type="number" name="nilai" step=".0001" class="form-control">
            </div>
            <div class="form-group">
                <label class="form-label">Metode Pembayaran <span class="text-danger">*</span></label>
                <select name="metode_pembayaran" class="form-control">
                    <option value="" disabled selected>Pilih Metode Pembayaran...</option>
                    @foreach (\App\Enums\Penatausahaan\MetodePembayaran::cases() as $metode_pembayaran)
                        <option value="{{ $metode_pembayaran }}">{{ $metode_pembayaran }}</option>
                    @endforeach
                </select>
            </div>
            @if (Auth::user()->modul != 'admin-blud' && Auth::user()->modul != 'admin-blud2')
                <div class="form-group">
                    <label class="form-label">Status <span class="text-danger">*</span></label>
                    <select name="status" class="form-control">
                        @foreach (App\Enums\Penatausahaan\StatusPosting::cases() as $status)
                            <option value="{{ $status }}">{{ $status }}</option>
                        @endforeach
                    </select>
                </div>
            @else
                <input type="hidden" name="status"
                    value="{{ App\Enums\Penatausahaan\StatusPosting::BelumPosting->value }}">
            @endif
        </div>
        <div class="col-md-6">
            <div class="card">
                <div class="card-body">
                    <div class="form-group">
                        <label class="form-label">Nama Penerima <span class="text-danger">*</span></label>
                        <div class="input-group">
                            <input name="nama" class="form-control">
                            <div class="input-group-append">
                                <span class="input-group-text">
                                    <a data-load="modal" title="Pilih dari Daftar Penerima" data-size="lg"
                                        href="{{ route('bukti-gu.penerima-index') }}" class="btn btn-sm btn-primary"><i
                                            class="fas fa-search"></i>
                                        Cari</a>
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Jenis Penerima <span class="text-danger">*</span></label>
                        <select name="jenis" class="form-control">
                            <option value="" disabled selected>Pilih Jenis Penerima...</option>
                            @foreach (\App\Enums\Penatausahaan\JenisBuktiGu::cases() as $jenis)
                                <option value="{{ $jenis }}">{{ $jenis }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Alamat <span class="text-danger">*</span></label>
                        <textarea name="alamat" class="form-control"></textarea>
                    </div>
                    <div class="form-group">
                        <label class="form-label">NPWP</label>
                        <input type="number" name="npwp" class="form-control">
                    </div>
                    <div class="form-group">
                        <label class="form-label">Bank Penerima</label>
                        <select name="bank_id" class="form-control">
                            <option value="">Pilih Bank Penerima...</option>
                            @foreach ($bank as $bank_item)
                                <option value="{{ $bank_item->id }}">
                                    [{{ $bank_item->kode }}] {{ $bank_item->nama }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label class="form-label">No. Rekening Penerima</label>
                        <input type="number" name="nomor_rekening" class="form-control">
                    </div>
                    @if (Auth::user()->modul != 'admin-blud' && Auth::user()->modul != 'admin-blud2')
                        <div class="form-group">
                            <label class="form-label">Tanggal Bayar <span class="text-warning">*</span></label>
                            <input type="date" name="tanggal_bayar" class="form-control">
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
    <div class="form-group">
        <button type="submit" class="btn btn-success"><i class="fas fa-save"></i> Simpan</button>
    </div>
</form>

<script>
    $("form[action='{{ route('bukti-gu.store') }}']").on("submit", function(event) {
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

<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <h4>Laporan Realisasi</h4>
                <ol class="breadcrumb m-0">
                    <li class="breadcrumb-item">Penatausahaan</li>
                    <li class="breadcrumb-item">Laporan</li>
                    <li class="breadcrumb-item active">Laporan Realisasi</li>
                </ol>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <div class="card mb-3">
                <div class="card-body">
                    <form method="POST" action="{{ route('laporan-realisasi.show') }}">
                        <div class="form-group mb-2">
                            <label class="form-label">Jenis Laporan <span class="text-warning">*</span></label>
                            <select name="jenis" class="form-control">
                                <option value="Periodik">Periodik</option>
                                {{-- <option value="Bulanan">Bulanan</option>
                                <option value="Triwulanan">Triwulanan</option> --}}
                            </select>
                        </div>
                        <div class="form-group mb-2">
                            <label class="form-label">Tanggal Mulai <span class="text-warning">*</span></label>
                            <input type="date" name="tgl_start" class="form-control">
                        </div>
                        <div class="form-group mb-2">
                            <label class="form-label">Tanggal Selesai <span class="text-warning">*</span></label>
                            <input type="date" name="tgl_end" class="form-control">
                        </div>
                        <div class="form-group">
                            <button type="submit" class="btn btn-success"><i class="fas fa-desktop"></i>
                                Tampilkan</button>
                            <a href="{{ route('laporan.pdf-realisasi') }}" class="btn btn-secondary"><i
                                    class="fas fa-save"></i> Cetak PDF</a>
                        </div>
                    </form>
                </div>
            </div>
            <div class="card mb-3">
                <div class="card-body">
                    <div id="laporan-realisasi-show"></div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    $("form[action='{{ route('laporan-realisasi.show') }}']").on("submit", function(event) {
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
                $("#laporan-realisasi-show").html(response);
                NProgress.done();
            }
        });
        return false;
    });
</script>

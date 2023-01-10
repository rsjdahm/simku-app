<html>

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <style>
        @page {
            margin: 1.25cm 1.55cm;
            font-family: 'Arial';
            font-size: 8pt;
            font-weight: normal;
        }

        .table {
            width: 100%;
            border-collapse: collapse;
            border: 0;
        }

        .table td,
        .table th {
            border: 1px solid #000;
            padding: 3px 5px;
        }
    </style>
</head>

<body>
    <table class="table">
        <tr>
            <td rowspan="2" style="width: 1.8cm; vertical-align: middle;">
                <img src="{{ asset('img/logo-kaltim.png') }}" style="width: 1.5cm; margin: 10px;">
            </td>
            <td style="text-align: center; vertical-align: middle;">
                <h3 style="margin: 0;">PEMERINTAH PROVINSI KALIMANTAN TIMUR</h3>
                <h2 style="margin: 0;">SURAT BUKTI PENGELUARAN/BELANJA (BLUD)</h2>
            </td>
            <td rowspan="2" style="width: 1.8cm; text-align: center; vertical-align: middle;">
                <h3>FORMULIR KAS KELUAR</h3>
            </td>
        </tr>
        <tr>
            <td class="padding: 0">
                <table style="border: 0; border-collapse: collapse; width: 100%;">
                    <tr>
                        <td style="border: 0; padding: 0; width: 1.15cm;">Nomor</td>
                        <td style="border: 0; padding: 0; width: 0.25cm;">:</td>
                        <td style="border: 0; padding: 0;">{!! $belanja_ls->nomor ?? '..................................' !!}</td>
                    </tr>
                    <tr>
                        <td style="border: 0; padding: 0;">Tanggal</td>
                        <td style="border: 0; padding: 0;">:</td>
                        <td style="border: 0; padding: 0;">
                            {!! $belanja_ls->tanggal
                                ? Carbon\Carbon::parse($belanja_ls->tanggal)->translatedFormat('d F Y')
                                : '..................................' !!}
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
        <tr>
            <td colspan="3">
                <table style="border: 0; border-collapse: collapse; width: 100%;">
                    <tr>
                        <th style="border: 0; padding: 0; width: 3cm; text-align: left;">Sub Unit Organisasi</th>
                        <td style="border: 0; padding: 0; width: 0.25cm;">:</td>
                        <td style="border: 0; padding: 0;">
                            {{ $belanja_ls->belanja_rka_pd->rka_pd->sub_unit_kerja->kode_lengkap }}
                            {{ $belanja_ls->belanja_rka_pd->rka_pd->sub_unit_kerja->nama }}
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
        <tr>
            <td colspan="3">
                Sudah diterima dari Bendahara Pengeluaran, uang sejumlah Rp
                {{ number_format($belanja_ls->nilai, 2, ',', '.') }} secara {{ $belanja_ls->metode_pembayaran }}
                @if ($belanja_ls->metode_pembayaran == App\Enums\Penatausahaan\MetodePembayaran::Transfer)
                    (Nomor Rekening: {{ $belanja_ls->bank->nama }} {{ $belanja_ls->nomor_rekening }})
                @endif
                <br />
                <i>Terbilang: {{ Str::title(Terbilang::make($belanja_ls->nilai)) }} @if (fmod($belanja_ls->nilai, 1) != 0)
                        Koma {{ Str::title(Terbilang::make(fmod($belanja_ls->nilai, 1) * 100)) }}
                    @endif Rupiah</i>
            </td>
        </tr>
        <tr>
            <td colspan="3">
                <strong>Yaitu untuk pembayaran:</strong>
                <br />
                <table style="border: 0; border-collapse: collapse; width: 100%;">
                    <tr>
                        <td style="border: 0; padding: 0; vertical-align: top; width: 3cm;">Program</td>
                        <td style="border: 0; padding: 0; vertical-align: top; width: 0.25cm;">:</td>
                        <td style="border: 0; padding: 0; vertical-align: top;">
                            {{ $belanja_ls->belanja_rka_pd->sub_kegiatan->kegiatan->program->kode_lengkap }}
                            {{ $belanja_ls->belanja_rka_pd->sub_kegiatan->kegiatan->program->nama }}
                        </td>
                    </tr>
                    <tr>
                        <td style="border: 0; padding: 0; vertical-align: top;">Kegiatan</td>
                        <td style="border: 0; padding: 0; vertical-align: top;">:</td>
                        <td style="border: 0; padding: 0; vertical-align: top;">
                            {{ $belanja_ls->belanja_rka_pd->sub_kegiatan->kegiatan->kode_lengkap }}
                            {{ $belanja_ls->belanja_rka_pd->sub_kegiatan->kegiatan->nama }}
                        </td>
                    </tr>
                    <tr>
                        <td style="border: 0; padding: 0; vertical-align: top;">Sub Kegiatan</td>
                        <td style="border: 0; padding: 0; vertical-align: top;">:</td>
                        <td style="border: 0; padding: 0; vertical-align: top;">
                            {{ $belanja_ls->belanja_rka_pd->sub_kegiatan->kode_lengkap }}
                            {{ $belanja_ls->belanja_rka_pd->sub_kegiatan->nama }}
                        </td>
                    </tr>
                    <tr>
                        <td style="border: 0; padding: 0; vertical-align: top;">Kode Rekening</td>
                        <td style="border: 0; padding: 0; vertical-align: top;">:</td>
                        <td style="border: 0; padding: 0; vertical-align: top;">
                            {{ $belanja_ls->belanja_rka_pd->rek_sub_rincian_objek->kode_lengkap }}
                            {{ $belanja_ls->belanja_rka_pd->rek_sub_rincian_objek->nama }}
                        </td>
                    </tr>
                    <tr>
                        <td style="border: 0; padding: 0; vertical-align: top;">Untuk Keperluan</td>
                        <td style="border: 0; padding: 0; vertical-align: top;">:</td>
                        <td style="border: 0; padding: 0; vertical-align: top;">
                            {{ $belanja_ls->uraian }}
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
        <tr>
            <td colspan="3" style="padding: 0;">
                <table style="border: 0; border-collapse: collapse; width: 100%;">
                    <tr>
                        <td
                            style="border: 0; padding: 3px 5px; width: 50%; border-right: 1px solid black; vertical-align: top;">
                            <strong>Diterima oleh:</strong>
                            <br />
                            <table style="border: 0; border-collapse: collapse; width: 100%;">
                                <tr>
                                    <td style="border: 0; padding: 0; width: 3cm;">Nama</td>
                                    <td style="border: 0; padding: 0; width: 0.25cm;">:</td>
                                    <td style="border: 0; padding: 0;">
                                        {{ $belanja_ls->nama }}
                                    </td>
                                </tr>
                                <tr>
                                    <td style="border: 0; padding: 0;">NPWP</td>
                                    <td style="border: 0; padding: 0;">:</td>
                                    <td style="border: 0; padding: 0;">
                                        {{ $belanja_ls->npwp }}
                                    </td>
                                </tr>
                                <tr>
                                    <td style="border: 0; padding: 0;">Alamat</td>
                                    <td style="border: 0; padding: 0;">:</td>
                                    <td style="border: 0; padding: 0;">
                                        {{ $belanja_ls->alamat }}
                                    </td>
                                </tr>
                            </table>
                        </td>
                        <td style="border: 0; padding: 3px 5px; width: 50%; vertical-align: top;">
                            <table style="border: 0; border-collapse: collapse; width: 100%;">
                                <tr>
                                    <td style="border: 0; padding: 0; font-weight: bold;">Jumlah yang Diminta</td>
                                    <td style="border: 0; padding: 0; text-align: right; width: 3cm;">
                                        {{ number_format($belanja_ls->nilai, 2, ',', '.') }}
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="2" style="border: 0; padding: 0;">
                                        <h3 style="margin: 3px 0;">Informasi Potongan:</h3>
                                    </td>
                                </tr>
                                @php
                                    $total_nilai_potongan = 0;
                                @endphp
                                {{-- @foreach ($belanja_ls->potongan_belanja_ls->where('status', App\Enums\Penatausahaan\StatusPotonganBuktiGu::Setor) as $potongan_belanja_ls) --}}
                                @foreach ($belanja_ls->potongan_belanja_ls as $potongan_belanja_ls)
                                    <tr style="vertical-align: top;">
                                        <td style="border: 0; padding: 0;">Penerimaan PFK -
                                            {{ $potongan_belanja_ls->potongan_pfk->nama }}
                                            ({{ $potongan_belanja_ls->nomor_billing }})
                                        </td>
                                        <td style="border: 0; padding: 0; text-align: right;">
                                            {{ number_format($potongan_belanja_ls->nilai, 2, ',', '.') }}
                                        </td>
                                    </tr>
                                    @php
                                        $total_nilai_potongan = $total_nilai_potongan + $potongan_belanja_ls->nilai;
                                    @endphp
                                @endforeach
                                <tr>
                                    <td
                                        style="border: 0; padding: 0; text-align: right; font-weight: bold; padding-right: 3px;">
                                        Jumlah
                                        Potongan</td>
                                    <td
                                        style="border: 0; padding: 0; text-align: right; font-weight: bold; border-top: 1px solid black;">
                                        {{ number_format($total_nilai_potongan, 2, ',', '.') }}
                                    </td>
                                </tr>
                                <tr>
                                    <td style="border: 0; padding: 0; font-weight: bold; padding-top: 15px;">Jumlah yang
                                        Dibayarkan</td>
                                    <td
                                        style="border: 0; padding: 0; text-align: right; font-weight: bold; width: 3cm; padding-top: 15px;">
                                        {{ number_format($belanja_ls->nilai - $total_nilai_potongan, 2, ',', '.') }}
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="2" style="border: 0; padding: 0; font-style: italic;">
                                        Terbilang:<br />
                                        {{ Str::title(Terbilang::make($belanja_ls->nilai - $total_nilai_potongan)) }}
                                        @if (fmod($belanja_ls->nilai - $total_nilai_potongan, 1) != 0)
                                            Koma
                                            {{ Str::title(Terbilang::make(fmod($belanja_ls->nilai - $total_nilai_potongan, 1) * 100)) }}
                                        @endif Rupiah
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
        <tr>
            <td colspan="3" style="padding: 0;">
                <table style="border: 0; border-collapse: collapse; width: 100%;">
                    <tr>
                        <td
                            style="border: 0; padding: 3px 5px; width: 33%; border-right: 1px solid black; vertical-align: top; text-align: center;">
                            <br />
                            Yang menerima barang,
                            <br />
                            Memeriksa pekerjaan tersebut di atas
                            <br />
                            <br />
                            <br />
                            <br />
                            <br />
                            <hr style="border: 0.5px solid black; width: 80%;" />
                        </td>
                        <td
                            style="border: 0; padding: 3px 5px; width: 33%; border-right: 1px solid black; vertical-align: top; text-align: center;">
                            <br />
                            BENDAHARA PENGELUARAN
                            <br />
                            <br />
                            <br />
                            <br />
                            <br />
                            <strong><u>Hari Jumadi, A.Md.</u></strong>
                            <br />
                            NIP. 19800404 201101 1 001
                        </td>
                        <td style="border: 0; padding: 3px 5px; width: 33%; vertical-align: top; text-align: center;">
                            Samarinda, {!! $belanja_ls->tanggal
                                ? Carbon\Carbon::parse($belanja_ls->tanggal)->translatedFormat('d F Y')
                                : '..................................' !!}
                            <br />
                            Kuasa Pengguna Anggaran BLUD
                            <br />
                            <br />
                            <br />
                            <br />
                            <br />
                            <strong><u>Hadi Machbudiansyah, S.E., M.M.</u></strong>
                            <br />
                            NIP. 19750911 199402 1 001
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>

    @include('vendor.dompdf.footer-a4-potrait')

</body>

</html>

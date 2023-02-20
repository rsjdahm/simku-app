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

        body {
            border: 1px solid #000;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            border: 0;
        }

        td,
        th {
            vertical-align: top;
            padding-left: 4px;
            padding-right: 4px;
        }

        th {
            vertical-align: middle;
        }
    </style>
</head>

<body>
    <table>
        <tr style="border-bottom: 1px solid black;">
            <td colspan="2">
                <table>
                    <tr>
                        <td style="width: 1.8cm; vertical-align: middle;">
                            <img src="{{ asset('img/logo-kaltim.png') }}" style="width: 1.5cm; margin: 10px;">
                        </td>
                        <td style="text-align: center; vertical-align: middle;">
                            <h3 style="margin: 0;">PEMERINTAH PROVINSI KALIMANTAN TIMUR</h3>
                            <h2 style="margin: 0; font-size: 11pt;">SURAT PERINTAH PENCAIRAN DANA (BLUD)</h2>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
        <tr style="border-bottom: 1px solid black;">
            <td width="50%" style="border-right: 1px solid black;">
                <table>
                    <tr>
                        <td style="width: 30%; vertical-align: top;">
                            No. SPM
                        </td>
                        <td style="width: 0.15cm;">
                            :
                        </td>
                        <td style="vertical-align: top;">
                            {{ $sp2d->spm->nomor }}/SPM-LS/RSJDAHM/BLUD/{{ Terbilang::roman(Carbon\Carbon::parse($sp2d->spm->tanggal)->month) }}/{{ Carbon\Carbon::parse($sp2d->spm->tanggal)->year }}
                        </td>
                    </tr>
                    <tr>
                        <td style="vertical-align: top;">
                            Tanggal
                        </td>
                        <td>
                            :
                        </td>
                        <td style="vertical-align: top;">
                            {{ Carbon\Carbon::parse($sp2d->spm->tanggal)->isoFormat('DD MMMM YYYY') }}
                        </td>
                    </tr>
                    <tr>
                        <td style="vertical-align: top;">
                            SKPD/Unit SKPD
                        </td>
                        <td>
                            :
                        </td>
                        <td style="vertical-align: top;">
                            {{ $sp2d->spm->spp->belanja_ls->belanja_rka_pd->rka_pd->sub_unit_kerja->nama }}
                        </td>
                    </tr>
                </table>
            </td>
            <td width="50%">
                <table>
                    <tr>
                        <td style="width: 30%; vertical-align: top;">
                            Dari
                        </td>
                        <td style="width: 0.15cm;">
                            :
                        </td>
                        <td style="vertical-align: top;">
                            Pengguna Anggaran BLUD
                        </td>
                    </tr>
                    <tr>
                        <td style="vertical-align: top;">
                            Nomor
                        </td>
                        <td>
                            :
                        </td>
                        <td style="vertical-align: top;">
                            {{ $sp2d->nomor }}/SP2D-LS/RSJDAHM/BLUD/{{ Terbilang::roman(Carbon\Carbon::parse($sp2d->tanggal)->month) }}/{{ Carbon\Carbon::parse($sp2d->tanggal)->year }}
                        </td>
                    </tr>
                    <tr>
                        <td style="vertical-align: top;">
                            Tanggal
                        </td>
                        <td>
                            :
                        </td>
                        <td style="vertical-align: top;">
                            {{ Carbon\Carbon::parse($sp2d->tanggal)->isoFormat('DD MMMM YYYY') }}
                        </td>
                    </tr>
                    <tr>
                        <td style="vertical-align: top;">
                            Tahun Anggaran
                        </td>
                        <td>
                            :
                        </td>
                        <td style="vertical-align: top;">
                            {{ Carbon\Carbon::parse($sp2d->tanggal)->year }}
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
        <tr style="border-bottom: 1px solid black;">
            <td colspan="2">
                <strong>BANKALTIMTARA</strong>
                <br />
                Hendaklah mencairkan/memindahbukukan dari baki Rekening Nomor 0011536760 uang sebesar Rp.
                {{ number_format($sp2d->spm->spp->belanja_ls->nilai, 2, ',', '.') }}
                (<i>{{ Str::title(Terbilang::make($sp2d->spm->spp->belanja_ls->nilai)) }} Rupiah</i>)
            </td>
        </tr>
        <tr style="border-bottom: 1px solid black;">
            <td colspan="2">
                <table>
                    <tr>
                        <td style="width: 30%; vertical-align: top;">
                            Kepada
                        </td>
                        <td style="width: 0.15cm;">
                            :
                        </td>
                        <td style="vertical-align: top;">
                            Hari Jumadi, A.Md. / Bendahara Pengeluaran BLUD
                        </td>
                    </tr>
                    <tr>
                        <td style="vertical-align: top;">
                            NPWP
                        </td>
                        <td>
                            :
                        </td>
                        <td style="vertical-align: top;">
                            953350162722000
                        </td>
                    </tr>
                    <tr>
                        <td style="vertical-align: top;">
                            No. Rekening Bank
                        </td>
                        <td>
                            :
                        </td>
                        <td style="vertical-align: top;">
                            0011536760
                        </td>
                    </tr>
                    <tr>
                        <td style="vertical-align: top;">
                            Bank Penerima
                        </td>
                        <td>
                            :
                        </td>
                        <td style="vertical-align: top;">
                            124 BANKALTIMTARA
                        </td>
                    </tr>
                    <tr>
                        <td style="vertical-align: top;  padding-bottom: 20px;">
                            Keperluan Untuk:
                        </td>
                        <td style=" padding-bottom: 20px;">
                            :
                        </td>
                        <td style="vertical-align: top;  padding-bottom: 20px;">
                            {{ $sp2d->spm->spp->uraian }}
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
        <tr style="border-bottom: 1px solid black;">
            <td colspan="2" style="padding: 0;">
                <table>
                    <thead>
                        <tr style="border-bottom: 1px solid black;">
                            <th width="25%" style="padding-top: 0; border-right: 1px solid black;">KODE
                                REKENING</th>
                            <th style="padding-top: 0; border-right: 1px solid black;">URAIAN</th>
                            <th width="25%" style="padding-top: 0;">NILAI</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr style="border-bottom: 1px solid black;">
                            <td style="padding: 0 auto; border-right: 1px solid black;">
                                {{ $sp2d->spm->spp->belanja_ls->belanja_rka_pd->rek_sub_rincian_objek->kode_lengkap }}
                            </td>
                            <td style="padding: 0 auto; border-right: 1px solid black;">
                                {{ $sp2d->spm->spp->belanja_ls->belanja_rka_pd->rek_sub_rincian_objek->nama }}</td>
                            <td style="padding: 0 auto; text-align: right;">
                                {{ number_format($sp2d->spm->spp->belanja_ls->nilai, 2, ',', '.') }}</td>
                        </tr>
                        <tr style="border-bottom: 1px solid black;">
                            <td colspan="2"
                                style="padding: 0 auto; border-right: 1px solid black; font-weight: bold; text-align: right;">
                                JUMLAH</td>
                            <td style="padding: 0 auto; font-weight: bold; text-align: right;">
                                {{ number_format($sp2d->spm->spp->belanja_ls->nilai, 2, ',', '.') }}</td>
                        </tr>
                    </tbody>
                </table>
                <table>
                    <tr style="border-bottom: 1px solid black;">
                        <td colspan="3">
                            <strong>Potongan-Potongan:</strong>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="3" style="padding: 0;">
                            <table>
                                <thead>
                                    <tr style="border-bottom: 1px solid black;">
                                        <th width="25%" style="padding-top: 0; border-right: 1px solid black;">KODE
                                            REKENING</th>
                                        <th style="padding-top: 0; border-right: 1px solid black;">URAIAN</th>
                                        <th width="25%" style="padding-top: 0;">JUMLAH (Rp.)</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr style="border-bottom: 1px solid black;">
                                        <td style="padding: 0 auto; border-right: 1px solid black;"></td>
                                        <td style="padding: 0 auto; border-right: 1px solid black;"></td>
                                        <td style="padding: 0 auto; text-align: right;"></td>
                                    </tr>
                                    <tr style="border-bottom: 1px solid black;">
                                        <td colspan="2"
                                            style="padding: 0 auto; border-right: 1px solid black; text-align: right;">
                                            JUMLAH</td>
                                        <td style="padding: 0 auto; text-align: right;">
                                            {{ number_format(0, 2, ',', '.') }}</td>
                                    </tr>
                                    <tr style="border-bottom: 1px solid black;">
                                        <td colspan="3" style="padding: 0 auto;">Informasi:
                                            <i>(tidak
                                                mengurangi
                                                jumlah pembayaran SP2D)</i>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                            <table>
                                <thead>
                                    <tr style="border-bottom: 1px solid black;">
                                        <th width="25%" style="padding-top: 0; border-right: 1px solid black;">KODE
                                            REKENING</th>
                                        <th style="padding-top: 0; border-right: 1px solid black;">URAIAN</th>
                                        <th width="25%" style="padding-top: 0;">JUMLAH (Rp.)</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr style="border-bottom: 1px solid black;">
                                        <td style="padding: 0 auto; border-right: 1px solid black;"></td>
                                        <td style="padding: 0 auto; border-right: 1px solid black;"></td>
                                        <td style="padding: 0 auto; text-align: right;"></td>
                                    </tr>
                                    <tr style="border-bottom: 1px solid black;">
                                        <td colspan="2"
                                            style="padding: 0 auto; border-right: 1px solid black; text-align: right;">
                                            JUMLAH</td>
                                        <td style="padding: 0 auto; text-align: right;">
                                            {{ number_format(0, 2, ',', '.') }}</td>
                                    </tr>
                                </tbody>
                            </table>
                            <table style="width: 60%">
                                <thead>
                                    <tr>
                                        <th colspan="2" style="text-align: left; padding-top: 0;">
                                            <br />
                                            SP2D yang Dibayarkan
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td style="padding: 0 auto;">
                                            Jumlah yang Diminta
                                        </td>
                                        <td style="width: 0.15cm;">
                                            Rp
                                        </td>
                                        <td width="25%" style="padding: 0 auto; text-align: right;">
                                            {{ number_format($sp2d->spm->spp->belanja_ls->nilai, 2, ',', '.') }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style="padding: 0 auto;">
                                            Jumlah Potongan
                                        </td>
                                        <td style="width: 0.15cm;">
                                            Rp
                                        </td>
                                        <td style="padding: 0 auto; text-align: right;">
                                            {{ number_format(0, 2, ',', '.') }}
                                        </td>
                                    </tr>
                                    <tr style="font-weight: bold;">
                                        <td style="padding: 0 auto;">
                                            Jumlah yang Dibayarkan
                                        </td>
                                        <td style="width: 0.15cm;">
                                            Rp
                                        </td>
                                        <td style="padding: 0 auto; text-align: right;">
                                            {{ number_format($sp2d->spm->spp->belanja_ls->nilai, 2, ',', '.') }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style="width: 25%; vertical-align: top; font-weight: bold;">
                                            Uang Sejumlah
                                            <br />
                                        </td>
                                        <td colspan="2" style="vertical-align: top;">
                                            <i>{{ Str::title(Terbilang::make($sp2d->spm->spp->belanja_ls->nilai)) }}
                                                Rupiah</i>
                                        </td>
                                    </tr>
                                    <br />
                                </tbody>
                            </table>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
        <tr>
            <td style="padding-top: 20px;">
                <strong>Lembar Asli</strong> : Untuk Pengguna Anggaran BLUD
                <br />
                <strong>Salinan 1</strong> : Untuk Kuasa Pengguna Anggaran BLUD
                <br />
                <strong>Salinan 2</strong> : Untuk Arsip
                <br />
                <strong>Salinan 3</strong> : Untuk Pihak Ketiga
            </td>
            <td style="padding-top: 30px; text-align: center;">
                Samarinda, {{ Carbon\Carbon::parse($sp2d->tanggal)->translatedFormat('d F Y') }}
                <br />
                Pengguna Anggaran BLUD
                <br />
                <br />
                <br />
                <br />
                <br />
                <strong><u>dr. Indah Puspitasari, MARS.</u></strong>
                <br />
                NIP. 19670530 199803 2 003
            </td>
        </tr>
    </table>

    @include('vendor.dompdf.footer-a4-potrait')

</body>

</html>

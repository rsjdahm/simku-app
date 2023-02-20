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
            padding-left: 5px;
            padding-right: 5px;
            padding-top: 4px;
            padding-bottom: 4px;
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
                        <td style="width: 1.8cm; vertical-align: middle; padding: 0 auto;">
                            <img src="{{ asset('img/logo-kaltim.png') }}" style="width: 1.5cm; margin: 10px;">
                        </td>
                        <td style="text-align: center; vertical-align: middle; padding: 0 auto;">
                            <h3 style="margin: 0;">PEMERINTAH PROVINSI KALIMANTAN TIMUR</h3>
                            <h2 style="margin: 0; font-size: 11pt;">SURAT PERINTAH MEMBAYAR</h2>
                            <h2 style="margin: 0; font-size: 10pt;">LANGSUNG (LS) BLUD</h2>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
        <tr style="border-bottom: 1px solid black;">
            <td style="border-right: 1px solid black; width: 50%;">
                <strong>Tahun Anggaran :</strong> {{ Carbon\Carbon::parse($spm->tanggal)->year }}
            <td style="text-align: right; width: 50%;">
                <strong>Nomor :</strong>
                {{ $spm->nomor }}/SPM-LS/RSJDAHM/BLUD/{{ Terbilang::roman(Carbon\Carbon::parse($spm->tanggal)->month) }}/{{ Carbon\Carbon::parse($spm->tanggal)->year }}
            </td>
        </tr>
        <tr style="border-bottom: 1px solid black;">
            <td style="border-right: 1px solid black; padding: 0;">
                <div style="padding: 5px;">
                    <strong>PENGGUNA ANGGARAN
                        {{ Str::upper($spm->spp->belanja_ls->belanja_rka_pd->rka_pd->sub_unit_kerja->nama) }}</strong>
                    <br />
                    Supaya menerbitkan SP2D kepada:
                </div>
                <table>
                    <tr>
                        <td style="width: 30%; vertical-align: top;">
                            SKPD/Unit Kerja
                        </td>
                        <td style="width: 0.15cm;">
                            :
                        </td>
                        <td style="vertical-align: top;">
                            {{ $spm->spp->belanja_ls->belanja_rka_pd->rka_pd->sub_unit_kerja->nama }}
                        </td>
                    </tr>
                    <tr>
                        <td style="vertical-align: top;">
                            Bendahara/Pihak Ketiga
                        </td>
                        <td>
                            :
                        </td>
                        <td style="vertical-align: top;">
                            Hari Jumadi, A.Md. / Bendahara Pengeluaran BLUD
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
                            Nama Bank
                        </td>
                        <td>
                            :
                        </td>
                        <td style="vertical-align: top;">
                            124 BANKALTIMTARA
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
                    <tr style="border-bottom: 1px solid black;">
                        <td style="vertical-align: top;">
                            Dasar Pembayaran
                        </td>
                        <td>
                            :
                        </td>
                        <td style="vertical-align: top;">

                        </td>
                    </tr>
                    <tr style="border-bottom: 1px solid black;">
                        <td style="vertical-align: top;">
                            Untuk Keperluan:
                        </td>
                        <td>
                            :
                        </td>
                        <td style="vertical-align: top;">
                            {{ $spm->spp->uraian }}
                        </td>
                    </tr>
                    <tr style="border-bottom: 1px solid black;">
                        <td colspan="3">
                            <strong>Pembebanan pada Kode Rekening</strong>
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
                                        <th width="25%" style="padding-top: 0;">NILAI</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr style="border-bottom: 1px solid black;">
                                        <td style="padding: 0 auto; border-right: 1px solid black;">
                                            {{ $spm->spp->belanja_ls->belanja_rka_pd->rek_sub_rincian_objek->kode_lengkap }}
                                        </td>
                                        <td style="padding: 0 auto; border-right: 1px solid black;">
                                            {{ $spm->spp->belanja_ls->belanja_rka_pd->rek_sub_rincian_objek->nama }}
                                        </td>
                                        <td style="padding: 0 auto; text-align: right;">
                                            {{ number_format($spm->spp->belanja_ls->nilai, 2, ',', '.') }}</td>
                                    </tr>
                                    <tr>
                                        <td colspan="2"
                                            style="padding: 0 auto; border-right: 1px solid black; font-weight: bold; text-align: center;">
                                            Jumlah</td>
                                        <td style="padding: 0 auto; font-weight: bold; text-align: right;">
                                            {{ number_format($spm->spp->belanja_ls->nilai, 2, ',', '.') }}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </td>
                    </tr>
                </table>
            <td style="padding: 0;">
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
                                            style="padding: 0 auto; border-right: 1px solid black; text-align: center;">
                                            Jumlah</td>
                                        <td style="padding: 0 auto; text-align: right;">
                                            {{ number_format(0, 2, ',', '.') }}</td>
                                    </tr>
                                    <tr style="border-bottom: 1px solid black;">
                                        <td colspan="3" style="padding: 0 auto;">Informasi: <i>(tidak
                                                mengurangi
                                                jumlah pembayaran SPM)</i></td>
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
                                            style="padding: 0 auto; border-right: 1px solid black; text-align: center;">
                                            Jumlah</td>
                                        <td style="padding: 0 auto; text-align: right;">
                                            {{ number_format(0, 2, ',', '.') }}</td>
                                    </tr>
                                </tbody>
                            </table>
                            <table>
                                <thead>
                                    <tr style="border-bottom: 1px solid black;">
                                        <th colspan="3" style="text-align: left; padding-top: 0;">
                                            SPM yang Dibayarkan
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr style="border-bottom: 1px solid black;">
                                        <td width="25%" style="padding: 0 auto; border-right: 1px solid black;">
                                            Jumlah yang Diminta
                                        </td>
                                        <td style="padding: 0 auto; text-align: right; border-right: 1px solid black;">
                                            {{ number_format($spm->spp->belanja_ls->nilai, 2, ',', '.') }}
                                        </td>
                                        <td width="25%" style="padding: 0 auto; text-align: right;"></td>
                                    </tr>
                                    <tr style="border-bottom: 1px solid black;">
                                        <td style="padding: 0 auto; border-right: 1px solid black;">
                                            Jumlah Potongan
                                        </td>
                                        <td style="padding: 0 auto; text-align: right; border-right: 1px solid black;">
                                            {{ number_format(0, 2, ',', '.') }}
                                        </td>
                                        <td style="padding: 0 auto; text-align: right;"></td>
                                    </tr>
                                    <tr style="border-bottom: 1px solid black;">
                                        <td colspan="2" style="padding: 0 auto; border-right: 1px solid black;">
                                            Jumlah yang Dibayarkan
                                        </td>
                                        <td style="padding: 0 auto; text-align: right;">
                                            {{ number_format($spm->spp->belanja_ls->nilai, 2, ',', '.') }}</td>
                                    </tr>
                                </tbody>
                            </table>
                            <table>
                                <tr>
                                    <td style="width: 25%; vertical-align: top; font-weight: bold;">
                                        Uang Sejumlah
                                    </td>
                                    <td style="width: 0.15cm; font-weight: bold;">
                                        :
                                    </td>
                                    <td style="vertical-align: top;">
                                        <i>{{ Str::title(Terbilang::make($spm->spp->belanja_ls->nilai)) }} Rupiah</i>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
        <tr style="border-bottom: 1px solid black;">
            <td style="border-right: 1px solid black;">
                <table>
                    <tr>
                        <td style="width: 30%; vertical-align: top; font-weight: bold; padding-left: 0;">
                            Jumlah SPP yang diminta
                        </td>
                        <td style="width: 0.15cm; font-weight: bold;">
                            :
                        </td>
                        <td style="vertical-align: top;">
                            <strong>Rp {{ number_format($spm->spp->belanja_ls->nilai, 2, ',', '.') }}</strong>
                            <br />
                            <i>{{ Str::title(Terbilang::make($spm->spp->belanja_ls->nilai)) }} Rupiah</i>
                        </td>
                    </tr>
                    <tr>
                        <td style="vertical-align: top; font-weight: bold; padding-left: 0;">
                            Nomor dan Tanggal SPP
                        </td>
                        <td style="font-weight: bold;">
                            :
                        </td>
                        <td style="vertical-align: top;">
                            {{ $spm->spp->nomor }}/SPP-LS/RSJDAHM/BLUD/{{ Terbilang::roman(Carbon\Carbon::parse($spm->spp->tanggal)->month) }}/{{ Carbon\Carbon::parse($spm->spp->tanggal)->year }}
                            <br />
                            {{ Carbon\Carbon::parse($spm->spp->tanggal)->isoFormat('DD MMMM YYYY') }}
                        </td>
                    </tr>
                </table>
            </td>
            <td style="text-align: center">
                Samarinda, {{ Carbon\Carbon::parse($spm->spp->tanggal)->isoFormat('DD MMMM YYYY') }}
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
        <tr style="border-bottom: 1px solid black;">
            <td colspan="2" style="text-align: center">
                <i>SPM ini sah apabila telah ditandatangani dan distempel oleh Kepala SKPD</i>
            </td>
        </tr>
    </table>

    @include('vendor.dompdf.footer-a4-potrait')

</body>

</html>

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

        table {
            width: 100%;
            border-collapse: collapse;
            border: 0;
        }

        .table-bordered td,
        .table-bordered th {
            vertical-align: top;
            padding-left: 5px;
            padding-right: 5px;
            padding-top: 4px;
            padding-bottom: 4px;
            border: 1px solid black;
        }

        th {
            vertical-align: middle;
        }
    </style>
</head>

<body>
    <h1 style="text-align: center; font-size: 13pt; margin: 0;">LEMBAR KENDALI PERMINTAAN CEK UNTUK PENGAMBILAN UANG</h1>
    <h2 style="text-align: center; font-size: 12pt; margin: 0;">PADA REKENING BLUD RUMAH SAKIT JIWA DAERAH ATMA HUSADA
        MAHAKAM</h2>
    <h2 style="text-align: center; font-size: 12pt; margin: 0;">TAHUN ANGGARAN
        {{ Carbon\Carbon::parse($sp2d->tanggal)->year }}</h2>

    <br />

    <table class="table-bordered">
        <thead>
            <tr style="border-bottom: 3px double black;">
                <th width="2.5%">NO</th>
                <th width="10%">TANGGAL</th>
                <th width="10%">NOMOR CEK</th>
                <th width="12.5%">JUMLAH UANG YANG DICAIRKAN</th>
                <th width="22.5%">URAIAN PENGGUNAAN</th>
                <th width="12.5%">NILAI RENCANA</th>
                <th width="12.5%">NILAI REALISASI</th>
                <th width="12.5%">JUMLAH SISA</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td style="text-align: center;">1.</td>
                <td style="text-align: center;">{{ Carbon\Carbon::parse($sp2d->tanggal)->isoFormat('DD MMMM YYYY') }}
                </td>
                <td style="text-align: center;">{{ $sp2d->nomor_cek }}</td>
                <td style="text-align: right;">{{ number_format($sp2d->spm->spp->belanja_ls->nilai, 2, ',', '.') }}
                </td>
                <td>{{ $sp2d->spm->spp->belanja_ls->uraian }}</td>
                <td style="text-align: right;">{{ number_format($sp2d->spm->spp->belanja_ls->nilai, 2, ',', '.') }}
                </td>
                <td style="text-align: right;">{{ number_format($sp2d->spm->spp->belanja_ls->nilai, 2, ',', '.') }}
                </td>
                <td style="text-align: right;">
                    {{ number_format($sp2d->spm->spp->belanja_ls->nilai - $sp2d->spm->spp->belanja_ls->nilai, 2, ',', '.') }}
                </td>
            </tr>
        </tbody>
        <tfoot>
            <tr>
                <th colspan="5" rowspan="2">JUMLAH</th>
                <td style="font-weight: bold; text-align: right;">
                    {{ number_format($sp2d->spm->spp->belanja_ls->nilai, 2, ',', '.') }}
                </td>
                <td style="font-weight: bold; text-align: right;">
                    {{ number_format($sp2d->spm->spp->belanja_ls->nilai, 2, ',', '.') }}
                </td>
                <td style="font-weight: bold; text-align: right;">
                    {{ number_format($sp2d->spm->spp->belanja_ls->nilai - $sp2d->spm->spp->belanja_ls->nilai, 2, ',', '.') }}
                </td>
            </tr>
            <tr>
                <td colspan="3">
                    <b>Terbilang:</b> <i>{{ Str::title(Terbilang::make($sp2d->spm->spp->belanja_ls->nilai)) }}
                        Rupiah</i>
                </td>
            </tr>
        </tfoot>
    </table>
    <br />
    <table>
        <tr>
            <td width="30%" style="text-align: center;">
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
            <td width="30%" style="text-align: center;">
                <br />
                PPTK BLUD
                <br />
                <br />
                <br />
                <br />
                <br />
                <strong><u>Ns. Budi Rahman, S.Kep.</u></strong>
                <br />
                NIP. 19790703 199903 1 003
            </td>
            <td width="30%" style="text-align: center;">
                Samarinda, {{ Carbon\Carbon::parse($sp2d->tanggal)->translatedFormat('d F Y') }}
                <br />
                Bendahara Pengeluaran BLUD
                <br />
                <br />
                <br />
                <br />
                <br />
                <strong><u>Hari Jumadi, A.Md.</u></strong>
                <br />
                NIP. 19800404 201101 1 001
            </td>
        </tr>
    </table>

    @include('vendor.dompdf.footer-a4-landscape')

</body>

</html>

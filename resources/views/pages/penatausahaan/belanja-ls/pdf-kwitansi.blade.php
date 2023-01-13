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
    <table style="border: 0; border-collapse: collapse; width: 100%;">
        <tr>
            <td style="width: 60%; vertical-align: top;">
                <u>UNTUK DINAS</u>
            </td>
            <td style="width: 40%; vertical-align: top;">
                <table style="border: 0; border-collapse: collapse; width: 100%;">
                    <tr>
                        <td>Tahun Anggaran</td>
                        <td style="width: 0.2cm;">:</td>
                        <td>2023</td>
                    </tr>
                    <tr>
                        <td>Nomor</td>
                        <td>:</td>
                        <td>
                            {!! $belanja_ls->nomor ?? '.............................' !!}
                        </td>
                    </tr>
                    <tr>
                        <td>Kode Rekening</td>
                        <td>:</td>
                        <td>{{ $belanja_ls->belanja_rka_pd->rek_sub_rincian_objek->kode_lengkap }}</td>
                    </tr>
                </table>
            </td>
        </tr>
        <tr>
            <td colspan="2" style="text-decoration: underline; text-align: center;">
                <h2>KWITANSI / BUKTI PEMBAYARAN</h2>
            </td>
        </tr>
        <tr>
            <td colspan="2">
                <table style="border: 0; border-collapse: collapse; width: 100%;">
                    <tr>
                        <td style="padding: 3px; vertical-align: top; width: 15%;">Sudah terima dari</td>
                        <td style="padding: 3px; vertical-align: top; width: 0.2cm;">:</td>
                        <td style="padding: 3px; vertical-align: top;">Kuasa Pengguna Anggaran
                            {{ $belanja_ls->belanja_rka_pd->rka_pd->sub_unit_kerja->nama }}
                            Provinsi Kalimantan Timur</td>
                    </tr>
                    <tr>
                        <td style="padding: 3px; vertical-align: top;">Jumlah Uang</td>
                        <td style="padding: 3px; vertical-align: top;">:</td>
                        <td style="padding: 3px; vertical-align: top;">
                            <h3 style="margin: 0;">Rp. {{ number_format($belanja_ls->nilai, 2, ',', '.') }}</h3>
                        </td>
                    </tr>
                    <tr>
                        <td style="padding: 3px; vertical-align: top;">Terbilang</td>
                        <td style="padding: 3px; vertical-align: top;">:</td>
                        <td
                            style="padding: 3px; vertical-align: top; background: #dedede; font-weight: bold; font-style: italic;">
                            {{ Str::title(Terbilang::make($belanja_ls->nilai)) }}
                            @if (fmod($belanja_ls->nilai, 1) != 0)
                                Koma {{ Str::title(Terbilang::make(fmod($belanja_ls->nilai, 1) * 100)) }}
                            @endif Rupiah
                        </td>
                    </tr>
                    <tr>
                        <td style="padding: 3px; vertical-align: top;">Untuk Pembayaran</td>
                        <td style="padding: 3px; vertical-align: top;">:</td>
                        <td style="padding: 3px; vertical-align: top;">
                            {{ $belanja_ls->uraian }}
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
        <tr style="border-bottom: 1px solid black;">
            <td></td>
            <td>
                <br />
                Samarinda, {!! $belanja_ls->tanggal
                    ? Carbon\Carbon::parse($belanja_ls->tanggal)->translatedFormat('d F Y')
                    : '.....................................' !!}
                <br />
                <br />
                <br />
                <br />
                <br />
                <strong><u>{{ $belanja_ls->nama }}</u></strong>
                <br />
                <br />
            </td>
        </tr>
        <tr style="border-bottom: 1px solid black;">
            <td>
                <strong>Disetujui dibayar:</strong>
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
                <br />
                <br />
            </td>
            <td>
                <strong>Setuju dan Lunas dibayar tgl:</strong>
                {!! $belanja_ls->tanggal_bayar
                    ? Carbon\Carbon::parse($belanja_ls->tanggal_bayar)->translatedFormat('d F Y')
                    : '.....................................' !!}
                <br />
                Bendahara Pengeluaran BLUD,
                <br />
                <br />
                <br />
                <br />
                <br />
                <strong><u>Hari Jumadi, A.Md.</u></strong>
                <br />
                NIP. 19800404 201101 1 001
                <br />
                <br />
            </td>
        </tr>
        <tr>
            <td colspan="2" style="text-align: left;">
                Barang/pekerjaan tersebut telah diterima/diselesaikan dengan lengkap dan baik.
                <br />
                Pejabat yang Bertanggungjawab,
                <br />
                <br />
                <br />
                <br />
                <br />
                <hr style="border: 0.5px solid black; width: 4cm; margin-left: 0;" />
            </td>
        </tr>
    </table>

    @include('vendor.dompdf.footer-a4-potrait')

</body>

</html>

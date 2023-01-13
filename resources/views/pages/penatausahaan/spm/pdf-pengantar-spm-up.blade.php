<html>

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <style>
        @page {
            margin: 1.25cm 2cm;
            font-family: 'Arial';
            font-size: 9pt;
            font-weight: normal;
        }

        body {
            line-height: 12pt;
        }

        table,
        table th,
        table td {
            border: none;
        }

        .table-bordered {
            border-collapse: collapse;
        }

        .table-bordered th,
        .table-bordered td {
            border: 1px solid black;
            padding: 5px;
        }

        .table-bordered td {
            vertical-align: top;
        }
    </style>
</head>

<body>
    <table style="width: 100%; border-bottom: 5px double black;">
        <tr>
            <td style="width: 2cm; vertical-align: middle;">
                <img src="{{ asset('img/logo-kaltim.png') }}" style="width: 1.8cm; margin: 10px;">
            </td>
            <td style="text-align: center; vertical-align: middle;">
                <h2 style="margin-bottom: 0; font-size: 11pt;">PEMERINTAH PROVINSI KALIMANTAN TIMUR</h2>
                <h1 style="margin-bottom: 0; margin-top: 5px; font-size: 13pt;">RUMAH SAKIT JIWA DAERAH ATMA HUSADA
                    MAHAKAM
                </h1>
                Jalan Kakap No. 23 Samarinda 75115 Telp. (0541) 743364 Fax. 741035
                <br />
                Laman: rsjdahm.kaltimprov.go.id // Email: rsjdahm@gmail.com
            </td>
        </tr>
    </table>
    <br />
    <div style="margin-left: 65%;">
        Samarinda, {{ Carbon\Carbon::parse($spm->tanggal)->isoFormat('DD MMMM YYYY') }}
        <br />
        <br />
        Kepada
        <br />
        <div style="text-indent: -0.7cm;">Yth. Pengguna Anggaran</div>
        {{ $spm->spp->pengajuan_up->sub_unit_kerja->nama }}
        <br />
        di -
        <br />
        <div style="margin-left: 0.75cm;"><u>Samarinda</u></div>
    </div>
    <br />
    <br />
    <h3 style="text-align: center; font-size: 12pt; margin: 0;">SURAT PENGANTAR</h3>
    <center>
        Nomor:
        {{ $spm->nomor }}/SPM-UP/RSJDAHM/BLUD/{{ Terbilang::roman(Carbon\Carbon::parse($spm->tanggal)->month) }}/{{ Carbon\Carbon::parse($spm->tanggal)->year }}
    </center>
    <br />

    <table class="table-bordered">
        <thead>
            <tr>
                <th style="padding: 15px 5px; width: 1cm;">NO</th>
                <th style="padding: 15px 5px;">URAIAN</th>
                <th style="padding: 15px 5px; width: 3cm;">BANYAKNYA</th>
                <th style="padding: 15px 5px;">KETERANGAN</th>
            </tr>
            <tr style="text-align: center; font-size: 7pt; line-height: 7pt;">
                <td style="padding: 2px 5px;">(1)</td>
                <td style="padding: 2px 5px;">(2)</td>
                <td style="padding: 2px 5px;">(3)</td>
                <td style="padding: 2px 5px;">(4)</td>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td style="text-align: center;">1.</td>
                <td>Bersama ini terlampir Surat Perintah Membayar Uang Persediaan (SPM-UP) BLUD Rumah Sakit Jiwa
                    Daerah Atma Husada Mahakam Tahun Anggaran {{ Carbon\Carbon::parse($spm->tanggal)->year }}
                </td>
                <td style="text-align: center;">1 (satu) berkas</td>
                <td>Disampaikan dengan hormat untuk dapat diproses penerbitan Surat Perintah Pencairan Dana (SP2D)</td>
            </tr>
        </tbody>
    </table>
    <p style="text-align:
                    justify;">
        Demikian disampaikan, atas kerjasamanya diucapkan terima kasih.
    </p>
    <br />
    <div style="text-align: center; margin-left: 60%;">
        Kuasa Pengguna Anggaran BLUD
        <br />
        <br />
        <br />
        <br />
        <br />
        <strong><u>Hadi Machbudiansyah, S.E., M.M.</u></strong>
        <br />
        NIP. 19750911 199402 1 001
    </div>

    <br />
    <br />
    <br />
    <br />
    <br />
    <table style="line-height: 8pt;">
        <tr>
            <td style="width: 2.5cm;">Lembar Asli</td>
            <td style="width: 0.25cm;">:</td>
            <td>Untuk Pengguna Anggaran BLUD</td>
        </tr>
        <tr>
            <td>Salinan 1</td>
            <td>:</td>
            <td>Untuk Kuasa Pengguna Anggaran BLUD</td>
        </tr>
        <tr>
            <td>Salinan 2</td>
            <td>:</td>
            <td>Untuk Bendahara Pengeluaran/PPTK BLUD</td>
        </tr>
        <tr>
            <td>Salinan 3</td>
            <td>:</td>
            <td>Untuk Arsip</td>
        </tr>
    </table>

    @include('vendor.dompdf.footer-a4-potrait')
</body>

</html>

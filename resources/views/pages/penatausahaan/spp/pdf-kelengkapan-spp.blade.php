<html>

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <style>
        @page {
            margin: 1.25cm 1.55cm;
            font-family: 'Arial';
            font-size: 9pt;
            font-weight: normal;
        }

        table,
        table th,
        table td {
            border: none;
        }
    </style>
</head>

<body>
    <h2 style="text-align: center;">PENELITIAN KELENGKAPAN DOKUMEN SPP</h2>
    <br />
    <strong>1 SPP-{{ $spp->jenis }} BLUD</strong>
    <br />
    <table>
        <tr>
            <td style="padding: 5px 0; vertical-align: top;">
                <div style="border: 1px black solid; height: 0.5cm; width: 1cm;"></div>
            </td>
            <td style="width: 0.5cm;"></td>
            <td>Surat Pengantar SPP-{{ $spp->jenis }} BLUD</td>
        </tr>
        <tr>
            <td style="padding: 5px 0; vertical-align: top;">
                <div style="border: 1px black solid; height: 0.5cm; width: 1cm;"></div>
            </td>
            <td style="width: 0.5cm;"></td>
            <td>Ringkasan SPP-{{ $spp->jenis }} BLUD</td>
        </tr>
        <tr>
            <td style="padding: 5px 0; vertical-align: top;">
                <div style="border: 1px black solid; height: 0.5cm; width: 1cm;"></div>
            </td>
            <td style="width: 0.5cm;"></td>
            <td>Rincian SPP-{{ $spp->jenis }} BLUD</td>
        </tr>
        <tr>
            <td style="padding: 5px 0; vertical-align: top;">
                <div style="border: 1px black solid; height: 0.5cm; width: 1cm;"></div>
            </td>
            <td style="width: 0.5cm;"></td>
            <td>Salinan SPD</td>
        </tr>
        <tr>
            <td style="padding: 5px 0; vertical-align: top;">
                <div style="border: 1px black solid; height: 0.5cm; width: 1cm;"></div>
            </td>
            <td style="width: 0.5cm;"></td>
            <td>Surat Pengesahan Laporan Pertanggungjawaban Bendahara Pengeluaran BLUD atas penggunaan dana
                SPP-UP/GU/TU BLUD sebelumnya</td>
        </tr>
        <tr>
            <td style="padding: 5px 0; vertical-align: top;">
                <div style="border: 1px black solid; height: 0.5cm; width: 1cm;"></div>
            </td>
            <td style="width: 0.5cm;"></td>
            <td>Draft Surat Pernyataan untuk ditandatangani oleh Pengguna Anggaran/Kuasa Pengguna Anggaran BLUD yang
                menyatakan bahwa uang yang diminta tidak dipergunakan untuk keperluan selain ganti uang persediaan saat
                pengajuan SP2D kepada Kuasa BUD</td>
        </tr>
        <tr>
            <td style="padding: 5px 0; vertical-align: top;">
                <div style="border: 1px black solid; height: 0.5cm; width: 1cm;"></div>
            </td>
            <td style="width: 0.5cm;"></td>
            <td>Lampiran lainnya</td>
        </tr>
    </table>
    <br />
    <br />
    <strong>PENELITI KELENGKAPAN DOKUMEN SPP</strong>
    <table>
        <tr>
            <td style="width: 2.5cm;">Tanggal</td>
            <td style="width: 0.25cm;">:</td>
            <td>{{ Carbon\Carbon::parse($spp->tanggal)->isoFormat('DD MMMM YYYY') }}</td>
        </tr>
        <tr>
            <td>Nama</td>
            <td>:</td>
            <td>Hj. Liliek Ani Suryaningsih, S.E., M.Si.</td>
        </tr>
        <tr>
            <td>NIP</td>
            <td>:</td>
            <td>19771217 199703 2 003</td>
        </tr>
        <tr>
            <td style="vertical-align: top;">Tanda Tangan</td>
            <td style="vertical-align: top;">:</td>
            <td style="height: 1.5cm; border-bottom: 1px solid black"></td>
        </tr>
    </table>
    <br />
    <br />
    <br />
    <br />
    <br />
    <table style="line-height: 8pt;">
        <tr>
            <td style="width: 2.5cm;">Lembar Asli</td>
            <td style="width: 0.25cm;">:</td>
            <td>Untuk Pengguna Anggaran/PPK-SKPD BLUD</td>
        </tr>
        <tr>
            <td>Salinan 1</td>
            <td>:</td>
            <td>Untuk Kuasa BUD</td>
        </tr>
        <tr>
            <td>Salinan 2</td>
            <td>:</td>
            <td>Untuk Bendahara Pengeluaran/PPTK BLUD</td>
        </tr>
        <tr>
            <td>Salinan 3</td>
            <td>:</td>
            <td>Untuk Arsip Bendahara Pengeluaran/PPTK BLUD</td>
        </tr>
    </table>
</body>

</html>

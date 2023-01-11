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
    <table width="100%">
        <tr>
            <td style="width: 65%; vertical-align: top;">
                <table>
                    <br />
                    <br />
                    <tr>
                        <td style="width: 2cm; padding: 0 auto;">Nomor</td>
                        <td style="padding: 0 auto;">:</td>
                        <td style="padding: 0 auto;">{{ $pengajuan_up->nomor }}</td>
                    </tr>
                    <tr>
                        <td style="padding: 0 auto;">Sifat</td>
                        <td style="padding: 0 auto;">:</td>
                        <td style="padding: 0 auto;">Penting</td>
                    </tr>
                    <tr>
                        <td style="padding: 0 auto;">Lampiran</td>
                        <td style="padding: 0 auto;">:</td>
                        <td style="padding: 0 auto;">1 (satu) rangkap</td>
                    </tr>
                    <tr>
                        <td style="padding: 0 auto;">Hal</td>
                        <td style="padding: 0 auto;">:</td>
                        <td style="padding: 0 auto;">Permintaan Uang Persediaan (UP) BLUD</td>
                    </tr>
                </table>
            </td>
            <td style="width: 35%; vertical-align: top;">
                Samarinda, {{ Carbon\Carbon::parse($pengajuan_up->tanggal)->isoFormat('DD MMMM YYYY') }}
                <br />
                <br />
                Kepada
                <br />
                <div style="text-indent: -0.7cm;">Yth. Pengguna Anggaran</div>
                {{ $pengajuan_up->sub_unit_kerja->nama }}
                <br />
                di -
                <br />
                <div style="margin-left: 0.75cm;"><u>Tempat</u></div>
            </td>
        </tr>
    </table>
    <br />

    <div style="padding-left: 2.5cm;">
        <p style="text-align: justify; text-indent: 1cm;">
            Memperhatikan Keputusan Gubernur Kalimantan Timur Nomor 900/K.896/2022 tanggal 27 Desember 2023 tentang
            Penetapan Uang Persediaan Anggaran Belanja pada Satuan Kerja Perangkat Daerah di Lingkungan Pemerintah
            Provinsi
            Kalimantan Timur Tahun Anggaran 2023, dengan ini kami sampaikan hal-hal berikut:
        </p>
        <ol style="text-align: justify;">
            <li>Besaran Anggaran Belanja {{ $pengajuan_up->sub_unit_kerja->nama }} Provinsi Kalimantan Timur setelah
                dikurangi Belanja Pegawai (LS), Belanja Barang dan Jasa (LS), dan Belanja Modal adalah sebesar
                Rp.5.932.587.672,00 (<i>Lima Milyar Sembilan Ratus Tiga Puluh Dua Juta Lima Ratus Delapan Puluh Tujuh
                    Ribu
                    Enam Ratus Tujuh Puluh Dua Rupiah</i>).</li>
            <li>Berdasarkan butir (1) di atas, kami mengajukan Uang Persediaan (UP)
                {{ $pengajuan_up->sub_unit_kerja->nama }} Tahun Anggaran
                {{ Carbon\Carbon::parse($pengajuan_up->tanggal)->year }} sebesar
                Rp.{{ number_format($pengajuan_up->nilai, 2, ',', '.') }}
                (<i>{{ Str::title(Terbilang::make($pengajuan_up->nilai)) }}
                    Rupiah</i>).</li>
        </ol>
        <p style="text-align: justify; text-indent: 1cm;">
            Demikian disampaikan atas perhatian dan kerjasamanya diucapkan terima kasih.
        </p>
    </div>


    <br />
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
</body>

</html>

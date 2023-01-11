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
    <br />
    <h3 style="text-align: center; font-size: 12pt; margin: 0;">SURAT PERNYATAAN PENGAJUAN SPP-UP</h3>
    <center>
        Nomor:
        {{ $spp->nomor }}/SPP-UP/RSJDAHM/BLUD/{{ Terbilang::roman(Carbon\Carbon::parse($spp->tanggal)->month) }}/{{ Carbon\Carbon::parse($spp->tanggal)->year }}
    </center>
    <br />
    <p style="text-align: justify; text-indent: 1cm;">
        Sehubungan dengan Surat Permintaan Pembayaran Uang Persediaan (SPP-UP) yang kami ajukan sebesar <strong>Rp.
            {{ number_format($spp->pengajuan_up->nilai, 2, ',', '.') }}</strong>
        (<i>{{ Str::title(Terbilang::make($spp->pengajuan_up->nilai)) }}
            @if (fmod($spp->pengajuan_up->nilai, 1) != 0)
                Koma {{ Str::title(Terbilang::make(fmod($spp->pengajuan_up->nilai, 1) * 100)) }}
            @endif Rupiah
        </i>) untuk keperluan BLUD Rumah
        Sakit Jiwa Daerah Atma Husada Mahakam Provinsi Kalimantan Timur Tahun Anggaran
        {{ Carbon\Carbon::parse($spp->tanggal)->year }}, dengan ini menyatakan dengan sebenarnya bahwa:
    </p>
    <ol style="text-align: justify;">
        <li>Jumlah Uang Persediaan (UP) tersebut di atas akan dipergunakan untuk keperluan guna membiayai kegiatan yang
            akan kami laksanakan sesuai DPA BLUD-SKPD.</li>
        <li>Jumlah Uang Persediaan (UP) tersebut tidak akan digunakan untuk membiayai pengeluaran-pengeluaran yang
            menurut ketentuan yang berlaku harus dilakukan dengan pembayaran Langsung (LS).</li>
    </ol>
    <p style="text-align: justify; text-indent: 1cm;">
        Demikian Surat Pernyataan ini dibuat untuk melengkapi persyaratan pengajuan SPP-UP BLUD SKPD kami.
    </p>

    <br />
    <br />
    <div style="text-align: center; margin-left: 60%;">
        Samarinda, {{ Carbon\Carbon::parse($spp->tanggal)->isoFormat('DD MMMM YYYY') }}
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
    </div>
</body>

</html>

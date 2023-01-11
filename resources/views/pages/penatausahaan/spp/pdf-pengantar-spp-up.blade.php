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
        Kepada
        <br />
        <div style="text-indent: -0.7cm;">Yth. Pengguna Anggaran/Kuasa Pengguna Anggaran BLUD</div>
        RSJD Atma Husada Mahakam
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
        {{ $spp->nomor }}/SPP-UP/RSJDAHM/BLUD/{{ Terbilang::roman(Carbon\Carbon::parse($spp->tanggal)->month) }}/{{ Carbon\Carbon::parse($spp->tanggal)->year }}
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
                <td>Bersama ini terlampir Surat Permintaan Pembayaran Uang Persediaan (SPP-UP) BLUD Rumah Sakit Jiwa
                    Daerah Atma Husada Mahakam Tahun Anggaran <strong>Rp.
                        {{ number_format($spp->pengajuan_up->nilai, 2, ',', '.') }}</strong>
                    (<i>{{ Str::title(Terbilang::make($spp->pengajuan_up->nilai)) }}
                        @if (fmod($spp->pengajuan_up->nilai, 1) != 0)
                            Koma {{ Str::title(Terbilang::make(fmod($spp->pengajuan_up->nilai, 1) * 100)) }}
                        @endif Rupiah
                    </i>)
                </td>
                <td style="text-align: center;">1 (satu) berkas</td>
                <td>Disampaikan dengan hormat untuk dapat diproses penerbitan Surat Perintah Membayar (SPM)</td>
            </tr>
        </tbody>
    </table>
    <p style="text-align:
                    justify;">
        Demikian disampaikan, atas kerjasamanya diucapkan terima kasih.
    </p>
    <br />
    <br />
    <div style="text-align: center; margin-left: 60%;">
        Samarinda, {{ Carbon\Carbon::parse($spp->tanggal)->isoFormat('DD MMMM YYYY') }}
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
            <td>Untuk Pengguna Anggaran BLUD/PPK-SKPD BLUD</td>
        </tr>
        <tr>
            <td>Salinan 1</td>
            <td>:</td>
            <td>Untuk Kuasa Pengguna Anggaran BLUD</td>
        </tr>
        <tr>
            <td>Salinan 2</td>
            <td>:</td>
            <td>Untuk Bendahara Pengeluaran BLUD/PPTK BLUD</td>
        </tr>
        <tr>
            <td>Salinan 3</td>
            <td>:</td>
            <td>Untuk Arsip</td>
        </tr>
    </table>

    <div style="page-break-before: always;" />

    <div style="font-size: 8pt;">
        <table>
            <tr>
                <td style="border-bottom: 1px solid black;">
                    <table>
                        <tr>
                            <td style="width: 1.8cm; vertical-align: middle;">
                                <img src="{{ asset('img/logo-kaltim.png') }}" style="width: 1.5cm; margin: 10px;">
                            </td>
                            <td style="text-align: center; vertical-align: middle;">
                                <h3 style="margin: 0;">PEMERINTAH PROVINSI KALIMANTAN TIMUR</h3>
                                <h2 style="margin: 0; font-size: 11pt;">SURAT PERMINTAAN PEMBAYARAN UANG PERSEDIAAN
                                    (SPP-UP)
                                    BLUD </h2>
                                Nomor :
                                {{ $spp->nomor }}/SPP-UP/RSJDAHM/BLUD/{{ Terbilang::roman(Carbon\Carbon::parse($spp->tanggal)->month) }}/{{ Carbon\Carbon::parse($spp->tanggal)->year }}<br />
                                Tahun Anggaran : {{ Carbon\Carbon::parse($spp->tanggal)->year }}
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>

        <br />
        <h3 style="text-align: center; margin: 0;">SURAT PENGANTAR</h3>
        <br />

        <div>
            Kepada Yth.
            <br />
            Pengguna Anggaran/Kuasa Pengguna Anggaran BLUD
            <br />
            RSJD Atma Husada Mahakam Provinsi Kalimantan Timur
            <br />
            di Tempat
        </div>

        <br />

        <p style="text-align:
                    justify;">
            Dengan memperhatikan Peraturan Gubernur Kalimantan Timur Nomor 1 Tahun 2022 tentang Penjabaran APBD, bersama
            ini kami mengajukan Surat Permintaan Pembayaran Uang Persediaan sebagai berikut:
        </p>
        <table>
            <tr>
                <td style="width: 0.25cm; vertical-align: top;">
                    a.
                </td>
                <td style="width: 5cm; vertical-align: top;">
                    Urusan Pemerintahan
                </td>
                <td style="width: 0.25cm; vertical-align: top;">
                    :
                </td>
                <td style="vertical-align: top;">
                    {{ $spp->pengajuan_up->sub_unit_kerja->unit_kerja->bidang->kode_lengkap }}
                    {{ $spp->pengajuan_up->sub_unit_kerja->unit_kerja->bidang->nama }}
                </td>
            </tr>
            <tr>
                <td style="vertical-align: top;">
                    b.
                </td>
                <td style="vertical-align: top;">
                    SKPD/Unit SKPD
                </td>
                <td style="vertical-align: top;">
                    :
                </td>
                <td style="vertical-align: top;">
                    {{ $spp->pengajuan_up->sub_unit_kerja->kode_lengkap }}
                    {{ $spp->pengajuan_up->sub_unit_kerja->nama }}
                </td>
            </tr>
            <tr>
                <td style="vertical-align: top;">
                    c.
                </td>
                <td style="vertical-align: top;">
                    Tahun Anggaran
                </td>
                <td style="vertical-align: top;">
                    :
                </td>
                <td style="vertical-align: top;">
                    {{ Carbon\Carbon::parse($spp->tanggal)->year }}
                </td>
            </tr>
            <tr>
                <td style="vertical-align: top;">
                    d.
                </td>
                <td style="vertical-align: top;">
                    Dasar Pengeluaran SPD Nomor
                </td>
                <td style="vertical-align: top;">
                    :
                </td>
                <td style="vertical-align: top;">

                </td>
            </tr>
            <tr>
                <td style="vertical-align: top;">
                    e.
                </td>
                <td style="vertical-align: top;">
                    Jumlah SPD
                </td>
                <td style="vertical-align: top;">
                    :
                </td>
                <td style="vertical-align: top;">
                    Rp {{ number_format($sum_belanja_rka_pd, 2, ',', '.') }}
                    <br />
                    (<i>{{ Str::title(Terbilang::make($sum_belanja_rka_pd)) }}
                        @if (fmod($sum_belanja_rka_pd, 1) != 0)
                            Koma {{ Str::title(Terbilang::make(fmod($sum_belanja_rka_pd, 1) * 100)) }}
                        @endif Rupiah
                    </i>)
                </td>
            </tr>
            <tr>
                <td style="vertical-align: top;">
                    f.
                </td>
                <td style="vertical-align: top;">
                    Nama Bendahara Pengeluaran
                </td>
                <td style="vertical-align: top;">
                    :
                </td>
                <td style="vertical-align: top;">
                    Hari Jumadi, A.Md.
                </td>
            </tr>
            <tr>
                <td style="vertical-align: top;">
                    g.
                </td>
                <td style="vertical-align: top;">
                    Jumlah Pembayaran yang Diminta
                </td>
                <td style="vertical-align: top;">
                    :
                </td>
                <td style="vertical-align: top;">
                    Rp {{ number_format($spp->pengajuan_up->nilai, 2, ',', '.') }}
                    <br />
                    (<i>{{ Str::title(Terbilang::make($spp->pengajuan_up->nilai)) }}
                        @if (fmod($spp->pengajuan_up->nilai, 1) != 0)
                            Koma {{ Str::title(Terbilang::make(fmod($spp->pengajuan_up->nilai, 1) * 100)) }}
                        @endif Rupiah
                    </i>)
                </td>
            </tr>
            <tr>
                <td style="vertical-align: top;">
                    h.
                </td>
                <td style="vertical-align: top;">
                    Nama dan Nomor Rekening Bank
                </td>
                <td style="vertical-align: top;">
                    :
                </td>
                <td style="vertical-align: top;">
                    124 BANKALTIMTARA / 0011536760
                </td>
            </tr>
        </table>
        <br />
        <br />
        <div style="text-align: center; margin-left: 60%;">
            Samarinda, {{ Carbon\Carbon::parse($spp->tanggal)->isoFormat('DD MMMM YYYY') }}
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
        </div>
    </div>


    {{-- @include('vendor.dompdf.footer-a4-potrait') --}}
</body>

</html>

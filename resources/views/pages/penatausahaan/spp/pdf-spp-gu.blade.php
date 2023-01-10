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
        <tr>
            <td style="border-bottom: 1px solid black;">
                <table>
                    <tr>
                        <td style="width: 1.8cm; vertical-align: middle;">
                            <img src="{{ asset('img/logo-kaltim.png') }}" style="width: 1.5cm; margin: 10px;">
                        </td>
                        <td style="text-align: center; vertical-align: middle;">
                            <h3 style="margin: 0;">PEMERINTAH PROVINSI KALIMANTAN TIMUR</h3>
                            <h2 style="margin: 0; font-size: 11pt;">SURAT PERMINTAAN PEMBAYARAN UANG PERSEDIAAN (SPP-GU)
                                BLUD </h2>
                            Nomor :
                            {{ $spp->nomor }}/SPP-GU/RSJDAHM/BLUD/{{ Terbilang::roman(Carbon\Carbon::parse($spp->tanggal)->month) }}/{{ Carbon\Carbon::parse($spp->tanggal)->year }}
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
        <tr>
            <td style="border-bottom: 1px solid black;">
                <table>
                    <tr>
                        <td style="width: 7cm;">
                            1. Nama SKPD/Unit Kerja
                        </td>
                        <td style="width: 0.25cm;">
                            :
                        </td>
                        <td>
                            {{ $spp->spj_gu->sub_unit_kerja->nama }}
                        </td>
                    </tr>
                    <tr>
                        <td>
                            2. Nama Pengguna/Kuasa Pengguna Anggaran
                        </td>
                        <td>
                            :
                        </td>
                        <td>
                            Hadi Machbudiansyah, S.E., M.M.
                        </td>
                    </tr>
                    <tr>
                        <td>
                            3. Nama Bendahara Pengeluaran
                        </td>
                        <td>
                            :
                        </td>
                        <td>
                            BLUD RSJD ATMA HUSADA MAHAKAM PROV.KALTIM
                        </td>
                    </tr>
                    <tr>
                        <td>
                            4. NPWP Bendahara Pengeluaran
                        </td>
                        <td>
                            :
                        </td>
                        <td>
                            953350162722000
                        </td>
                    </tr>
                    <tr>
                        <td>
                            5. Nama Bank Penerima
                        </td>
                        <td>
                            :
                        </td>
                        <td>
                            124 BANKALTIMTARA
                        </td>
                    </tr>
                    <tr>
                        <td>
                            6. Nomor Rekening Bank
                        </td>
                        <td>
                            :
                        </td>
                        <td>
                            0011536760
                        </td>
                    </tr>
                    <tr>
                        <td>
                            7. Untuk Keperluan
                        </td>
                        <td>
                            :
                        </td>
                        <td>
                            {{ $spp->uraian }}
                        </td>
                    </tr>
                    <tr>
                        <td>
                            7. Dasar Pengeluaran
                        </td>
                        <td>
                            :
                        </td>
                        <td>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
        <tr>
            <td style="black; padding-left: 7.75cm;">
                Sebesar Rp. {{ number_format($spp->spj_gu->nilai, 2, ',', '.') }}
                <br />
                (Terbilang: <i>{{ Str::title(Terbilang::make($spp->spj_gu->nilai)) }} Rupiah</i>)
                <br />
                <br />
            </td>
        </tr>
        <tr>
            <table>
                <tr>
                    <td style="border: 1px solid black; border-left: 0; width: 0.75cm;">No</td>
                    <td colspan="3" style="border: 1px solid black; border-right: 0;">Uraian</td>
                </tr>
                <tr>
                    <td colspan="4"></td>
                </tr>
                <tr>
                    <td style="border: 1px solid black; border-left: 0; text-align: center;">
                        I
                    </td>
                    <td colspan="3" style="border: 1px solid black; border-right: 0;">
                        SPD
                    </td>
                </tr>
                <tr>
                    <td style="border: 1px solid black; border-left: 0; text-align: center;">

                    </td>
                    <td style="border: 1px solid black; width: 4cm;">
                        Tanggal:
                    </td>
                    <td style="border: 1px solid black;">
                        Nomor:
                    </td>
                    <td style="border: 1px solid black; border-right: 0; width: 5cm;">
                    </td>
                </tr>
                <tr>
                    <td style="border: 1px solid black; border-left: 0; text-align: center;">
                        II
                    </td>
                    <td colspan="3" style="border: 1px solid black; border-right: 0;">
                        SP2D
                    </td>
                </tr>
                <tr>
                    <td style="border: 1px solid black; border-left: 0; text-align: center;">

                    </td>
                    <td style="border: 1px solid black; width: 4cm;">
                        Tanggal:
                    </td>
                    <td style="border: 1px solid black;">
                        Nomor:
                    </td>
                    <td style="border: 1px solid black; border-right: 0; width: 5cm;">
                    </td>
                </tr>
                <tr>
                    <td colspan="4"
                        style="border: 1px solid black; border-left: 0; border-right: 0; text-align: center; font-style: italic; font-size: 6.5pt;">
                        Pada SPP ini ditetapkan lampiran-lampiran yang diperlukan sebagaimana tertera pada daftar
                        kelengkapan dokumen SPP ini.
                    </td>
                </tr>
            </table>
        </tr>
        <tr>
            <td style="padding-left: 10cm; text-align: center;">
                <br />
                <br />
                Samarinda, {{ Carbon\Carbon::parse($spp->tanggal)->translatedFormat('d F Y') }}
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
        </tr>
        <tr>
            <td>
                <br />
                <br />
                <br />
                <br />
                <strong>Lembar Asli</strong> : Untuk Pengguna Anggaran/PPK-SKPD
                <br />
                <strong>Salinan 1</strong> : Untuk Kuasa BUD
                <br />
                <strong>Salinan 2</strong> : Untuk Bendahara Pengeluaran
                <br />
                <strong>Salinan 3</strong> : Untuk Arsip Bendahara Pengeluaran
            </td>
        </tr>
    </table>

    <div style="page-break-before: always;" />

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
                            <h2 style="margin: 0; font-size: 11pt;">SURAT PERMINTAAN PEMBAYARAN UANG PERSEDIAAN (SPP-GU)
                                BLUD </h2>
                            Nomor :
                            {{ $spp->nomor }}/SPP-GU/RSJDAHM/BLUD/{{ Terbilang::roman(Carbon\Carbon::parse($spp->tanggal)->month) }}/{{ Carbon\Carbon::parse($spp->tanggal)->year }}<br />
                            Tahun Anggaran : 2023
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
        <tr>
            <td>
                <h3 style="text-align: center;">RINCIAN RENCANA PENGGUNAAN</h3>
            </td>
        </tr>
        <tr>
            <table>
                <tr>
                    <th rowspan="2" style="border: 1px solid black; border-left: 0; width: 0.75cm;">NO</th>
                    <th colspan="2" style="border: 1px solid black;">PROGRAM/KEGIATAN/SUBKEGIATAN/REKENING</th>
                    <th rowspan="2" style="border: 1px solid black; border-right: 0; width: 3.5cm;">NILAI RUPIAH</th>
                </tr>
                <tr>
                    <th style="border: 1px solid black; width: 3.75cm;">KODE</th>
                    <th style="border: 1px solid black;">NAMA</th>
                </tr>
                <tr>
                    <td style="border: 1px solid black; border-left: 0; text-align: center;">1</td>
                    <td style="border: 1px solid black;">{{ $spp->spj_gu->rek_sub_rincian_objek->kode_lengkap }}
                    </td>
                    <td style="border: 1px solid black;">{{ $spp->spj_gu->rek_sub_rincian_objek->nama }}</td>
                    <td style="border: 1px solid black; border-right: 0; text-align: right;">
                        {{ number_format($spp->spj_gu->nilai, 2, ',', '.') }}</td>
                </tr>
            </table>
        </tr>
        <tr>
            <td style="text-align: right; font-weight: bold;">
                TOTAL : Rp. {{ number_format($spp->spj_gu->nilai, 2, ',', '.') }}
            </td>
        </tr>
        <tr>
            <td>
                Terbilang: <i>{{ Str::title(Terbilang::make($spp->spj_gu->nilai)) }} Rupiah</i>
            </td>
        </tr>
        <tr>
            <td style="padding-top: 1cm;">
                <table>
                    <tr>
                        <td style="text-align: center;">
                            Mengetahui/Menyetujui:
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
                        <td style="text-align: center;">
                            Samarinda, {{ Carbon\Carbon::parse($spp->tanggal)->translatedFormat('d F Y') }}
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
                    </tr>
                </table>
            </td>
        </tr>
    </table>

    @include('vendor.dompdf.footer-a4-potrait')

</body>

</html>

<html>

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <style>
        @page {
            margin: 1.25cm 1.55cm;
            font-family: 'Arial';
            font-size: 7pt;
            font-weight: normal;
        }

        .table {
            border-top: 1px solid black;
            border-bottom: 1px solid black;
            border-collapse: collapse;
            width: 100%;
        }

        .table thead,
        .table tfoot {
            border-top: 1px solid black;
            border-bottom: 1px solid black;
        }

        .table td {
            border-left: 1px solid #000;
            border-right: 1px solid #000;
            padding: 1px 5px;
            vertical-align: top;
        }

        .table th {
            border-left: 1px solid #000;
            border-right: 1px solid #000;
            padding: 5px 5px;
        }
    </style>
</head>

<body>
    <table style="width: 100%; border-collapse: collapse; border: 0;">
        <tr>
            <td style="width: 1.8cm">
                <img src="{{ asset('img/logo-kaltim.png') }}" style="width: 1.5cm; margin: 10px;">
            </td>
            <td>
                <div style="text-align: center;">
                    <h3 style="margin: 0;">PEMERINTAH PROVINSI KALIMANTAN TIMUR</h3>
                </div>
                <div style="text-align: center;">
                    <h2 style="margin: 0;">LAPORAN PERTANGGUNGJAWABAN GANTI UANG PERSEDIAAN (GU) BLUD</h2>
                </div>
                <div style="text-align: center;">
                    Nomor:
                    {{ $spj_gu->nomor }}/SPM-GU/BLUD-RSJDAHM/{{ Terbilang::roman(Carbon\Carbon::parse($spj_gu->tanggal)->isoFormat('MM')) }}/{{ Carbon\Carbon::parse($spj_gu->tanggal)->isoFormat('YYYY') }}
                </div>
            </td>
        </tr>
    </table>
    <table style="width: 100%; border-collapse: collapse; border: 0; margin-bottom: 0.5cm;">
        <tr>
            <td style="width: 4cm;">Urusan Pemerintahan</td>
            <td style="width: 0.5cm;">:</td>
            <td>1.02 URUSAN PEMERINTAHAN BIDANG KESEHATAN
            </td>
        </tr>
        <tr>
            <td>Unit Organisasi</td>
            <td>:</td>
            <td>1.02.00-00.00-00.01 Dinas Kesehatan </td>
        </tr>
        <tr>
            <td>Sub Unit Organisasi</td>
            <td>:</td>
            <td>1.02.00-00.00-00.01.004 BLUD Rumah Sakit Jiwa Daerah Atma Husada Mahakam</td>
        </tr>
        <tr>
            <td>Pengguna Anggaran BLUD</td>
            <td>:</td>
            <td>dr. Indah Puspitasari, MARS.</td>
        </tr>
        <tr>
            <td>Bendahara Pengeluaran BLUD</td>
            <td>:</td>
            <td>Hari Jumadi, A.Md.</td>
        </tr>
    </table>
    <table class="table">
        <thead>
            <tr>
                <th rowspan="2">NO</th>
                <th rowspan="2">KODE REKENING</th>
                <th rowspan="2">NO. BUKTI</th>
                <th rowspan="2">TANGGAL</th>
                <th rowspan="2">URAIAN</th>
                <th rowspan="2">JUMLAH</th>
                <th colspan="{{ collect(App\Enums\Penatausahaan\JenisPotonganPfk::cases())->count() }}"
                    style="border-bottom: 1px solid black;">POTONGAN</th>
                <th rowspan="2">JUMLAH POTONGAN</th>
            </tr>
            <tr>
                @foreach (App\Enums\Penatausahaan\JenisPotonganPfk::cases() as $jenis_potongan)
                    <th>{{ $jenis_potongan }}</th>
                @endforeach
            </tr>
        </thead>
        <tbody>
            @php
                $total_potongan = 0;
                foreach (App\Enums\Penatausahaan\JenisPotonganPfk::cases() as $jenis_potongan) {
                    $total_potongan_per_jenis[Str::snake($jenis_potongan->value)] = 0;
                }
            @endphp
            @foreach ($spj_gu->bukti_spj_gu as $bukti_spj_gu)
                <tr style="border-bottom: 1px dotted black;">
                    <td style="text-align: center;">{{ $loop->iteration }}.</td>
                    <td style="text-align: center;">
                        {{ $bukti_spj_gu->bukti_gu->belanja_rka_pd->rek_sub_rincian_objek->kode_lengkap }}</td>
                    <td style="text-align: center;">{{ $bukti_spj_gu->bukti_gu->nomor }}</td>
                    <td style="text-align: center;">
                        {{ Carbon\Carbon::parse($bukti_spj_gu->bukti_gu->tanggal)->isoFormat('DD/MM/YYYY') }}</td>
                    <td>{{ $bukti_spj_gu->bukti_gu->uraian }}</td>
                    <td style="text-align: right;">{{ number_format($bukti_spj_gu->bukti_gu->nilai, 2, ',', '.') }}
                    </td>
                    @foreach (App\Enums\Penatausahaan\JenisPotonganPfk::cases() as $jenis_potongan)
                        @php
                            $total_potongan_per_jenis[Str::snake($jenis_potongan->value)] += $bukti_spj_gu->bukti_gu->potongan_bukti_gu->where('potongan_pfk.jenis', $jenis_potongan)->sum('nilai');
                        @endphp
                        <td style="text-align: right;">
                            {{ number_format($bukti_spj_gu->bukti_gu->potongan_bukti_gu->where('potongan_pfk.jenis', $jenis_potongan)->sum('nilai'), 2, ',', '.') }}
                        </td>
                    @endforeach
                    <td style="text-align: right;">
                        @php
                            $total_potongan += $bukti_spj_gu->bukti_gu->potongan_bukti_gu->sum('nilai');
                        @endphp
                        {{ number_format($bukti_spj_gu->bukti_gu->potongan_bukti_gu->sum('nilai'), 2, ',', '.') }}
                    </td>
                </tr>
            @endforeach
        </tbody>
        <tfoot>
            <tr>
                <th colspan="5">TOTAL</th>
                <th>{{ number_format($spj_gu->bukti_spj_gu->sum('bukti_gu.nilai'), 2, ',', '.') }}</th>
                @foreach (App\Enums\Penatausahaan\JenisPotonganPfk::cases() as $jenis_potongan)
                    <th style="text-align: right;">
                        {{ number_format($total_potongan_per_jenis[Str::snake($jenis_potongan->value)], 2, ',', '.') }}
                    </th>
                @endforeach
                <th style="text-align: right;">
                    {{ number_format($total_potongan, 2, ',', '.') }}
                </th>
            </tr>
        </tfoot>
    </table>


    @include('vendor.dompdf.footer-a4-landscape')

</body>

</html>

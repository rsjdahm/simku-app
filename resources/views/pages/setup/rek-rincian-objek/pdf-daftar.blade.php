<html>

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <style>
        @page {
            margin: 1.25cm 1.55cm;
            font-family: 'Arial';
            font-size: 7pt;
            font-weight: normal;
            size: "A4";
        }

        table {
            border-top: 1px solid black;
            border-bottom: 1px solid black;
            border-collapse: collapse;
        }

        table thead {
            border-top: 1px solid black;
            border-bottom: 1px solid black;
        }

        table td {
            border-left: 1px solid #000;
            padding: 1px 5px;
            vertical-align: top;
        }

        table th {
            border-left: 1px solid #000;
            padding: 5px 5px;
        }

        table td:first-child,
        table th:first-child {
            border-left: none;
        }
    </style>
</head>

<body style="border: 1px solid black; padding: 5px 0 5px 0;">
    <div style="text-align: center;">
        <strong>APLIKASI SIMKU RSJD-AHM</strong>
    </div>
    <div style="text-align: center;">
        <h3 style="margin: 0;">DAFTAR REKENING STANDAR</h3>
    </div>
    <div style="text-align: center;">
        Untuk Rekening Akun, Kelompok, Jenis, Objek, dan Rincian Objek
    </div>
    <br />
    <br />
    <div>
        <table style="width: 100%; border-collapse: collapse;">
            <thead>
                <tr>
                    <th style="width: 20%;">KODE REKENING</th>
                    <th>URAIAN</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($rek_akun->sortBy('kode_lengkap') as $rek_akun_item)
                    <tr>
                        <td><strong>{{ $rek_akun_item->kode_lengkap }}</strong></td>
                        <td><strong>{{ $rek_akun_item->nama }}</strong></td>
                    </tr>
                    @foreach ($rek_akun_item->rek_kelompok->sortBy('kode_lengkap') as $rek_kelompok_item)
                        <tr>
                            <td><strong>{{ $rek_kelompok_item->kode_lengkap }}</strong></td>
                            <td style="padding-left: 1.5rem;"><strong>{{ $rek_kelompok_item->nama }}</strong></td>
                        </tr>
                        @foreach ($rek_kelompok_item->rek_jenis->sortBy('kode_lengkap') as $rek_jenis_item)
                            <tr>
                                <td><strong>{{ $rek_jenis_item->kode_lengkap }}</strong></td>
                                <td style="padding-left: 3rem;"><strong>{{ $rek_jenis_item->nama }}</strong></td>
                            </tr>
                            @foreach ($rek_jenis_item->rek_objek->sortBy('kode_lengkap') as $rek_objek_item)
                                <tr>
                                    <td>{{ $rek_objek_item->kode_lengkap }}</td>
                                    <td style="padding-left: 4.5rem;">{{ $rek_objek_item->nama }}</td>
                                </tr>
                                @foreach ($rek_objek_item->rek_rincian_objek->sortBy('kode_lengkap') as $rek_rincian_objek_item)
                                    <tr>
                                        <td>{{ $rek_rincian_objek_item->kode_lengkap }}</td>
                                        <td style="padding-left: 6rem;">{{ $rek_rincian_objek_item->nama }}</td>
                                    </tr>
                                @endforeach
                            @endforeach
                        @endforeach
                    @endforeach
                @endforeach
            </tbody>
        </table>
    </div>
</body>

</html>

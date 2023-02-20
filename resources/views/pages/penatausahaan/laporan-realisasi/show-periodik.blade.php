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
                <h2 style="margin: 0;">LAPORAN REALISASI KEUANGAN (BLUD)</h2>
            </div>
            <div style="text-align: center;">
                Per tanggal {{ Carbon\Carbon::parse($tgl_start)->isoFormat('DD MMMM YYYY') }} s/d
                {{ Carbon\Carbon::parse($tgl_end)->isoFormat('DD MMMM YYYY') }}
            </div>
        </td>
    </tr>
</table>
<div class="table-responsive">
    <table class="table-sm table-bordered table-hovered table">
        <thead class="bg-primary text-white">
            <tr>
                <th rowspan="2">KODE REKENING</th>
                <th rowspan="2">URAIAN</th>
                <th rowspan="2">PAGU {{ Str::upper($rka_pd->status->value) }} ANGGARAN</th>
                <th colspan="3" class="text-center">REALISASI</th>
            </tr>
            <tr>
                <th>KEUANGAN (RP)</th>
                <th>%</th>
                <th>SISA ANGGARAN</th>
            </tr>
        </thead>
        <tbody>
            @php
                $defisit_surplus = 0;
                $realisasi_defisit_surplus = 0;
            @endphp
            @foreach ($rek_akun as $_rek_akun)
                @php
                    $jumlah_nilai_per_akun = $belanja_rka_pd->whereIn('rek_sub_rincian_objek_id', $rek_sub_rincian_objek->whereIn('rek_rincian_objek_id', $rek_rincian_objek->whereIn('rek_objek_id', $rek_objek->whereIn('rek_jenis_id', $rek_jenis->whereIn('rek_kelompok_id', $rek_kelompok->where('rek_akun_id', $_rek_akun->id)->pluck('id'))->pluck('id'))->pluck('id'))->pluck('id'))->pluck('id'))->sum('nilai');
                    
                @endphp
                {{-- <tr style="font-weight: bold; background: #cbcbcb">
                    <td>{{ $_rek_akun->kode_lengkap }}</td>
                    <td>{{ $_rek_akun->nama }}</td>
                    <td style="text-align: right;">{{ number_format($jumlah_nilai_per_akun, 2, ',', '.') }}
                    </td>
                    <td style="text-align: right;">
                        @php
                            $jumlah_realisasi_per_akun = $belanja_rka_pd->whereIn('rek_sub_rincian_objek_id', $rek_sub_rincian_objek->whereIn('rek_rincian_objek_id', $rek_rincian_objek->whereIn('rek_objek_id', $rek_objek->whereIn('rek_jenis_id', $rek_jenis->whereIn('rek_kelompok_id', $rek_kelompok->where('rek_akun_id', $_rek_akun->id)->pluck('id'))->pluck('id'))->pluck('id'))->pluck('id'))->pluck('id'))->sum('belanja_ls_sum_nilai') + $belanja_rka_pd->whereIn('rek_sub_rincian_objek_id', $rek_sub_rincian_objek->whereIn('rek_rincian_objek_id', $rek_rincian_objek->whereIn('rek_objek_id', $rek_objek->whereIn('rek_jenis_id', $rek_jenis->whereIn('rek_kelompok_id', $rek_kelompok->where('rek_akun_id', $_rek_akun->id)->pluck('id'))->pluck('id'))->pluck('id'))->pluck('id'))->pluck('id'))->sum('bukti_gu_sum_nilai');
                        @endphp
                        {{ number_format($jumlah_realisasi_per_akun, 2, ',', '.') }}</td>
                    <td style="text-align: right;">
                        @if ($jumlah_nilai_per_akun > 0 && $jumlah_realisasi_per_akun > 0)
                            {{ number_format(($jumlah_realisasi_per_akun / $jumlah_nilai_per_akun) * 100, 2, ',', '.') }}
                        @elseif ($jumlah_nilai_per_akun <= 0 && $jumlah_realisasi_per_akun > 0)
                            ~
                        @else
                            0,00
                        @endif
                    </td>
                    <td style="text-align: right;">
                        {{ number_format($jumlah_nilai_per_akun - $jumlah_realisasi_per_akun, 2, ',', '.') }}
                    </td>
                </tr> --}}
                @foreach ($rek_kelompok->where('rek_akun_id', $_rek_akun->id)->all() as $_rek_kelompok)
                    @php
                        $jumlah_nilai_per_kelompok = $belanja_rka_pd->whereIn('rek_sub_rincian_objek_id', $rek_sub_rincian_objek->whereIn('rek_rincian_objek_id', $rek_rincian_objek->whereIn('rek_objek_id', $rek_objek->whereIn('rek_jenis_id', $rek_jenis->where('rek_kelompok_id', $_rek_kelompok->id)->pluck('id'))->pluck('id'))->pluck('id'))->pluck('id'))->sum('nilai');
                        
                    @endphp
                    <tr class="font-weight-bold bg-warning">
                        <td>{{ $_rek_kelompok->kode_lengkap }}</td>
                        <td>{{ $_rek_kelompok->nama }}</td>
                        <td style="text-align: right;">{{ number_format($jumlah_nilai_per_kelompok, 2, ',', '.') }}
                        </td>
                        <td style="text-align: right;">
                            @php
                                $jumlah_realisasi_per_kelompok = $belanja_rka_pd->whereIn('rek_sub_rincian_objek_id', $rek_sub_rincian_objek->whereIn('rek_rincian_objek_id', $rek_rincian_objek->whereIn('rek_objek_id', $rek_objek->whereIn('rek_jenis_id', $rek_jenis->where('rek_kelompok_id', $_rek_kelompok->id)->pluck('id'))->pluck('id'))->pluck('id'))->pluck('id'))->sum('belanja_ls_sum_nilai') + $belanja_rka_pd->whereIn('rek_sub_rincian_objek_id', $rek_sub_rincian_objek->whereIn('rek_rincian_objek_id', $rek_rincian_objek->whereIn('rek_objek_id', $rek_objek->whereIn('rek_jenis_id', $rek_jenis->where('rek_kelompok_id', $_rek_kelompok->id)->pluck('id'))->pluck('id'))->pluck('id'))->pluck('id'))->sum('bukti_gu_sum_nilai');
                            @endphp
                            {{ number_format($jumlah_realisasi_per_kelompok, 2, ',', '.') }}</td>
                        <td style="text-align: right;">
                            @if ($jumlah_nilai_per_kelompok > 0 && $jumlah_realisasi_per_kelompok > 0)
                                {{ number_format(($jumlah_realisasi_per_kelompok / $jumlah_nilai_per_kelompok) * 100, 2, ',', '.') }}
                            @elseif ($jumlah_nilai_per_kelompok <= 0 && $jumlah_realisasi_per_kelompok > 0)
                                ~
                            @else
                                0,00
                            @endif
                        </td>
                        <td style="text-align: right;">
                            {{ number_format($jumlah_nilai_per_kelompok - $jumlah_realisasi_per_kelompok, 2, ',', '.') }}
                        </td>
                    </tr>
                    @foreach ($rek_jenis->where('rek_kelompok_id', $_rek_kelompok->id)->all() as $_rek_jenis)
                        @php
                            $jumlah_nilai_per_jenis = $belanja_rka_pd->whereIn('rek_sub_rincian_objek_id', $rek_sub_rincian_objek->whereIn('rek_rincian_objek_id', $rek_rincian_objek->whereIn('rek_objek_id', $rek_objek->where('rek_jenis_id', $_rek_jenis->id)->pluck('id'))->pluck('id'))->pluck('id'))->sum('nilai');
                            
                        @endphp
                        <tr style="font-weight: bold; background: #dedede">
                            <td>{{ $_rek_jenis->kode_lengkap }}</td>
                            <td>{{ $_rek_jenis->nama }}</td>
                            <td style="text-align: right;">{{ number_format($jumlah_nilai_per_jenis, 2, ',', '.') }}
                            </td>
                            <td style="text-align: right;">
                                @php
                                    $jumlah_realisasi_per_jenis = $belanja_rka_pd->whereIn('rek_sub_rincian_objek_id', $rek_sub_rincian_objek->whereIn('rek_rincian_objek_id', $rek_rincian_objek->whereIn('rek_objek_id', $rek_objek->where('rek_jenis_id', $_rek_jenis->id)->pluck('id'))->pluck('id'))->pluck('id'))->sum('belanja_ls_sum_nilai') + $belanja_rka_pd->whereIn('rek_sub_rincian_objek_id', $rek_sub_rincian_objek->whereIn('rek_rincian_objek_id', $rek_rincian_objek->whereIn('rek_objek_id', $rek_objek->where('rek_jenis_id', $_rek_jenis->id)->pluck('id'))->pluck('id'))->pluck('id'))->sum('bukti_gu_sum_nilai');
                                @endphp
                                {{ number_format($jumlah_realisasi_per_jenis, 2, ',', '.') }}</td>
                            <td style="text-align: right;">
                                @if ($jumlah_nilai_per_jenis > 0 && $jumlah_realisasi_per_jenis > 0)
                                    {{ number_format(($jumlah_realisasi_per_jenis / $jumlah_nilai_per_jenis) * 100, 2, ',', '.') }}
                                @elseif ($jumlah_nilai_per_jenis <= 0 && $jumlah_realisasi_per_jenis > 0)
                                    ~
                                @else
                                    0,00
                                @endif
                            </td>
                            <td style="text-align: right;">
                                {{ number_format($jumlah_nilai_per_jenis - $jumlah_realisasi_per_jenis, 2, ',', '.') }}
                            </td>
                        </tr>
                        @foreach ($rek_objek->where('rek_jenis_id', $_rek_jenis->id)->all() as $_rek_objek)
                            @php
                                $jumlah_nilai_per_objek = $belanja_rka_pd->whereIn('rek_sub_rincian_objek_id', $rek_sub_rincian_objek->whereIn('rek_rincian_objek_id', $rek_rincian_objek->where('rek_objek_id', $_rek_objek->id)->pluck('id'))->pluck('id'))->sum('nilai');
                                
                            @endphp
                            <tr style="font-weight: bold; background: #ececec">
                                <td>{{ $_rek_objek->kode_lengkap }}</td>
                                <td>{{ $_rek_objek->nama }}</td>
                                <td style="text-align: right;">
                                    {{ number_format($jumlah_nilai_per_objek, 2, ',', '.') }}
                                </td>
                                <td style="text-align: right;">
                                    @php
                                        $jumlah_realisasi_per_objek = $belanja_rka_pd->whereIn('rek_sub_rincian_objek_id', $rek_sub_rincian_objek->whereIn('rek_rincian_objek_id', $rek_rincian_objek->where('rek_objek_id', $_rek_objek->id)->pluck('id'))->pluck('id'))->sum('belanja_ls_sum_nilai') + $belanja_rka_pd->whereIn('rek_sub_rincian_objek_id', $rek_sub_rincian_objek->whereIn('rek_rincian_objek_id', $rek_rincian_objek->where('rek_objek_id', $_rek_objek->id)->pluck('id'))->pluck('id'))->sum('bukti_gu_sum_nilai');
                                    @endphp
                                    {{ number_format($jumlah_realisasi_per_objek, 2, ',', '.') }}</td>
                                <td style="text-align: right;">
                                    @if ($jumlah_nilai_per_objek > 0 && $jumlah_realisasi_per_objek > 0)
                                        {{ number_format(($jumlah_realisasi_per_objek / $jumlah_nilai_per_objek) * 100, 2, ',', '.') }}
                                    @elseif ($jumlah_nilai_per_objek <= 0 && $jumlah_realisasi_per_objek > 0)
                                        ~
                                    @else
                                        0,00
                                    @endif
                                </td>
                                <td style="text-align: right;">
                                    {{ number_format($jumlah_nilai_per_objek - $jumlah_realisasi_per_objek, 2, ',', '.') }}
                                </td>
                            </tr>
                            @foreach ($rek_rincian_objek->where('rek_objek_id', $_rek_objek->id)->all() as $_rek_rincian_objek)
                                @php
                                    $jumlah_nilai_per_rincian_objek = $belanja_rka_pd->whereIn('rek_sub_rincian_objek_id', $rek_sub_rincian_objek->whereIn('rek_rincian_objek_id', $_rek_rincian_objek->id)->pluck('id'))->sum('nilai');
                                    
                                @endphp
                                <tr class="font-weight-bold" style="background: #fafafa">
                                    <td>{{ $_rek_rincian_objek->kode_lengkap }}</td>
                                    <td>{{ $_rek_rincian_objek->nama }}</td>
                                    <td style="text-align: right;">
                                        {{ number_format($jumlah_nilai_per_rincian_objek, 2, ',', '.') }}
                                    </td>
                                    <td style="text-align: right;">
                                        @php
                                            $jumlah_realisasi_per_rincian_objek = $belanja_rka_pd->whereIn('rek_sub_rincian_objek_id', $rek_sub_rincian_objek->whereIn('rek_rincian_objek_id', $_rek_rincian_objek->id)->pluck('id'))->sum('belanja_ls_sum_nilai') + $belanja_rka_pd->whereIn('rek_sub_rincian_objek_id', $rek_sub_rincian_objek->whereIn('rek_rincian_objek_id', $_rek_rincian_objek->id)->pluck('id'))->sum('bukti_gu_sum_nilai');
                                        @endphp
                                        {{ number_format($jumlah_realisasi_per_rincian_objek, 2, ',', '.') }}</td>
                                    <td style="text-align: right;">
                                        @if ($jumlah_nilai_per_rincian_objek > 0 && $jumlah_realisasi_per_rincian_objek > 0)
                                            {{ number_format(($jumlah_realisasi_per_rincian_objek / $jumlah_nilai_per_rincian_objek) * 100, 2, ',', '.') }}
                                        @elseif ($jumlah_nilai_per_rincian_objek <= 0 && $jumlah_realisasi_per_rincian_objek > 0)
                                            ~
                                        @else
                                            0,00
                                        @endif
                                    </td>
                                    <td style="text-align: right;">
                                        {{ number_format($jumlah_nilai_per_rincian_objek - $jumlah_realisasi_per_rincian_objek, 2, ',', '.') }}
                                    </td>
                                </tr>
                                @foreach ($rek_sub_rincian_objek->where('rek_rincian_objek_id', $_rek_rincian_objek->id)->all() as $_rek_sub_rincian_objek)
                                    <tr style="background: #f5f5f5">
                                        <td
                                            rowspan="{{ $belanja_rka_pd->where('rek_sub_rincian_objek_id', $_rek_sub_rincian_objek->id)->count() + 1 }}">
                                            {{ $_rek_sub_rincian_objek->kode_lengkap }}</td>
                                        <td>{{ $_rek_sub_rincian_objek->nama }}</td>
                                        <td style="text-align: right;">
                                            @php
                                                $total_nilai_per_sub_rincian_objek = $belanja_rka_pd->where('rek_sub_rincian_objek_id', $_rek_sub_rincian_objek->id)->sum('nilai');
                                            @endphp
                                            {{ number_format($total_nilai_per_sub_rincian_objek, 2, ',', '.') }}
                                        </td>
                                        <td style="text-align: right;">
                                            @php
                                                $total_realisasi_per_sub_rincian_objek = $belanja_rka_pd->where('rek_sub_rincian_objek_id', $_rek_sub_rincian_objek->id)->sum('belanja_ls_sum_nilai') + $belanja_rka_pd->where('rek_sub_rincian_objek_id', $_rek_sub_rincian_objek->id)->sum('bukti_gu_sum_nilai');
                                            @endphp
                                            {{ number_format($total_realisasi_per_sub_rincian_objek, 2, ',', '.') }}
                                        </td>
                                        <td style="text-align: right;">
                                            @if ($total_nilai_per_sub_rincian_objek > 0 && $total_realisasi_per_sub_rincian_objek > 0)
                                                {{ number_format(($total_realisasi_per_sub_rincian_objek / $total_nilai_per_sub_rincian_objek) * 100, 2, ',', '.') }}
                                            @elseif ($total_nilai_per_sub_rincian_objek <= 0 && $total_realisasi_per_sub_rincian_objek > 0)
                                                ~
                                            @else
                                                0,00
                                            @endif
                                        </td>
                                        <td style="text-align: right;">
                                            {{ number_format($total_nilai_per_sub_rincian_objek - $total_realisasi_per_sub_rincian_objek, 2, ',', '.') }}
                                        </td>
                                        @php
                                            if ($_rek_akun->jenis == \App\Enums\Setup\JenisRekAkun::Belanja):
                                                $defisit_surplus = $defisit_surplus + $total_nilai_per_sub_rincian_objek;
                                                $realisasi_defisit_surplus = $realisasi_defisit_surplus + $total_realisasi_per_sub_rincian_objek;
                                            endif;
                                        @endphp
                                    </tr>
                                    @foreach ($belanja_rka_pd->where('rek_sub_rincian_objek_id', $_rek_sub_rincian_objek->id)->all() as $_belanja_rka_pd)
                                        <tr>
                                            <td>{{ $_belanja_rka_pd->uraian }}</td>
                                            <td style="text-align: right;">
                                                {{ number_format($_belanja_rka_pd->nilai, 2, ',', '.') }}</td>
                                            <td style="text-align: right;">
                                                {{ number_format($_belanja_rka_pd->belanja_ls_sum_nilai + $_belanja_rka_pd->bukti_gu_sum_nilai, 2, ',', '.') }}
                                            </td>
                                            <td style="text-align: right;">
                                                @if ($_belanja_rka_pd->nilai > 0)
                                                    {{ number_format((($_belanja_rka_pd->belanja_ls_sum_nilai + $_belanja_rka_pd->bukti_gu_sum_nilai) / $_belanja_rka_pd->nilai) * 100, 2, ',', '.') }}
                                                @elseif ($_belanja_rka_pd->nilai <= 0 && $_belanja_rka_pd->belanja_ls_sum_nilai + $_belanja_rka_pd->bukti_gu_sum_nilai > 0)
                                                    ~
                                                @else
                                                    0,00
                                                @endif
                                            </td>
                                            <td style="text-align: right;">
                                                {{ number_format($_belanja_rka_pd->nilai - ($_belanja_rka_pd->belanja_ls_sum_nilai + $_belanja_rka_pd->bukti_gu_sum_nilai), 2, ',', '.') }}
                                            </td>
                                        </tr>
                                    @endforeach
                                @endforeach
                            @endforeach
                        @endforeach
                    @endforeach
                @endforeach
            @endforeach
        </tbody>
        <tfoot class="bg-primary text-white">
            <tr>
                <th colspan="2" style="width: 15%; font-weight: bold; text-align: right;">JUMLAH
                </th>
                <th style="width: 20%; font-weight: bold; text-align: right;">
                    {{ number_format($defisit_surplus, 2, ',', '.') }}</th>
                <th style="width: 20%; font-weight: bold; text-align: right;">
                    {{ number_format($realisasi_defisit_surplus, 2, ',', '.') }}</th>
                <th style="width: 20%; font-weight: bold; text-align: right;">
                    {{ number_format(($realisasi_defisit_surplus / $defisit_surplus) * 100, 2, ',', '.') }}</th>
                <th style="width: 20%; font-weight: bold; text-align: right;">
                    {{ number_format($defisit_surplus - $realisasi_defisit_surplus, 2, ',', '.') }}</th>
            </tr>
        </tfoot>
    </table>
</div>

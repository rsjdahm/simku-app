<div class="container-fluid">
    <!-- start page title -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <h4>Dashboard</h4>

                <ol class="breadcrumb m-0">
                    <li class="breadcrumb-item">Dashboard</a></li>
                    <li class="breadcrumb-item active">Ringkasan</li>
                </ol>

            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-4">
            <div class="card mb-3">
                <div class="card-body">
                    <div class="media">
                        <div class="media-body">
                            <p class="text-muted font-weight-medium">Total Anggaran</p>
                            <h4 class="mb-0">Rp {{ number_format($sum_belanja_rka_pd, 2, ',', '.') }}</h4>
                        </div>

                        <div class="avatar-sm rounded-circle bg-primary align-self-center">
                            <span class="avatar-title rounded-circle bg-primary">

                                <i class="fas fa-copy font-size-24"></i>
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card mb-3">
                <div class="card-body">
                    <div class="media">
                        <div class="media-body">
                            <p class="text-muted font-weight-medium">Total Realisasi</p>
                            <h4 class="mb-0">Rp {{ number_format($sum_realisasi_belanja_rka_pd, 2, ',', '.') }}</h4>
                            <small class="font-weight-bold text-success">
                                {{ number_format(($sum_realisasi_belanja_rka_pd / $sum_belanja_rka_pd) * 100, 2, ',', '.') }}%
                            </small>
                            <ul>
                                <li>Triwulan I: Rp {{ number_format($sum_realisasi_belanja_rka_pd_tw1, 2, ',', '.') }}
                                </li>
                                <li>Triwulan II: Rp {{ number_format($sum_realisasi_belanja_rka_pd_tw2, 2, ',', '.') }}
                                </li>
                                <li>Triwulan III: Rp {{ number_format($sum_realisasi_belanja_rka_pd_tw3, 2, ',', '.') }}
                                </li>
                                <li>Triwulan IV: Rp {{ number_format($sum_realisasi_belanja_rka_pd_tw4, 2, ',', '.') }}
                                </li>
                            </ul>
                        </div>

                        <div class="avatar-sm rounded-circle bg-primary align-self-center mini-stat-icon">
                            <span class="avatar-title rounded-circle bg-primary">
                                <i class="fas fa-archive font-size-24"></i>
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card mb-3">
                <div class="card-body">
                    <div class="media">
                        <div class="media-body">
                            <p class="text-muted font-weight-medium">Sisa Anggaran</p>
                            <h4 class="mb-0">Rp
                                {{ number_format($sum_belanja_rka_pd - $sum_realisasi_belanja_rka_pd, 2, ',', '.') }}
                            </h4>
                            <small class="font-weight-bold text-danger">
                                {{ number_format((($sum_belanja_rka_pd - $sum_realisasi_belanja_rka_pd) / $sum_belanja_rka_pd) * 100, 2, ',', '.') }}%
                            </small>
                        </div>

                        <div class="avatar-sm rounded-circle bg-primary align-self-center mini-stat-icon">
                            <span class="avatar-title rounded-circle bg-primary">
                                <i class="fas fa-money-bill font-size-24"></i>
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    {{-- <div class="row">
        <div class="col-md-4">
            <div class="card mb-3">
                <div class="card-header">
                    <strong>Realisasi Rekening Belanja</strong>
                </div>
                <div class="card-body">
                    <canvas id="chart-belanja" width="400" height="400"></canvas>
                    <script>
                        var ctx = document.getElementById('chart-belanja').getContext('2d');
                        var myChart = new Chart(ctx, {
                            type: 'bar',
                            data: {
                                labels: [
                                    'Pegawai',
                                    'Barang dan Jasa',
                                    'Modal',
                                ],
                                datasets: [{
                                    label: '% Realisasi Belanja',
                                    data: [12, 19, 3, 5, 2, 3],
                                    backgroundColor: [
                                        'rgba(255, 99, 132, 0.2)',
                                        'rgba(54, 162, 235, 0.2)',
                                        'rgba(255, 206, 86, 0.2)',
                                    ],
                                    borderColor: [
                                        'rgba(255, 99, 132, 1)',
                                        'rgba(54, 162, 235, 1)',
                                        'rgba(255, 206, 86, 1)',
                                    ],
                                    borderWidth: 1
                                }]
                            },
                            options: {
                                scales: {
                                    yAxes: [{
                                        ticks: {
                                            beginAtZero: true
                                        }
                                    }]
                                }
                            }
                        });
                    </script>
                </div>
            </div>
        </div>
        <div class="col-md-8">
            <div class="card mb-3">
                <div class="card-header">
                    <strong>Realisasi Belanja Bulanan</strong>
                </div>
                <div class="card-body">
                    <canvas id="chart-belanja-bulanan" width="400" height="180"></canvas>
                    <script>
                        var ctx = document.getElementById('chart-belanja-bulanan').getContext('2d');
                        var myChart = new Chart(ctx, {
                            type: 'bar',
                            data: {
                                labels: [
                                    'Januari',
                                    'Februari',
                                    'Maret',
                                    'April',
                                    'Mei',
                                    'Juni',
                                    'Juli',
                                    'Agustus',
                                    'September',
                                    'Oktober',
                                    'November',
                                    'Desember',
                                ],
                                datasets: [{
                                        label: 'Pegawai',
                                        data: [1000000, 2000000, 3000000, 5000000, 2000000, 3000000, 9000000, 4000000, 5000000,
                                            10000000, 5000000, 6000000
                                        ],
                                        backgroundColor: [
                                            'rgba(255, 99, 132, 0.2)',
                                            'rgba(255, 99, 132, 0.2)',
                                            'rgba(255, 99, 132, 0.2)',
                                            'rgba(255, 99, 132, 0.2)',
                                            'rgba(255, 99, 132, 0.2)',
                                            'rgba(255, 99, 132, 0.2)',
                                            'rgba(255, 99, 132, 0.2)',
                                            'rgba(255, 99, 132, 0.2)',
                                            'rgba(255, 99, 132, 0.2)',
                                            'rgba(255, 99, 132, 0.2)',
                                            'rgba(255, 99, 132, 0.2)',
                                            'rgba(255, 99, 132, 0.2)',
                                        ],
                                        borderColor: [
                                            'rgba(255, 99, 132, 1)',
                                            'rgba(255, 99, 132, 1)',
                                            'rgba(255, 99, 132, 1)',
                                            'rgba(255, 99, 132, 1)',
                                            'rgba(255, 99, 132, 1)',
                                            'rgba(255, 99, 132, 1)',
                                            'rgba(255, 99, 132, 1)',
                                            'rgba(255, 99, 132, 1)',
                                            'rgba(255, 99, 132, 1)',
                                            'rgba(255, 99, 132, 1)',
                                            'rgba(255, 99, 132, 1)',
                                            'rgba(255, 99, 132, 1)',
                                        ],
                                        borderWidth: 1
                                    },
                                    {
                                        label: 'Barang dan Jasa',
                                        data: [2000000, 3000000, 1000000, 6000000, 3000000, 4000000, 1000000, 2000000, 4000000,
                                            9000000, 9000000, 2000000
                                        ],
                                        backgroundColor: [
                                            'rgba(54, 162, 235, 0.2)',
                                            'rgba(54, 162, 235, 0.2)',
                                            'rgba(54, 162, 235, 0.2)',
                                            'rgba(54, 162, 235, 0.2)',
                                            'rgba(54, 162, 235, 0.2)',
                                            'rgba(54, 162, 235, 0.2)',
                                            'rgba(54, 162, 235, 0.2)',
                                            'rgba(54, 162, 235, 0.2)',
                                            'rgba(54, 162, 235, 0.2)',
                                            'rgba(54, 162, 235, 0.2)',
                                            'rgba(54, 162, 235, 0.2)',
                                            'rgba(54, 162, 235, 0.2)',
                                        ],
                                        borderColor: [
                                            'rgba(54, 162, 235, 1)',
                                            'rgba(54, 162, 235, 1)',
                                            'rgba(54, 162, 235, 1)',
                                            'rgba(54, 162, 235, 1)',
                                            'rgba(54, 162, 235, 1)',
                                            'rgba(54, 162, 235, 1)',
                                            'rgba(54, 162, 235, 1)',
                                            'rgba(54, 162, 235, 1)',
                                            'rgba(54, 162, 235, 1)',
                                            'rgba(54, 162, 235, 1)',
                                            'rgba(54, 162, 235, 1)',
                                            'rgba(54, 162, 235, 1)',
                                        ],
                                        borderWidth: 1
                                    },
                                    {
                                        label: 'Modal',
                                        data: [6000000, 9000000, 9000000, 2000000, 3000000, 4000000, 2000000, 3000000, 1000000,
                                            1000000, 2000000, 4000000
                                        ],
                                        backgroundColor: [
                                            'rgba(255, 206, 86, 0.2)',
                                            'rgba(255, 206, 86, 0.2)',
                                            'rgba(255, 206, 86, 0.2)',
                                            'rgba(255, 206, 86, 0.2)',
                                            'rgba(255, 206, 86, 0.2)',
                                            'rgba(255, 206, 86, 0.2)',
                                            'rgba(255, 206, 86, 0.2)',
                                            'rgba(255, 206, 86, 0.2)',
                                            'rgba(255, 206, 86, 0.2)',
                                            'rgba(255, 206, 86, 0.2)',
                                            'rgba(255, 206, 86, 0.2)',
                                            'rgba(255, 206, 86, 0.2)',
                                        ],
                                        borderColor: [
                                            'rgba(255, 206, 86, 1)',
                                            'rgba(255, 206, 86, 1)',
                                            'rgba(255, 206, 86, 1)',
                                            'rgba(255, 206, 86, 1)',
                                            'rgba(255, 206, 86, 1)',
                                            'rgba(255, 206, 86, 1)',
                                            'rgba(255, 206, 86, 1)',
                                            'rgba(255, 206, 86, 1)',
                                            'rgba(255, 206, 86, 1)',
                                            'rgba(255, 206, 86, 1)',
                                            'rgba(255, 206, 86, 1)',
                                            'rgba(255, 206, 86, 1)',
                                        ],
                                        borderWidth: 1
                                    }
                                ]
                            },
                            options: {
                                scales: {
                                    yAxes: [{
                                        ticks: {
                                            beginAtZero: true
                                        }
                                    }]
                                }
                            }
                        });
                    </script>
                </div>
            </div>
        </div>
    </div> --}}
</div>

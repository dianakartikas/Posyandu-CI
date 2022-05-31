<?= $this->extend('templates/index'); ?>
<?= $this->section('dashboard'); ?>
<!-- Begin Page Content -->
<!-- tabel -->
<!-- Card Body -->
<?php if (empty($kegiatan)) { ?>
    -
<?php } else { ?>
    <center>
        <table class="bg-danger text-white shadow">
            <tr>
                <td>
                    <h1 id="Jam">
                </td>
                <td>
                    <h1 id="Menit">
                </td>
                <td>
                    <h1 id="Detik">
                </td>
            </tr>
        </table>
    </center>
    <div class="card-body row">
        <div class="col-8">
            <div class="card shadow mb-4">
                <div class="card-body">
                    <table class="table table-bordered">
                        <tr>
                            <th>Tanggal Hari Ini</th>
                            <td class="bg-primary text-white shadow">
                                : <?= date("d-m-Y", strtotime($kegiatan->tanggal)); ?>
                            </td>
                        </tr>
                        <tr>
                            <th>Nama Kegiatan</th>
                            <td class="bg-primary text-white shadow">
                                : <?= $kegiatan->nama; ?></td>
                        </tr>
                        <tr>
                            <th>Lokasi Kegiatan</th>
                            <td class="bg-primary text-white shadow">
                                : <?= $kegiatan->lokasi; ?></td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>







        <!-- Pie Chart -->

        <div class="col">

            <div class="card shadow mb-4">


                <!-- Card Header - Dropdown -->
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between ">
                    <h6 class="font-weight-bold text-warning">Nomor Antrian</h6>
                </div>
                <!-- Card Body -->
                <center>
                    <div class="card-body bg-warning text-white shadow">
                        <?php if (empty($tampilAntrian->id_kunjungan)) { ?>
                            <h2 style="font-size: 70px">-</h2>
                        <?php } else { ?>
                            <h2 style="font-size: 70px"><?= ($tampilAntrian->id_kunjungan) - ($reset->id_kunjungan); ?> </h2>
                        <?php } ?>
                    </div>
                </center>
            </div>
        </div>
        <div class="col">

            <div class="card shadow mb-4">

                <!-- Card Header - Dropdown -->
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between ">
                    <h6 class="font-weight-bold text-info ">Jumlah Kunjungan</h6>
                </div>
                <!-- Card Body -->
                <center>
                    <div class="card-body bg-info text-white shadow">

                        <h2 style="font-size: 70px"><?php echo $countKunjungan; ?></h2>
                        </span>

                    </div>
                </center>
            </div>
        </div>
    </div>



    <div class="card-body">
        <div class="card shadow mb-4">

            <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                <h6 class="m-0 font-weight-bold text-primary">Daftar Antrian</h6>

            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered table-sm" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr class="text-center">
                                <th>No Antrian</th>
                                <th colspan="2">Identitas Anak</th>
                                <th colspan="2">Identitas OrangTua</th>
                                <th>Berat Badan Lahir</th>
                                <th>panjang Badan Lahir</th>
                                <th>jenis Kelamin</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            foreach ($joinKunjungan as $row) : ?>
                                <tr class="text-center">
                                    <td>
                                        <?php if ($row['status'] == 'antri') { ?>
                                            <span class="card bg-warning text-white shadow"><?= $row['id_kunjungan'] - ($reset->id_kunjungan); ?>
                                            <?php } elseif ($row['status'] == 'proses') { ?>
                                                <span class="card bg-primary text-white shadow"><?= $row['id_kunjungan'] - ($reset->id_kunjungan); ?>
                                                <?php } elseif ($row['status'] == 'terlewat') { ?>
                                                    <span class="card bg-danger text-white shadow"><?= $row['id_kunjungan'] - ($reset->id_kunjungan); ?>
                                                    <?php } elseif ($row['status'] == 'periksa') { ?>
                                                        <span class="card bg-info text-white shadow"><?= $row['id_kunjungan'] - ($reset->id_kunjungan); ?>
                                                        <?php } elseif ($row['status'] == 'cekgizi') { ?>
                                                            <span class="card bg-info text-white shadow"><?= $row['id_kunjungan'] - ($reset->id_kunjungan); ?>
                                                            <?php } else {  ?>
                                                                <span class="card bg-success text-white shadow"><?= $row['id_kunjungan'] - ($reset->id_kunjungan); ?>
                                                                <?php } ?>
                                    </td>
                                    <td><img src="<?= base_url('/img/anak/' . $row['gambar_anak']); ?> " class="rounded-circle" width="50"></td>
                                    <td><?= $row['namaAnak']; ?> </td>
                                    <td><img src="<?= base_url('/img/' . $row['user_image']); ?> " class="rounded-circle" width="50"></td>
                                    <td><?= $row['fullname']; ?> </td>
                                    <td><?= $row['bb_lahir']; ?> </td>
                                    <td><?= $row['tb_lahir']; ?> </td>
                                    <td><?= $row['jenis_kelamin']; ?></td>
                                    <td>
                                        <?php if ($row['status'] == 'antri') { ?>
                                            <span class="card bg-warning text-white shadow"><?= $row['status']; ?>
                                            <?php } elseif ($row['status'] == 'proses') { ?>
                                                <span class="card bg-primary text-white shadow"><?= $row['status']; ?>
                                                <?php } elseif ($row['status'] == 'terlewat') { ?>
                                                    <span class="card bg-danger text-white shadow"><?= $row['status']; ?>
                                                    <?php } elseif ($row['status'] == 'periksa') { ?>
                                                        <span class="card bg-info text-white shadow"><?= $row['status']; ?>
                                                        <?php } elseif ($row['status'] == 'cekgizi') { ?>
                                                            <span class="card bg-info text-white shadow"><?= $row['status']; ?>
                                                            <?php } else {  ?>
                                                                <span class="card bg-success text-white shadow"><?= $row['status']; ?>
                                                                <?php } ?>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                        <tfoot>
                            <tr class="text-center">
                                <th>No Antrian</th>
                                <th colspan="2">Identitas Anak</th>
                                <th colspan="2">Identitas OrangTua</th>
                                <th>Berat Badan Lahir</th>
                                <th>panjang Badan Lahir</th>
                                <th>jenis Kelamin</th>
                                <th>Status</th>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </div>
<?php } ?>

<div class="card-body row">


    <!-- Area Chart -->
    <div class="col">
        <div class="card shadow mb-4">
            <!-- Card Header - Dropdown -->
            <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                <h6 class="m-0 font-weight-bold text-primary">Grafik Kunjungan</h6>

            </div>
            <!-- Card Body -->
            <div class="card-body">
                <div class="chart-area">
                    <canvas id="myLineChart"></canvas>
                </div>
            </div>
        </div>
    </div>

    <div class="col">
        <div class="card shadow mb-4">
            <!-- Card Header - Dropdown -->
            <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                <h6 class="m-0 font-weight-bold text-primary"> Status Gizi Anak</h6>

            </div>
            <div class="card-body">
                <div class="chart-bar">
                    <canvas id="myChart"></canvas>
                </div>
                <!-- Car
        d Body -->

            </div>
        </div>
    </div>
</div>
<?php if (empty($kegiatan)) { ?>
    -
<?php } else { ?>
    <?php
    if (isset($chart3)) {
        foreach ($chart3 as $data) {
            $totalantri[] = $data['totalantri'];
            $totalproses[] = $data['totalproses'];
            $totalterlewat[] = $data['totalterlewat'];
            $totalselesai[] = $data['totalselesai'];
        }
    } ?>

    <?php if (isset($chart3)) { ?>
        <script src="<?= base_url(); ?>/vendor/chart.js/Chart.min.js"></script>
        <script>
            var ctx = document.getElementById("myPieChart");
            var myPieChart = new Chart(ctx, {
                type: 'doughnut',
                data: {
                    labels: ["Dalam Antrian", "Dalam Proses", "Antrian Terlewat", "Selesai"],
                    datasets: [{
                        data: [<?php echo json_encode($totalantri); ?>, <?php echo json_encode($totalproses); ?>, <?php echo json_encode($totalterlewat); ?>, <?php echo json_encode($totalselesai); ?>],
                        backgroundColor: ['#e9ed18', '#4e73df', '#cc3636', '#12e62b'],
                        hoverBackgroundColor: ['#ecedbe', '#96aef2', '#f79e9e', '#adf7b6'],
                        hoverBorderColor: "rgba(234, 236, 244, 1)",
                    }],
                },
                options: {
                    maintainAspectRatio: false,
                    tooltips: {
                        backgroundColor: "rgb(255,255,255)",
                        bodyFontColor: "#858796",
                        borderColor: '#dddfeb',
                        borderWidth: 1,
                        xPadding: 15,
                        yPadding: 15,
                        displayColors: false,
                        caretPadding: 10,
                    },
                    legend: {
                        display: false
                    },
                    cutoutPercentage: 80,
                },
            });
        </script>
    <?php } ?>
<?php } ?>
<?php
if (isset($chart)) {
    foreach ($chart as $data) {
        // $created_at[] = date("d-m-Y", strtotime($data['created_at']));
        $bbsangatkurang[] = $data['bbsangatkurang'];
        $bbkurang[] = $data['bbkurang'];
        $bbnormal[] = $data['bbnormal'];
        $risikobblebih[] = $data['risikobblebih'];
        $sangatpendek[] = $data['sangatpendek'];
        $pendek[] = $data['pendek'];
        $normal[] = $data['normal'];
        $tinggi[] = $data['tinggi'];
        $giziburuk[] = $data['giziburuk'];
        $gizikurang[] = $data['gizikurang'];
        $gizibaik[] = $data['gizibaik'];
        $risikogizilebih[] = $data['risikogizilebih'];
        $obesitas[] = $data['obesitas'];
    }
} ?>
<?php if (isset($chart)) { ?>
    <script src="<?= base_url(); ?>/js/Chart.min.js"></script>
    <script>
        var ctx = document.getElementById("myChart");
        var myBarChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: ["BB Sangat Kurang", "BB Kurang", "BB Normal", "Risiko BB Lebih", "Sangat Pendek", "Pendek", "Normal", "Tinggi", "Gizi Buruk", "Gizi Kurang", "Gizi Baik", "Risiko Gizi Lebih", "Gizi Lebih", "Obesitas"],
                datasets: [{
                    label: "Status Gizi",


                    data: [<?php echo json_encode($bbsangatkurang); ?>,
                        <?php echo json_encode($bbkurang); ?>,
                        <?php echo json_encode($bbnormal); ?>,
                        <?php echo json_encode($risikobblebih); ?>,
                        <?php echo json_encode($sangatpendek); ?>,
                        <?php echo json_encode($pendek); ?>,
                        <?php echo json_encode($normal); ?>,
                        <?php echo json_encode($tinggi); ?>,
                        <?php echo json_encode($giziburuk); ?>,
                        <?php echo json_encode($gizikurang); ?>,
                        <?php echo json_encode($gizibaik); ?>,
                        <?php echo json_encode($risikogizilebih); ?>,
                        <?php echo json_encode($obesitas); ?>
                    ],
                    backgroundColor: [

                        'rgba(228, 33, 5, 1)',
                        'rgba(195, 228, 5, 1)',
                        'rgba(8, 255, 19, 1)',
                        'rgba(5, 27, 228, 1)',
                        'rgba(228, 33, 5, 1)',
                        'rgba(195, 228, 5, 1)',
                        'rgba(8, 255, 19, 1)',
                        'rgba(5, 27, 228, 1)',
                        'rgba(228, 33, 5, 1)',
                        'rgba(195, 228, 5, 1)',
                        'rgba(8, 255, 19, 1)',
                        'rgba(20, 189, 158, 1)',
                        'rgba(5, 27, 228, 1)',
                        'rgba(3, 26, 22, 1)'

                    ],
                    borderColor: [
                        'rgba(255, 255, 255, 1)',
                    ],
                    borderWidth: 1
                }],
            },
            options: {
                maintainAspectRatio: false,

                legend: {
                    display: false
                },

                layout: {
                    padding: {
                        left: 10,
                        right: 25,
                        top: 25,
                        bottom: 0
                    },


                },

                scales: {
                    yAxes: [{
                        ticks: {
                            beginZero: true
                        }
                    }]
                },
                scales: {
                    xAxes: [{
                        beginAtZero: true,
                        ticks: {
                            autoSkip: false
                        }
                    }]
                }
            }
        });
    </script>
<?php } ?>

<?php
if (isset($chart2)) {
    foreach ($chart2 as $data2) {

        $storelabel[] =  date("d-m-Y", strtotime($data2['tanggal']));
        $datatotal[] = $data2['totalKunjungan'];
    }
} ?>
<?php if (isset($chart2)) { ?>
    <script src="<?= base_url(); ?>/vendor/chart.js/Chart.min.js"></script>
    <script>
        var ctx = document.getElementById("myLineChart");
        var myLineChart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: <?php echo json_encode($storelabel); ?>,
                datasets: [{
                    label: "Grafik Kunjungan",
                    data: <?php echo json_encode($datatotal); ?>,
                    backgroundColor: [

                        'rgba(54, 162, 253, 0.2)',
                        'rgba(255, 206, 86, 0.2)',
                        'rgba(75, 192, 192, 0.2)',
                        'rgba(153, 255, 255, 0.2)',
                        'rgba(255, 159, 64, 0.2)',
                        'rgba(255, 99, 132, 1)',
                    ],
                    borderColor: [

                        'rgba(54, 162, 253, 1)',
                        'rgba(255, 206, 86, 1)',
                        'rgba(75, 192, 192, 1)',
                        'rgba(153, 255, 255, 1)',
                        'rgba(255, 159, 64, 1)',
                        'rgba(255, 99, 132, 1)',
                    ],

                    borderWidth: 1
                }]
            },
            options: {
                maintainAspectRatio: false,
                layout: {
                    padding: {
                        left: 10,
                        right: 25,
                        top: 25,
                        bottom: 0
                    }
                },
                scales: {
                    yAxes: [{
                        ticks: {
                            beginZero: true
                        }
                    }]
                }
            }
        });
    </script>

<?php } ?>
<script type="text/javascript">
    function WaktuKunjungan() {
        var t = setInterval("ubah_waktu();", 1000);
    }

    function ubah_waktu() {
        var d = new Date();
        var jam_sekarang = d.getHours();
        var menit_sekarang = d.getMinutes();
        var detik_sekarang = d.getSeconds();
        if (detik_sekarang < 10)
            detik_sekarang = ("0" + detik_sekarang).slice(-2);
        if (menit_sekarang < 10)
            menit_sekarang = ("0" + menit_sekarang).slice(-2);
        document.getElementById('Jam').innerHTML = jam_sekarang + ':';
        document.getElementById('Menit').innerHTML = menit_sekarang + ':';
        document.getElementById('Detik').innerHTML = detik_sekarang;
    }
    WaktuKunjungan();
</script>
<?= $this->endSection(); ?>
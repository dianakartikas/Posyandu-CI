<?= $this->extend('templates/user'); ?>
<?= $this->section('dashboard'); ?>

<div class="card-body row">


    <?php if (empty($tampilAntrian)) { ?>
        -
    <?php } else { ?>
        <div class="col">
            <a href="/kunjungan/LewatiAntrian/<?= $tampilAnakAntri->id_kunjungan; ?>" class="btn btn-danger btn-icon-split btn-lg">
                <span class="icon text-white-50">
                    <i class="fas fa-minus"></i>
                </span>
                <span class="text">Lewati Antrian</span>
            </a>
        </div>
        <div class="col">

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

        </div>
        <div class="col-auto">
            <a href="/kunjungan/AntrianSelanjutnya/<?= $tampilAnakAntri->id_kunjungan; ?>" class="btn btn-primary btn-icon-split btn-lg">
                <span class="icon text-white-50">
                    <i class="fas fa-plus"></i>
                </span>
                <span class="text">Antrian Selanjutnya</span>
            </a>
        </div>
</div>
<?php } ?>

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
                        <h2 style="font-size: 60px">-</h2>
                    <?php } else { ?>
                        <h2 style="font-size: 60px"><?= ($tampilAntrian->id_kunjungan) - ($reset->id_kunjungan); ?> </h2>
                    <?php } ?>
                </div>
            </center>
        </div>
    </div>
    <div class="col">
        <div class="card shadow mb-4">
            <!-- Card Header - Dropdown -->
            <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between ">
                <h6 class="font-weight-bold text-info ">Total Kunjungan</h6>
            </div>
            <!-- Card Body -->
            <center>
                <div class="card-body bg-info text-white shadow">

                    <h2 style="font-size: 60px"><?php echo $countKunjungan; ?></h2>
                    </span>

                </div>
            </center>
        </div>
    </div>
</div>
<div class="card-body">

    <div class="row">
        <!-- Pie Chart -->
        <div class="col">
            <div class="card shadow mb-4">

                <!-- Card Header - Dropdown -->
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <a class="btn btn-primary" href="<?= base_url('kunjungan/' . $kegiatan->id); ?>">
                        <i class="fa fa-plus-circle"></i> Tambah Antrian
                    </a>
                </div>
                <!-- Card Body -->
                <div class="card-body">
                    <div class="chart-pie pt-4 pb-2">
                        <canvas id="myPieChart"></canvas>
                    </div>
                    <div class="mt-4 text-center small">
                        <span class="mr-2">
                            <i class="fas fa-circle text-warning"></i> Dalam Antrian
                        </span>
                        <span class="mr-2">
                            <i class="fas fa-circle text-primary"></i> Dalam Proses
                        </span>
                        <span class="mr-2">
                            <i class="fas fa-circle text-danger"></i> Antrian Terlewat
                        </span>
                        <span class="mr-2">
                            <i class="fas fa-circle text-success"></i> Selasai
                        </span>
                    </div>
                </div>
            </div>
        </div>

        <?php if (empty($tampilAntrian)) { ?>
            -
        <?php } else { ?>
            <div class="col">

                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="font-weight-bold text-primary ">Data Anak</h6>
                        </button>
                    </div>
                    <center>
                        <img src="<?= base_url('/img/' . $tampilAnakAntri->user_image) ?>" class="rounded-circle" alt="..." width="100" height="100">
                        <img src="<?= base_url('/img/anak/' . $tampilAnakAntri->gambar_anak) ?>" class="rounded-circle" alt="..." width="100" height="100">

                    </center>
                    <div class="card-body">
                        <center>
                            <h5 class="card-title text-primary"><?= $tampilAnakAntri->namaAnak; ?></h5>
                        </center>
                        <p class="card-text">
                        <table class="table table-bordered">
                            <tr>
                                <th>Tanggal lahir</th>
                                <td class="bg-primary text-white shadow">
                                    : <?= date("d-m-Y", strtotime($tampilAnakAntri->tanggal_lahir)) ?>
                                </td>
                            </tr>
                            <tr>
                                <th>Jenis Kelamin</th>
                                <td class="bg-primary text-white shadow">
                                    :<?php if ($tampilAnakAntri->jenis_kelamin == 'L') { ?>
                                    Laki-Laki
                                <?php } else {
                                            ($tampilAnakAntri->jenis_kelamin == 'P') ?>
                                    Perempuan
                                <?php } ?>
                                </td>
                            </tr>
                            <tr>
                                <th>Berat Badan lahir</th>
                                <td class="bg-primary text-white shadow">
                                    : <?= $tampilAnakAntri->bb_lahir; ?> KG
                                </td>
                            </tr>
                            <tr>
                                <th>Panjang Badan lahir</th>
                                <td class="bg-primary text-white shadow">
                                    : <?= $tampilAnakAntri->tb_lahir; ?> CM
                                </td>
                            </tr>
                        </table>
                        </p>
                    </div>
                </div>
            </div>
    </div>
</div>

<?php } ?>
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




<?php
if (isset($chart)) {
    foreach ($chart as $data) {
        $totalantri[] = $data['totalantri'];
        $totalproses[] = $data['totalproses'];
        $totalterlewat[] = $data['totalterlewat'];
        $totalselesai[] = $data['totalselesai'];
    }
} ?>

<?php if (isset($chart)) { ?>
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
<?= $this->endSection(); ?>
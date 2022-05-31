<?= $this->extend('templates/index'); ?>
<?= $this->section('dashboard'); ?>
<div class="card-body">
    <div class="card shadow mb-4">
        <div class="card-body">
            <ul class="nav nav-tabs" id="myTab" role="tablist">
                <li class="nav-item">
                    <a class="nav-link active" id="proses-tab" data-toggle="tab" href="#proses" role="tab" aria-controls="proses" aria-selected="true">Antrian</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="terlewat-tab" data-toggle="tab" href="#terlewat" role="tab" aria-controls="terlewat" aria-selected="false">Terlewat</a>
                </li>
            </ul>
            <div class="tab-content" id="myTabContent">
                <div class="tab-pane fade show active" id="proses" role="tabpanel" aria-labelledby="proses-tab">
                    <div class="card shadow mb-4">
                        <!-- Card Header - Dropdown -->
                        <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                            <h6 class="m-0 font-weight-bold text-primary">Daftar Antrian Proses</h6>

                        </div>
                        <div class="card-body">
                            <div class="table-responsive" id="kunjungan">
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
                                            <th><i class="fas fa-mouse-pointer"></i> Aksi</th>

                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        foreach ($kunjungan as $row) : ?>
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
                                                                    <?php } else {  ?>
                                                                        <span class="card bg-success text-white shadow"><?= $row['status']; ?>
                                                                        <?php } ?>
                                                </td>
                                                <?php if ($row['status'] == 'proses' || $row['status'] == 'cekgizi') { ?>
                                                    <td>
                                                        <a class="btn btn-primary btn-icon-split btn-sm" href="<?= base_url('pertumbuhan/' . $row['id_kunjungan']); ?>">
                                                            <span class="icon text-white-50">
                                                                <i class="fas fa-mouse-pointer"></i>
                                                            </span>
                                                            <span class="text">Pilih</span>
                                                        </a>
                                                    </td>

                                                <?php } elseif ($row['status'] == 'periksa') { ?>

                                                    <td>
                                                        <button class="btn btn-warning btn-icon-split btn-sm" data-toggle="modal" data-target="#modalsimpan">
                                                            <span class="icon text-white-50">
                                                                <i class="fas fa-mouse-pointer"></i>
                                                            </span>
                                                            <span class="text">Periksa</span>
                                                            </a>
                                                    </td>
                                                    <!-- <td>
                                                        <a class="btn btn-warning btn-icon-split btn-sm" href=">">
                                                            <span class="icon text-white-50">
                                                                <i class="fas fa-check"></i>
                                                            </span>
                                                            <span class="text">Periksa</span>
                                                        </a>

                                                    </td> -->

                                                <?php } ?>

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
                                            <th><i class="fas fa-mouse-pointer"></i> Aksi</th>

                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>

                        <!-- khusus cekgizi -->
                        <div class="card-body">
                            <div class="table-responsive" id="kunjungan">
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
                                            <th><i class="fas fa-mouse-pointer"></i> Aksi</th>

                                        </tr>
                                    </thead>

                                    <tbody>
                                        <?php
                                        foreach ($hasilcek as $row) : ?>
                                            <tr class="text-center">
                                                <td>
                                                    <?php if ($row['status'] == 'antri') { ?>
                                                        <span class="card bg-warning text-white shadow"><?= $row['id_kunjungan']; ?>
                                                        <?php } elseif ($row['status'] == 'proses') { ?>
                                                            <span class="card bg-primary text-white shadow"><?= $row['id_kunjungan']; ?>
                                                            <?php } elseif ($row['status'] == 'terlewat') { ?>
                                                                <span class="card bg-danger text-white shadow"><?= $row['id_kunjungan']; ?>
                                                                <?php } elseif ($row['status'] == 'periksa') { ?>
                                                                    <span class="card bg-info text-white shadow"><?= $row['id_kunjungan']; ?>
                                                                    <?php } elseif ($row['status'] == 'cekgizi') { ?>
                                                                        <span class="card bg-info text-white shadow"><?= $row['id_kunjungan']; ?>
                                                                        <?php } else {  ?>
                                                                            <span class="card bg-success text-white shadow"><?= $row['id_kunjungan']; ?>
                                                                            <?php } ?>
                                                </td>
                                                <td><img src="<?= base_url('/img/anak/' . $row['gambar_anak']); ?> " class="rounded-circle" width="50"></td>
                                                <td><?= $row['namaAnak']; ?> </td>
                                                <td><img src="<?= base_url('/img/' . $row['user_image']); ?> " class="rounded-circle" width="50"></td>
                                                <td><?= $row['fullname']; ?> </td>
                                                <td><?= $row['berat_badan']; ?> </td>
                                                <td><?= $row['tinggi_badan']; ?> </td>
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
                                                                    <?php } else {  ?>
                                                                        <span class="card bg-success text-white shadow"><?= $row['status']; ?>
                                                                        <?php } ?>
                                                </td>
                                                <?php if ($row['status'] == 'proses' || $row['status'] == 'cekgizi') { ?>
                                                    <td>
                                                        <a class="btn btn-primary btn-icon-split btn-sm" href="<?= base_url('pertumbuhan/' . $row['id_kunjungan']); ?>">
                                                            <span class="icon text-white-50">
                                                                <i class="fas fa-mouse-pointer"></i>
                                                            </span>
                                                            <span class="text">Pilih</span>
                                                        </a>
                                                    </td>

                                                <?php } elseif ($row['status'] == 'periksa') { ?>
                                                    <td>
                                                        <button class="btn btn-warning btn-icon-split btn-sm" data-toggle="modal" data-target="#modalsimpan<?= $row['id_cek_pertumbuhan']; ?>">
                                                            <span class="icon text-white-50">
                                                                <i class="fas fa-check"></i>
                                                            </span>
                                                            <span class="text">Periksa</span>
                                                            </a>
                                                    </td>

                                                    <!-- <td>
                                                        <a class="btn btn-warning btn-icon-split btn-sm" href="<?= base_url('periksa/' . $row['id_cek_pertumbuhan']); ?>">
                                                            <span class="icon text-white-50">
                                                                <i class="fas fa-check"></i>
                                                            </span>
                                                            <span class="text">Periksa</span>
                                                        </a>
                                                    </td> -->
                                                    <!-- <td>
                                                        <a class="btn btn-warning btn-icon-split btn-sm" href=">">
                                                            <span class="icon text-white-50">
                                                                <i class="fas fa-check"></i>
                                                            </span>
                                                            <span class="text">Periksa</span>
                                                        </a>

                                                    </td> -->

                                                <?php } ?>

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
                                            <th><i class="fas fa-mouse-pointer"></i> Aksi</th>

                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="tab-pane fade" id="terlewat" role="tabpanel" aria-labelledby="terlewat-tab">
                    <div class="card shadow mb-4">
                        <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                            <h6 class="m-0 font-weight-bold text-primary">Daftar Antrian Terlewat</h6>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered table-sm" id="dataTable-Terlewat" width="100%" cellspacing="0">
                                    <thead>
                                        <tr class="text-center">
                                            <th>No Antrian</th>
                                            <th colspan="2">Identitas Anak</th>
                                            <th colspan="2">Identitas OrangTua</th>
                                            <th>Berat Badan Lahir</th>
                                            <th>panjang Badan Lahir</th>
                                            <th>jenis Kelamin</th>
                                            <th>Status</th>
                                            <th><i class="fas fa-mouse-pointer"></i> Aksi</th>

                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        foreach ($terlewat as $row) : ?>
                                            <tr class="text-center">
                                                <td>
                                                    <?php if ($row['status'] == 'antri') { ?>
                                                        <span class="card bg-warning text-white shadow"><?= $row['id_kunjungan']; ?>
                                                        <?php } elseif ($row['status'] == 'proses') { ?>
                                                            <span class="card bg-primary text-white shadow"><?= $row['id_kunjungan']; ?>
                                                            <?php } elseif ($row['status'] == 'terlewat') { ?>
                                                                <span class="card bg-danger text-white shadow"><?= $row['id_kunjungan']; ?>
                                                                <?php } else {  ?>
                                                                    <span class="card bg-success text-white shadow"><?= $row['id_kunjungan']; ?>
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
                                                                <?php } else {  ?>
                                                                    <span class="card bg-success text-white shadow"><?= $row['status']; ?>
                                                                    <?php } ?>
                                                </td>

                                                <td>
                                                    <a class="btn btn-primary btn-icon-split btn-sm" href="<?= base_url('pertumbuhan/' . $row['id_kunjungan']); ?>">
                                                        <span class="icon text-white-50">
                                                            <i class="fas fa-mouse-pointer"></i>
                                                        </span>
                                                        <span class="text">Pilih</span>
                                                    </a>
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
                                            <th><i class="fas fa-mouse-pointer"></i> Aksi</th>

                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php foreach ($hasilcek as $key) : ?>
    <div class="modal fade" id="modalsimpan<?= $key['id_cek_pertumbuhan']; ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Simpan Hasil Pemeriksaan <?= $key['namaAnak']; ?></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <?= csrf_field(); ?>
                    <form action="/cekPertumbuhan/hasil/<?= $key['id_cek_pertumbuhan']; ?>/<?= $key['id_kunjungan']; ?>" method="post">
                        <div class="row">
                            <div class="col-md-4">
                                <img src="<?= base_url('/img/anak/' . $key['gambar_anak']); ?>" class="card-img">
                            </div>
                            <input type="hidden" name="nama" id="nama" class="form-control" value="<?= $key['id_kunjungan']; ?>">
                            <div class="col-md-8">
                                <div class="form-group">
                                    <label for="nama">Nama</label>
                                    <input type="text" name="nama" id="nama" class="form-control" value="<?= $key['namaAnak']; ?>" readonly>
                                    <div class="invalid-feedback">
                                        <?= $validation->getError('nama'); ?>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="nama">Jenis Kelamin</label>
                                    <input type="text" name="jenis_kelamin" id="jenis_kelamin" class="form-control" value="<?= $key['jenis_kelamin']; ?>" readonly>
                                    <div class="invalid-feedback">
                                        <?= $validation->getError('jenis_kelamin'); ?>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="umur">Umur</label>
                                    <input type="text" name="umur" id="umur" class="form-control" value="<?= $key['umur']; ?> Bulan" readonly>
                                    <div class="invalid-feedback">
                                        <?= $validation->getError('umur'); ?>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-6">
                                        <div class="form-group">
                                            <label for="berat_badan">Berat badan</label>
                                            <input type="tect" name="berat_badan" id="berat_badan" class="form-control" value="<?= $key['berat_badan']; ?> Kg" readonly>
                                            <div class="invalid-feedback">
                                                <?= $validation->getError('berat_badan'); ?>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="form-group">
                                            <label for="tinggi_badan">Tinggi badan</label>
                                            <input type="text" name="tinggi_badan" id="tinggi_badan" class="form-control" value="<?= $key['tinggi_badan']; ?> Cm" readonly>
                                            <div class="invalid-feedback">
                                                <?= $validation->getError('tinggi_badan'); ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Perhitungan TBU Menurut Umur -->
                                <?php foreach ($bbu as $row) :  ?>
                                    <?php if (($key['umur'] == $row['umur']) && ($key['jenis_kelamin'] == $row['jenis_kelamin'])) {

                                        if ($key['berat_badan'] < $row['median']) {

                                            $nsbr = $row['median'] - $row['sdmin1'];
                                        } else {

                                            $nsbr = $row['sdplus1'] - $row['median'];
                                        }
                                        $key['hasil_bbu'] = (($key['berat_badan']  - $row['median']) / $nsbr);
                                    }
                                    if ($key['hasil_bbu'] < -3)

                                        $hasil = "BB Sangat Kurang";

                                    elseif ($key['hasil_bbu'] >= -3 && $key['hasil_bbu'] < -2)

                                        $hasil = "BB Kurang";

                                    elseif ($key['hasil_bbu'] >= -2 && $key['hasil_bbu']  <= 1)

                                        $hasil = "BB Normal";

                                    elseif ($key['hasil_bbu'] > 1)

                                        $hasil = "Risiko BB Lebih";

                                    ?>
                                <?php endforeach; ?>
                                <div class="form-group">
                                    <label for="tinggi_badan">Hasil Gizi /Berat Badan Umur</label>
                                    <input type="text" name="hasil_bbu" id="hasil_bbu" class="form-control" value="<?= $hasil; ?>" readonly>
                                    <div class="invalid-feedback">
                                        <?= $validation->getError('hasil_bbu'); ?>
                                    </div>
                                </div>
                                <!-- Perhitungan TB Menurut Umur-->
                                <?php foreach ($tbu as $row) :  ?>
                                    <?php if (($key['umur']  == $row['umur']) && ($key['jenis_kelamin'] == $row['jenis_kelamin'])) {

                                        if ($key['tinggi_badan'] < $row['median']) {

                                            $nsbr = $row['median'] - $row['sdmin1'];
                                        } else {

                                            $nsbr = $row['sdplus1'] - $row['median'];
                                        }
                                        $key['hasil_tbu']  = (($key['tinggi_badan'] - $row['median']) / $nsbr);
                                    }
                                    if ($key['hasil_tbu'] < -3)

                                        $hasil = "Sangat Pendek";

                                    elseif ($key['hasil_tbu'] >= -3 &&  $key['hasil_tbu'] < -2)

                                        $hasil = "Pendek";

                                    elseif ($key['hasil_tbu'] >= -2 &&  $key['hasil_tbu'] <= 3)

                                        $hasil = "Normal";

                                    elseif ($key['hasil_tbu'] > 3)

                                        $hasil = "Tinggi";
                                    ?>
                                <?php endforeach; ?>
                                <div class="form-group">
                                    <label for="tinggi_badan">Hasil Gizi /Tinggi Badan Umur</label>
                                    <input type="text" name="hasil_tbu" id="hasil_tbu" class="form-control" value="<?= $hasil; ?>" readonly>
                                    <div class="invalid-feedback">
                                        <?= $validation->getError('hasil_tbu'); ?>
                                    </div>
                                </div>
                                <!-- Perhitungan BB/TB -->
                                <?php foreach ($bbtb1 as $row) :  ?>
                                    <?php foreach ($bbtb2 as $row2) :  ?>
                                        <?php
                                        if ($key['umur'] <= 24) {
                                            if (($key['jenis_kelamin'] == $row['jenis_kelamin']) && ($key['tinggi_badan'] == $row['tinggi_badan'])) {

                                                if ($key['berat_badan'] < $row['median']) {

                                                    $nsbr = $row['median'] - $row['sdmin1'];
                                                } else {

                                                    $nsbr = $row['sdplus1'] - $row['median'];
                                                }
                                                $key['hasil_bbtb'] = (($key['berat_badan'] - $row['median']) / $nsbr);
                                            }
                                        } else {

                                            if (($key['jenis_kelamin'] == $row2['jenis_kelamin']) && ($key['tinggi_badan'] == $row2['tinggi_badan'])) {

                                                if ($key['berat_badan'] < $row2['median']) {

                                                    $nsbr = $row2['median'] - $row2['sdmin1'];
                                                } else {

                                                    $nsbr = $row2['sdplus1'] - $row2['median'];
                                                }
                                                $key['hasil_bbtb'] = (($key['berat_badan'] - $row2['median']) / $nsbr);
                                            }
                                        }
                                        if ($key['hasil_bbtb'] < -3)

                                            $hasil = "Gizi Buruk";

                                        elseif ($key['hasil_bbtb'] >= -3 && $key['hasil_bbtb'] < -2)

                                            $hasil = "Gizi Kurang";

                                        elseif ($key['hasil_bbtb'] >= -2 && $key['hasil_bbtb'] <= 1)

                                            $hasil = "Gizi Baik";

                                        elseif ($key['hasil_bbtb'] > 1 && $key['hasil_bbtb'] <= 2)

                                            $hasil = "Berisiko Gizi Lebih";

                                        elseif ($key['hasil_bbtb'] > 2 && $key['hasil_bbtb'] <= 3)

                                            $hasil = "Gizi Lebih";

                                        elseif ($key['hasil_bbtb'] > 3)

                                            $hasil = "Obesitas";
                                        ?>
                                    <?php endforeach; ?>
                                <?php endforeach; ?>
                                <div class="form-group">
                                    <label for="hasil_bbtb">Hasil Gizi /Berat Badan Tinggi Badan</label>
                                    <input type="text" name="hasil_bbtb" id="hasil_bbtb" class="form-control" value="<?= $hasil; ?>" readonly>
                                    <div class="invalid-feedback">
                                        <?= $validation->getError('hasil_bbtb'); ?>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="nama">Catatan</label>
                                    <textarea type="text" name="catatan" id="catatan" class="form-control" value="<?= (old('catatan')); ?>"></textarea>
                                    <div class="invalid-feedback">
                                        <?= $validation->getError('catatan'); ?>
                                    </div>
                                </div>
                                <div class="footer" style=" float: right;">
                                    <a type="button" class="btn btn-secondary" href="/pertumbuhan">Kembali</a>
                                    <button type="submit" class="btn btn-primary">Simpan</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
<?php endforeach; ?>
<script>
    $(document).ready(function() {
        $('#dataTable-Terlewat').DataTable({
            responsive: true
        });
    });
    $("div.id_100 select").val("val2").change();
</script>
<?= $this->endSection(); ?>
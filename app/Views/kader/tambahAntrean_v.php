<?= $this->extend('templates/index'); ?>
<?= $this->section('dashboard'); ?>
<div class="card-body">
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

<div class="card-body">

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <a class="btn btn-primary" href="<?= base_url('kunjungan'); ?>">
                <i class="fa fa-plus-circle"></i> Kembali ke Antrean
            </a>
        </div>

        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr class="text-center">
                            <th colspan="2">Identitas Anak</th>
                            <th colspan="2">Identitas OrangTua</th>
                            <th>Jenis Kelamin</th>
                            <th>Tanggal Lahir</th>
                            <th>Berat Badan lahir</th>
                            <th>Panjang Badan lahir</th>
                            <th><i class="fas fa-mouse-pointer"></i> Pilih</th>
                        </tr>
                    </thead>
                    <tbody>


                        <?php

                        foreach ($joinAntrian as $row) : ?>

                            <tr class="text-center">
                                <td><img src="<?= base_url('/img/anak/' . $row['gambar_anak']); ?> " width="50" height="50"></td>
                                <td><?= $row['namaAnak']; ?></td>
                                <td><img src="<?= base_url('/img/' . $row['user_image']); ?> " width="50" height="50"></td>
                                <td><?= $row['fullname']; ?></td>
                                <td><?= $row['jenis_kelamin']; ?></td>
                                <td><?= date("d-m-Y", strtotime($row['tanggal_lahir'])); ?></td>
                                <td><?= $row['bb_lahir']; ?></td>
                                <td><?= $row['tb_lahir']; ?></td>
                                <td>
                                    <button class="btn btn-primary btn btn-sm" data-toggle="modal" data-target="#modalPilih<?= $row['id_kms']; ?>">Pilih
                                    </button>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                    <tfoot>
                        <tr class="text-center">
                            <th colspan="2">Identitas Anak</th>
                            <th colspan="2">Identitas OrangTua</th>
                            <th>Jenis Kelamin</th>
                            <th>Tanggal Lahir</th>
                            <th>Berat Badan lahir</th>
                            <th>Panjang Badan lahir</th>
                            <th><i class="fas fa-mouse-pointer"></i> Pilih</th>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>
</div>

<?php
foreach ($joinAntrian as $row) : ?>
    <div class="modal fade" id="modalPilih<?= $row['id_kms']; ?>" tabindex=" -1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Pilih <?= $row['namaAnak']; ?></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="/kunjungan/pilih/<?= $kegiatan->id; ?>" method="post">
                        <?= csrf_field(); ?>
                        <div class="card-body">
                            <div class="form-group">
                                <input type="hidden" name="id_kms" id="id_kms" class="form-control" value="<?= $row['id_kms']; ?>">
                                <div class="invalid-feedback">
                                </div>
                            </div>
                            <?php
                            $arr = array($kegiatan->id, $row['id_kms']);
                            $kode =  implode(" ", $arr);
                            ?>
                            <?php
                            foreach ($kunjungan as $row) : ?>
                                <div class="form-group">
                                    <input type="hidden" name="kode" id="kode" class="form-control<?= ($validation->hasError('kode')) ? ' is-invalid' : '' ?>" value="<?= $kode; ?>">
                                    <div class=" invalid-feedback">
                                        <?= $validation->getError('kode'); ?>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                            <div class="form-group">
                                <label for="">Anda yakin memlilih data ini? </label>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                            <button type="submit" class="btn btn-primary">Tambah</button>
                        </div>
                </div>
                </form>
            </div>
        </div>
    </div>
    </div>
<?php endforeach; ?>
<?= $this->endSection(); ?>
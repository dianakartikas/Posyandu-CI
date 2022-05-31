<?= $this->extend('templates/user'); ?>
<?= $this->section('dashboard'); ?>
<div class="card-body">

    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#formPilihAntri">
                <i class="fa fa-plus-circle"></i> Ambil Nomor Antrian
            </button>

        </div>

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
<div class="modal fade" id="formPilihAntri" tabindex="-1" aria-labelledby="exampleModalLabel" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title text-primary" id="exampleModalLabel">Tambah Anak</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <div class="modal-body">
                <?= csrf_field(); ?>
                <div class="table-responsive">
                    <table class="table table-bordered table-sm" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr class="text-center">
                                <th>gambar</th>
                                <th>Nama</th>
                                <th>Jenis Kelamin</th>
                                <th>Tanggal Lahir</th>

                                <th><i class="fas fa-mouse-pointer"></i> Pilih</th>
                            </tr>
                        </thead>
                        <tfoot>
                            <tr class="text-center">
                                <th>gambar</th>
                                <th>Nama</th>
                                <th>Jenis Kelamin</th>
                                <th>Tanggal Lahir</th>

                                <th><i class="fas fa-mouse-pointer"></i> Pilih</th>
                            </tr>
                        </tfoot>
                        <tbody>
                            <?php
                            foreach ($joinKMS as $row) : ?>
                                <tr class="text-center">
                                    <td><img src="<?= base_url('/img/anak/' . $row['gambar_anak']); ?> " width="50"></td>
                                    <td><?= $row['nama']; ?></td>
                                    <td><?= $row['jenis_kelamin']; ?></td>
                                    <td><?= date("d-m-Y", strtotime($row['tanggal_lahir'])); ?></td>


                                    <td>
                                        <button class="btn btn-primary btn btn-sm" data-toggle="modal" data-target="#modalPilih<?= $row['id_kms']; ?>">Pilih
                                        </button>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<?php foreach ($joinAntrian as $row) : ?>
    <div class=" modal fade" id="modalPilih<?= $row['id_kms']; ?>" tabindex=" -1" aria-labelledby="exampleModalLabel" aria-hidden="true">
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

<div class="card-body">
    <div class="card shadow mb-4">
        <div class="card-body">
            <ul class="nav nav-tabs" id="myTab" role="tablist">
                <li class="nav-item">
                    <a class="nav-link active" id="imunisasi-tab" data-toggle="tab" href="#imunisasi" role="tab" aria-controls="imunisasi" aria-selected="true">Imunisasi</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="pertumbuhan-tab" data-toggle="tab" href="#pertumbuhan" role="tab" aria-controls="pertumbuhan" aria-selected="false">Pertumbuhan</a>
                </li>
            </ul>
            <div class="tab-content" id="myTabContent">
                <div class="tab-pane fade show active" id="imunisasi" role="tabpanel" aria-labelledby="imunisasi-tab">
                    <div class="card shadow mb-4">
                        <!-- Card Header - Dropdown -->
                        <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                            <h6 class="m-0 font-weight-bold text-primary">Daftar Pemeriksaan Imunisasi</h6>

                        </div>
                        <div class="card-body">
                            <div class="table-responsive" id="imunisasi">
                                <table class="table table-bordered table-sm" id="dataTable" width="100%" cellspacing="0">
                                    <thead>
                                        <tr class="text-center">
                                            <th>Gambar Anak</th>
                                            <th>nama Anak</th>
                                            <th>Jenis Kelamin</th>
                                            <th>Umur</th>
                                            <th>Tanggal Cek</th>
                                            <th>Nama Imunisasi</th>
                                            <th>catatan</th>


                                        </tr>
                                    </thead>

                                    <tbody>

                                        <?php foreach ($dataImunisasi as $row) : ?>
                                            <tr class="text-center">
                                                <td><img src="<?= base_url('/img/anak/' . $row['gambar_anak']); ?> " width="50"></td>
                                                <td><?= $row['namaAnak']; ?></td>
                                                <td><?= $row['jenis_kelamin']; ?></td>
                                                <td><?= $row['umur']; ?></td>
                                                <td><span class="badge badge-primary btn-large"><?= date("d-m-Y", strtotime($row['tanggal'])); ?></span></td>
                                                <td><?= $row['namaImunisasi']; ?></td>
                                                <td><?= $row['catatan']; ?></td>
                                            </tr>
                                        <?php endforeach; ?>

                                    </tbody>

                                    <tfoot>
                                        <tr class="text-center">
                                            <th>Gambar Anak</th>
                                            <th>nama Anak</th>
                                            <th>Jenis Kelamin</th>
                                            <th>Umur</th>
                                            <th>Tanggal Cek</th>
                                            <th>Nama Imunisasi</th>
                                            <th>catatan</th>

                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="tab-pane fade" id="pertumbuhan" role="tabpanel" aria-labelledby="pertumbuhan-tab">
                    <div class="card shadow mb-4">
                        <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                            <h6 class="m-0 font-weight-bold text-primary">Daftar Pemeriksaan Pertumbuhan</h6>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered table-sm" id="dataTable-Terlewat" width="100%" cellspacing="0">
                                    <thead>
                                        <tr class="text-center">
                                            <th>Gambar Anak</th>
                                            <th>Nama Anak</th>
                                            <th>Jenis Kelamin</th>
                                            <th>Umur</th>
                                            <th>Tanggal Cek</th>
                                            <th>Berat Badan</th>
                                            <th>Tinggi Badan</th>
                                            <th>Hasil BB/U</th>
                                            <th>Hasil TB/U</th>
                                            <th>Hasil BB/TB</th>
                                            <th>Catatan</th>
                                        </tr>
                                    </thead>
                                    <?php foreach ($dataPertumbuhan as $row) : ?>
                                        <tbody>
                                            <tr class="text-center">
                                                <td><img src="<?= base_url('/img/anak/' . $row['gambar_anak']); ?> " width="50"></td>
                                                <td><?= $row['namaAnak']; ?></td>
                                                <td><?= $row['jenis_kelamin']; ?></td>
                                                <td><?= $row['umur']; ?></td>
                                                <td> <span class="badge badge-primary btn-large"><?= date("d-m-Y", strtotime($row['tanggal'])); ?></span></td>
                                                <td><?= $row['berat_badan']; ?> KG</td>
                                                <td><?= $row['tinggi_badan']; ?> CM</td>
                                                <td><?= $row['hasil_bbu']; ?></td>
                                                <td><?= $row['hasil_tbu']; ?></td>
                                                <td><?= $row['hasil_bbtb']; ?></td>
                                                <td><?= $row['catatan']; ?></td>
                                            </tr>
                                        </tbody>

                                    <?php endforeach; ?>
                                    <tfoot>
                                        <tr class="text-center">
                                            <th>Gambar Anak</th>
                                            <th>Nama Anak</th>
                                            <th>Jenis Kelamin</th>
                                            <th>Umur</th>
                                            <th>Tanggal Cek</th>
                                            <th>Berat Badan</th>
                                            <th>Tinggi Badan</th>
                                            <th colspan="3">Hasil</th>
                                            <th>Catatan</th>
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

<script>
    $(document).ready(function() {
        $('#dataTable-Terlewat').DataTable({
            responsive: true
        });
    });
    $("div.id_100 select").val("val2").change();
</script>

<?= $this->endSection(); ?>
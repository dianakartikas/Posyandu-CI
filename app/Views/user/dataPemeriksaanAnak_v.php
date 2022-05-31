<?= $this->extend('templates/user'); ?>
<?= $this->section('dashboard'); ?>
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
<?= $this->endSection(); ?>
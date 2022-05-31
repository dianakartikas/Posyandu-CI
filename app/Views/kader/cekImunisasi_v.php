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
                                            <th><i class="fas fa-mouse-pointer"></i> Pilih</th>
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
                                                <?php if ($row['status'] == 'proses') { ?>
                                                    <td>
                                                        <a class="btn btn-primary btn-icon-split btn-sm" href="<?= base_url('cekimunisasi/' . $row['id_kunjungan']); ?>">
                                                            <span class="icon text-white-50">
                                                                <i class="fas fa-mouse-pointer"></i>
                                                            </span>
                                                            <span class="text">Pilih</span>
                                                        </a>
                                                    </td>
                                                <?php } elseif ($row['status'] == 'cekgizi') { ?>
                                                    <td>
                                                        <a class="btn btn-warning btn-icon-split btn-sm" href="/pertumbuhan">
                                                            <span class="icon text-white-50">
                                                                <i class="fas fa-arrow-up"></i>
                                                            </span>
                                                            <span class="text">Cek</span>
                                                        </a>
                                                    </td>
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
                                            <th><i class="fas fa-mouse-pointer"></i> Pilih</th>
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
                                            <th><i class="fas fa-mouse-pointer"></i> Pilih</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        foreach ($terlewat as $row) : ?>
                                            <tr class="text-center">
                                                <td>
                                                    <?php if ($row['status'] == 'antri') { ?>
                                                        <span class="card bg-warning text-white shadow"><?= $row['id_kunjungan'] - ($reset->id_kunjungan); ?>
                                                        <?php } elseif ($row['status'] == 'proses') { ?>
                                                            <span class="card bg-primary text-white shadow"><?= $row['id_kunjungan'] - ($reset->id_kunjungan); ?>
                                                            <?php } elseif ($row['status'] == 'terlewat') { ?>
                                                                <span class="card bg-danger text-white shadow"><?= $row['id_kunjungan'] - ($reset->id_kunjungan); ?>
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
                                                                <?php } else {  ?>
                                                                    <span class="card bg-success text-white shadow"><?= $row['status']; ?>
                                                                    <?php } ?>
                                                </td>
                                                <td>
                                                    <a class="btn btn-primary btn-icon-split btn-sm" href="<?= base_url('cekimunisasi/' . $row['id_kunjungan']); ?>">
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
                                            <th><i class="fas fa-mouse-pointer"></i> Pilih</th>
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
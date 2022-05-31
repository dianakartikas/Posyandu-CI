<?= $this->extend('templates/index'); ?>
<?= $this->section('dashboard'); ?>
<!-- Begin Page Content -->
<!-- tabel -->
<div class="card-body">
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#formTambahKms">
                <i class="fa fa-plus-circle"></i> Tambah KMS
            </button>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-sm" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr class="text-center">
                            <th>No</th>
                            <th>Nama Anak</th>
                            <th>Berat badan Lahir</th>
                            <th>Panjang badan lahir</th>
                            <th>Detail</th>
                            <th>
                                <i class="fas fa-cogs"></i> Aksi
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php

                        $nomor = 1;

                        foreach ($kms as $row) :

                        ?>
                            <tr class="text-center">
                                <td><?= $nomor++ ?></td>
                                <td><?= $row['nama'] ?></td>
                                <td><?= $row['bb_lahir'] ?> KG</td>
                                <td><?= $row['tb_lahir'] ?> CM</td>
                                <td>
                                    <a href="<?= base_url('kms/' . $row['id']); ?>" class="btn btn-info btn-sm">detail</a>
                                </td>
                                <td>
                                    <button class="btn btn-warning btn-circle btn-sm" data-toggle="modal" data-target="#modaledit<?= $row['id']; ?>">
                                        <i class="fas fa-pencil-alt"></i>
                                    </button>

                                    <button class="btn btn-danger btn-circle btn-sm confirm_del_btn" value="<?= $row['id'] ?>"><i class="fas fa-trash"></i></button>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                    <tfoot>
                        <tr class="text-center">
                            <th>No</th>
                            <th>Nama Anak</th>
                            <th>Berat badan Lahir</th>
                            <th>Panjang badan lahir</th>
                            <th>Detail</th>
                            <th>
                                <i class="fas fa-cogs"></i> Aksi
                            </th>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="formTambahKms" tabindex="-1" aria-labelledby="exampleModalLabel" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Tambah Anak</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-sm" id="dataTable-anak" width="100%" cellspacing="0">
                            <thead>
                                <tr class="text-center">
                                    <th>No.</th>
                                    <th>gambar</th>
                                    <th>Nama</th>
                                    <th>P/L</th>
                                    <th>Tanggal Lahir</th>
                                    <th><i class="fas fa-cogs"></i> Edit</th>
                                </tr>
                            </thead>
                            <tfoot>
                                <tr class="text-center">
                                    <th>No.</th>
                                    <th>gambar</th>
                                    <th>Nama</th>
                                    <th>P/L</th>
                                    <th>Tanggal Lahir</th>
                                    <th><i class="fas fa-cogs"></i> Edit</th>
                                </tr>
                            </tfoot>
                            <tbody>
                                <?php
                                $nomor = 1;
                                foreach ($nonkms as $row) : ?>
                                    <tr class="text-center">
                                        <td><?= $nomor++ ?></td>
                                        <td><img src="<?= base_url('/img/anak/' . $row['gambar_anak']); ?> " width="50"></td>
                                        <td><?= $row['nama']; ?></td>
                                        <td><?= $row['jenis_kelamin']; ?></td>
                                        <td><?= date("d-m-Y", strtotime($row['tanggal_lahir'])); ?></td>
                                        <td>
                                            <button class="btn btn-primary btn btn-sm" data-toggle="modal" data-target="#modalPilih<?= $row['id_anak']; ?>">Pilih
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
</div>
<?php foreach ($nonkms as $row) : ?>
    <div class=" modal fade" id="modalPilih<?= $row['id_anak']; ?>" tabindex=" -1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Pilih <?= $row['nama']; ?></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="kms/save/<?= $row['id_anak']; ?>" method="post">
                    <div class="modal-body">
                        <?= csrf_field(); ?>
                        <div class="modal-body">
                            <div class="form-group">
                                <label for="">Nama Anak</label>
                                <input type="text" name="nama" id="nama" class="form-control" value="<?= $row['nama']; ?>" readonly>
                                <div class="invalid-feedback">
                                    <?= $validation->getError('id_anak'); ?>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="">Berat Badan Lahir</label>
                                <input type="text" class="form-control<?= ($validation->hasError('bb_lahir')) ? ' is-invalid' : '' ?>" value="<?= old('bb_lahir'); ?>" name="bb_lahir" id="bb_lahir" placeholder="Berat Badan Lahir (kg)">
                                <div class="invalid-feedback">
                                    <?= $validation->getError('bb_lahir'); ?>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="">Panjang Badan Lahir</label>
                                <input type="text" class="form-control<?= ($validation->hasError('tb_lahir')) ? ' is-invalid' : '' ?>" value="<?= old('tb_lahir'); ?>" name="tb_lahir" id="tb_lahir" placeholder="Panjang Badan Lahir (cm)">
                                <div class="invalid-feedback">
                                    <?= $validation->getError('tb_lahir'); ?>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                                <button type="submit" class="btn btn-primary">Simpan</button>
                            </div>
                        </div>
                    </div>
            </div>
            </form>
        </div>
    </div>
<?php endforeach; ?>



<?php foreach ($kms as $row) : ?>
    <div class="modal fade" id="modaledit<?= $row['id']; ?>" tabindex="-1" aria-labelledby="modaleditLabel" role="dialog" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modaleditLabel">Edit KMS <?= $row['nama']; ?></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <?= csrf_field(); ?>
                <form action="kms/update/<?= $row['id']; ?>">
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="nama">Nama</label>
                            <input type="text" name="nama" id="nama" class="form-control" value="<?= $row['nama']; ?>" readonly>
                        </div>
                        <div class="form-group">
                            <label for="bb_lahir">Berat Badan Lahir (KG)</label>
                            <input type="text" name="bb_lahir" id="bb_lahir" class="form-control<?= ($validation->hasError('bb_lahir')) ? ' is-invalid' : '' ?>" value="<?= (old('bb_lahir')) ? old('bb_lahir') :  $row['bb_lahir']; ?>">
                            <div class="invalid-feedback">
                                <?= $validation->getError('bb_lahir'); ?>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="tb_lahir">Panjang Badan Lahir (CM)</label>
                            <input type="text" name="tb_lahir" id="tb_lahir" class="form-control<?= ($validation->hasError('tb_lahir')) ? ' is-invalid' : '' ?>" value="<?= (old('tb_lahir')) ? old('tb_lahir') : $row['tb_lahir']; ?>">
                            <div class="invalid-feedback">
                                <?= $validation->getError('tb_lahir'); ?>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                            <button type="submit" class="btn btn-primary">Perbarui</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
<?php endforeach; ?>
<script>
    $(document).ready(function() {
        $('.dataTable').on("click", ".confirm_del_btn", function(e) {
            e.preventDefault();
            var id = $(this).val();
            swal.fire({
                    title: "Apakah Anda Yakin?",
                    text: "Data tidak dapat dipulihkan setelah dihapus",
                    icon: "warning",
                    button: true,
                    dangerMode: true,
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'iya, hapus!'
                })
                .then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: "kms/confirmdelete/" + id,
                            success: function(response) {
                                swal.fire({
                                    title: response.status,
                                    text: response.status_text,
                                    icon: response.status_icon,
                                    button: "ok",
                                }).then(function() {
                                    window.location.reload();



                                });
                            }
                        });
                    } else {
                        swal.fire("data tidak jadi dihapus");
                    }
                });
        });
    });
</script>
<script>
    $(document).ready(function() {
        $('#dataTable-anak').DataTable({
            responsive: true
        });
    });
    $("div.id_100 select").val("val2").change();
</script>


<?= $this->endSection(); ?>
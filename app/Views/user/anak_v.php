<?= $this->extend('templates/user'); ?>
<?= $this->section('dashboard'); ?>

<!-- Begin Page Content -->

<!-- Detail Page-->

<!-- Tambah Antrian -->

<div class="card-body">
    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#formTambahAnak">
                <i class="fa fa-plus-circle"></i> Tambah Anak
            </button>
        </div>
        <div class="card-body">
            <ul class="nav nav-tabs" id="myTab" role="tablist">
                <li class="nav-item">
                    <a class="nav-link active" id="kms-tab" data-toggle="tab" href="#kms" role="tab" aria-controls="kms" aria-selected="true">Anak KMS</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="non-tab" data-toggle="tab" href="#non" role="tab" aria-controls="non" aria-selected="false">Anak Non KMS</a>
                </li>
            </ul>
            <div class="tab-content" id="myTabContent">
                <div class="tab-pane fade show active" id="kms" role="tabpanel" aria-labelledby="kms-tab">
                    <div class="card shadow mb-4">
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered table-sm" id="dataTable" width="100%" cellspacing="0">
                                    <thead>
                                        <tr class="text-center">
                                            <th>gambar</th>
                                            <th>Nama</th>
                                            <th>Jenis Kelamin</th>
                                            <th>Tanggal Lahir</th>
                                            <th><i class="fas fa-cogs"></i> Edit</th>
                                        </tr>
                                    </thead>
                                    <tfoot>
                                        <tr class="text-center">
                                            <th>gambar</th>
                                            <th>Nama</th>
                                            <th>Jenis Kelamin</th>
                                            <th>Tanggal Lahir</th>

                                            <th><i class="fas fa-cogs"></i> Edit</th>
                                        </tr>
                                    </tfoot>
                                    <tbody>
                                        <?php
                                        foreach ($anakKMS as $row) : ?>
                                            <tr class="text-center">
                                                <td><img src="<?= base_url('/img/anak/' . $row['gambar_anak']); ?> " width="50"></td>
                                                <td><?= $row['nama']; ?></td>
                                                <td><?= $row['jenis_kelamin']; ?></td>
                                                <td><?= date("d-m-Y", strtotime($row['tanggal_lahir'])); ?></td>

                                                <td>
                                                    <button class="btn btn-warning btn-circle btn-sm" data-toggle="modal" data-target="#formModalEditAnak<?= $row['id_anak'] ?>">
                                                        <i class="fas fa-pencil-alt"></i>
                                                    </button>
                                                    <button class="btn btn-danger btn-circle btn-sm" onclick="hapus('<?= $row['id_anak']; ?>')"> <i class="fas fa-trash"></i></button>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="tab-pane fade show" id="non" role="tabpanel" aria-labelledby="non-tab">
                    <div class="card shadow mb-4">
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered table-sm" id="dataTable-nonkms" width="100%" cellspacing="0">
                                    <thead>
                                        <tr class="text-center">
                                            <th>gambar</th>
                                            <th>Nama</th>
                                            <th>Jenis Kelamin</th>
                                            <th>Tanggal Lahir</th>
                                            <th><i class="fas fa-cogs"></i> Edit</th>
                                        </tr>
                                    </thead>
                                    <tfoot>
                                        <tr class="text-center">
                                            <th>gambar</th>
                                            <th>Nama</th>
                                            <th>Jenis Kelamin</th>
                                            <th>Tanggal Lahir</th>
                                            <th><i class="fas fa-cogs"></i> Edit</th>
                                        </tr>
                                    </tfoot>
                                    <tbody>
                                        <?php

                                        foreach ($anakNonKMS as $row) : ?>
                                            <tr class="text-center">
                                                <td><img src="<?= base_url('/img/anak/' . $row['gambar_anak']); ?> " width="50"></td>
                                                <td><?= $row['nama']; ?></td>
                                                <td><?= $row['jenis_kelamin']; ?></td>
                                                <td><?= date("d-m-Y", strtotime($row['tanggal_lahir'])); ?></td>
                                                <td>
                                                    <button class="btn btn-warning btn-circle btn-sm" data-toggle="modal" data-target="#formModalEditAnak<?= $row['id_anak'] ?>">
                                                        <i class="fas fa-pencil-alt"></i>
                                                    </button>
                                                    <button class="btn btn-danger btn-circle btn-sm" onclick="hapus('<?= $row['id_anak']; ?>')"> <i class="fas fa-trash"></i></button>
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
    </div>
</div>
<!-- Modal Tambah -->
<div class="modal fade" id="formTambahAnak" tabindex="-1" aria-labelledby="exampleModalLabel" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Tambah Anak</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="/anak/save" method="post" enctype="multipart/form-data">
                <div class="modal-body">
                    <?= csrf_field(); ?>
                    <div class="form-group">
                        <label for="">Nama</label>
                        <input type="text" name="nama" id="nama" class="form-control<?= ($validation->hasError('nama')) ? ' is-invalid' : '' ?>" value="<?= old('nama'); ?>" placeholder="Nama Anak">
                        <div class="invalid-feedback">
                            <?= $validation->getError('nama'); ?>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="">Jenis Kelamin</label>
                        <select name="jenis_kelamin" id="jenis_kelamin" class="form-control<?= ($validation->hasError('jenis_kelamin')) ? ' is-invalid' : '' ?>">
                            <option value="">-- Pilih Jenis Kelamin --</option>
                            <option value="L">L</option>
                            <option value="P">P</option>
                        </select>
                        <div class="invalid-feedback">
                            <?= $validation->getError('jenis_kelamins'); ?>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="">Tanggal Lahir</label>
                        <input type="date" id="tanggal_lahir" name="tanggal_lahir" class="form-control<?= ($validation->hasError('tanggal_lahir')) ? ' is-invalid' : '' ?>" value="<?= old('tanggal_lahir'); ?>">
                        <div class="invalid-feedback">
                            <?= $validation->getError('tanggal_lahir'); ?>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="user_image">Foto</label>
                        <input type="file" name="gambar_anak" id="gambar_anak" class="form-control-file<?= ($validation->hasError('user_image')) ? ' is-invalid' : '' ?>">
                        <div class="invalid-feedback">
                            <?= $validation->getError('gambar_anak'); ?>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Kembali</button>
                        <button type="submit" class="btn btn-primary">Tambah</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal Edit -->
<?php foreach ($anak as $row) : ?>
    <div class="modal fade" id="formModalEditAnak<?= $row['id_anak']; ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Edit Anak <?= $row['nama']; ?></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="/anak/update/<?= $row['id_anak']; ?>" method="post" enctype="multipart/form-data">
                        <?= csrf_field(); ?>
                        <div class="card mb-3" style="max-width: 540px;">
                            <div class="row g-0">
                                <input type="hidden" name="gambarLama" value="<?= $row['gambar_anak'] ?>">
                                <div class="col-md-4">
                                    <img src="<?= base_url('/img/anak/' . $row['gambar_anak']); ?>" class="card-img" alt="<?= $row['nama']; ?>">
                                </div>
                                <div class="col-md-8">
                                    <div class="card-body">
                                        <div class="form-group">
                                            <label for="nama">Nama</label>
                                            <input type="text" name="nama" id="nama" class="form-control<?= ($validation->hasError('nama')) ? ' is-invalid' : '' ?>" value="<?= (old('nama')) ? old('nama') : $row['nama']; ?>">
                                            <div class="invalid-feedback">
                                                <?= $validation->getError('nama'); ?>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="tanggal_lahir">Tanggal Lahir</label>
                                            <input type="date" name="tanggal_lahir" id="tanggal_lahir" class="form-control<?= ($validation->hasError('tanggal_lahir')) ? ' is-invalid' : '' ?>" value="<?= (old('tanggal_lahir')) ? old('tanggal_lahir') : $row['tanggal_lahir']; ?>">
                                            <div class="invalid-feedback">
                                                <?= $validation->getError('tanggal_lahir'); ?>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="jenis_kelamin">Jenis Kelamin</label>
                                            <select name="jenis_kelamin" id="jenis_kelamin" class="form-control<?= ($validation->hasError('jenis_kelamin')) ? ' is-invalid' : '' ?>" value="<?= (old('jenis_kelamin')) ? old('jenis_kelamin') : $row['jenis_kelamin']; ?>">
                                                <?php $jenis_kelamin = $row['jenis_kelamin']; ?>
                                                <option value="L" <?php if ($jenis_kelamin == 'L') { ?> selected="selected" <?php } ?>>L</option>
                                                <option value="P" <?php if ($jenis_kelamin == 'P') { ?> selected="selected" <?php } ?>>P</option>
                                            </select>
                                            <div class="invalid-feedback">
                                                <?= $validation->getError('jenis_kelamin'); ?>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="gambar_anak" class="col-sm-2 col-form-label">Foto</label>
                                            <div class="col-sm-2">
                                                <img src="/img/anak/<?= $row['gambar_anak']; ?>" class="img-thumbnail img-preview">
                                            </div>
                                            <div class="col-sm-8">
                                                <div class="custom-file">
                                                    <input type="file" class="custom-file-input <?= ($validation->hasError('gambar_anak')) ? 'is-invalid' : ''; ?>" id="gambar_anak" name="gambar_anak" onchange="previewImg()">
                                                    <div class=" invalid-feedback">
                                                        <?= $validation->getError('gambar_anak'); ?>
                                                    </div>
                                                    <label class="custom-file-label" for="gambar_anak"><?= $row['gambar_anak']; ?> </label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                                            <button type="submit" class="btn btn-primary">Perbarui</button>
                                        </div>
                                    </div>
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
    function hapus(id_anak) {
        Swal.fire({
            title: 'hapus',
            text: `Yakin menghapus data anak ini ?`,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ya, Hapus!',
            cancelButtonText: 'Tidak',
        }).then((result) => {
            if (result.value) {
                $.ajax({
                    type: "post",
                    url: "<?= site_url('warga/hapus') ?>",
                    data: {
                        id_anak: id_anak
                    },
                    dataType: "json",

                    success: function(response) {
                        if (response.sukses) {
                            Swal.fire({
                                    icon: 'success',
                                    title: 'Berhasil',
                                    text: response.sukses,
                                })
                                .then(function() {
                                    window.location.reload();
                                })
                        }
                    },
                    error: function(xhr, ajaxOptios, thrownError) {
                        alert(xhr.status + "\n" + xhr.responseText + "\n" +
                            thrownError);

                    }
                });
            }
        })
    }

    function previewImg() {

        const gambar = document.querySelector('#gambar_anak');
        const gambarLabel = document.querySelector('.custom-file-label');
        const imgPreview = document.querySelector('.img-preview');

        gambarLabel.textContent = gambar.files[0].name;
        const filegambar = new FileReader();
        filegambar.readAsDataURL(gambar.files[0]);

        filegambar.onload = function(e) {

            imgPreview.src = e.target.result;

        }
    }
</script>
<script>
    $(document).ready(function() {
        $('#dataTable-nonkms').DataTable({
            responsive: true
        });
    });
    $("div.id_100 select").val("val2").change();
</script>




<?= $this->endSection(); ?>
<?= $this->extend('templates/index'); ?>
<?= $this->section('dashboard'); ?>

<!-- Tambah Antrian -->

<div class="card-body">
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#formModalAnak<?= $user->userid; ?>">
                <i class="fa fa-plus-circle"></i> Tambah Anak
            </button>
        </div>
        <div class="row">
            <div class="card-body">
                <div class="card mb-3" style="max-width: 540px;">
                    <div class="row no-gutters">
                        <div class="col-md-4">
                            <img src="<?= base_url('/img/' . $user->user_image); ?>" class="card-img" alt="<?= $user->username; ?>">
                        </div>
                        <div class="col-md-8">
                            <div class="card-body">
                                <h5 class="card-title">Detail Profile</h5>
                                <p class="card-text">Informasi mengenai data user Sistem Informasi Posyandu, ganti gambar profile dengan tombol "upload gambar" jika dibutuhkan.</p>
                                <ul class="list-group list-group-flush">
                                    <li class="list-group-item">
                                        <h4><?= $user->username; ?></h4>
                                    </li>
                                    <?php if ($user->fullname) : ?>
                                        <li class="list-group-item"><?= $user->fullname; ?></li>
                                    <?php endif; ?>
                                    <li class="list-group-item"><?= $user->email; ?> </li>
                                    <?php if (!empty($user->no_kk)) : ?>
                                        <li class="list-group-item">
                                            <span class="badge badge-success"><?= $user->no_kk; ?></span>
                                        </li>
                                    <?php endif; ?>
                                    <li class="list-group-item">
                                        <span class="badge badge-warning"> <?= $user->name; ?></span>
                                    </li>
                                </ul>
                                <div class="card-footer">
                                    <a href=" <?= base_url('warga'); ?>" class="btn btn-primary"> <i class="fas fa-backward"> </i> Kembali ke Daftar Pengguna</a>
                                </div>
                            </div>
                        </div>

                        </ul>
                    </div>
                </div>
            </div>

            <?php
            foreach ($anak as $row) : ?>
                <div class="card-body">
                    <div class="card mb-3" style="max-width: 540px;">
                        <div class="row no-gutters">
                            <div class="col-md-4">
                                <img src="<?= base_url('/img/anak/' . $row['gambar_anak']); ?>" class="card-img" alt="<?= $row['gambar_anak']; ?>">
                            </div>
                            <div class="col-md-8">
                                <div class="card-body">
                                    <h5 class="card-title">Detail Anak</h5>
                                    <p class="card-text">Informasi mengenai data user Sistem Informasi Posyandu, ganti gambar profile dengan tombol "upload gambar" jika dibutuhkan.</p>
                                    <ul class="list-group list-group-flush">
                                        <li class="list-group-item">
                                            <h4><?= $row['nama']; ?></h4>
                                        </li>

                                        <li class="list-group-item"><?= $row['jenis_kelamin']; ?> </li>

                                        <li class="list-group-item"><?= date("d-m-Y", strtotime($row['tanggal_lahir'])); ?></li>
                                        <li class="list-group-item">
                                            <span class="badge badge-info"> Anak</span>
                                        </li>
                                    </ul>

                                    <div class="card-footer row">
                                        <div class="col">
                                            <p><i class="fas fa-cogs"></i> aksi</p>
                                        </div>
                                        <div class="col">
                                            <a data-toggle="modal" data-target="#formModalEditAnak<?= $row['id_anak']; ?>" class="btn btn-primary"> <i class="fas fa-pencil-alt"> </i></a>
                                        </div>
                                        <div class="col">
                                            <button class="btn btn-danger" onclick="hapus('<?= $row['id_anak']; ?>')"> <i class="fas fa-trash"></i></button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</div>
<?php
foreach ($user as $row) : ?>
    <div class="modal fade" id="formModalAnak<?= $user->userid; ?>" tabindex="-1" aria-labelledby="exampleModalLabel" role="dialog" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Tambah Anak</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="/warga/saveanak/<?= $user->userid; ?>" method="post" enctype="multipart/form-data">
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
                            <input type="file" name="gambar_anak" id="gambar_anak" class="form-control-file,?= ($validation->hasError('user_image')) ? ' is-invalid' : '' ?>">
                            <div class="invalid-feedback">
                                <?= $validation->getError('gambar_anak'); ?>
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
<?php endforeach; ?>

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
                    <form action="/warga/updateanak/<?= $row['id_anak']; ?>" method="post" enctype="multipart/form-data">
                        <?= csrf_field(); ?>
                        <div class="card mb-3" style="max-width: 540px;">
                            <div class="row g-0">
                                <input type="hidden" name="gambarLama" value="<?= $row['gambar_anak'] ?>">
                                <div class="col-md-4">
                                    <img src="<?= base_url('/img/anak/' . $row['gambar_anak']); ?>" class="card-img" alt="<?= $row['nama']; ?>">
                                </div>
                                <div class="col-md-8">
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
                                        <label for="gambar_anak">Foto</label>
                                        <div class="col-sm-2">
                                            <img src="/img/anak/<?= $row['gambar_anak']; ?>" class="img-thumbnail img-preview" alt="<?= $row['nama']; ?>">
                                        </div>
                                        <div class="col-sm-8">
                                            <div class="custom-file">
                                                <input type="file" class="custom-file-input<?= ($validation->hasError('gambar_anak')) ? 'is-invalid' : ''; ?>" id="gambar_anak" name="gambar_anak">
                                                <div class=" invalid-feedback">
                                                    <?= $validation->getError('gambar_anak'); ?>
                                                </div>
                                            </div>
                                            <label class="custom-file-label" for="gambar_anak"><?= $row['gambar_anak'];; ?> </label>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                                        <button type="submit" class="btn btn-primary">Perbarui</button>
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
</script>
<?= $this->endSection(); ?>
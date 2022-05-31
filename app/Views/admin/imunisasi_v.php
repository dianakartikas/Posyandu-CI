<?= $this->extend('templates/index'); ?>
<?= $this->section('dashboard'); ?>
<!-- Begin Page Content -->
<!-- tabel -->
<div class="card-body">
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#formTambahImunisasi">
                <i class="fa fa-plus-circle"></i> Tambah Imunisasi
            </button>
        </div>

        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-sm" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr class="text-center">
                            <th>No</th>
                            <th>Nama</th>
                            <th>Jenjang Usia</th>
                            <th>Catatan</th>
                            <th>
                                <i class="fas fa-cogs"></i> Aksi
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $nomor = 1;
                        foreach ($imunisasi as $row) :
                        ?>
                            <tr class="text-center">
                                <td><?= $nomor++ ?></td>
                                <td><?= $row['nama'] ?></td>
                                <td><?= $row['dari_usia'] ?>-<?= $row['sampai_usia']  ?> Bulan </td>
                                <td><?php if (empty($row['catatan'])) { ?>
                                        <span class="badge badge-success">catatan tidak tersedia</span>

                                    <?php } else  ?>
                                    <?= $row['catatan'] ?>
                                </td>
                                <td>
                                    <button class="btn btn-warning btn-circle btn-sm" data-toggle="modal" data-target="#modaledit<?= $row['id_imunisasi']; ?>">
                                        <i class="fas fa-pencil-alt"></i>
                                    </button>
                                    <button class="btn btn-danger btn-circle btn-sm" onclick="hapus('<?= $row['id_imunisasi']; ?>')">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                    <tfoot>
                        <tr class="text-center">
                            <th>No</th>
                            <th>Nama</th>
                            <th>Jenjang Usia</th>
                            <th>Catatan</th>
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

<!-- Modal Tambah -->
<div class="modal fade" id="formTambahImunisasi" tabindex="-1" aria-labelledby="exampleModalLabel" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Tambah Imunisasi</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="imunisasi/save">
                <div class="modal-body">
                    <?= csrf_field(); ?>
                    <div class="form-group">
                        <label for="">Nama</label>
                        <input type="text" class="form-control<?= ($validation->hasError('nama')) ? ' is-invalid' : '' ?>" value="<?= old('nama'); ?>" name="nama" id="nama" placeholder="Nama Imunisasi">
                        <div class="invalid-feedback">
                            <?= $validation->getError('nama'); ?>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="">Dari Usia (Bulan)</label>
                        <input type="text" class="form-control<?= ($validation->hasError('dari_usia')) ? ' is-invalid' : '' ?>" value="<?= old('dari_usia'); ?>" name="dari_usia" id="dari_usia" placeholder="Dari Usia dalam Bulan">
                        <div class="invalid-feedback">
                            <?= $validation->getError('dari_usia'); ?>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="">Sampai Usia (Bulan)</label>
                        <input type="text" class="form-control<?= ($validation->hasError('sampai_usia')) ? ' is-invalid' : '' ?>" value="<?= old('sampai_usia'); ?>" name="sampai_usia" id="sampai_usia" placeholder="Sampai Usia dalam Bulan">
                        <div class="invalid-feedback">
                            <?= $validation->getError('sampai_usia'); ?>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="">Catatan</label>
                        <textarea type="text" class="form-control" name="catatan" id="catatan"></textarea>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Kembali</button>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal Edit -->
<?php foreach ($imunisasi as $row) : ?>
    <div class="modal fade" id="modaledit<?= $row['id_imunisasi']; ?>" tabindex="-1" aria-labelledby="modaleditLabel" role="dialog" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modaleditLabel">Edit Imunisasi<?= $row['nama']; ?></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <?= csrf_field(); ?>
                <form action="imunisasi/update/<?= $row['id_imunisasi']; ?>">
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="nama">Nama</label>
                            <input type="text" name="nama" id="nama" class="form-control<?= ($validation->hasError('nama')) ? ' is-invalid' : '' ?>" value="<?= (old('nama')) ? old('nama') : $row['nama']; ?>">
                            <div class="invalid-feedback">
                                <?= $validation->getError('nama'); ?>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="dari_usia">Dari Usia (Bulan)</label>
                            <input type="text" name="dari_usia" id="dari_usia" class="form-control<?= ($validation->hasError('dari_usia')) ? ' is-invalid' : '' ?>" value="<?= (old('dari_usia')) ? old('dari_usia') :  $row['dari_usia']; ?>">
                            <div class="invalid-feedback">
                                <?= $validation->getError('dari_usia'); ?>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="sampai_usia">Sampai Usia (Bulan)</label>
                            <input type="text" name="sampai_usia" id="sampai_usia" class="form-control<?= ($validation->hasError('sampai_usia')) ? ' is-invalid' : '' ?>" value="<?= (old('sampai_usia')) ? old('sampai_usia') : $row['sampai_usia']; ?>">
                            <div class="invalid-feedback">
                                <?= $validation->getError('sampai_usia'); ?>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="catatan">Catatan</label>
                            <textarea type="text" class="form-control" name="catatan" id="catatan" value="<?= (old('catatan')) ? old('catatan') : $row['catatan']; ?>"></textarea>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Kembali</button>
                            <button type="submit" class="btn btn-primary">Perbarui</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

<?php endforeach; ?>
<!-- <script>
    $(document).ready(function() {
        $('#dtVerticalScrollExample').DataTable({
            "scrollY": "200px",
            "scrollCollapse": true,
        });
        $('.dataTables_length').addClass('bs-select');
    });

    $(document).ready(function() {
        $('#dtVerticalScrollUser').DataTable({
            "scrollY": "200px",
            "scrollCollapse": true,
        });
        $('.dataTables_length').addClass('bs-select');
    });
</script>

<script>
    $(document).ready(function() {
        $('.formimunisasi').submit(function(e) {
            e.preventDefault();
            $.ajax({
                type: "post",
                url: $(this).attr('action'),
                data: $(this).serialize(),
                dataType: "json",
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                },
                beforeSend: function() {

                    $('.btnsimpan').attr('disable', 'disabled');
                    $('.btnsimpan').html('<i class="fa fa-spinner"></i> Cek');

                },
                complete: function() {
                    $('.btnsimpan').removeAttr('disable');
                    $('.btnsimpan').html('Simpan');

                },
                success: function(response) {
                    if (response.error) {
                        if (response.error.nama) {
                            $('#nama').addClass('is-invalid');
                            $('.errorNama').html(response.error.nama);

                        } else {
                            $('#nama').removeClass('is-invalid').addClass('is-valid');
                        }
                        if (response.error.dari_usia) {
                            $('#dari_usia').addClass('is-invalid');
                            $('.errorDari').html(response.error.dari_usia);
                        } else {
                            $('#dari_usia').removeClass('is-invalid').addClass('is-valid');
                        }
                        if (response.error.sampai_usia) {
                            $('#sampai_usia').addClass('is-invalid');
                            $('.errorSampai').html(response.error.sampai_usia);
                        } else {
                            $('#sampai_usia').removeClass('is-invalid').addClass('is-valid');
                        }
                    } else {
                        $('#nama').removeClass('is-invalid').addClass('is-valid');
                        $('#dari_usia').removeClass('is-invalid').addClass('is-valid');
                        $('#sampai_usia').removeClass('is-invalid').addClass('is-valid');
                        $('.btnsimpan').html('<i class="fa fa-spinner"></i> Cek');

                        Swal.fire({
                                icon: 'success',
                                title: 'Berhasil',
                                text: response.sukses

                            })
                            .then(function() {
                                window.location.reload();
                            })
                        $("#formTambahImunisasi")
                            .modal("show")
                            .on("shown.bs.modal", function() {
                                window.setTimeout(function() {
                                    $("#formTambahImunisasi").modal("hide");
                                    location.reload();
                                }, 5000);
                            });
                    }
                    $("#formTambahImunisasi")
                        .modal("show")
                        .on("hide.bs.modal", function() {
                            location.reload();
                        });
                },
                error: function(xhr, ajaxOptios, thrownError) {
                    alert(xhr.status + "\n" + xhr.responseText + "\n" +
                        thrownError);
                }
            });
            return false;
        });
    });
</script>


<script>
    $(document).ready(function() {
        $('.formeditimunisasi').submit(function(e) {
            e.preventDefault();
            $.ajax({
                type: "post",
                url: $(this).attr('action'),
                data: $(this).serialize(),
                dataType: "json",

                beforeSend: function() {

                    $('.btnedit').attr('disable', 'disabled');
                    $('.btnedit').html('<i class="fa fa-spinner"></i> Cek');

                },
                complete: function() {
                    $('.btnedit').removeAttr('disable');
                    $('.btnedit').html('Update');

                },
                success: function(response) {
                    if (response.error) {
                        if (response.error.nama) {
                            $('#nama').addClass('is-invalid');
                            $('.errorNama').html(response.error.nama);

                        } else {
                            $('#nama').removeClass('is-invalid').addClass('is-valid');
                        }
                        if (response.error.dari_usia) {
                            $('#dari_usia').addClass('is-invalid');
                            $('.errorDari').html(response.error.dari_usia);
                        } else {
                            $('#dari_usia').removeClass('is-invalid').addClass('is-valid');
                        }
                        if (response.error.sampai_usia) {
                            $('#sampai_usia').addClass('is-invalid');
                            $('.errorSampai').html(response.error.sampai_usia);
                        } else {
                            $('#sampai_usia').removeClass('is-invalid').addClass('is-valid');
                        }
                    } else {
                        $('#nama').removeClass('is-invalid').addClass('is-valid');
                        $('#dari_usia').removeClass('is-invalid').addClass('is-valid');
                        $('#sampai_usia').removeClass('is-invalid').addClass('is-valid');
                        $('.btnedit').html('<i class="fa fa-spinner"></i> Cek');

                        Swal.fire({
                                icon: 'success',
                                title: 'Berhasil',
                                text: response.sukses

                            })
                            .then(function() {
                                window.location.reload();
                            })
                        $("#formeditimunisasi")
                            .modal("show")
                            .on("shown.bs.modal", function() {
                                window.setTimeout(function() {
                                    $("#formeditimunisasi").modal("hide");
                                    location.reload();
                                }, 5000);
                            });
                    }
                    $("#formeditimunisasi")
                        .modal("show")
                        .on("hide.bs.modal", function() {
                            location.reload();
                        });
                },
                error: function(xhr, ajaxOptios, thrownError) {
                    alert(xhr.status + "\n" + xhr.responseText + "\n" +
                        thrownError);
                }
            });
            return false;
        });
    });
</script> -->

<script>
    function hapus(id_imunisasi) {
        Swal.fire({
            title: 'hapus',
            text: `Yakin menghapus data imunisasi ini ?`,
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
                    url: "<?= site_url('imunisasi/hapus') ?>",
                    data: {
                        id_imunisasi: id_imunisasi
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
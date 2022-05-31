<?= $this->extend('templates/index'); ?>
<?= $this->section('dashboard'); ?>
<!-- Begin Page Content -->
<!-- tabel -->
<div class="card-body">
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#formTambahKegiatan">
                <i class="fa fa-plus-circle"></i> Tambah Kegiatan
            </button>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-sm" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr class="text-center">
                            <th>No</th>
                            <th>Nama Kegiatan</th>
                            <th>Tanggal Kegiatan</th>
                            <th>Lokasi</th>
                            <th>Ditambahkan Oleh</th>
                            <th>
                                <i class="fas fa-cogs"></i> Aksi
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php

                        $nomor = 1;

                        foreach ($kegiatan as $row) :

                        ?>
                            <tr class="text-center">
                                <td><?= $nomor++ ?></td>
                                <td><?= $row['nama'] ?></td>
                                <td> <?= date("d-m-Y", strtotime($row['tanggal'])); ?></td>
                                <td><?= $row['lokasi'] ?></td>

                                <td>
                                    <span class="badge badge-success btn-large"> <?= $row['fullname'] ?></span>
                                </td>
                                <td>
                                    <button class="btn btn-warning btn-circle btn-sm" data-toggle="modal" data-target="#modaledit<?= $row['kegid']; ?>">
                                        <i class="fas fa-pencil-alt"></i>
                                    </button>

                                    <button class="btn btn-danger btn-circle btn-sm confirm_del_btn" value="<?= $row['kegid'] ?>"><i class="fas fa-trash"></i></button>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                    <tfoot>
                        <tr class="text-center">
                            <th>No</th>
                            <th>Nama Kegiatan</th>
                            <th>Tanggal Kegiatan</th>
                            <th>Lokasi</th>
                            <th>Ditambahkan Oleh</th>
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
<div class="modal fade" id="formTambahKegiatan" tabindex="-1" aria-labelledby="exampleModalLabel" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Tambah Kegiatan</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="kegiatan/save" class="formtambahkegiatan">
                <div class="modal-body">
                    <?= csrf_field(); ?>
                    <div class="form-group">
                        <label for="">Nama Kegiatan</label>
                        <input type="text" class="form-control" name="nama" id="nama" placeholder="Nama Kegiatan">
                        <div class="invalid-feedback errorNama">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="">Tanggal Kegiatan</label>
                        <input type="date" class="form-control" name="tanggal" id="tanggal" placeholder="Pilih tanggal">
                        <div class="invalid-feedback errortanggal">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="">Lokasi</label>
                        <input type="text" class="form-control" name="lokasi" id="lokasi" placeholder="Tuliskan Lokasi Kegiatan">
                        <div class="invalid-feedback errorlokasi">
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Kembali</button>
                        <button type="submit" class="btn btn-primary btnsimpan">Simpan</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<?php foreach ($kegiatan as $row) : ?>
    <div class="modal fade" id="modaledit<?= $row['kegid']; ?>" tabindex="-1" aria-labelledby="modaleditLabel" role="dialog" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modaleditLabel">Edit Kegiatan<?= $row['nama']; ?></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <?= csrf_field(); ?>
                <form action="kegiatan/update/<?= $row['kegid']; ?>">
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="nama">Nama</label>
                            <input type="text" name="nama" id="nama" class="form-control<?= ($validation->hasError('nama')) ? ' is-invalid' : '' ?>" value="<?= (old('nama')) ? old('nama') : $row['nama']; ?>">
                            <div class="invalid-feedback">
                                <?= $validation->getError('nama'); ?>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="tanggal">Tanggal</label>
                            <input type="date" name="tanggal" id="tanggal" class="form-control<?= ($validation->hasError('tanggal')) ? ' is-invalid' : '' ?>" value="<?= (old('tanggal')) ? old('tanggal') :  $row['tanggal']; ?>" readonly>
                            <div class="invalid-feedback">
                                <?= $validation->getError('tanggal'); ?>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="lokasi">Lokasi</label>
                            <input type="text" name="lokasi" id="lokasi" class="form-control<?= ($validation->hasError('lokasi')) ? ' is-invalid' : '' ?>" value="<?= (old('lokasi')) ? old('lokasi') : $row['lokasi']; ?>">
                            <div class="invalid-feedback">
                                <?= $validation->getError('lokasi'); ?>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Kembali</button>
                            <button type="submit" class="btn btn-primary">Update</button>
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
                            url: "kegiatan/confirmdelete/" + id,
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
        $('.formtambahkegiatan').submit(function(e) {
            e.preventDefault();
            $.ajax({
                type: "post",
                url: "<?= site_url('kegiatan/save'); ?>",
                data: $(this).serialize(),
                dataType: "json",
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                },
                beforeSend: function() {

                    $('.btnsimpan').attr('disable', 'disabled');
                    $('.btnsimpan').html('<i class="fa fa-spinner"></i> Simpan');

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

                        if (response.error.tanggal) {
                            $('#tanggal').addClass('is-invalid');
                            $('.errortanggal').html(response.error.tanggal);
                        } else {
                            $('#tanggal').removeClass('is-invalid').addClass('is-valid');
                        }
                        if (response.error.lokasi) {
                            $('#lokasi').addClass('is-invalid');
                            $('.errorlokasi').html(response.error.lokasi);
                        } else {
                            $('#lokasi').removeClass('is-invalid').addClass('is-valid');
                        }

                    } else {
                        $('#nama').removeClass('is-invalid').addClass('is-valid');
                        $('#tanggal').removeClass('is-invalid').addClass('is-valid');
                        $('#lokasi').removeClass('is-invalid').addClass('is-valid');
                        $('.btnsimpan').html('<i class="fa fa-spinner"></i> simpan');


                        Swal.fire({
                                icon: 'success',
                                title: 'Berhasil',
                                text: response.sukses

                            })
                            .then(function() {
                                window.location.reload();
                            })
                        $("#formTambahKegiatan")
                            .modal("show")
                            .on("shown.bs.modal", function() {
                                window.setTimeout(function() {
                                    $("#formTambahKegiatan").modal("hide");
                                    location.reload();
                                }, 5000);
                            });
                    }
                    $("#formTambahKegiatan")
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
<!-- <script>
    $(document).ready(function() {

        // get Edit Product
        $('.edit').on('click', function() {
            // get data from button edit
            const id = $(this).data('id');
            const nama = $(this).data('nama');
            const tanggal = $(this).data('tanggal');
            const lokasi = $(this).data('lokasi');
            // Set data to Form Edit
            $('.nama').val(id);
            $('.tanggal').val(nama);
            $('.lokasi').val(lokasi);

            // Call Modal Edit
            $('#modaledit').modal('show');
        });
    });
</script> -->


<!-- <script>
    $(document).ready(function() {
        $('.formeditkegiatan').submit(function(e) {
            e.preventDefault();
            var id = $(this).val();

            $.ajax({
                type: "post",
                url: "<?= site_url('kegiatan/save'); ?>/" + id,
                data: $(this).serialize(),
                dataType: "json",
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                },
                beforeSend: function() {

                    $('.btnedit').attr('disable', 'disabled');
                    $('.btnedit').html('<i class="fa fa-spinner"></i> Simpan');

                },
                complete: function() {
                    $('.btnedit').removeAttr('disable');
                    $('.btnedit').html('Simpan');

                },
                success: function(response) {
                    if (response.error) {
                        if (response.error.nama) {
                            $('#nama').addClass('is-invalid');
                            $('.errornamaedit').html(response.error.nama);

                        } else {
                            $('#nama').removeClass('is-invalid').addClass('is-valid');
                        }

                        if (response.error.tanggaledit) {
                            $('#tanggaledit').addClass('is-invalid');
                            $('.errortanggaledit').html(response.error.tanggaledit);
                        } else {
                            $('#tanggaledit').removeClass('is-invalid').addClass('is-valid');
                        }
                        if (response.error.lokasiedit) {
                            $('#lokasiedit').addClass('is-invalid');
                            $('.errorlokasiedit').html(response.error.lokasiedit);
                        } else {
                            $('#lokasiedit').removeClass('is-invalid').addClass('is-valid');
                        }

                    } else {
                        $('#nama').removeClass('is-invalid').addClass('is-valid');
                        $('#tanggaledit').removeClass('is-invalid').addClass('is-valid');
                        $('#lokasiedit').removeClass('is-invalid').addClass('is-valid');
                        $('.btnsimpan').html('<i class="fa fa-spinner"></i> simpan');


                        Swal.fire({
                                icon: 'success',
                                title: 'Berhasil',
                                text: response.sukses

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
            return false;
        });
    });
</script> -->
<?= $this->endSection(); ?>
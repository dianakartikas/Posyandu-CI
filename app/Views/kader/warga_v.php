<?= $this->extend('templates/index'); ?>
<?= $this->section('dashboard'); ?>
<div class="card-body">
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#formModalUser">
                <i class="fa fa-plus-circle"></i> Tambah Warga
            </button>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-sm" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr class="text-center">
                            <th>Gambar</th>
                            <th>Username</th>
                            <th>Email</th>
                            <th>Role</th>
                            <th><i class="fas fa-info"></i> Detail</th>
                            <th><i class="fas fa-cogs"></i> Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        foreach ($users as $user) : ?>
                            <tr class="text-center">
                                <td><img src="<?= base_url('/img/' . $user->user_image); ?> " width="50" height="50"></td>
                                <td><?= $user->username; ?></td>
                                <td><?= $user->email; ?> </td>
                                <td><?= $user->name; ?> </td>
                                <td>

                                    <a href="<?= base_url('warga/detail/' . $user->userid); ?>" class="btn btn-info btn-sm">detail</a>
                                </td>
                                <td>
                                    <button class="btn btn-warning btn-circle btn-sm" data-toggle="modal" data-target="#modaleditUser<?= $user->userid; ?>">
                                        <i class="fas fa-pencil-alt"></i>
                                    </button>
                                    <button class="btn btn-danger btn-circle btn-sm confirm_del_btn" value="<?= $user->userid; ?>"><i class="fas fa-trash"></i></button>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                    <tfoot>
                        <tr class="text-center">
                            <th>Gambar</th>
                            <th>Username</th>
                            <th>Email</th>
                            <th>Role</th>
                            <th><i class="fas fa-info"></i> Detail</th>
                            <th><i class="fas fa-cogs"></i> Aksi</th>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>
</div>
<?php foreach ($users as $user) : ?>
    <div class="modal fade" id="modaleditUser<?= $user->userid; ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Edit <?= $user->username; ?></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="/warga/update/<?= $user->userid; ?>" method="post" enctype="multipart/form-data">
                        <?= csrf_field(); ?>
                        <div class="card mb-3" style="max-width: 540px;">
                            <div class="row g-0">
                                <input type="hidden" name="gambarLama" value="<?= $user->user_image; ?>">
                                <div class="col-md-4">
                                    <img src="<?= base_url('/img/' . $user->user_image); ?>" class="card-img" alt="<?= $user->username; ?>">
                                </div>
                                <div class="col-md-8">
                                    <div class="card-body">
                                        <div class="form-group">
                                            <label for="username">Username</label>
                                            <input type="text" name="username" id="username" class="form-control<?= ($validation->hasError('username')) ? ' is-invalid' : '' ?>" value="<?= (old('username')) ? old('username') : $user->username; ?>">
                                            <div class="invalid-feedback">
                                                <?= $validation->getError('username'); ?>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="fullname">Nama</label>
                                            <input type="text" name="fullname" id="fullname" class="form-control<?= ($validation->hasError('fullname')) ? ' is-invalid' : '' ?>" value="<?= (old('fullname')) ? old('fullname') : $user->fullname; ?>">
                                            <div class="invalid-feedback">
                                                <?= $validation->getError('fullname'); ?>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="email">Email</label>
                                            <input type="email" name="email" id="email" class="form-control<?= ($validation->hasError('email')) ? ' is-invalid' : '' ?>" value="<?= (old('email')) ? old('email') : $user->email; ?>">
                                            <div class="invalid-feedback">
                                                <?= $validation->getError('email'); ?>
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <label for="user_image">Foto</label>
                                            <div class="col-sm-2">
                                                <img src="/img/<?= $user->user_image; ?>" class="img-thumbnail img-preview" alt="<?= $user->username; ?>">
                                            </div>
                                            <div class="col-sm-8">
                                                <div class="custom-file">
                                                    <input type="file" class="custom-file-input<?= ($validation->hasError('user_image')) ? 'is-invalid' : ''; ?>" id="user_image" name="user_image">
                                                    <div class=" invalid-feedback">
                                                        <?= $validation->getError('user_image'); ?>
                                                    </div>
                                                </div>
                                                <label class="custom-file-label" for="user_image"><?= $user->user_image; ?> </label>
                                            </div>

                                        </div>

                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                                            <button type="submit" class="btn btn-primary">Edit</button>
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
    <div class="modal fade" id="formModalUser" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Tambah Warga</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="/warga/save" method="post" enctype="multipart/form-data">
                        <?= csrf_field(); ?>
                        <div class="form-group">
                            <label for="username">Username</label>
                            <input type="text" name="username" id="username" class="form-control<?= ($validation->hasError('username')) ? ' is-invalid' : '' ?>">
                            <div class="invalid-feedback">
                                <?= $validation->getError('username'); ?>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="fullname">Nama Orangtua</label>
                            <input type="text" name="fullname" id="fullname" class="form-control<?= ($validation->hasError('fullname')) ? ' is-invalid' : '' ?>">
                            <div class="invalid-feedback">
                                <?= $validation->getError('fullname'); ?>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="email">email</label>
                            <input type="email" name="email" id="email" class="form-control<?= ($validation->hasError('email')) ? ' is-invalid' : '' ?>">
                            <div class="invalid-feedback">
                                <?= $validation->getError('email'); ?>
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-sm-6">
                                <label for="password">password</label>
                                <input type="password" name="password" id="password" class="form-control active<?= ($validation->hasError('password')) ? ' is-invalid' : '' ?>">
                                <div class="invalid-feedback">
                                    <?= $validation->getError('password'); ?>
                                </div>
                            </div>

                            <div class="col-sm-6">
                                <label for="confirm_password">Ulangi password</label>
                                <input type="password" name="confirm_password" id="password" class="form-control<?= ($validation->hasError('confirm_password')) ? ' is-invalid' : '' ?>">
                                <div class="invalid-feedback">
                                    <?= $validation->getError('confirm_password'); ?>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <input type="checkbox" onclick="myFunction()">Tampilkan Password
                        </div>
                        <div class="form-group row">
                            <div class="col-sm-6">
                                <img id="output_image" class="img-thumbnail img-preview" />
                            </div>
                            <div class="col-sm-6">

                                <label for="user_image">Foto</label>
                                <input type="file" name="user_image" id="user_image" class="form-control-file<?= ($validation->hasError('user_image')) ? ' is-invalid' : '' ?>" onchange="preview_image(event)">
                                <div class="invalid-feedback">
                                    <?= $validation->getError('user_image'); ?>
                                </div>
                            </div>
                        </div>

                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                            <button type="submit" class="btn btn-primary">Tambah</button>
                        </div>
                    </form>
                </div>
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
                    confirmButtonText: 'Iya, Hapus!'
                })
                .then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: "admin/confirmdelete/" + id,
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
                        swal("data tidak jadi dihpus");
                    }
                });
        });
    });

    function myFunction() {
        var x = document.querySelectorAll("[id='password']");
        for (var i = 0; i < x.length; i++)
            if (x[i].type === "password") {
                x[i].type = "text";
            } else {
                x[i].type = "password";
            }
    }

    function preview_image(event) {
        var reader = new FileReader();
        reader.onload = function() {
            var output = document.querySelectorAll("[id='output_image']");
            for (var i = 0; i < output.length; i++)
                output[i].src = reader.result;
        }
        reader.readAsDataURL(event.target.files[0]);
    }
</script>


<!-- <script>
    $(document).ready(function() {
        $('.formuser').submit(function(e) {
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
                        if (response.error.username) {
                            $('#username').addClass('is-invalid');
                            $('.errorUsername').html(response.error.username);

                        } else {
                            $('#username').removeClass('is-invalid').addClass('is-valid');
                        }

                        if (response.error.fullname) {
                            $('#fullname').addClass('is-invalid');
                            $('.errorFullname').html(response.error.fullname);
                        } else {
                            $('#fullname').removeClass('is-invalid').addClass('is-valid');
                        }
                        if (response.error.email) {
                            $('#email').addClass('is-invalid');
                            $('.errorEmail').html(response.error.email);
                        } else {
                            $('#email').removeClass('is-invalid').addClass('is-valid');
                        }
                        if (response.error.user_image) {
                            $('#user_image').addClass('is-invalid');
                            $('.errorUser_image').html(response.error.user_image);
                        } else {
                            $('#user_image').removeClass('is-invalid').addClass('is-valid');


                        }

                    } else {
                        $('#username').removeClass('is-invalid').addClass('is-valid');
                        $('#fullname').removeClass('is-invalid').addClass('is-valid');
                        $('#email').removeClass('is-invalid').addClass('is-valid');
                        $('#user_image').removeClass('is-invalid').addClass('is-valid');
                        $('.btnsimpan').html('<i class="fa fa-spinner"></i> Cek');


                        Swal.fire({
                                icon: 'success',
                                title: 'Berhasil',
                                text: response.sukses

                            })
                            .then(function() {
                                window.location.reload();
                            })
                        $("#formTambahUser")
                            .modal("show")
                            .on("shown.bs.modal", function() {
                                window.setTimeout(function() {
                                    $("#formTambahAnak").modal("hide");
                                    location.reload();
                                }, 5000);
                            });
                    }
                    $("#formTambahUser")
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

<!-- <script>
    function hapus(userid) {
        Swal.fire({
            title: 'hapus',
            text: `Yakin menghapus data imunisasi ini ?`,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ya, Hapus!',
            cancelButtonText: 'Tidak',
        })

        // .then((result) => {
        //     if (result.value) {
        // $.ajax({
        //     type: "post",
        //     url: "",
        //     data: {
        //         userid: userid
        //     },
        //     dataType: "json",

        //     success: function(response) {
        //         if (response.sukses) {
        //             Swal.fire({
        //                     icon: 'success',
        //                     title: 'Berhasil',
        //                     text: response.sukses,
        //                 })
        //                 .then(function() {
        //                     window.location.reload();
        //                 })
        //         }
        //     },
        //     error: function(xhr, ajaxOptios, thrownError) {
        //         alert(xhr.status + "\n" + xhr.responseText + "\n" +
        //             thrownError);

        //     }
        // });
    } -->

<?= $this->endSection(); ?>
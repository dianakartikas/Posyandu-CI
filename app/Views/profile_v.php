<?= $this->extend('templates/user'); ?>
<?= $this->section('dashboard'); ?>

<div class="card shadow mb-4">
    <div class="card-header py-3"> <i class="fas fa-user-circle"></i> My Profile
    </div>
    <div class="card-body">
        <div class="card mb-3" style="max-width: 540px;">
            <div class="row g-0">
                <div class="col-md-4">
                    <img src="<?= base_url('/img/' . user()->user_image); ?>" class="card-img" alt="<?= user()->username; ?>">
                </div>
                <div class="col-md-8">
                    <div class="card-body">
                        <h5 class="card-title">Profile Saya</h5>
                        <p class="card-text">Informasi mengenai data user Sistem Informasi Posyandu, ganti gambar profile dengan tombol "upload gambar" jika dibutuhkan.</p>
                        <ul class="list-group list-group-flush">
                            <li class="list-group-item">
                                <h4><?= user()->username; ?></h4>
                            </li>
                            <?php if (user()->fullname) : ?>
                                <li class="list-group-item"><?= user()->fullname; ?></li>
                            <?php endif; ?>

                            <li class="list-group-item"><?= user()->email; ?> </li>
                            <button class="btn btn-primary" data-toggle="modal" data-target="#modaleditMyProfile<?= user()->userid; ?>">Edit Profile</button>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<div class="modal fade" id="modaleditMyProfile<?= user()->userid; ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Edit <?= user()->username; ?></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="/admin/updateprofile" method="post" enctype="multipart/form-data">
                    <?= csrf_field(); ?>
                    <div class="card mb-3" style="max-width: 540px;">
                        <div class="row g-0">
                            <input type="hidden" name="gambarLama" value="<?= user()->user_image; ?>">
                            <div class="col-md-4">
                                <img src="<?= base_url('/img/' . user()->user_image); ?>" class="card-img" alt="<?= user()->username; ?>">
                            </div>
                            <div class="col-md-8">
                                <div class="card-body">
                                    <div class="form-group">
                                        <label for="username">Username</label>
                                        <input type="text" name="username" id="username" class="form-control<?= ($validation->hasError('username')) ? ' is-invalid' : '' ?>" value="<?= (old('username')) ? old('username') : user()->username; ?>">
                                        <div class="invalid-feedback">
                                            <?= $validation->getError('username'); ?>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="fullname">Nama</label>
                                        <input type="text" name="fullname" id="fullname" class="form-control<?= ($validation->hasError('fullname')) ? ' is-invalid' : '' ?>" value="<?= (old('fullname')) ? old('fullname') : user()->fullname; ?>">
                                        <div class="invalid-feedback">
                                            <?= $validation->getError('fullname'); ?>
                                        </div>
                                    </div>

                                    <?php foreach ($users as $user) : ?>
                                        <?php if ($user->name == 'user') : ?>
                                            <div class="form-group">
                                                <label for="no_kk">No Kartu Keluarga</label>
                                                <input type="no_kk" name="no_kk" id="no_kk" class="form-control<?= ($validation->hasError('no_kk')) ? ' is-invalid' : '' ?>" value="<?= (old('no_kk')) ? old('no_kk') : user()->no_kk; ?>">
                                                <div class="invalid-feedback">
                                                    <?= $validation->getError('no_kk'); ?>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="nama_ayah">Nama Ayah</label>
                                                <input type="nama_ayah" name="nama_ayah" id="nama_ayah" class="form-control<?= ($validation->hasError('nama_ayah')) ? ' is-invalid' : '' ?>" value="<?= (old('nama_ayah')) ? old('nama_ayah') : user()->nama_ayah; ?>">
                                                <div class="invalid-feedback">
                                                    <?= $validation->getError('nama_ayah'); ?>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="nama_ibu">Nama Ibu</label>
                                                <input type="nama_ibu" name="nama_ibu" id="nama_ibu" class="form-control<?= ($validation->hasError('nama_ibu')) ? ' is-invalid' : '' ?>" value="<?= (old('nama_ibu')) ? old('nama_ibu') : user()->nama_ibu; ?>">
                                                <div class="invalid-feedback">
                                                    <?= $validation->getError('nama_ibu'); ?>
                                                </div>
                                            </div>
                                        <?php endif; ?>
                                    <?php endforeach; ?>
                                    <div class="form-group">
                                        <label for="email">Email</label>
                                        <input type="email" name="email" id="email" class="form-control<?= ($validation->hasError('email')) ? ' is-invalid' : '' ?>" value="<?= (old('email')) ? old('email') : user()->email; ?>">
                                        <div class="invalid-feedback">
                                            <?= $validation->getError('email'); ?>
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label for="user_image" class="col-sm-2 col-form-label">Foto</label>
                                        <div class="col-sm-2">
                                            <img src="/img/<?= user()->user_image; ?>" class="img-thumbnail img-preview">
                                        </div>
                                        <div class="col-sm-8">
                                            <div class="custom-file">
                                                <input type="file" class="custom-file-input <?= ($validation->hasError('user_image')) ? 'is-invalid' : ''; ?>" id="user_image" name="user_image" onchange="previewImg()">
                                                <div class=" invalid-feedback">
                                                    <?= $validation->getError('user_image'); ?>
                                                </div>
                                                <label class="custom-file-label" for="user_image"><?= user()->user_image; ?></label>
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




<script>
    function previewImg() {

        const gambar = document.querySelector('#user_image');
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



<?= $this->endSection(); ?>
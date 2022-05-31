<?= $this->extend('templates/user'); ?>
<?= $this->section('dashboard'); ?>

<div class="card-body">
    <div class="card shadow mb-4">
        <div class="card-header py-3 text-primary"> <i class="fas fa-user-circle"></i> Ganti Password
        </div>
        <div class="card-body">
            <form action="/admin/simpanpassword" method="post">
                <div class="form-group">
                    <label for="nama">Password Lama</label>
                    <input type="password" class="form-control" value="<?= (old('password_hash')) ? old('password_hash') : $password->password_hash; ?>" readonly>
                </div>

                <div class="form-group">
                    <label for="nama">Password Baru</label>
                    <input type="password" name="password" id="password" class="form-control<?= ($validation->hasError('password')) ? ' is-invalid' : '' ?>" value="<?= (old('password')); ?>">
                    <div class=" invalid-feedback">
                        <?= $validation->getError('password'); ?>
                    </div>
                </div>
                <div class="form-group">
                    <label for="nama">Ulangi Password</label>
                    <input type="password" name="confirm_password" id="password" class="form-control<?= ($validation->hasError('confirm_password')) ? ' is-invalid' : '' ?>" value="<?= (old('confirm_password')); ?>">
                    <div class="invalid-feedback">
                        <?= $validation->getError('confirm_password'); ?>
                    </div>
                </div>
                <div class="form-group">
                    <input type="checkbox" onclick="myFunction()"> Tampilkan Password
                </div>
                <div>
                    <button type="submit" class="btn btn-primary btn-lg" style="float: right;">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    function myFunction() {
        var x = document.querySelectorAll("[id='password']");
        for (var i = 0; i < x.length; i++)
            if (x[i].type === "password") {
                x[i].type = "text";
            } else {
                x[i].type = "password";
            }
    }
</script>
<?= $this->endSection(); ?>
<?= $this->extend('templates/index'); ?>
<?= $this->section('dashboard'); ?>
<div class="card-body">
    <div class="card shadow mb-4">
        <div class="card-body">
            <div class="card shadow mb-4">
                <!-- Card Header - Dropdown -->
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary">Pemeriksaan Pertumbuhan Anak</h6>
                </div>
                <div class="card-body">
                    <form action="/cekPertumbuhan/simpan/<?= $pertumbuhan->id_kunjungan; ?>" method="post">
                        <div class="row">
                            <div class="col-md-4">
                                <img src="<?= base_url('/img/anak/' . $pertumbuhan->gambar_anak); ?>" class="card-img">
                            </div>
                            <div class="col-md-8">
                                <div class="form-group">
                                    <label for="nama">Nama</label>
                                    <input type="text" name="nama" id="nama" class="form-control" value="<?= $pertumbuhan->namaAnak; ?>" readonly>
                                    <div class="invalid-feedback">
                                        <?= $validation->getError('nama'); ?>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="nama">Jenis Kelamin</label>
                                    <input type="text" name="jenis_kelamin" id="jenis_kelamin" class="form-control" value="<?= $pertumbuhan->jenis_kelamin; ?>" readonly>
                                    <div class="invalid-feedback">
                                        <?= $validation->getError('jenis_kelamin'); ?>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="umur">Umur</label>
                                    <input type="text" class="form-control" value="<?= $pertumbuhan->umur; ?>" readonly>
                                    <?php $umur = (strtotime(date('d-m-Y')) - strtotime($pertumbuhan->tanggal_lahir)) / (60 * 60 * 24 * 30);
                                    $umur_bulat = floor($umur); ?>
                                    <input type=" text" name="umur" id="umur" class="form-control" value="<?= $umur_bulat; ?> Bulan" hidden>
                                    <div class="invalid-feedback">
                                        <?= $validation->getError('umur'); ?>
                                    </div>




                                </div>
                                <div class="row">
                                    <div class="col-6">
                                        <div class="form-group">
                                            <label for="berat_badan">Berat badan</label>
                                            <input type="number" name="berat_badan" id="berat_badan" step="any" class="form-control" value="<?= (old('berat_badan')); ?>">
                                            <div class="invalid-feedback">
                                                <?= $validation->getError('berat_badan'); ?>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="form-group">
                                            <label for="tinggi_badan">Tinggi badan</label>
                                            <input type="number" name="tinggi_badan" id="tinggi_badan" step="any" class="form-control" value="<?= (old('tinggi_badan')); ?>">
                                            <div class="invalid-feedback">
                                                <?= $validation->getError('tinggi_badan'); ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- <div class="form-group" style=" float: right;">
                                    <form action="" method="post">
                                        <button class="btn btn-primary">Periksa</button>
                                    </form>
                                </div> -->

                                <div class="footer" style=" float: right;">
                                    <a type="button" class="btn btn-secondary" href="/pertumbuhan">Kembali</a>
                                    <button type="submit" class="btn btn-primary">Simpan</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection(); ?>
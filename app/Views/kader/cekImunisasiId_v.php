<?= $this->extend('templates/index'); ?>
<?= $this->section('dashboard'); ?>
<div class="card-body">
    <div class="card shadow mb-4">
        <div class="card-body">
            <div class="card shadow mb-4">
                <!-- Card Header - Dropdown -->
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary">Pemberian Imunisasi</h6>
                </div>
                <div class="card-body">
                    <form action="/cekImunisasi/simpan/<?= $imunisasi->id_kunjungan; ?>" method="post">
                        <div class="row">
                            <div class="col-md-4">
                                <img src="<?= base_url('/img/anak/' . $imunisasi->gambar_anak); ?>" class="card-img">
                            </div>
                            <div class="col-md-8">
                                <div class="form-group">
                                    <label for="nama">Nama</label>
                                    <input type="text" name="nama" id="nama" class="form-control" value="<?= $imunisasi->namaAnak; ?>" readonly>
                                    <div class="invalid-feedback">
                                        <?= $validation->getError('nama'); ?>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="nama">Jenis Kelamin</label>
                                    <input type="text" name="jenis_kelamin" id="jenis_kelamin" class="form-control" value="<?= $imunisasi->jenis_kelamin; ?>" readonly>
                                    <div class="invalid-feedback">
                                        <?= $validation->getError('jenis_kelamin'); ?>
                                    </div>
                                </div>
                                <!-- $umur = (strtotime(date('d-m-Y')) - strtotime($imunisasi->tanggal_lahir)) / (60 * 60 * 24 * 30);
                               $umur_bulat = floor($umur); 
                               echo $umur_bulat -->
                                <div class="form-group">
                                    <label for="umur">Umur</label>
                                    <input type="text" name="umur" id="umur" class="form-control" value="<?= $imunisasi->umur; ?>" readonly>

                                    <div class="invalid-feedback">
                                        <?= $validation->getError('umur'); ?>
                                    </div>
                                </div>
                                <?php

                                // $string_val = $imunisasi->umur;

                                // $parts = explode(' ', $string_val);
                                // if ($parts[1] === "Hari") {
                                //     $umur = 1; // range umur dalam hitungan hari 
                                // } else if ($parts[1] === "Bulan") {
                                //     $umur = $parts[0]; // range umur dalam hitungan bulan
                                // } else if ($parts[1] === "Tahun") {
                                //     $umur = $parts[0] * 12; //range umur dalam hitungan tahun , convert ke dalam jumlah bulan
                                // }
                                // print_r($umur);
                                ?>
                                <div class="form-group">
                                    <label for="id_imunisasi">Beri Imunisasi</label>
                                    <select id="id_imunisasi" name="id_imunisasi" class="form-control">
                                        <option value="">--- Pilih Imunisasi ---</option>
                                        <?php foreach ($beriimunisasi as $value) : ?>
                                            <option value=<?= $value['id_imunisasi']; ?>> <?= $value['nama']; ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label for="nama">Catatan</label>
                                    <textarea type="text" name="catatan" id="catatan" class="form-control" value="<?= (old('catatan')); ?>"></textarea>
                                    <div class="invalid-feedback">
                                        <?= $validation->getError('catatan'); ?>
                                    </div>
                                </div>

                                <div class="footer" style=" float: right;">

                                    <button type="submit" class="btn btn-success" formaction="/cekImunisasi/cekPertumbuhan/<?= $imunisasi->id_kunjungan; ?>">Simpan & Cek Pertumbuhan</button>
                                    <a type="button" class="btn btn-secondary" href="/cekimunisasi">Kembali</a>
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
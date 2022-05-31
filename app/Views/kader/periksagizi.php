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
                <?php
                foreach ($hasilcek as $key) : ?>
                    <div class="card-body">

                        <form action="/cekPertumbuhan/hasil/<?= $key['id_cek_pertumbuhan']; ?>" method="post">
                            <div class="row">
                                <div class="col-md-4">
                                    <img src="<?= base_url('/img/anak/' . $key['gambar_anak']); ?>" class="card-img">
                                </div>
                                <div class="col-md-8">
                                    <div class="form-group">
                                        <label for="nama">Nama</label>
                                        <input type="text" name="nama" id="nama" class="form-control" value="<?= $key['namaAnak']; ?>" readonly>
                                        <div class="invalid-feedback">
                                            <?= $validation->getError('nama'); ?>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="nama">Jenis Kelamin</label>
                                        <input type="text" name="jenis_kelamin" id="jenis_kelamin" class="form-control" value="<?= $key['jenis_kelamin']; ?>" readonly>
                                        <div class="invalid-feedback">
                                            <?= $validation->getError('jenis_kelamin'); ?>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="umur">Umur</label>
                                        <input type="text" name="umur" id="umur" class="form-control" value="<?= $key['umur']; ?> Bulan" readonly>
                                        <div class="invalid-feedback">
                                            <?= $validation->getError('umur'); ?>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-6">
                                            <div class="form-group">
                                                <label for="berat_badan">Berat badan</label>
                                                <input type="tect" name="berat_badan" id="berat_badan" class="form-control" value="<?= $key['berat_badan']; ?> Kg" readonly>
                                                <div class="invalid-feedback">
                                                    <?= $validation->getError('berat_badan'); ?>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div class="form-group">
                                                <label for="tinggi_badan">Tinggi badan</label>
                                                <input type="text" name="tinggi_badan" id="tinggi_badan" class="form-control" value="<?= $key['tinggi_badan']; ?> Cm" readonly>
                                                <div class="invalid-feedback">
                                                    <?= $validation->getError('tinggi_badan'); ?>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Perhitungan TBU Menurut Umur -->
                                    <?php foreach ($bbu as $row) :  ?>
                                        <?php if (($key['umur'] == $row['umur']) && ($key['jenis_kelamin'] == $row['jenis_kelamin'])) {

                                            if ($key['berat_badan'] < $row['median']) {

                                                $nsbr = $row['median'] - $row['sdmin1'];
                                            } else {

                                                $nsbr = $row['sdplus1'] - $row['median'];
                                            }
                                            $key['hasil_bbu'] = (($key['berat_badan']  - $row['median']) / $nsbr);
                                        }
                                        if ($key['hasil_bbu'] < -3)

                                            $hasil = "Gizi Buruk";

                                        elseif ($key['hasil_bbu'] >= -3 && $key['hasil_bbu'] < -2)

                                            $hasil = "Gizi Kurang";

                                        elseif ($key['hasil_bbu'] >= -2 && $key['hasil_bbu']  <= 2)

                                            $hasil = "Gizi Baik";

                                        elseif ($key['hasil_bbu'] > 2)

                                            $hasil = "Gizi Lebih";

                                        ?>
                                    <?php endforeach; ?>
                                    <div class="form-group">
                                        <label for="tinggi_badan">Hasil Gizi /Berat Badan Umur</label>
                                        <input type="text" name="hasil_bbu" id="hasil_bbu" class="form-control" value="<?= $hasil; ?>" readonly>
                                        <div class="invalid-feedback">
                                            <?= $validation->getError('hasil_bbu'); ?>
                                        </div>
                                    </div>
                                    <!-- Perhitungan TB Menurut Umur-->
                                    <?php foreach ($tbu as $row) :  ?>
                                        <?php if (($key['umur']  == $row['umur']) && ($key['jenis_kelamin'] == $row['jenis_kelamin'])) {

                                            if ($key['tinggi_badan'] < $row['median']) {

                                                $nsbr = $row['median'] - $row['sdmin1'];
                                            } else {

                                                $nsbr = $row['sdplus1'] - $row['median'];
                                            }
                                            $key['hasil_tbu']  = (($key['tinggi_badan'] - $row['median']) / $nsbr);
                                        }


                                        if ($key['hasil_tbu'] < -3)

                                            $hasil = "Sangat Pendek";

                                        elseif ($key['hasil_tbu'] >= -3 &&  $key['hasil_tbu'] < -2)

                                            $hasil = "Pendek";

                                        elseif ($key['hasil_tbu'] >= -2 &&  $key['hasil_tbu'] <= 2)

                                            $hasil = "Normal";

                                        elseif ($key['hasil_tbu'] > 2)

                                            $hasil = "Tinggi";
                                        ?>
                                    <?php endforeach; ?>
                                    <div class="form-group">
                                        <label for="tinggi_badan">Hasil Gizi /Tinggi Badan Umur</label>
                                        <input type="text" name="hasil_tbu" id="hasil_tbu" class="form-control" value="<?= $hasil; ?>" readonly>
                                        <div class="invalid-feedback">
                                            <?= $validation->getError('hasil_tbu'); ?>
                                        </div>
                                    </div>
                                    <!-- Perhitungan BB/TB -->
                                    <?php foreach ($bbtb1 as $row) :  ?>
                                        <?php foreach ($bbtb2 as $row2) :  ?>
                                            <?php
                                            if ($key['umur'] <= 24) {
                                                if (($key['jenis_kelamin'] == $row['jenis_kelamin']) && ($key['tinggi_badan'] == $row['tinggi_badan'])) {

                                                    if ($key['berat_badan'] < $row['median']) {

                                                        $nsbr = $row['median'] - $row['sdmin1'];
                                                    } else {

                                                        $nsbr = $row['sdplus1'] - $row['median'];
                                                    }
                                                    $key['hasil_bbtb'] = (($key['berat_badan'] - $row['median']) / $nsbr);
                                                }
                                            } else {

                                                if (($key['jenis_kelamin'] == $row2['jenis_kelamin']) && ($key['tinggi_badan'] == $row2['tinggi_badan'])) {

                                                    if ($key['berat_badan'] < $row2['median']) {

                                                        $nsbr = $row2['median'] - $row2['sdmin1'];
                                                    } else {

                                                        $nsbr = $row2['sdplus1'] - $row2['median'];
                                                    }
                                                    $key['hasil_bbtb'] = (($key['berat_badan'] - $row2['median']) / $nsbr);
                                                }
                                            }
                                            if ($key['hasil_bbtb'] < -3)

                                                $hasil = "Sangat Kurus";

                                            elseif ($key['hasil_bbtb'] >= -3 && $key['hasil_bbtb'] < -2)

                                                $hasil = "Kurus";

                                            elseif ($key['hasil_bbtb'] >= -2 && $key['hasil_bbtb'] <= 2)

                                                $hasil = "Normal";

                                            elseif ($key['hasil_bbtb'] > 2)

                                                $hasil = "Gemuk";
                                            ?>
                                        <?php endforeach; ?>
                                    <?php endforeach; ?>
                                    <div class="form-group">
                                        <label for="hasil_bbtb">Hasil Gizi /Berat Badan Tinggi Badan</label>
                                        <input type="text" name="hasil_bbtb" id="hasil_bbtb" class="form-control" value="<?= $hasil; ?>" readonly>
                                        <div class="invalid-feedback">
                                            <?= $validation->getError('hasil_bbtb'); ?>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="nama">Catatan</label>
                                        <textarea type="text" name="catatan" id="catatan" class="form-control" value="<?= (old('catatan')); ?>"></textarea>
                                        <div class="invalid-feedback">
                                            <?= $validation->getError('catatan'); ?>
                                        </div>
                                    </div>
                                    <div class="footer" style=" float: right;">
                                        <a type="button" class="btn btn-secondary" href="/pertumbuhan">Kembali</a>
                                        <button type="submit" class="btn btn-primary">Simpan</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection(); ?>
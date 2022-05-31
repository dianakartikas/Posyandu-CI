<?= $this->extend('templates/index'); ?>
<?= $this->section('dashboard'); ?>
<div class="card-body">
    <div class="card shadow mb-4">
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <table class="table table-striped">
                        <tr>

                            <th>No KK :</th>

                            <td>
                                <?php if (empty($user->no_kk)) { ?>
                                    <a class="badge badge-danger">tidak ada data</a>
                                <?php } else  ?>
                                <?= $user->no_kk; ?>
                            </td>
                        </tr>
                        <tr>
                            <th>Nama Orangtua :</th>
                            <td><?= $user->fullname; ?></td>
                        </tr>
                        <tr>
                            <th>Nama :</th>
                            <td><?= $user->nama; ?></td>
                        </tr>
                        <tr>
                            <th>Jenis Kelamin :</th>
                            <td><?= $user->jenis_kelamin; ?></td>
                        </tr>


                    </table>
                </div>
                <div class="col-md-6">
                    <table class="table table-striped">
                        <tr>
                            <th>Tanggal Lahir :</th>
                            <td><?= date("d-m-Y", strtotime($user->tanggal_lahir)); ?></td>
                        </tr>
                        <tr>
                            <th>Tanggal terdaftar :</th>
                            <td><?= date("d-m-Y", strtotime($user->tanggalterdaftar)); ?></td>
                        </tr>
                        <tr>
                            <th>Berat badan lahir :</th>
                            <td><?= $user->bb_lahir; ?></td>
                        </tr>
                        <tr>
                            <th>Panjang badan lahir :</th>
                            <td><?= $user->tb_lahir; ?></td>
                        </tr>

                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="card-body">
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <a class="btn btn-primary" href="<?= base_url('kms'); ?>">
                <i class="fa fa-backward"></i> Kembali ke Data KMS
            </a>
        </div>
        <div class="card-body">
            <ul class="nav nav-tabs" id="myTab" role="tablist">
                <li class="nav-item">
                    <a class="nav-link active" id="kunjungan-tab" data-toggle="tab" href="#kunjungan" role="tab" aria-controls="kunjungan" aria-selected="true">Kunjungan</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="imunisasi-tab" data-toggle="tab" href="#imunisasi" role="tab" aria-controls="imunisasi" aria-selected="false">Imunisasi</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="pertumbuhan-tab" data-toggle="tab" href="#pertumbuhan" role="tab" aria-controls="pertumbuhan" aria-selected="false">Pertumbuhan</a>
                </li>
            </ul>
            <div class="tab-content" id="myTabContent">
                <div class="tab-pane fade show active" id="kunjungan" role="tabpanel" aria-labelledby="kunjungan-tab">
                    <div class="card shadow mb-4">
                        <!-- Card Header - Dropdown -->
                        <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                            <h6 class="m-0 font-weight-bold text-primary"></h6>
                            <div class="table-responsive">
                                <table class="table table-bordered table-sm" id="dataTable-kunjunganx" width="100%" cellspacing="0">

                                    <thead>
                                        <tr class="text-center">
                                            <th colspan="2">Kunjungan</th>
                                            <th colspan="2">Imunisasi</th>
                                            <th colspan="5">Pertumbuhan</th>
                                        </tr>
                                    </thead>
                                    <thead>
                                        <tr class="text-center">

                                            <th>Tanggal</th>
                                            <th>Status</th>
                                            <th>Nama</th>
                                            <th>Umur</th>
                                            <th>Berat Badan (kg)</th>
                                            <th>Panjang Badan (cm)</th>
                                            <th>Hasil BB/U</th>
                                            <th>Hasil TB/U</th>
                                            <th>Hasil BB/TB</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($detail as $row) : ?>
                                            <tr class="text-center">
                                                <td><span class="badge badge-primary btn-large"><?= date("d-m-Y", strtotime($row['tanggal'])); ?></span></td>

                                                <td><?= $row['status']; ?></td>
                                                <td>
                                                    <?php if (empty($row['nama'])) {
                                                    ?> -
                                                    <?php } else { ?>
                                                        <?= $row['nama']; ?> Bulan
                                                    <?php } ?>

                                                </td>
                                                <td>
                                                    <?php if (empty($row['umur'])) {
                                                    ?> -
                                                    <?php } else { ?>
                                                        <?= $row['umur']; ?> Bulan
                                                    <?php } ?>
                                                </td>
                                                <td>
                                                    <?php if (empty($row['berat_badan'])) {
                                                    ?> -
                                                    <?php } else { ?>
                                                        <?= $row['berat_badan']; ?>
                                                    <?php } ?>
                                                </td>
                                                <td>
                                                    <?php if (empty($row['tinggi_badan'])) {
                                                    ?> -
                                                    <?php } else { ?>
                                                        <?= $row['tinggi_badan']; ?>
                                                    <?php } ?>
                                                </td>
                                                <td>
                                                    <?php if (empty($row['hasil_bbu'])) {
                                                    ?> -
                                                    <?php } else { ?>
                                                        <?= $row['hasil_bbu']; ?>
                                                    <?php } ?>
                                                </td>
                                                <td>
                                                    <?php if (empty($row['hasil_tbu'])) {
                                                    ?> -
                                                    <?php } else { ?>
                                                        <?= $row['hasil_tbu']; ?>
                                                    <?php } ?>
                                                </td>
                                                <td>
                                                    <?php if (empty($row['hasil_bbtb'])) {
                                                    ?> -
                                                    <?php } else { ?>
                                                        <?= $row['hasil_bbtb']; ?>
                                                    <?php } ?>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                    <tfoot>
                                        <tr class="text-center">
                                            <th>Tanggal</th>
                                            <th>Status</th>
                                            <th>Nama</th>
                                            <th>Umur</th>
                                            <th>Berat Badan (kg)</th>
                                            <th>Panjang Badan (cm)</th>
                                            <th>Hasil BB/U</th>
                                            <th>Hasil TB/U</th>
                                            <th>Hasil BB/TB</th>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="tab-pane fade" id="imunisasi" role="tabpanel" aria-labelledby="imunisasi-tab">
                    <div class="card shadow mb-4">
                        <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                            <h6 class="m-0 font-weight-bold text-primary">Tabel Imunisasi</h6>
                            <div class="table-responsive">
                                <table class="table table-bordered table-sm" id="dataTable-imunisasi" width="100%" cellspacing="0">

                                    <thead>
                                        <tr class="text-center">

                                            <th>Tanggal</th>
                                            <th>Nama</th>
                                            <th>Umur</th>
                                            <th>Catatan</th>

                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($detail as $row) : ?>
                                            <tr class="text-center">
                                                <td><span class="badge badge-primary btn-large"><?= date("d-m-Y", strtotime($row['tanggal'])); ?></span></td>
                                                <td>
                                                    <?php if (empty($row['nama'])) {
                                                    ?> -
                                                    <?php } else { ?>
                                                        <?= $row['nama']; ?>
                                                    <?php } ?>

                                                </td>
                                                <td>
                                                    <?php if (empty($row['umur'])) {
                                                    ?> -
                                                    <?php } else { ?>
                                                        <?= $row['umur']; ?>
                                                    <?php } ?>
                                                </td>
                                                <td>
                                                    <?php if (empty($row['catatan'])) {
                                                    ?> -
                                                    <?php } else { ?>
                                                        <?= $row['catatan']; ?>
                                                    <?php } ?>
                                                </td>


                                            </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                    <tfoot>
                                        <tr class="text-center">
                                            <th>Tanggal</th>
                                            <th>Nama</th>
                                            <th>Umur</th>
                                            <th>Catatan</th>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="tab-pane fade" id="pertumbuhan" role="tabpanel" aria-labelledby="pertumbuhan-tab">
                    <div class="card shadow mb-4">
                        <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                            <h6 class="m-0 font-weight-bold text-primary">Tabel Pertumbuhan</h6>
                            <div class="table-responsive">
                                <table class="table table-bordered table-sm" id="dataTable" width="100%" cellspacing="0">
                                    <thead>
                                        <tr class="text-center">

                                            <th>Tanggal</th>
                                            <th>Umur</th>
                                            <th>Berat Badan</th>
                                            <th>Tinggi Badan</th>
                                            <th>Hasil BB/U</th>
                                            <th>Hasil TB/U</th>
                                            <th>Hasil BB/TB</th>
                                            <th>Catatan</th>

                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($detail as $row) : ?>
                                            <tr class="text-center">
                                                <td><span class="badge badge-primary btn-large"><?= date("d-m-Y", strtotime($row['tanggal'])); ?></span></td>
                                                <td>
                                                    <?php if (empty($row['cekumur'])) {
                                                    ?> -
                                                    <?php } else { ?>
                                                        <?= $row['cekumur']; ?> Bulan
                                                    <?php } ?>
                                                </td>

                                                <td>
                                                    <?php if (empty($row['berat_badan'])) {
                                                    ?> -
                                                    <?php } else { ?>
                                                        <?= $row['berat_badan']; ?>
                                                    <?php } ?>
                                                </td>
                                                <td>
                                                    <?php if (empty($row['tinggi_badan'])) {
                                                    ?> -
                                                    <?php } else { ?>
                                                        <?= $row['tinggi_badan']; ?>
                                                    <?php } ?>
                                                </td>
                                                <td>
                                                    <?php if (empty($row['hasil_bbu'])) {
                                                    ?> -
                                                    <?php } else { ?>
                                                        <?= $row['hasil_bbu']; ?>
                                                    <?php } ?>
                                                </td>
                                                <td>
                                                    <?php if (empty($row['hasil_tbu'])) {
                                                    ?> -
                                                    <?php } else { ?>
                                                        <?= $row['hasil_tbu']; ?>
                                                    <?php } ?>
                                                </td>
                                                <td>
                                                    <?php if (empty($row['hasil_bbtb'])) {
                                                    ?> -
                                                    <?php } else { ?>
                                                        <?= $row['hasil_bbtb']; ?>
                                                    <?php } ?>
                                                </td>
                                                <td>
                                                    <?php if (empty($row['catatan2'])) {
                                                    ?> -
                                                    <?php } else { ?>
                                                        <?= $row['catatan2']; ?>
                                                    <?php } ?>
                                                </td>

                                            </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                    <tfoot>
                                        <tr class="text-center">
                                            <th>Tanggal</th>
                                            <th>Umur</th>
                                            <th>Berat Badan</th>
                                            <th>Tinggi Badan</th>
                                            <th>Hasil BB/U</th>
                                            <th>Hasil TB/U</th>
                                            <th>Hasil BB/TB</th>
                                            <th>Catatan</th>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<script>
    $(document).ready(function() {
        $('#dataTable-imunisasi').DataTable({
            responsive: true
        });
    });
    $("div.id_100 select").val("val2").change();
</script>

<?= $this->endSection(); ?>
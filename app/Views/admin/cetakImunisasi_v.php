<?= $this->extend('templates/user'); ?>
<?= $this->section('dashboard'); ?>



<script src="<?= base_url(); ?>/js/jquery.min.js"></script>
<div class="card-body">
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h2>Pemeriksaan Imunisasi</h2>
        </div>
        <div class="card-body">
            <form method="get" action="">
                <div class="row">
                    <div class="col-sm-3 col-md-2">
                        <div class="form-group">
                            <label>Filter Berdasarkan</label>
                            <select name="filter" id="filter" class="form-control">
                                <option value="">Pilih</option>
                                <option value="1">Per Tanggal</option>
                                <option value="2">Per Bulan</option>
                                <option value="3">Per Tahun</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="row" id="form-tanggal">
                    <div class="col-sm-3 col-md-2">
                        <div class="form-group">
                            <label>Tanggal</label>
                            <input type="text" name="tanggal" class="form-control datepicker datetimepicker-input" data-toggle="datetimepicker" data-target=".datepicker" autocomplete="off" />
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-3 col-md-2" id="form-bulan">
                        <div class="form-group">
                            <label>Bulan</label>
                            <select name="bulan" class="form-control">
                                <option value="">Pilih</option>
                                <option value="1">Januari</option>
                                <option value="2">Februari</option>
                                <option value="3">Maret</option>
                                <option value="4">April</option>
                                <option value="5">Mei</option>
                                <option value="6">Juni</option>
                                <option value="7">Juli</option>
                                <option value="8">Agustus</option>
                                <option value="9">September</option>
                                <option value="10">Oktober</option>
                                <option value="11">November</option>
                                <option value="12">Desember</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-sm-3 col-md-2" id="form-tahun">
                        <div class="form-group">
                            <label>Tahun</label>
                            <select name="tahun" class="form-control">
                                <option value="">Pilih</option>
                                <?php
                                foreach ($option_tahun as $data) { // Ambil data tahun dari model yang dikirim dari controller
                                    echo '<option value="' . $data->tahun . '">' . $data->tahun . '</option>';
                                }
                                ?>
                            </select>
                        </div>
                    </div>
                </div>

                <button type="submit" class="btn btn-primary">Tampilkan</button>
                <a href="/cetakimunisasi" class="btn btn-secondary">Reset Filter</a>
            </form>
            <hr />

            <b><?php echo $label; ?></b><br /><br />
            <a href="<?php echo $url_export; ?>" class="btn btn-success btn-sm">EXPORT EXCEL</a><br /><br />

            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered table-sm" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr class="text-center">
                                <th> No. </th>
                                <th>Nama Kegiatan</th>
                                <th>Tanggal Pemeriksaan</th>
                                <th>Nomor KK</th>
                                <th>Nama Anak</th>
                                <th>Jenis Kelamin</th>
                                <th>Umur</th>
                                <th>Nama Imunisasi</th>
                                <th>Catatan</th>
                            </tr>
                        </thead>

                        <tfoot>
                            <tr class="text-center">
                                <th> No.</th>
                                <th>Nama Kegiatan</th>
                                <th>Tanggal Pemeriksaan</th>
                                <th>Nomor KK</th>
                                <th>Nama Anak</th>
                                <th>Jenis Kelamin</th>
                                <th>Umur</th>
                                <th>Nama Imunisasi</th>
                                <th>Catatan</th>
                            </tr>
                        </tfoot>
                        <tbody>
                            <?php
                            if (!empty($cetak)) {
                                $no = 1;
                                foreach ($cetak as $data) {

                                    echo "<tr class='text-center'>";
                                    echo "<td>" . $no++ . "</td>";
                                    echo "<td>" . $data->namaKegiatan . "</td>";
                                    echo "<td>" . date('d-m-Y', (strtotime($data->tgl_cek))) . "</td>";
                                    echo "<td>" . $data->no_kk . "</td>";
                                    echo "<td>" . $data->namaAnak . "</td>";
                                    echo "<td>" . $data->jenis_kelamin . "</td>";
                                    echo "<td>" . $data->umur . "</td>";
                                    echo "<td>" . $data->namaImunisasi . "</td>";
                                    echo "<td>" . $data->catatan . "</td>";
                                    echo "</tr>";
                                }
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Include File jQuery -->


<!-- Include library Datepicker Gijgo -->

<script src="<?= base_url(); ?>/assets/js/bootstrap.min.js"></script> <!-- Include file boootstrap.min.js -->
<script src="<?= base_url(); ?>/assets/libraries/moment/moment.min.js?>"></script> <!-- Include library Moment JS -->
<script src="<?= base_url(); ?>/assets/libraries/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js"></script>
<!-- Include file CSS Bootstrap -->

<!-- Include library Bootstrap Datepicker -->
<link href="<?= base_url(); ?>/bootstrap-datepicker/css/bootstrap-datepicker.min.css" rel="stylesheet">
<!-- Include library Datepicker Tempus Dominus -->
<!-- Include library Datepicker Tempus Dominus -->
<script>
    $(document).ready(function() { // Ketika halaman selesai di load
        setDatePicker() // Panggil fungsi setDatePicker

        $('#form-tanggal, #form-bulan, #form-tahun').hide(); // Sebagai default kita sembunyikan form filter tanggal, bulan & tahunnya

        $('#filter').change(function() { // Ketika user memilih filter
            if ($(this).val() == '1') { // Jika filter nya 1 (per tanggal)
                $('#form-bulan, #form-tahun').hide(); // Sembunyikan form bulan dan tahun
                $('#form-tanggal').show(); // Tampilkan form tanggal
            } else if ($(this).val() == '2') { // Jika filter nya 2 (per bulan)
                $('#form-tanggal').hide(); // Sembunyikan form tanggal
                $('#form-bulan, #form-tahun').show(); // Tampilkan form bulan dan tahun
            } else { // Jika filternya 3 (per tahun)
                $('#form-tanggal, #form-bulan').hide(); // Sembunyikan form tanggal dan bulan
                $('#form-tahun').show(); // Tampilkan form tahun
            }

            $('#form-tanggal input, #form-bulan select, #form-tahun select').val(''); // Clear data pada textbox tanggal, combobox bulan & tahun
        })
    })

    function setDatePicker() {
        $(".datepicker").datetimepicker({
            format: "YYYY-MM-DD",
            useCurrent: false
        })
    }
</script>



<?= $this->endSection(); ?>
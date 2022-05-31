<?= $this->extend('templates/user'); ?>
<?= $this->section('dashboard'); ?>



<script src="<?= base_url(); ?>/js/jquery.min.js"></script>
<div class="card-body">
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h2>Data yang Tidak Berkunjung</h2>


        </div>

        <div class="card-body">
            <b><?php echo $label; ?></b><br /><br />
            <a href="<?php echo $url_export; ?>" class="btn btn-success btn-sm">EXPORT EXCEL</a><br /><br />
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-sm" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr class="text-center">
                            <th> No.</th>

                            <th>Nomor KK</th>
                            <th>Nama Ayah</th>
                            <th>Nama Ibu</th>
                            <th>Nama Anak</th>
                            <th>Tanggal Lahir</th>
                            <th>Jenis Kelamin</th>

                        </tr>
                    </thead>

                    <tfoot>
                        <tr class="text-center">
                            <th> No.</th>

                            <th>Nomor KK</th>
                            <th>Nama Ayah</th>
                            <th>Nama Ibu</th>
                            <th>Nama Anak</th>
                            <th>Tanggal Lahir</th>
                            <th>Jenis Kelamin</th>

                        </tr>
                    </tfoot>
                    <tbody>
                        <?php
                        if (!empty($cetak)) {
                            $no = 1;
                            foreach ($cetak as $data) {

                                echo "<tr class='text-center'>";
                                echo "<td>" . $no++ . "</td>";
                                echo "<td>" . $data->no_kk . "</td>";
                                echo "<td>" . $data->nama_ayah . "</td>";
                                echo "<td>" . $data->nama_ibu . "</td>";
                                echo "<td>" . $data->nama . "</td>";
                                echo "<td>" . $data->tanggal_lahir . "</td>";
                                echo "<td>" . $data->jenis_kelamin . "</td>";

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
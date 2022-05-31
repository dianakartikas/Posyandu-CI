<?php

namespace App\Controllers;

use App\Models\UserModel;
use App\Models\AnakModel;
use App\Models\ImunisasiModel;
use App\Models\CekImunisasiModel;
use App\Models\CekPertumbuhanModel;
use App\Models\KunjunganModel;
use App\Models\KegiatanModel;
use App\Models\KmsModel;
use PHPExcel;
use PHPExcel_IOFactory;
use PHPExcel_Worksheet_PageSetup;
use PHPExcel_Style_Border;
use PHPExcel_Style_Alignment;


class Home extends BaseController
{
    protected $db, $builder;
    protected $UserModel;
    protected $AnakModel;
    protected $ImunisasiModel;
    protected $CekPertumbuhanModel;
    protected $KunjunganModel;
    protected $CekImunisasiModel;
    protected $KmsModel;
    protected $KegiatanModel;
    public function __construct()
    {

        $this->UserModel = new UserModel();
        $this->AnakModel = new AnakModel();
        $this->ImunisasiModel = new ImunisasiModel();
        $this->CekPertumbuhanModel = new CekPertumbuhanModel();
        $this->KunjunganModel = new KunjunganModel();
        $this->CekImunisasiModel = new CekImunisasiModel();
        $this->KegiatanModel = new KegiatanModel();
        $this->KmsModel = new KmsModel();
        $this->db      = \Config\Database::connect();
    }

    // Controller pengelolaan VIEW pada admin USERLIST
    public function index()
    {

        $data = [
            'title' => 'Selamat Datang di Sistem Posyandu Batu Horpak',
            'validation' => \Config\Services::validation(),
            'tambahuser' => $this->UserModel->getRole(),
            'keterangan' => '',
            'countkader' => $this->UserModel->countKader(),
            'countuser' => $this->UserModel->countUser(),
            'jumlah' => $this->AnakModel->countAnak(),
            'countimunisasi' => $this->ImunisasiModel->countImunisasi(),
            'chart' => $this->CekPertumbuhanModel->chart_gizi(),
            'chart2' => $this->KunjunganModel->chart_kunjungan(),
            'countKunjungan' => $this->KunjunganModel->countKunjungan(),
            'tampilAntrian' => $this->KunjunganModel->tampilAntrian(),
            'joinKunjungan' => $this->KunjunganModel->joinKunjungan(),
            'chart3' => $this->KunjunganModel->chart_antrian(),
            'kegiatan' => $this->KegiatanModel->getKegiatanHariIni(),
            'reset' => $this->KunjunganModel->resetKunjungan()


        ];
        $this->builder =  $this->db->table('kegiatan');
        $current_date = date("Y-m-d");
        // $this->builder->select('id, nama, lokasi, tanggal');
        // $this->builder->where('tanggal', $current_date);
        // $query = $this->builder->get();
        // $data['kegiatan'] = $query->getRow();
        $this->builder->select('id, nama, lokasi, tanggal');
        $this->builder->where('tanggal', $current_date);
        $query = $this->builder->get();
        $data['kegiatan'] = $query->getRow();
        return view('dashboard_v', $data);
    }

    public function cetakimunisasi()
    {
        $filter = $this->request->getGet('filter');

        if (isset($filter) && !empty($filter)) { // Cek apakah user telah memilih filter dan klik tombol tampilkan
            // Ambil data filder yang dipilih user
            if ($filter == '1') {
                // $cetak = $query->getResult(); // Panggil fungsi view_by_date yang ada di CekImunisasiModel
                $tgl_cek = $this->request->getGet('tanggal');
                $label = 'Data Pemeriksaan Imunisasi Tanggal ' . date('d-m-y', strtotime($tgl_cek));
                $url_export = '/cetakimunisasi/export?filter=1&tanggal=' . $tgl_cek;
                $cetak = $this->CekImunisasiModel->view_by_date($tgl_cek);
            } else if ($filter == '2') {

                $bulan = $this->request->getGet('bulan');
                $tahun = $this->request->getGet('tahun');
                $nama_bulan = array('', 'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember');
                $label = 'Data Pemeriksaan Imunisasi Bulan ' . $nama_bulan[$bulan] . ' ' . $tahun;
                $url_export = '/cetakimunisasi/export?filter=2&bulan=' . $bulan . '&tahun=' . $tahun;
                $cetak = $this->CekImunisasiModel->view_by_month($bulan, $tahun);
                // Panggil fungsi view_by_month yang ada di CekImunisasiModel
            } else { // Jika filter nya 3 (per tahun)
                $tahun = $this->request->getGet('tahun');
                $label = 'Data Pemeriksaan Imunisasi Tahun ' . $tahun;
                $url_export = '/cetakimunisasi/export?filter=3&tahun=' . $tahun;
                $cetak = $this->CekImunisasiModel->view_by_year($tahun);
            }
        } else {
            $label = 'Semua Data Pemeriksaan Imunisasi';
            $url_export = '/cetakimunisasi/export';
            $cetak = $this->CekImunisasiModel->view_all();
        }
        $data = [
            'cetak' => $cetak,
            'label' => $label,
            'title' => "Data Cetak Pemeriksaan Imunisasi",
            'keterangan' => "Data Cetak Pemeriksaan Imunisasi Posyandu Batu Horpak",
            'url_export' => base_url('/' . $url_export),
            'option_tahun' => $this->CekImunisasiModel->option_tahun(),
        ];
        // $data['cetak'] = $cetak;
        // $data['label'] = $label;
        // $data['tittle'] = 'Data Anak';

        // $data['url_export'] = base_url('/' . $url_export);

        // $data['option_tahun'] = $this->CekImunisasiModel->option_tahun();
        // $data['title'] = 'cetak';
        // $data['keterangan'] = 'cetak';
        return view('admin/cetakImunisasi_v', $data);
    }

    public function exportimunisasi()
    {
        // Load plugin PHPExcel nya


        // Panggil class PHPExcel nya
        $excel = new PHPExcel();

        // Settingan awal fil excel
        $excel->getProperties()->setCreator('Posyandu BatuHorpak')
            ->setLastModifiedBy('Posyandu BatuHorpak')
            ->setTitle("Data Pemeriksaan Imunisasi")
            ->setSubject("Pemeriksaan Imunisasi")
            ->setDescription("Laporan Semua Data Pemeriksaan Imunisasi")
            ->setKeywords("Data Pemeriksaan Imunisasi");
        $style_col = array(
            'font' => array('bold' => true), // Set font nya jadi bold
            'alignment' => array(
                'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
                'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER, // Set text jadi di tengah secara vertical (middle)
            ),
            'borders' => array(
                'top' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), // Set border top dengan garis tipis
                'right' => array('style'  => PHPExcel_Style_Border::BORDER_THIN),  // Set border right dengan garis tipis
                'bottom' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), // Set border bottom dengan garis tipis
                'left' => array('style'  => PHPExcel_Style_Border::BORDER_THIN) // Set border left dengan garis tipis
            )
        );
        // Buat sebuah variabel untuk menampung pengaturan style dari isi tabel
        $style_row = array(
            'alignment' => array(
                'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER, // Set text jadi di tengah secara vertical (middle)'alignment' => array(
                'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,

            ),
            'borders' => array(
                'top' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), // Set border top dengan garis tipis
                'right' => array('style'  => PHPExcel_Style_Border::BORDER_THIN),  // Set border right dengan garis tipis
                'bottom' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), // Set border bottom dengan garis tipis
                'left' => array('style'  => PHPExcel_Style_Border::BORDER_THIN) // Set border left dengan garis tipis
            )
        );

        // Buat sebuah variabel untuk menampung pengaturan style dari header tabel
        $filter = $this->request->getGet('filter');

        if (isset($filter) && !empty($filter)) { // Cek apakah user telah memilih filter dan klik tombol tampilkan
            // Ambil data filder yang dipilih user

            if ($filter == '1') { // Jika filter nya 1 (per tanggal)
                $tgl_cek = $this->request->getGet('tanggal');

                $label = 'Data Pemeriksaan Imunisasi Tanggal ' . date('d-m-y', strtotime($tgl_cek));
                $cetak = $this->CekImunisasiModel->view_by_date($tgl_cek); // Panggil fungsi view_by_date yang ada di CekImunisasiModel
            } else if ($filter == '2') { // Jika filter nya 2 (per bulan)
                $bulan = $this->request->getGet('bulan');
                $tahun = $this->request->getGet('tahun');
                $nama_bulan = array('', 'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember');

                $label = 'Data Pemeriksaan Imunisasi Bulan ' . $nama_bulan[$bulan] . ' ' . $tahun;
                $cetak = $this->CekImunisasiModel->view_by_month($bulan, $tahun); // Panggil fungsi view_by_month yang ada di CekImunisasiModel
            } else { // Jika filter nya 3 (per tahun)
                $tahun = $this->request->getGet('tahun');;

                $label = 'Data Pemeriksaan Imunisasi Tahun ' . $tahun;
                $cetak = $this->CekImunisasiModel->view_by_year($tahun); // Panggil fungsi view_by_year yang ada di CekImunisasiModel
            }
        } else { // Jika user tidak mengklik tombol tampilkan
            $label = 'Semua Data Pemeriksaan Imunisasi';
            $cetak = $this->CekImunisasiModel->view_all(); // Panggil fungsi view_all yang ada di CekImunisasiModel
        }

        $excel->setActiveSheetIndex(0);
        $excel->getActiveSheet()->setCellValue('A1', "DATA PEMERIKSAAN IMUNISASI"); // Set kolom A1 dengan tulisan "DATA SISWA"
        $excel->getActiveSheet()->mergeCells('A1:I1'); // Set Merge Cell pada kolom A1 sampai E1
        // Set bold kolom A1
        $excel->getActiveSheet()->getStyle('A1')->getFont()->setBold(TRUE)->setSize(16);
        $excel->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $excel->getActiveSheet()->getStyle('A2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $excel->getActiveSheet()->setCellValue('A2', $label); // Set kolom A2 sesuai dengan yang pada variabel $label
        $excel->getActiveSheet()->mergeCells('A2:I2'); // Set Merge Cell pada kolom A2 sampai E2
        $excel->getActiveSheet()->setCellValue('B4', "Kegiatan");
        $excel->getActiveSheet()->mergeCells('B4:C4');
        $excel->getActiveSheet()->getStyle('B4')->getFont()->setBold(TRUE);
        $excel->getActiveSheet()->getStyle('B4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

        $excel->getActiveSheet()->setCellValue('E4', "Data Anak");
        $excel->getActiveSheet()->mergeCells('E4:G4');
        $excel->getActiveSheet()->getStyle('E4')->getFont()->setBold(TRUE);
        $excel->getActiveSheet()->getStyle('E4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $excel->getActiveSheet()->setCellValue('H4', "Imunisasi");
        $excel->getActiveSheet()->mergeCells('H4:I4');
        $excel->getActiveSheet()->getStyle('H4')->getFont()->setBold(TRUE);
        $excel->getActiveSheet()->getStyle('H4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

        // Buat header tabel nya pada baris ke 4
        $excel->getActiveSheet()->setCellValue('A4', "No.");
        $excel->getActiveSheet()->mergeCells('A4:A5');
        $excel->getActiveSheet()->setCellValue('B5', "Nama");
        $excel->getActiveSheet()->setCellValue('C5', "Tanggal");
        $excel->getActiveSheet()->setCellValue('D4', "Nomor KK");
        $excel->getActiveSheet()->mergeCells('D4:D5');

        $excel->getActiveSheet()->setCellValue('E5', "Nama Anak");
        $excel->getActiveSheet()->setCellValue('F5', "P/L");
        $excel->getActiveSheet()->setCellValue('G5', "Umur");
        $excel->getActiveSheet()->setCellValue('H5', "Nama");
        $excel->getActiveSheet()->setCellValue('I5', "Catatan");
        // Apply style header yang telah kita buat tadi ke masing-masing kolom header

        $excel->getActiveSheet()->getStyle('A4')->applyFromArray($style_col);
        $excel->getActiveSheet()->getStyle('B4')->applyFromArray($style_col);
        $excel->getActiveSheet()->getStyle('C4')->applyFromArray($style_col);
        $excel->getActiveSheet()->getStyle('D4')->applyFromArray($style_col);
        $excel->getActiveSheet()->getStyle('E4')->applyFromArray($style_col);
        $excel->getActiveSheet()->getStyle('F4')->applyFromArray($style_col);
        $excel->getActiveSheet()->getStyle('G4')->applyFromArray($style_col);
        $excel->getActiveSheet()->getStyle('H4')->applyFromArray($style_col);
        $excel->getActiveSheet()->getStyle('I4')->applyFromArray($style_col);
        $excel->getActiveSheet()->getStyle('A5')->applyFromArray($style_col);
        $excel->getActiveSheet()->getStyle('B5')->applyFromArray($style_col);
        $excel->getActiveSheet()->getStyle('C5')->applyFromArray($style_col);
        $excel->getActiveSheet()->getStyle('D5')->applyFromArray($style_col);
        $excel->getActiveSheet()->getStyle('E5')->applyFromArray($style_col);
        $excel->getActiveSheet()->getStyle('F5')->applyFromArray($style_col);
        $excel->getActiveSheet()->getStyle('G5')->applyFromArray($style_col);
        $excel->getActiveSheet()->getStyle('H5')->applyFromArray($style_col);
        $excel->getActiveSheet()->getStyle('I5')->applyFromArray($style_col);
        // Set height baris ke 1, 2, 3 dan 4
        $excel->getActiveSheet()->getRowDimension('1')->setRowHeight(20);
        $excel->getActiveSheet()->getRowDimension('2')->setRowHeight(20);
        $excel->getActiveSheet()->getRowDimension('3')->setRowHeight(20);
        $excel->getActiveSheet()->getRowDimension('4')->setRowHeight(20);

        $no = 1; // Untuk penomoran tabel, di awal set dengan 1
        $numrow = 6; // Set baris pertama untuk isi tabel adalah baris ke 5
        $nomor = 1;
        foreach ($cetak as $data) { // Lakukan looping pada variabel cetak
            $tgl_cek = date('d-m-Y', strtotime($data->tgl_cek)); // Ubah format tanggal jadi dd-mm-yyyy

            $excel->getActiveSheet()->setCellValue('A' . $numrow, $nomor++);
            $excel->getActiveSheet()->setCellValue('B' . $numrow, $data->namaKegiatan);
            $excel->getActiveSheet()->setCellValue('C' . $numrow, $tgl_cek);
            $excel->getActiveSheet()->setCellValueExplicit('D' . $numrow, $data->no_kk);
            $excel->getActiveSheet()->setCellValue('E' . $numrow, $data->namaAnak);
            $excel->getActiveSheet()->setCellValue('F' . $numrow, $data->jenis_kelamin);
            $excel->getActiveSheet()->setCellValue('G' . $numrow, $data->umur);
            $excel->getActiveSheet()->setCellValue('H' . $numrow, $data->namaImunisasi);
            $excel->getActiveSheet()->setCellValue('I' . $numrow, $data->catatan);
            // Apply style row yang telah kita buat tadi ke masing-masing baris (isi tabel)
            $excel->getActiveSheet()->getStyle('A' . $numrow)->applyFromArray($style_row);
            $excel->getActiveSheet()->getStyle('B' . $numrow)->applyFromArray($style_row);
            $excel->getActiveSheet()->getStyle('C' . $numrow)->applyFromArray($style_row);
            $excel->getActiveSheet()->getStyle('D' . $numrow)->applyFromArray($style_row);
            $excel->getActiveSheet()->getStyle('E' . $numrow)->applyFromArray($style_row);
            $excel->getActiveSheet()->getStyle('F' . $numrow)->applyFromArray($style_row);
            $excel->getActiveSheet()->getStyle('G' . $numrow)->applyFromArray($style_row);
            $excel->getActiveSheet()->getStyle('H' . $numrow)->applyFromArray($style_row);
            $excel->getActiveSheet()->getStyle('I' . $numrow)->applyFromArray($style_row);

            $excel->getActiveSheet()->getRowDimension($numrow)->setRowHeight(20);

            $no++; // Tambah 1 setiap kali looping
            $numrow++; // Tambah 1 setiap kali looping
        }

        // Set width kolom
        $excel->getActiveSheet()->getColumnDimension('A')->setWidth(5); // Set width kolom A
        $excel->getActiveSheet()->getColumnDimension('B')->setWidth(30); // Set width kolom B
        $excel->getActiveSheet()->getColumnDimension('C')->setWidth(15); // Set width kolom C
        $excel->getActiveSheet()->getColumnDimension('D')->setWidth(25); // Set width kolom D
        $excel->getActiveSheet()->getColumnDimension('E')->setWidth(20); // Set width kolom E
        $excel->getActiveSheet()->getColumnDimension('F')->setWidth(8); // Set width kolom C
        $excel->getActiveSheet()->getColumnDimension('G')->setWidth(10); // Set width kolom D
        $excel->getActiveSheet()->getColumnDimension('H')->setWidth(15); // Set width kolom E
        $excel->getActiveSheet()->getColumnDimension('I')->setWidth(30); // Set width kolom E


        // Set orientasi kertas jadi LANDSCAPE
        $excel->getActiveSheet()->getPageSetup()->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_LANDSCAPE);
        $excel->getActiveSheet()->getPageSetup()->setPaperSize(PHPExcel_Worksheet_PageSetup::PAPERSIZE_LEGAL);

        // Set judul file excel nya
        $excel->getActiveSheet()->setTitle("Pemeriksaan Imunisasi");
        $excel->getActiveSheet();

        // Proses file excel
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment; filename="Data cekimunisasi.xlsx"'); // Set nama file excel nya
        header('Cache-Control: max-age=0');

        $write = PHPExcel_IOFactory::createWriter($excel, 'Excel2007');
        $write->save('php://output');
    }


    public function cetakpertumbuhan()
    {
        $filter = $this->request->getGet('filter');

        if (isset($filter) && !empty($filter)) { // Cek apakah user telah memilih filter dan klik tombol tampilkan
            // Ambil data filder yang dipilih user
            if ($filter == '1') {
                // $cetak = $query->getResult(); // Panggil fungsi view_by_date yang ada di CekImunisasiModel
                $tgl_cek = $this->request->getGet('tanggal');
                $label = 'Data Pemeriksaan Pertumbuhan Tanggal ' . date('d-m-y', strtotime($tgl_cek));
                $url_export = '/cetakpertumbuhan/export?filter=1&tanggal=' . $tgl_cek;
                $cetak = $this->CekPertumbuhanModel->view_by_date($tgl_cek);
            } else if ($filter == '2') {

                $bulan = $this->request->getGet('bulan');
                $tahun = $this->request->getGet('tahun');
                $nama_bulan = array('', 'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember');
                $label = 'Data Pemeriksaan Pertumbuhan Bulan ' . $nama_bulan[$bulan] . ' ' . $tahun;
                $url_export = '/cetakpertumbuhan/export?filter=2&bulan=' . $bulan . '&tahun=' . $tahun;
                $cetak = $this->CekPertumbuhanModel->view_by_month($bulan, $tahun);
                // Panggil fungsi view_by_month yang ada di CekPertumbuhanModel
            } else { // Jika filter nya 3 (per tahun)
                $tahun = $this->request->getGet('tahun');
                $label = 'Data Pemeriksaan Pertumbuhan Tahun ' . $tahun;
                $url_export = '/cetakpertumbuhan/export?filter=3&tahun=' . $tahun;
                $cetak = $this->CekPertumbuhanModel->view_by_year($tahun);
            }
        } else {
            $label = 'Semua Data Pemeriksaan Pertumbuhan';
            $url_export = '/cetakpertumbuhan/export';
            $cetak = $this->CekPertumbuhanModel->view_all();
        }
        $data = [
            'cetak' => $cetak,
            'label' => $label,
            'title' => "Data Cetak Pemeriksaan Pertumbuhan",
            'keterangan' => "Data Cetak Pemeriksaan Pertumbuhan Posyandu Batu Horpak",
            'url_export' => base_url('/' . $url_export),
            'option_tahun' => $this->CekPertumbuhanModel->option_tahun(),
        ];
        // $data['cetak'] = $cetak;
        // $data['label'] = $label;
        // $data['tittle'] = 'Data Anak';

        // $data['url_export'] = base_url('/' . $url_export);

        // $data['option_tahun'] = $this->CekImunisasiModel->option_tahun();
        // $data['title'] = 'cetak';
        // $data['keterangan'] = 'cetak';
        return view('admin/cetakPertumbuhan_v', $data);
    }

    public function exportpertumbuhan()
    {
        // Load plugin PHPExcel nya


        // Panggil class PHPExcel nya
        $excel = new PHPExcel();

        // Settingan awal fil excel
        $excel->getProperties()->setCreator('Posyandu BatuHorpak')
            ->setLastModifiedBy('Posyandu BatuHorpak')
            ->setTitle("Data Pemeriksaan Pertumbuhan")
            ->setSubject("Pemeriksaan Pertumbuhan")
            ->setDescription("Laporan Semua Data Pemeriksaan Pertumbuhan")
            ->setKeywords("Data Pemeriksaan Pertumbuhan");
        $style_col = array(
            'font' => array('bold' => true), // Set font nya jadi bold
            'alignment' => array(
                'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
                'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER, // Set text jadi di tengah secara vertical (middle)
            ),
            'borders' => array(
                'top' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), // Set border top dengan garis tipis
                'right' => array('style'  => PHPExcel_Style_Border::BORDER_THIN),  // Set border right dengan garis tipis
                'bottom' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), // Set border bottom dengan garis tipis
                'left' => array('style'  => PHPExcel_Style_Border::BORDER_THIN) // Set border left dengan garis tipis
            )
        );
        // Buat sebuah variabel untuk menampung pengaturan style dari isi tabel
        $style_row = array(
            'font' => array('size' => 9),
            'alignment' => array(
                'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER, // Set text jadi di tengah secara vertical (middle)'alignment' => array(
                'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,

            ),
            'borders' => array(
                'top' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), // Set border top dengan garis tipis
                'right' => array('style'  => PHPExcel_Style_Border::BORDER_THIN),  // Set border right dengan garis tipis
                'bottom' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), // Set border bottom dengan garis tipis
                'left' => array('style'  => PHPExcel_Style_Border::BORDER_THIN) // Set border left dengan garis tipis
            )
        );

        // Buat sebuah variabel untuk menampung pengaturan style dari header tabel
        $filter = $this->request->getGet('filter');

        if (isset($filter) && !empty($filter)) { // Cek apakah user telah memilih filter dan klik tombol tampilkan
            // Ambil data filder yang dipilih user

            if ($filter == '1') { // Jika filter nya 1 (per tanggal)
                $tgl_cek = $this->request->getGet('tanggal');

                $label = 'Data Pemeriksaan Pertumbuhan Tanggal ' . date('d-m-y', strtotime($tgl_cek));
                $cetak = $this->CekPertumbuhanModel->view_by_date($tgl_cek); // Panggil fungsi view_by_date yang ada di CekPertumbuhanModel
            } else if ($filter == '2') { // Jika filter nya 2 (per bulan)
                $bulan = $this->request->getGet('bulan');
                $tahun = $this->request->getGet('tahun');
                $nama_bulan = array('', 'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember');

                $label = 'Data Pemeriksaan Pertumbuhan Bulan ' . $nama_bulan[$bulan] . ' ' . $tahun;
                $cetak = $this->CekPertumbuhanModel->view_by_month($bulan, $tahun); // Panggil fungsi view_by_month yang ada di CekPertumbuhanModel
            } else { // Jika filter nya 3 (per tahun)
                $tahun = $this->request->getGet('tahun');;

                $label = 'Data Pemeriksaan Pertumbuhan Tahun ' . $tahun;
                $cetak = $this->CekPertumbuhanModel->view_by_year($tahun); // Panggil fungsi view_by_year yang ada di CekPertumbuhanModel
            }
        } else { // Jika user tidak mengklik tombol tampilkan
            $label = 'Semua Data Pemeriksaan Pertumbuhan';
            $cetak = $this->CekPertumbuhanModel->view_all(); // Panggil fungsi view_all yang ada di CekImunisasiModel
        }

        $excel->setActiveSheetIndex(0);
        $excel->getActiveSheet()->setCellValue('A1', "DATA PEMERIKSAAN PERTUMBUHAN"); // Set kolom A1 dengan tulisan "DATA SISWA"
        $excel->getActiveSheet()->mergeCells('A1:M1'); // Set Merge Cell pada kolom A1 sampai E1
        // Set bold kolom A1
        $excel->getActiveSheet()->getStyle('A1')->getFont()->setBold(TRUE)->setSize(16);
        $excel->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $excel->getActiveSheet()->getStyle('A2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $excel->getActiveSheet()->setCellValue('A2', $label); // Set kolom A2 sesuai dengan yang pada variabel $label
        $excel->getActiveSheet()->mergeCells('A2:M2'); // Set Merge Cell pada kolom A2 sampai E2
        $excel->getActiveSheet()->setCellValue('B4', "Kegiatan");
        $excel->getActiveSheet()->mergeCells('B4:C4');
        $excel->getActiveSheet()->getStyle('B4')->getFont()->setBold(TRUE);
        $excel->getActiveSheet()->getStyle('B4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

        $excel->getActiveSheet()->setCellValue('E4', "Data Anak");
        $excel->getActiveSheet()->mergeCells('E4:I4');
        $excel->getActiveSheet()->getStyle('E4')->getFont()->setBold(TRUE);
        $excel->getActiveSheet()->getStyle('E4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $excel->getActiveSheet()->setCellValue('J4', "Hasil");
        $excel->getActiveSheet()->mergeCells('H4:L4');
        $excel->getActiveSheet()->getStyle('J4')->getFont()->setBold(TRUE);
        $excel->getActiveSheet()->getStyle('J4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

        // Buat header tabel nya pada baris ke 4
        $excel->getActiveSheet()->setCellValue('A4', "No.");
        $excel->getActiveSheet()->mergeCells('A4:A5');
        $excel->getActiveSheet()->setCellValue('B5', "Nama");
        $excel->getActiveSheet()->setCellValue('C5', "Tanggal");
        $excel->getActiveSheet()->setCellValue('D4', "Nomor KK");
        $excel->getActiveSheet()->mergeCells('D4:D5');
        $excel->getActiveSheet()->setCellValue('E5', "Nama Anak");
        $excel->getActiveSheet()->setCellValue('F5', "P/L");
        $excel->getActiveSheet()->setCellValue('G5', "Umur(bulan)");
        $excel->getActiveSheet()->setCellValue('H5', "BB(KG)");
        $excel->getActiveSheet()->setCellValue('I5', "TB(KG)");
        $excel->getActiveSheet()->setCellValue('J5', "BB/U");
        $excel->getActiveSheet()->setCellValue('K5', "TB/U");
        $excel->getActiveSheet()->setCellValue('L5', "BB/TB");
        $excel->getActiveSheet()->setCellValue('M5', "Catatan");
        // Apply style header yang telah kita buat tadi ke masing-masing kolom header

        $excel->getActiveSheet()->getStyle('A4')->applyFromArray($style_col);
        $excel->getActiveSheet()->getStyle('B4')->applyFromArray($style_col);
        $excel->getActiveSheet()->getStyle('C4')->applyFromArray($style_col);
        $excel->getActiveSheet()->getStyle('D4')->applyFromArray($style_col);
        $excel->getActiveSheet()->getStyle('E4')->applyFromArray($style_col);
        $excel->getActiveSheet()->getStyle('F4')->applyFromArray($style_col);
        $excel->getActiveSheet()->getStyle('G4')->applyFromArray($style_col);
        $excel->getActiveSheet()->getStyle('H4')->applyFromArray($style_col);
        $excel->getActiveSheet()->getStyle('I4')->applyFromArray($style_col);
        $excel->getActiveSheet()->getStyle('J4')->applyFromArray($style_col);
        $excel->getActiveSheet()->getStyle('K4')->applyFromArray($style_col);
        $excel->getActiveSheet()->getStyle('L4')->applyFromArray($style_col);
        $excel->getActiveSheet()->getStyle('M4')->applyFromArray($style_col);
        $excel->getActiveSheet()->getStyle('A5')->applyFromArray($style_col);
        $excel->getActiveSheet()->getStyle('B5')->applyFromArray($style_col);
        $excel->getActiveSheet()->getStyle('C5')->applyFromArray($style_col);
        $excel->getActiveSheet()->getStyle('D5')->applyFromArray($style_col);
        $excel->getActiveSheet()->getStyle('E5')->applyFromArray($style_col);
        $excel->getActiveSheet()->getStyle('F5')->applyFromArray($style_col);
        $excel->getActiveSheet()->getStyle('G5')->applyFromArray($style_col);
        $excel->getActiveSheet()->getStyle('H5')->applyFromArray($style_col);
        $excel->getActiveSheet()->getStyle('I5')->applyFromArray($style_col);
        $excel->getActiveSheet()->getStyle('J5')->applyFromArray($style_col);
        $excel->getActiveSheet()->getStyle('K5')->applyFromArray($style_col);
        $excel->getActiveSheet()->getStyle('L5')->applyFromArray($style_col);
        $excel->getActiveSheet()->getStyle('M5')->applyFromArray($style_col);
        // Set height baris ke 1, 2, 3 dan 4
        $excel->getActiveSheet()->getRowDimension('1')->setRowHeight(20);
        $excel->getActiveSheet()->getRowDimension('2')->setRowHeight(20);
        $excel->getActiveSheet()->getRowDimension('3')->setRowHeight(20);
        $excel->getActiveSheet()->getRowDimension('4')->setRowHeight(20);

        $no = 1; // Untuk penomoran tabel, di awal set dengan 1
        $numrow = 6; // Set baris pertama untuk isi tabel adalah baris ke 5
        $nomor = 1;
        foreach ($cetak as $data) { // Lakukan looping pada variabel cetak
            $tgl_cek = date('d-m-Y', strtotime($data->tgl_cek)); // Ubah format tanggal jadi dd-mm-yyyy

            $excel->getActiveSheet()->setCellValue('A' . $numrow, $nomor++);
            $excel->getActiveSheet()->setCellValue('B' . $numrow, $data->namaKegiatan);
            $excel->getActiveSheet()->setCellValue('C' . $numrow, $tgl_cek);
            $excel->getActiveSheet()->setCellValueExplicit('D' . $numrow, $data->no_kk);
            $excel->getActiveSheet()->setCellValue('E' . $numrow, $data->namaAnak);
            $excel->getActiveSheet()->setCellValue('F' . $numrow, $data->jenis_kelamin);
            $excel->getActiveSheet()->setCellValue('G' . $numrow, $data->umur);
            $excel->getActiveSheet()->setCellValue('H' . $numrow, $data->berat_badan);
            $excel->getActiveSheet()->setCellValue('I' . $numrow, $data->tinggi_badan);
            $excel->getActiveSheet()->setCellValue('J' . $numrow, $data->hasil_bbu);
            $excel->getActiveSheet()->setCellValue('K' . $numrow, $data->hasil_tbu);
            $excel->getActiveSheet()->setCellValue('L' . $numrow, $data->hasil_bbtb);
            $excel->getActiveSheet()->setCellValue('M' . $numrow, $data->catatan);
            // Apply style row yang telah kita buat tadi ke masing-masing baris (isi tabel)
            $excel->getActiveSheet()->getStyle('A' . $numrow)->applyFromArray($style_row);
            $excel->getActiveSheet()->getStyle('B' . $numrow)->applyFromArray($style_row);
            $excel->getActiveSheet()->getStyle('C' . $numrow)->applyFromArray($style_row);
            $excel->getActiveSheet()->getStyle('D' . $numrow)->applyFromArray($style_row);
            $excel->getActiveSheet()->getStyle('E' . $numrow)->applyFromArray($style_row);
            $excel->getActiveSheet()->getStyle('F' . $numrow)->applyFromArray($style_row);
            $excel->getActiveSheet()->getStyle('G' . $numrow)->applyFromArray($style_row);
            $excel->getActiveSheet()->getStyle('H' . $numrow)->applyFromArray($style_row);
            $excel->getActiveSheet()->getStyle('I' . $numrow)->applyFromArray($style_row);
            $excel->getActiveSheet()->getStyle('J' . $numrow)->applyFromArray($style_row);
            $excel->getActiveSheet()->getStyle('K' . $numrow)->applyFromArray($style_row);
            $excel->getActiveSheet()->getStyle('L' . $numrow)->applyFromArray($style_row);
            $excel->getActiveSheet()->getStyle('M' . $numrow)->applyFromArray($style_row);

            $excel->getActiveSheet()->getRowDimension($numrow)->setRowHeight(20);

            $no++; // Tambah 1 setiap kali looping
            $numrow++; // Tambah 1 setiap kali looping
        }

        // Set width kolom
        $excel->getActiveSheet()->getColumnDimension('A')->setWidth(4); // Set width kolom A
        $excel->getActiveSheet()->getColumnDimension('B')->setWidth(30); // Set width kolom B
        $excel->getActiveSheet()->getColumnDimension('C')->setWidth(10); // Set width kolom C
        $excel->getActiveSheet()->getColumnDimension('D')->setWidth(15); // Set width kolom D
        $excel->getActiveSheet()->getColumnDimension('E')->setWidth(15); // Set width kolom E
        $excel->getActiveSheet()->getColumnDimension('F')->setWidth(4); // Set width kolom C
        $excel->getActiveSheet()->getColumnDimension('G')->setWidth(5); // Set width kolom D
        $excel->getActiveSheet()->getColumnDimension('H')->setWidth(7); // Set width kolom E
        $excel->getActiveSheet()->getColumnDimension('I')->setWidth(8); // Set width kolom E
        $excel->getActiveSheet()->getColumnDimension('J')->setWidth(10); // Set width kolom C
        $excel->getActiveSheet()->getColumnDimension('K')->setWidth(11); // Set width kolom D
        $excel->getActiveSheet()->getColumnDimension('L')->setWidth(10); // Set width kolom E
        $excel->getActiveSheet()->getColumnDimension('M')->setWidth(30);

        // Set orientasi kertas jadi LANDSCAPE
        $excel->getActiveSheet()->getPageSetup()->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_LANDSCAPE);
        $excel->getActiveSheet()->getPageSetup()->setPaperSize(PHPExcel_Worksheet_PageSetup::PAPERSIZE_LEGAL);

        // Set judul file excel nya
        $excel->getActiveSheet()->setTitle("Pemeriksaan Pertumbuhan");
        $excel->getActiveSheet();

        // Proses file excel
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment; filename="Data cekpertumbuhan.xlsx"'); // Set nama file excel nya
        header('Cache-Control: max-age=0');

        $write = PHPExcel_IOFactory::createWriter($excel, 'Excel2007');
        $write->save('php://output');
    }

    public function cetakgagalPemeriksaan()
    {
        $filter = $this->request->getGet('filter');

        if (isset($filter) && !empty($filter)) { // Cek apakah user telah memilih filter dan klik tombol tampilkan
            // Ambil data filder yang dipilih user
            if ($filter == '1') {
                // $cetak = $query->getResult(); // Panggil fungsi view_by_date yang ada di CekImunisasiModel
                $tanggal_kunjungan = $this->request->getGet('tanggal');
                $label = 'Data Pemeriksaan yang Gagal Tanggal ' . date('d-m-y', strtotime($tanggal_kunjungan));
                $url_export = '/cetakgagalperiksa/export?filter=1&tanggal=' . $tanggal_kunjungan;
                $cetak = $this->KunjunganModel->view_by_date($tanggal_kunjungan);
            } else if ($filter == '2') {

                $bulan = $this->request->getGet('bulan');
                $tahun = $this->request->getGet('tahun');
                $nama_bulan = array('', 'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember');
                $label = 'Data Pemeriksaan yang Gagal Bulan ' . $nama_bulan[$bulan] . ' ' . $tahun;
                $url_export = '/cetakgagalperiksa/export?filter=2&bulan=' . $bulan . '&tahun=' . $tahun;
                $cetak = $this->KunjunganModel->view_by_month($bulan, $tahun);
                // Panggil fungsi view_by_month yang ada di KunjunganModel
            } else { // Jika filter nya 3 (per tahun)
                $tahun = $this->request->getGet('tahun');
                $label = 'Data Pemeriksaan yang Gagal Tahun ' . $tahun;
                $url_export = '/cetakgagalperiksa/export?filter=3&tahun=' . $tahun;
                $cetak = $this->KunjunganModel->view_by_year($tahun);
            }
        } else {
            $label = 'Semua Data Pemeriksaan yang Gagal';
            $url_export = '/cetakgagalperiksa/export';
            $cetak = $this->KunjunganModel->view_all();
        }
        $data = [
            'cetak' => $cetak,
            'label' => $label,
            'title' => "Data Cetak Pemeriksaan yang Gagal",
            'keterangan' => "Data Cetak Pemeriksaan yang Gagal Posyandu Batu Horpak",
            'url_export' => base_url('/' . $url_export),
            'option_tahun' => $this->KunjunganModel->option_tahun(),
        ];
        // $data['cetak'] = $cetak;
        // $data['label'] = $label;
        // $data['tittle'] = 'Data Anak';

        // $data['url_export'] = base_url('/' . $url_export);

        // $data['option_tahun'] = $this->CekImunisasiModel->option_tahun();
        // $data['title'] = 'cetak';
        // $data['keterangan'] = 'cetak';
        return view('admin/cetakGagalPeriksa_v', $data);
    }
    public function exportgagalperiksa()
    {
        // Load plugin PHPExcel nya


        // Panggil class PHPExcel nya
        $excel = new PHPExcel();

        // Settingan awal fil excel
        $excel->getProperties()->setCreator('Posyandu BatuHorpak')
            ->setLastModifiedBy('Posyandu BatuHorpak')
            ->setTitle("Data Pemeriksaan yang Gagal")
            ->setSubject("Pemeriksaan yang Gagal")
            ->setDescription("Laporan Semua Data Pemeriksaan yang Gagal")
            ->setKeywords("Data Pemeriksaan yang Gagal");
        $style_col = array(
            'font' => array('bold' => true), // Set font nya jadi bold
            'alignment' => array(
                'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
                'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER, // Set text jadi di tengah secara vertical (middle)
            ),
            'borders' => array(
                'top' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), // Set border top dengan garis tipis
                'right' => array('style'  => PHPExcel_Style_Border::BORDER_THIN),  // Set border right dengan garis tipis
                'bottom' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), // Set border bottom dengan garis tipis
                'left' => array('style'  => PHPExcel_Style_Border::BORDER_THIN) // Set border left dengan garis tipis
            )
        );
        // Buat sebuah variabel untuk menampung pengaturan style dari isi tabel
        $style_row = array(
            'font' => array('size' => 9),
            'alignment' => array(
                'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER, // Set text jadi di tengah secara vertical (middle)'alignment' => array(
                'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,

            ),
            'borders' => array(
                'top' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), // Set border top dengan garis tipis
                'right' => array('style'  => PHPExcel_Style_Border::BORDER_THIN),  // Set border right dengan garis tipis
                'bottom' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), // Set border bottom dengan garis tipis
                'left' => array('style'  => PHPExcel_Style_Border::BORDER_THIN) // Set border left dengan garis tipis
            )
        );

        // Buat sebuah variabel untuk menampung pengaturan style dari header tabel
        $filter = $this->request->getGet('filter');

        if (isset($filter) && !empty($filter)) { // Cek apakah user telah memilih filter dan klik tombol tampilkan
            // Ambil data filder yang dipilih user

            if ($filter == '1') { // Jika filter nya 1 (per tanggal)
                $tanggal_kunjungan = $this->request->getGet('tanggal');

                $label = 'Data Pemeriksaan yang Gagal Tanggal ' . date('d-m-y', strtotime($tanggal_kunjungan));
                $cetak = $this->KunjunganModel->view_by_date($tanggal_kunjungan); // Panggil fungsi view_by_date yang ada di KunjunganModel
            } else if ($filter == '2') { // Jika filter nya 2 (per bulan)
                $bulan = $this->request->getGet('bulan');
                $tahun = $this->request->getGet('tahun');
                $nama_bulan = array('', 'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember');

                $label = 'Data Pemeriksaan yang Gagal Bulan ' . $nama_bulan[$bulan] . ' ' . $tahun;
                $cetak = $this->KunjunganModel->view_by_month($bulan, $tahun); // Panggil fungsi view_by_month yang ada di KunjunganModel
            } else { // Jika filter nya 3 (per tahun)
                $tahun = $this->request->getGet('tahun');;

                $label = 'Data Pemeriksaan yang Gagal Tahun ' . $tahun;
                $cetak = $this->KunjunganModel->view_by_year($tahun); // Panggil fungsi view_by_year yang ada di KunjunganModel
            }
        } else { // Jika user tidak mengklik tombol tampilkan
            $label = 'Semua Data Pemeriksaan yang Gagal';
            $cetak = $this->KunjunganModel->view_all(); // Panggil fungsi view_all yang ada di CekImunisasiModel
        }

        $excel->setActiveSheetIndex(0);
        $excel->getActiveSheet()->setCellValue('A1', "DATA PEMERIKSAAN YANG GAGAL"); // Set kolom A1 dengan tulisan "DATA SISWA"
        $excel->getActiveSheet()->mergeCells('A1:H1'); // Set Merge Cell pada kolom A1 sampai E1
        // Set bold kolom A1
        $excel->getActiveSheet()->getStyle('A1')->getFont()->setBold(TRUE)->setSize(16);
        $excel->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $excel->getActiveSheet()->getStyle('A2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $excel->getActiveSheet()->setCellValue('A2', $label); // Set kolom A2 sesuai dengan yang pada variabel $label
        $excel->getActiveSheet()->mergeCells('A2:H2'); // Set Merge Cell pada kolom A2 sampai E2
        $excel->getActiveSheet()->setCellValue('C4', "Data Keluarga");
        $excel->getActiveSheet()->mergeCells('C4:E4');
        $excel->getActiveSheet()->getStyle('C4')->getFont()->setBold(TRUE);
        $excel->getActiveSheet()->getStyle('C4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

        $excel->getActiveSheet()->setCellValue('F4', "Data Anak");
        $excel->getActiveSheet()->mergeCells('F4:H4');
        $excel->getActiveSheet()->getStyle('E4')->getFont()->setBold(TRUE);
        $excel->getActiveSheet()->getStyle('E4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);


        // Buat header tabel nya pada baris ke 4
        $excel->getActiveSheet()->setCellValue('A4', "No.");
        $excel->getActiveSheet()->mergeCells('A4:A5');
        $excel->getActiveSheet()->setCellValue('B4', "Tanggal Kegiatan");
        $excel->getActiveSheet()->mergeCells('B4:B5');
        $excel->getActiveSheet()->setCellValue('C5', "Nomor KK");
        $excel->getActiveSheet()->setCellValue('D5', "Nama Ayah");
        $excel->getActiveSheet()->setCellValue('E5', "Nama Ibu");
        $excel->getActiveSheet()->setCellValue('F5', "Nama Anak");
        $excel->getActiveSheet()->setCellValue('G5', "Tanggal Lahir");
        $excel->getActiveSheet()->setCellValue('H5', "Jenis Kelamin");

        // Apply style header yang telah kita buat tadi ke masing-masing kolom header

        $excel->getActiveSheet()->getStyle('A4')->applyFromArray($style_col);
        $excel->getActiveSheet()->getStyle('B4')->applyFromArray($style_col);
        $excel->getActiveSheet()->getStyle('C4')->applyFromArray($style_col);
        $excel->getActiveSheet()->getStyle('D4')->applyFromArray($style_col);
        $excel->getActiveSheet()->getStyle('E4')->applyFromArray($style_col);
        $excel->getActiveSheet()->getStyle('F4')->applyFromArray($style_col);
        $excel->getActiveSheet()->getStyle('G4')->applyFromArray($style_col);
        $excel->getActiveSheet()->getStyle('H4')->applyFromArray($style_col);
        $excel->getActiveSheet()->getStyle('A5')->applyFromArray($style_col);
        $excel->getActiveSheet()->getStyle('B5')->applyFromArray($style_col);
        $excel->getActiveSheet()->getStyle('C5')->applyFromArray($style_col);
        $excel->getActiveSheet()->getStyle('D5')->applyFromArray($style_col);
        $excel->getActiveSheet()->getStyle('E5')->applyFromArray($style_col);
        $excel->getActiveSheet()->getStyle('F5')->applyFromArray($style_col);
        $excel->getActiveSheet()->getStyle('G5')->applyFromArray($style_col);
        $excel->getActiveSheet()->getStyle('H5')->applyFromArray($style_col);

        // Set height baris ke 1, 2, 3 dan 4
        $excel->getActiveSheet()->getRowDimension('1')->setRowHeight(20);
        $excel->getActiveSheet()->getRowDimension('2')->setRowHeight(20);
        $excel->getActiveSheet()->getRowDimension('3')->setRowHeight(20);
        $excel->getActiveSheet()->getRowDimension('4')->setRowHeight(20);

        $no = 1; // Untuk penomoran tabel, di awal set dengan 1
        $numrow = 6; // Set baris pertama untuk isi tabel adalah baris ke 5
        $nomor = 1;
        foreach ($cetak as $data) { // Lakukan looping pada variabel cetak
            $tanggal_kunjungan = date('d-m-Y', strtotime($data->tanggal_kunjungan)); // Ubah format tanggal jadi dd-mm-yyyy

            $excel->getActiveSheet()->setCellValue('A' . $numrow, $nomor++);
            $excel->getActiveSheet()->setCellValue('B' . $numrow, $tanggal_kunjungan);
            $excel->getActiveSheet()->setCellValueExplicit('C' . $numrow, $data->no_kk);
            $excel->getActiveSheet()->setCellValue('D' . $numrow, $data->nama_ayah);
            $excel->getActiveSheet()->setCellValue('E' . $numrow, $data->nama_ibu);
            $excel->getActiveSheet()->setCellValue('F' . $numrow, $data->nama);
            $excel->getActiveSheet()->setCellValue('G' . $numrow, $data->tanggal_lahir);
            $excel->getActiveSheet()->setCellValue('H' . $numrow, $data->jenis_kelamin);

            // Apply style row yang telah kita buat tadi ke masing-masing baris (isi tabel)
            $excel->getActiveSheet()->getStyle('A' . $numrow)->applyFromArray($style_row);
            $excel->getActiveSheet()->getStyle('B' . $numrow)->applyFromArray($style_row);
            $excel->getActiveSheet()->getStyle('C' . $numrow)->applyFromArray($style_row);
            $excel->getActiveSheet()->getStyle('D' . $numrow)->applyFromArray($style_row);
            $excel->getActiveSheet()->getStyle('E' . $numrow)->applyFromArray($style_row);
            $excel->getActiveSheet()->getStyle('F' . $numrow)->applyFromArray($style_row);
            $excel->getActiveSheet()->getStyle('G' . $numrow)->applyFromArray($style_row);
            $excel->getActiveSheet()->getStyle('H' . $numrow)->applyFromArray($style_row);


            $excel->getActiveSheet()->getRowDimension($numrow)->setRowHeight(20);

            $no++; // Tambah 1 setiap kali looping
            $numrow++; // Tambah 1 setiap kali looping
        }

        // Set width kolom
        $excel->getActiveSheet()->getColumnDimension('A')->setWidth(4); // Set width kolom A
        $excel->getActiveSheet()->getColumnDimension('B')->setWidth(30); // Set width kolom B
        $excel->getActiveSheet()->getColumnDimension('C')->setWidth(15); // Set width kolom C
        $excel->getActiveSheet()->getColumnDimension('D')->setWidth(15); // Set width kolom D
        $excel->getActiveSheet()->getColumnDimension('E')->setWidth(15); // Set width kolom E
        $excel->getActiveSheet()->getColumnDimension('F')->setWidth(15); // Set width kolom C
        $excel->getActiveSheet()->getColumnDimension('G')->setWidth(20); // Set width kolom D
        $excel->getActiveSheet()->getColumnDimension('H')->setWidth(15); // Set width kolom E


        // Set orientasi kertas jadi LANDSCAPE
        $excel->getActiveSheet()->getPageSetup()->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_LANDSCAPE);
        $excel->getActiveSheet()->getPageSetup()->setPaperSize(PHPExcel_Worksheet_PageSetup::PAPERSIZE_LEGAL);

        // Set judul file excel nya
        $excel->getActiveSheet()->setTitle("Pemeriksaan Yang Gagal");
        $excel->getActiveSheet();

        // Proses file excel
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment; filename="Data cekgagalperiksa.xlsx"'); // Set nama file excel nya
        header('Cache-Control: max-age=0');

        $write = PHPExcel_IOFactory::createWriter($excel, 'Excel2007');
        $write->save('php://output');
    }

    public function cetaktidakberkunjung()
    {
        $cetak = $this->KmsModel->view_all();
        $current_date = date("d-m-Y");
        $data = [
            'cetak' => $cetak,
            'label' => "Data Tidak Berkunjung $current_date",
            'title' => "Data Tidak Berkunjung pada Kegiatan Hari Ini",
            'keterangan' => "Data Cetak Tidak Berkunjung Posyandu Batu Horpak",
            'url_export' => base_url('/cetaktidakberkunjung/export'),


        ];
        // $data['cetak'] = $cetak;
        // $data['label'] = $label;
        // $data['tittle'] = 'Data Anak';

        // $data['url_export'] = base_url('/' . $url_export);

        // $data['option_tahun'] = $this->CekImunisasiModel->option_tahun();
        // $data['title'] = 'cetak';
        // $data['keterangan'] = 'cetak';
        return view('admin/cetakTidakBerkunjung_v', $data);
    }
    public function exporttidakberkunjung()
    {
        // Load plugin PHPExcel nya


        // Panggil class PHPExcel nya
        $excel = new PHPExcel();

        // Settingan awal fil excel
        $excel->getProperties()->setCreator('Posyandu BatuHorpak')
            ->setLastModifiedBy('Posyandu BatuHorpak')
            ->setTitle("Data Tidak Berkunjung")
            ->setSubject("Tidak Berkunjung")
            ->setDescription("Laporan Semua Data Tidak Berkunjung")
            ->setKeywords("Data Tidak Berkunjung");
        $style_col = array(
            'font' => array('bold' => true), // Set font nya jadi bold
            'alignment' => array(
                'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
                'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER, // Set text jadi di tengah secara vertical (middle)
            ),
            'borders' => array(
                'top' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), // Set border top dengan garis tipis
                'right' => array('style'  => PHPExcel_Style_Border::BORDER_THIN),  // Set border right dengan garis tipis
                'bottom' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), // Set border bottom dengan garis tipis
                'left' => array('style'  => PHPExcel_Style_Border::BORDER_THIN) // Set border left dengan garis tipis
            )
        );
        // Buat sebuah variabel untuk menampung pengaturan style dari isi tabel
        $style_row = array(
            'font' => array('size' => 12),
            'alignment' => array(
                'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER, // Set text jadi di tengah secara vertical (middle)'alignment' => array(
                'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,

            ),
            'borders' => array(
                'top' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), // Set border top dengan garis tipis
                'right' => array('style'  => PHPExcel_Style_Border::BORDER_THIN),  // Set border right dengan garis tipis
                'bottom' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), // Set border bottom dengan garis tipis
                'left' => array('style'  => PHPExcel_Style_Border::BORDER_THIN) // Set border left dengan garis tipis
            )
        );

        // Buat sebuah variabel untuk menampung pengaturan style dari header tabel

        $label = 'Semua Data Tidak Berkunjung pada Kegiatan Hari Ini';
        $cetak = $this->KmsModel->view_all(); // Panggil fungsi view_all yang ada di CekImunisasiModel


        $excel->setActiveSheetIndex(0);
        $excel->getActiveSheet()->setCellValue('A1', "DATA TIDAK BERKUNJUNG"); // Set kolom A1 dengan tulisan "DATA SISWA"
        $excel->getActiveSheet()->mergeCells('A1:G1'); // Set Merge Cell pada kolom A1 sampai E1
        // Set bold kolom A1
        $excel->getActiveSheet()->getStyle('A1')->getFont()->setBold(TRUE)->setSize(16);
        $excel->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $excel->getActiveSheet()->getStyle('A2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $excel->getActiveSheet()->setCellValue('A2', $label); // Set kolom A2 sesuai dengan yang pada variabel $label
        $excel->getActiveSheet()->mergeCells('A2:G2'); // Set Merge Cell pada kolom A2 sampai E2
        $excel->getActiveSheet()->setCellValue('B4', "Data Keluarga");
        $excel->getActiveSheet()->mergeCells('B4:D4');
        $excel->getActiveSheet()->getStyle('B4')->getFont()->setBold(TRUE);
        $excel->getActiveSheet()->getStyle('B4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

        $excel->getActiveSheet()->setCellValue('E4', "Data Anak");
        $excel->getActiveSheet()->mergeCells('E4:G4');
        $excel->getActiveSheet()->getStyle('E4')->getFont()->setBold(TRUE);
        $excel->getActiveSheet()->getStyle('E4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);


        // Buat header tabel nya pada baris ke 4
        $excel->getActiveSheet()->setCellValue('A4', "No.");
        $excel->getActiveSheet()->mergeCells('A4:A5');
        $excel->getActiveSheet()->setCellValue('B5', "Nomor KK");
        $excel->getActiveSheet()->setCellValue('C5', "Nama Ayah");
        $excel->getActiveSheet()->setCellValue('D5', "Nama Ibu");
        $excel->getActiveSheet()->setCellValue('E5', "Nama Anak");
        $excel->getActiveSheet()->setCellValue('F5', "Tanggal Lahir");
        $excel->getActiveSheet()->setCellValue('G5', "Jenis Kelamin");

        // Apply style header yang telah kita buat tadi ke masing-masing kolom header

        $excel->getActiveSheet()->getStyle('A4')->applyFromArray($style_col);
        $excel->getActiveSheet()->getStyle('B4')->applyFromArray($style_col);
        $excel->getActiveSheet()->getStyle('C4')->applyFromArray($style_col);
        $excel->getActiveSheet()->getStyle('D4')->applyFromArray($style_col);
        $excel->getActiveSheet()->getStyle('E4')->applyFromArray($style_col);
        $excel->getActiveSheet()->getStyle('F4')->applyFromArray($style_col);
        $excel->getActiveSheet()->getStyle('G4')->applyFromArray($style_col);

        $excel->getActiveSheet()->getStyle('A5')->applyFromArray($style_col);
        $excel->getActiveSheet()->getStyle('B5')->applyFromArray($style_col);
        $excel->getActiveSheet()->getStyle('C5')->applyFromArray($style_col);
        $excel->getActiveSheet()->getStyle('D5')->applyFromArray($style_col);
        $excel->getActiveSheet()->getStyle('E5')->applyFromArray($style_col);
        $excel->getActiveSheet()->getStyle('F5')->applyFromArray($style_col);
        $excel->getActiveSheet()->getStyle('G5')->applyFromArray($style_col);


        // Set height baris ke 1, 2, 3 dan 4
        $excel->getActiveSheet()->getRowDimension('1')->setRowHeight(20);
        $excel->getActiveSheet()->getRowDimension('2')->setRowHeight(20);
        $excel->getActiveSheet()->getRowDimension('3')->setRowHeight(20);
        $excel->getActiveSheet()->getRowDimension('4')->setRowHeight(20);

        $no = 1; // Untuk penomoran tabel, di awal set dengan 1
        $numrow = 6; // Set baris pertama untuk isi tabel adalah baris ke 5
        $nomor = 1;
        foreach ($cetak as $data) { // Lakukan looping pada variabel cetak
            // Ubah format tanggal jadi dd-mm-yyyy

            $excel->getActiveSheet()->setCellValue('A' . $numrow, $nomor++);
            $excel->getActiveSheet()->setCellValueExplicit('B' . $numrow, $data->no_kk);
            $excel->getActiveSheet()->setCellValue('C' . $numrow, $data->nama_ayah);
            $excel->getActiveSheet()->setCellValue('D' . $numrow, $data->nama_ibu);
            $excel->getActiveSheet()->setCellValue('E' . $numrow, $data->nama);
            $excel->getActiveSheet()->setCellValue('F' . $numrow, $data->tanggal_lahir);
            $excel->getActiveSheet()->setCellValue('G' . $numrow, $data->jenis_kelamin);

            // Apply style row yang telah kita buat tadi ke masing-masing baris (isi tabel)
            $excel->getActiveSheet()->getStyle('A' . $numrow)->applyFromArray($style_row);
            $excel->getActiveSheet()->getStyle('B' . $numrow)->applyFromArray($style_row);
            $excel->getActiveSheet()->getStyle('C' . $numrow)->applyFromArray($style_row);
            $excel->getActiveSheet()->getStyle('D' . $numrow)->applyFromArray($style_row);
            $excel->getActiveSheet()->getStyle('E' . $numrow)->applyFromArray($style_row);
            $excel->getActiveSheet()->getStyle('F' . $numrow)->applyFromArray($style_row);
            $excel->getActiveSheet()->getStyle('G' . $numrow)->applyFromArray($style_row);


            $excel->getActiveSheet()->getRowDimension($numrow)->setRowHeight(20);

            $no++; // Tambah 1 setiap kali looping
            $numrow++; // Tambah 1 setiap kali looping
        }

        // Set width kolom
        $excel->getActiveSheet()->getColumnDimension('A')->setWidth(4); // Set width kolom A
        $excel->getActiveSheet()->getColumnDimension('B')->setWidth(30); // Set width kolom B
        $excel->getActiveSheet()->getColumnDimension('C')->setWidth(25); // Set width kolom C
        $excel->getActiveSheet()->getColumnDimension('D')->setWidth(25); // Set width kolom D
        $excel->getActiveSheet()->getColumnDimension('E')->setWidth(25); // Set width kolom E
        $excel->getActiveSheet()->getColumnDimension('F')->setWidth(25); // Set width kolom C
        $excel->getActiveSheet()->getColumnDimension('G')->setWidth(12); // Set width kolom D



        // Set orientasi kertas jadi LANDSCAPE
        $excel->getActiveSheet()->getPageSetup()->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_LANDSCAPE);
        $excel->getActiveSheet()->getPageSetup()->setPaperSize(PHPExcel_Worksheet_PageSetup::PAPERSIZE_LEGAL);

        // Set judul file excel nya
        $excel->getActiveSheet()->setTitle("Data Tidak Berkunjung");
        $excel->getActiveSheet();

        // Proses file excel
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment; filename="Data tidakberkunjung.xlsx"'); // Set nama file excel nya
        header('Cache-Control: max-age=0');

        $write = PHPExcel_IOFactory::createWriter($excel, 'Excel2007');
        $write->save('php://output');
    }
}

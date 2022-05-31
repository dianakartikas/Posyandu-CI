<?php

namespace App\Models;

use CodeIgniter\Model;

class KunjunganModel extends Model
{
    protected $table = 'kunjungan';
    protected $primaryKey = 'id_kunjungan';
    protected $allowedFields = ['id_kms', 'id_kegiatan', 'status', 'kode'];
    protected $useTimestamps = true;
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';
    // public function jadwalKegiatan()
    // {
    //     $db      = \Config\Database::connect();
    //     $query = $db->query("SELECT tanggal FROM pemasukan WHERE tgl_pemasukan = $current_date");
    //     return $query;
    //         ->join('kegiatan', 'kegiatan.id = kunjungan.id_kegiatan')
    //         ->where('tanggal=$currentdate()')
    //         ->get()->getResultArray();
    // }

    public function dataKunjungan()
    {
        return $this->db->table('kunjungan');
    }
    public function tambahAntrian($id)
    {
        $this->builder =  $this->db->table('kunjungan');
        $this->builder->select('id_kegiatan, bb_lahir, tb_lahir, anak.nama as namaAnak, jenis_kelamin, tanggal_lahir, gambar_anak, fullname');
        $this->builder->join('kms', 'kms.id_kms = kunjungan.id_kms');
        $this->builder->join('anak', 'anak.id_anak = kms.id_anak');
        $this->builder->join('users', 'users.id = anak.id_user');
        $this->builder->where('kunjungan.id_kegiatan', $id);
        return $this->builder->get()->getResultArray();
    }

    public function joinKunjungan()
    {
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
        if (empty($data['kegiatan']) || empty($current_date)) {
            return redirect()->to('/kegiatan');
        }
        $id =  $data['kegiatan']->id;

        $this->builder =  $this->db->table('kunjungan');
        $this->builder->select('id_kunjungan, kunjungan.status as status, bb_lahir, tb_lahir, anak.nama as namaAnak, jenis_kelamin, gambar_anak, fullname, user_image');
        $this->builder->join('kms', 'kms.id_kms = kunjungan.id_kms');
        $this->builder->join('anak', 'anak.id_anak = kms.id_anak');
        $this->builder->join('users', 'users.id = anak.id_user');
        $this->builder->where('id_kegiatan', $id);
        return $this->builder->get()->getResultArray();
    }

    public function joinKunjunganCekProses()
    {
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
        if (empty($data['kegiatan']) || empty($current_date)) {
            return redirect()->to('/kegiatan');
        }
        $id =  $data['kegiatan']->id;

        $this->builder =  $this->db->table('kunjungan');
        $status1 = 'proses';
        $status3 = 'cekgizi';
        $this->builder->select('id_kunjungan, kunjungan.status as status, bb_lahir, tb_lahir, anak.nama as namaAnak, jenis_kelamin, gambar_anak, fullname, user_image');
        $this->builder->join('kms', 'kms.id_kms = kunjungan.id_kms');
        $this->builder->join('anak', 'anak.id_anak = kms.id_anak');
        $this->builder->join('users', 'users.id = anak.id_user');

        $this->builder->where('id_kegiatan', $id);
        $this->builder->where('kunjungan.status', $status1);
        // $this->builder->orWhere('kunjungan.status', $status2);
        // $this->builder->where('id_kegiatan', $id);
        $this->builder->orWhere('kunjungan.status', $status3);
        $this->builder->where('id_kegiatan', $id);
        return $this->builder->get()->getResultArray();
    }

    public function joinKunjunganCekProses2()
    {
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
        if (empty($data['kegiatan']) || empty($current_date)) {
            return redirect()->to('/kegiatan');
        }
        $id =  $data['kegiatan']->id;

        $this->builder =  $this->db->table('kunjungan');
        $status1 = 'proses';
        $status2 = 'cekgizi';
        $this->builder->select('id_kunjungan, kunjungan.status as status, bb_lahir, tb_lahir, anak.nama as namaAnak, jenis_kelamin, gambar_anak, fullname, user_image');
        $this->builder->join('kms', 'kms.id_kms = kunjungan.id_kms');
        $this->builder->join('anak', 'anak.id_anak = kms.id_anak');
        $this->builder->join('users', 'users.id = anak.id_user');

        $this->builder->where('id_kegiatan', $id);
        $this->builder->where('kunjungan.status', $status1);;
        $this->builder->orWhere('kunjungan.status', $status2);
        $this->builder->where('id_kegiatan', $id);
        return $this->builder->get()->getResultArray();
    }

    public function joinKunjunganPeriksa()
    {
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
        if (empty($data['kegiatan']) || empty($current_date)) {
            return redirect()->to('/kegiatan');
        }
        $id =  $data['kegiatan']->id;

        $this->builder =  $this->db->table('kunjungan');
        $status1 = 'periksa';

        $this->builder->select('id_kunjungan, kunjungan.status as status, bb_lahir, tb_lahir, anak.nama as namaAnak, jenis_kelamin, gambar_anak, fullname, user_image');
        $this->builder->join('kms', 'kms.id_kms = kunjungan.id_kms');
        $this->builder->join('anak', 'anak.id_anak = kms.id_anak');
        $this->builder->join('users', 'users.id = anak.id_user');

        $this->builder->where('id_kegiatan', $id);
        $this->builder->where('kunjungan.status', $status1);

        return $this->builder->get()->getResultArray();
    }
    public function joinKunjunganCheckout($id_kunjungan)
    {
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
        if (empty($data['kegiatan']) || empty($current_date)) {
            return redirect()->to('/kegiatan');
        }
        $id =  $data['kegiatan']->id;
        $this->builder =  $this->db->table('kunjungan');
        $this->builder->select('id_kunjungan, kunjungan.status as status, bb_lahir, tb_lahir, anak.nama as namaAnak, jenis_kelamin, gambar_anak, fullname, user_image, kunjungan.created_at as tanggal, tanggal_lahir');
        $this->builder->join('kms', 'kms.id_kms = kunjungan.id_kms');
        $this->builder->join('anak', 'anak.id_anak = kms.id_anak');
        $this->builder->join('users', 'users.id = anak.id_user');
        $this->builder->where('id_kegiatan', $id);
        $this->builder->where('kunjungan.id_kunjungan', $id_kunjungan);


        return $this->builder->get()->getRow();
    }
    public function joinKunjunganCekLewat()
    {
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
        if (empty($data['kegiatan']) || empty($current_date)) {
            return redirect()->to('/kegiatan');
        }
        $id =  $data['kegiatan']->id;
        $this->builder =  $this->db->table('kunjungan');
        $status1 = 'terlewat';

        $this->builder->select('id_kunjungan, kunjungan.status as status, bb_lahir, tb_lahir, anak.nama as namaAnak, jenis_kelamin, gambar_anak, fullname, user_image');
        $this->builder->join('kms', 'kms.id_kms = kunjungan.id_kms');
        $this->builder->join('anak', 'anak.id_anak = kms.id_anak');
        $this->builder->join('users', 'users.id = anak.id_user');
        $this->builder->where('id_kegiatan', $id);
        $this->builder->where('kunjungan.status', $status1);

        return $this->builder->get()->getResultArray();
    }




    // public function joinKunjunganWarga()
    // {
    //     $this->builder =  $this->db->table('kegiatan');
    //     $current_date = date("Y-m-d");
    //     // $this->builder->select('id, nama, lokasi, tanggal');
    //     // $this->builder->where('tanggal', $current_date);
    //     // $query = $this->builder->get();
    //     // $data['kegiatan'] = $query->getRow();
    //     $this->builder->select('id, nama, lokasi, tanggal');
    //     $this->builder->where('tanggal', $current_date);
    //     $query = $this->builder->get();
    //     $data['kegiatan'] = $query->getRow();
    //     $id =  $data['kegiatan']->id;
    //     $this->builder =  $this->db->table('kunjungan');
    //     $this->builder->select('id_kunjungan, kunjungan.status as status, bb_lahir, tb_lahir, anak.nama as namaAnak, jenis_kelamin, gambar_anak, fullname, user_image');
    //     $this->builder->join('kms', 'kms.id_kms = kunjungan.id_kms');
    //     $this->builder->join('anak', 'anak.id_anak = kms.id_anak');
    //     $this->builder->join('users', 'users.id = anak.id_user');
    //     $this->builder->where('id_kegiatan', $id);
    //     return $this->builder->get()->getRow();
    // }
    public function countKunjungan()
    {
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
        if (empty($data['kegiatan']) || empty($current_date)) {
            return redirect()->to('/kegiatan');
        }
        $id =  $data['kegiatan']->id;
        return $this->db->table('kunjungan')
            ->where('id_kegiatan', $id)
            ->countAllResults();
    }
    public function resetKunjungan()
    {
        $this->builder =  $this->db->table('kunjungan');
        $current_date = date("Y-m-d");
        $this->builder->select('id_kunjungan');
        $this->builder->join('kegiatan', 'kegiatan.id=kunjungan.id_kegiatan');
        $this->builder->where('tanggal !=', $current_date);
        $this->builder->orderBy('id_kunjungan', 'DESC');
        $this->builder->limit(1);
        return $this->builder->get()->getRow();
    }
    public function tampilAntrian()
    {

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
        if (empty($data['kegiatan']) || empty($current_date)) {
            return redirect()->to('/kegiatan');
        }
        $this->builder =  $this->db->table('kunjungan');
        $status = 'antri';
        $id =  $data['kegiatan']->id;
        $this->builder->select('id_kunjungan');
        $this->builder->where('id_kegiatan', $id);
        $this->builder->where('status', $status);

        $this->builder->orderBy('id_kunjungan', 'ASC');
        $this->builder->limit(1);
        return $this->builder->get()->getRow();
    }

    public function tampilDataAnakSedangAntri()
    {
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
        if (empty($data['kegiatan']) || empty($current_date)) {
            return redirect()->to('/kegiatan');
        }
        $this->builder =  $this->db->table('kunjungan');
        $status = 'antri';
        $id =  $data['kegiatan']->id;
        $this->builder->select('id_kunjungan, bb_lahir, kunjungan.status as status, tb_lahir, anak.nama as namaAnak, tanggal_lahir, no_kk, gambar_anak, fullname, jenis_kelamin, user_image, nama_ayah, nama_ibu');
        $this->builder->join('kms', 'kms.id_kms=kunjungan.id_kms');
        $this->builder->join('anak', 'anak.id_anak=kms.id_anak');
        $this->builder->join('users', 'users.id=anak.id_user');
        $this->builder->where('id_kegiatan', $id);
        $this->builder->where('kunjungan.status', $status);

        $this->builder->orderBy('id_kunjungan', 'ASC');
        $this->builder->limit(1);
        return $this->builder->get()->getRow();
    }

    public function cekKode()
    {
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

        $id =  $data['kegiatan']->id;
        $this->builder =   $this->db->table('kunjungan');
        $this->builder->select('kunjungan.id_kms as id_cek');
        $this->builder->join('kms', 'kms.id_kms=kunjungan.id_kms');
        $this->builder->where('id_kegiatan', $id);
        return $this->builder->get()->getResult();
    }
    // public function kode()
    // {

    //     $this->builder = $this->db->table('kunjungan');
    //     $this->builder->select('kode');
    //     $query = $this->builder->get();
    //     return $this->builder->get()->getRow();
    // }

    public function detailKMS($id)
    {
        $this->builder = $this->db->table('kunjungan');
        $this->builder->select('nama, cek_imunisasi.created_at as created_at, status,  cek_imunisasi.umur as umur, cek_imunisasi.catatan as catatan, kunjungan.created_at as tanggal, kunjungan.id_kunjungan as id_kunjungan, hasil_bbu, hasil_tbu, berat_badan, tinggi_badan, cek_pertumbuhan.created_at as created_at2,cek_pertumbuhan.umur as cekumur');
        $this->builder->join('cek_imunisasi', 'cek_imunisasi.id_kunjungan = kunjungan.id_kunjungan');
        $this->builder->join('cek_pertumbuhan', 'cek_pertumbuhan.id_kunjungan = kunjungan.id_kunjungan', 'left');
        $this->builder->join('imunisasi', 'imunisasi.id_imunisasi = cek_imunisasi.id_imunisasi');
        $this->builder->where('kunjungan.id_kms', $id);
        return $this->builder->get()->getRow();
    }

    public function chart_antrian()
    {
        $this->builder =  $this->db->table('kegiatan');
        $current_date = date("Y-m-d");
        $this->builder->select('id, nama, lokasi, tanggal');
        $this->builder->where('tanggal', $current_date);
        $query = $this->builder->get();
        $data['kegiatan'] = $query->getRow();
        if (empty($data['kegiatan']) || empty($current_date)) {
            return redirect()->to('/kegiatan');
        }
        $this->builder =  $this->db->table('kunjungan');
        $id =  $data['kegiatan']->id;

        $query = $this->db->query("SELECT SUM(status = 'antri') as totalantri, SUM(status = 'proses') as totalproses, SUM(status = 'terlewat') as totalterlewat, SUM(status = 'selesai') as totalselesai FROM kunjungan WHERE id_kegiatan = '$id' ");

        $hasil = [];
        if (!empty($query)) {
            foreach ($query->getResultArray() as $data) {
                $hasil[] = $data;
            }
        }
        return $hasil;
    }

    public function chart_kunjungan()
    {
        $query = $this->db->query("SELECT kegiatan.tanggal, kunjungan.id_kunjungan, COUNT(kunjungan.id_kunjungan) as totalKunjungan FROM kegiatan LEFT JOIN kunjungan ON kegiatan.id = kunjungan.id_kegiatan GROUP BY kegiatan.tanggal");
        $hasil2 = [];
        if (!empty($query)) {
            foreach ($query->getResultArray() as $data) {
                $hasil2[] = $data;
            }
        }
        return $hasil2;
    }

    public function view_by_date($date)
    {

        $this->builder =  $this->db->table('kunjungan');
        $this->builder->Select('nama, tanggal_lahir, jenis_kelamin, nama_ayah, nama_ibu, no_kk, kunjungan.status as status, kunjungan.created_at as tanggal_kunjungan');
        $this->builder->join('kms', 'kms.id_kms = kunjungan.id_kms', 'left');
        $this->builder->join('anak', 'anak.id_anak = kms.id_anak', 'left');
        $this->builder->join('users', 'users.id = anak.id_user', 'left');
        $status = 'selesai';
        $this->builder->where('kunjungan.status !=', $status);
        $this->builder->where('DATE(kunjungan.created_at)', $date);
        return $this->builder->get()->getResult();
    }

    public function view_by_month($month, $year)
    {
        $this->builder =  $this->db->table('kunjungan');
        $this->builder->Select('nama, tanggal_lahir, jenis_kelamin, nama_ayah, nama_ibu, no_kk, kunjungan.status as status, kunjungan.created_at as tanggal_kunjungan');
        $this->builder->join('kms', 'kms.id_kms = kunjungan.id_kms', 'left');
        $this->builder->join('anak', 'anak.id_anak = kms.id_anak', 'left');
        $this->builder->join('users', 'users.id = anak.id_user', 'left');
        $status = 'selesai';
        $this->builder->where('kunjungan.status !=', $status);
        // $month = date('m');
        // $year = date('Y');
        $this->builder->where('MONTH(kunjungan.created_at)', $month);
        $this->builder->where('YEAR(kunjungan.created_at)', $year);
        return $this->builder->get()->getResult();
    }

    public function view_by_year($year)
    {

        $$this->builder =  $this->db->table('kunjungan');
        $this->builder->Select('nama, tanggal_lahir, jenis_kelamin, nama_ayah, nama_ibu, no_kk, kunjungan.status as status, kunjungan.created_at as tanggal_kunjungan');
        $this->builder->join('kms', 'kms.id_kms = kunjungan.id_kms', 'left');
        $this->builder->join('anak', 'anak.id_anak = kms.id_anak', 'left');
        $this->builder->join('users', 'users.id = anak.id_user', 'left');
        $status = 'selesai';
        $this->builder->where('kunjungan.status !=', $status);
        // $year = date('Y');
        $this->builder->where('YEAR(kunjungan.created_at)', $year);
        return $this->builder->get()->getResult();
    }

    public function view_all()
    {
        $this->builder =  $this->db->table('kunjungan');
        $this->builder->Select('nama, tanggal_lahir, jenis_kelamin, nama_ayah, nama_ibu, no_kk, kunjungan.status as status, kunjungan.created_at as tanggal_kunjungan');
        $this->builder->join('kms', 'kms.id_kms = kunjungan.id_kms', 'left');
        $this->builder->join('anak', 'anak.id_anak = kms.id_anak', 'left');
        $this->builder->join('users', 'users.id = anak.id_user', 'left');
        $status = 'selesai';
        $this->builder->where('kunjungan.status !=', $status);
        return $this->builder->get()->getResult();
    }

    public function option_tahun()
    {
        $this->builder =  $this->db->table('kunjungan');
        $this->builder->Select('nama, jenis_kelamin, nama_ayah, YEAR(kunjungan.created_at) as tahun, nama_ibu, no_kk, kunjungan.status as status, kunjungan.created_at as tanggal_kunjungan');
        $this->builder->join('kms', 'kms.id_kms = kunjungan.id_kms', 'left');
        $this->builder->join('anak', 'anak.id_anak = kms.id_anak', 'left');
        $this->builder->join('users', 'users.id = anak.id_user', 'left');
        $status = 'selesai';
        $this->builder->where('kunjungan.status !=', $status);

        $this->builder->orderBy('YEAR(kunjungan.created_at)');
        $this->builder->groupBy('YEAR(kunjungan.created_at)');
        return $this->builder->get()->getResult();
    }
}

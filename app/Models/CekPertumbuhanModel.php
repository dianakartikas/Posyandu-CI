<?php

namespace App\Models;

use App\BBU;
use CodeIgniter\Model;

class CekPertumbuhanModel extends Model
{
    protected $table = 'cek_pertumbuhan';
    protected $primaryKey = 'id_cek_pertumbuhan';
    protected $allowedFields = ['id_kunjungan', 'id_pengurus', 'catatan', 'umur', 'berat_badan', 'tinggi_badan', 'hasil_bbu', 'hasil_tbu', 'hasil_bbtb', 'jenis_kelamin'];
    protected $useTimestamps = true;


    // public function id_cek()
    // {
    //     $this->builder =  $this->db->table('cek_pertumbuhan');
    //     $this->builder->select('id_cek_pertumbuhan');
    //     return $this->builder->get()->getRow();
    // }

    // public function periksagizi($id_kunjungan)
    // {
    //     $this->builder =  $this->db->table('cek_pertumbuhan');
    //     $this->builder->select('umur, berat_badan, tinggi_badan, hasil_bbu, hasil_tbu, hasil_bbtb, catatan');
    //     $this->builder->where('id_kunjungan', $id_kunjungan);
    //     return $this->builder->get()->getRow();
    // }
    public function getID()
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
        $this->builder =  $this->db->table('cek_pertumbuhan');
        $this->builder->select('id_cek_pertumbuhan');
        $this->builder->join('kunjungan', 'cek_pertumbuhan.id_kunjungan=kunjungan.id_kunjungan');
        $this->builder->join('kegiatan', 'kunjungan.id_kegiatan=kegiatan.id');
        $this->builder->where('id_kegiatan', $id);
        return $this->builder->get()->getRow();
    }
    public function cekHasil()
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

        $this->builder =  $this->db->table('cek_pertumbuhan');
        $status1 = 'periksa';
        $this->builder->select('kunjungan.id_kunjungan as id_kunjungan, umur, gambar_anak, user_image, fullname, berat_badan, tinggi_badan, hasil_bbu, hasil_tbu, anak.jenis_kelamin as jenis_kelamin, hasil_bbtb, id_cek_pertumbuhan, catatan, kunjungan.status as status, anak.nama as namaAnak');
        $this->builder->join('kunjungan', 'cek_pertumbuhan.id_kunjungan = kunjungan.id_kunjungan');
        $this->builder->join('kegiatan', 'kunjungan.id_kegiatan=kegiatan.id');

        $this->builder->join('kms', 'kunjungan.id_kms = kms.id_kms');
        $this->builder->join('anak', 'kms.id_anak = anak.id_anak');
        $this->builder->join('users', 'users.id = anak.id_user');
        $this->builder->where('kunjungan.status', $status1);
        $this->builder->where('id_kegiatan', $id);
        return $this->builder->get()->getResultArray();
    }
    // public function orderID()
    // {
    //     return $this->builder = $this->db->table('cek_pertumbuhan');
    //     $this->builder->select('umur, berat_badan, tinggi_badan, hasil_bbu');
    //     $this->builder->orderBy('id_cek_imunisasi', 'DESC');
    // }

    // public function BBU()
    // {
    //     return $this->builder = $this->db->table('cek_pertumbuhan');
    //     $this->builder->select('umur, berat_badan, tinggi_badan, hasil_bbu, bbu.umur as hitungumur, jenis_kelamin');
    //     $this->builder->join('bbu', 'bbu.umur=cek_pertumbuhan.umur');
    //     $this->builder->where('bb.jenis_kelamin=cek_pertumbuhan.jenis_kelamin');
    //     $this->builder->get()->getResultArray();
    // }
    public function chart_gizi()
    {
        $query = $this->db->query("SELECT SUM(hasil_bbu = 'BB Sangat Kurang') as bbsangatkurang, SUM(hasil_bbu = 'BB Kurang') as bbkurang, SUM(hasil_bbu = 'BB Normal') as bbnormal, SUM(hasil_bbu = 'Risiko BB Lebih') as risikobblebih, SUM(hasil_tbu = 'Sangat Pendek') as sangatpendek, SUM(hasil_tbu = 'Pendek') as pendek, SUM(hasil_tbu = 'Normal') as normal, SUM(hasil_tbu = 'Tinggi') as tinggi, SUM(hasil_bbtb = 'Gizi Buruk') as giziburuk, SUM(hasil_bbtb = 'Gizi Kurang') as gizikurang, SUM(hasil_bbtb = 'Gizi Baik') as gizibaik, SUM(hasil_bbtb = 'Gizi Lebih') as gizilebih, SUM(hasil_bbtb = 'Risiko Gizi Lebih') as risikogizilebih, SUM(hasil_bbtb = 'Obesitas') as obesitas  FROM cek_pertumbuhan");
        $hasil = [];
        if (!empty($query)) {
            foreach ($query->getResultArray() as $data) {
                $hasil[] = $data;
            }
        }
        return $hasil;
    }

    public function cekPemeriksaan()
    {
        $this->builder =  $this->db->table('cek_pertumbuhan');
        $this->builder->select('umur, username, id_pengurus, anak.nama as namaAnak, anak.jenis_kelamin as jenis_kelamin,, umur, berat_badan, tinggi_badan, hasil_bbu, hasil_tbu, hasil_bbtb, gambar_anak, cek_pertumbuhan.catatan as catatan, cek_pertumbuhan.created_at as tanggal');

        $this->builder->join('kunjungan', 'cek_pertumbuhan.id_kunjungan = kunjungan.id_kunjungan');
        $this->builder->join('kms', 'kunjungan.id_kms = kms.id_kms');
        $this->builder->join('anak', 'kms.id_anak = anak.id_anak');
        $this->builder->join('users', 'users.id = cek_pertumbuhan.id_pengurus');
        return $this->builder->get()->getResultArray();
    }
    public function cekPemeriksaanUser()
    {
        $this->builder =  $this->db->table('cek_pertumbuhan');
        $this->builder->select('umur, anak.nama as namaAnak, anak.jenis_kelamin as jenis_kelamin,, umur, berat_badan, tinggi_badan, hasil_bbu, hasil_tbu, hasil_bbtb, gambar_anak, cek_pertumbuhan.catatan as catatan, cek_pertumbuhan.created_at as tanggal');

        $this->builder->join('kunjungan', 'cek_pertumbuhan.id_kunjungan = kunjungan.id_kunjungan');
        $this->builder->join('kms', 'kunjungan.id_kms = kms.id_kms');
        $this->builder->join('anak', 'kms.id_anak = anak.id_anak');
        $this->builder->join('users', 'anak.id_user = users.id');
        $this->builder->where('anak.id_user', user_id());
        return $this->builder->get()->getResultArray();
    }
    public function view_by_date($date)
    {

        $this->builder =  $this->db->table('cek_pertumbuhan');
        $this->builder->Select('umur, cek_pertumbuhan.created_at as tgl_cek, cek_pertumbuhan.catatan as catatan, kegiatan.nama as namaKegiatan, anak.nama as namaAnak, anak.jenis_kelamin as jenis_kelamin, no_kk, hasil_bbu, hasil_tbu, hasil_bbtb, tinggi_badan, berat_badan');
        $this->builder->join('kunjungan', 'cek_pertumbuhan.id_kunjungan = kunjungan.id_kunjungan', 'left');
        $this->builder->join('kegiatan', 'kunjungan.id_kegiatan = kegiatan.id', 'left');
        $this->builder->join('kms', 'kunjungan.id_kms = kms.id_kms', 'left');
        $this->builder->join('anak', 'kms.id_anak = anak.id_anak', 'left');
        $this->builder->join('users', 'anak.id_user = users.id', 'left');
        // $date = date('d-m-Y');
        $this->builder->where('DATE(cek_pertumbuhan.created_at)', $date);
        return $this->builder->get()->getResult();
    }

    public function view_by_month($month, $year)
    {
        $this->builder =  $this->db->table('cek_pertumbuhan');
        $this->builder->Select('umur, cek_pertumbuhan.created_at as tgl_cek, cek_pertumbuhan.catatan as catatan, kegiatan.nama as namaKegiatan, anak.nama as namaAnak, anak.jenis_kelamin as jenis_kelamin, no_kk, hasil_bbu, hasil_tbu, hasil_bbtb, tinggi_badan, berat_badan');
        $this->builder->join('kunjungan', 'cek_pertumbuhan.id_kunjungan = kunjungan.id_kunjungan', 'left');
        $this->builder->join('kegiatan', 'kunjungan.id_kegiatan = kegiatan.id', 'left');
        $this->builder->join('kms', 'kunjungan.id_kms = kms.id_kms', 'left');
        $this->builder->join('anak', 'kms.id_anak = anak.id_anak', 'left');
        $this->builder->join('users', 'anak.id_user = users.id', 'left');
        // $month = date('m');
        // $year = date('Y');
        $this->builder->where('MONTH(cek_pertumbuhan.created_at)', $month);
        $this->builder->where('YEAR(cek_pertumbuhan.created_at)', $year);
        return $this->builder->get()->getResult();
    }

    public function view_by_year($year)
    {

        $this->builder =  $this->db->table('cek_pertumbuhan');
        $this->builder->Select('umur, cek_pertumbuhan.created_at as tgl_cek, cek_pertumbuhan.catatan as catatan, kegiatan.nama as namaKegiatan, anak.nama as namaAnak, anak.jenis_kelamin as jenis_kelamin, no_kk, hasil_bbu, hasil_tbu, hasil_bbtb, tinggi_badan, berat_badan');
        $this->builder->join('kunjungan', 'cek_pertumbuhan.id_kunjungan = kunjungan.id_kunjungan', 'left');
        $this->builder->join('kegiatan', 'kunjungan.id_kegiatan = kegiatan.id', 'left');
        $this->builder->join('kms', 'kunjungan.id_kms = kms.id_kms', 'left');
        $this->builder->join('anak', 'kms.id_anak = anak.id_anak', 'left');
        $this->builder->join('users', 'anak.id_user = users.id', 'left');
        // $year = date('Y');
        $this->builder->where('YEAR(cek_pertumbuhan.created_at)', $year);
        return $this->builder->get()->getResult();
    }

    public function view_all()
    {
        $this->builder =  $this->db->table('cek_pertumbuhan');
        $this->builder->Select('umur, cek_pertumbuhan.created_at as tgl_cek, cek_pertumbuhan.catatan as catatan, kegiatan.nama as namaKegiatan, anak.nama as namaAnak, anak.jenis_kelamin as jenis_kelamin, no_kk, hasil_bbu, hasil_tbu, hasil_bbtb, tinggi_badan, berat_badan');
        $this->builder->join('kunjungan', 'cek_pertumbuhan.id_kunjungan = kunjungan.id_kunjungan', 'left');
        $this->builder->join('kegiatan', 'kunjungan.id_kegiatan = kegiatan.id', 'left');
        $this->builder->join('kms', 'kunjungan.id_kms = kms.id_kms', 'left');
        $this->builder->join('anak', 'kms.id_anak = anak.id_anak', 'left');
        $this->builder->join('users', 'anak.id_user = users.id', 'left');
        return $this->builder->get()->getResult();
    }

    public function option_tahun()
    {
        $this->builder =  $this->db->table('cek_pertumbuhan');
        $this->builder->Select('umur, cek_pertumbuhan.created_at as tgl_cek, YEAR(cek_pertumbuhan.created_at) as tahun, cek_pertumbuhan.catatan as catatan, kegiatan.nama as namaKegiatan, anak.nama as namaAnak, anak.jenis_kelamin as jenis_kelamin, no_kk, hasil_bbu, hasil_tbu, hasil_bbtb, tinggi_badan, berat_badan');
        $this->builder->join('kunjungan', 'cek_pertumbuhan.id_kunjungan = kunjungan.id_kunjungan', 'left');
        $this->builder->join('kegiatan', 'kunjungan.id_kegiatan = kegiatan.id', 'left');
        $this->builder->join('kms', 'kunjungan.id_kms = kms.id_kms', 'left');
        $this->builder->join('anak', 'kms.id_anak = anak.id_anak', 'left');
        $this->builder->join('users', 'anak.id_user = users.id', 'left');

        $this->builder->orderBy('YEAR(cek_pertumbuhan.created_at)');
        $this->builder->groupBy('YEAR(cek_pertumbuhan.created_at)');
        return $this->builder->get()->getResult();
    }
}

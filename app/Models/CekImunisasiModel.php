<?php

namespace App\Models;

use CodeIgniter\Model;

class CekImunisasiModel extends Model
{
    protected $table = 'cek_imunisasi';
    protected $primaryKey = 'id_cek_imunisasi';
    protected $allowedFields = ['id_imunisasi', 'id_kunjungan', 'id_pengurus', 'catatan', 'umur'];
    protected $useTimestamps = true;
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';

    public function cekImunisasi()
    {
        $this->db->table('cek_imunisasi')
            ->select('id_imunisasi', 'id_kunjungan', 'id_pengurus', 'catatan', 'umur');
        return  $this->get()->getResult();
    }

    public function cekPemeriksaan()
    {
        $this->builder =  $this->db->table('cek_imunisasi');
        $this->builder->select('umur, id_pengurus, username, anak.nama as namaAnak, jenis_kelamin, umur, imunisasi.nama as namaImunisasi, gambar_anak, cek_imunisasi.catatan as catatan, cek_imunisasi.created_at as tanggal');
        $this->builder->join('imunisasi', 'cek_imunisasi.id_imunisasi = imunisasi.id_imunisasi');
        $this->builder->join('kunjungan', 'cek_imunisasi.id_kunjungan = kunjungan.id_kunjungan');
        $this->builder->join('kms', 'kunjungan.id_kms = kms.id_kms');
        $this->builder->join('anak', 'kms.id_anak = anak.id_anak');
        $this->builder->join('users', 'users.id = cek_imunisasi.id_pengurus');
        return $this->builder->get()->getResultArray();
    }
    public function cekPemeriksaanUser()
    {
        $this->builder =  $this->db->table('cek_imunisasi');
        $this->builder->select('umur, anak.nama as namaAnak, jenis_kelamin, umur, imunisasi.nama as namaImunisasi, gambar_anak, cek_imunisasi.catatan as catatan, cek_imunisasi.created_at as tanggal');
        $this->builder->join('imunisasi', 'cek_imunisasi.id_imunisasi = imunisasi.id_imunisasi');
        $this->builder->join('kunjungan', 'cek_imunisasi.id_kunjungan = kunjungan.id_kunjungan');
        $this->builder->join('kms', 'kunjungan.id_kms = kms.id_kms');
        $this->builder->join('anak', 'kms.id_anak = anak.id_anak');
        $this->builder->join('users', 'anak.id_user = users.id');
        $this->builder->where('anak.id_user', user_id());
        return $this->builder->get()->getResultArray();
    }

    public function view_by_date($date)
    {
        $this->builder =  $this->db->table('cek_imunisasi');
        $this->builder->Select('umur, cek_imunisasi.created_at as tgl_cek, cek_imunisasi.catatan as catatan, imunisasi.nama as namaImunisasi, kegiatan.nama as namaKegiatan, lokasi, anak.nama as namaAnak, jenis_kelamin, no_kk, nama_ayah, nama_ibu');
        $this->builder->join('imunisasi', 'cek_imunisasi.id_imunisasi = imunisasi.id_imunisasi', 'left');
        $this->builder->join('kunjungan', 'cek_imunisasi.id_kunjungan = kunjungan.id_kunjungan', 'left');
        $this->builder->join('kegiatan', 'kunjungan.id_kegiatan = kegiatan.id', 'left');
        $this->builder->join('kms', 'kunjungan.id_kms = kms.id_kms', 'left');
        $this->builder->join('anak', 'kms.id_anak = anak.id_anak', 'left');
        $this->builder->join('users', 'anak.id_user = users.id', 'left');
        // $date = date('d-m-Y');
        $this->builder->where('DATE(cek_imunisasi.created_at)', $date);
        return $this->builder->get()->getResult();
    }

    public function view_by_month($month, $year)
    {
        $this->builder =  $this->db->table('cek_imunisasi');
        $this->builder->Select('umur, cek_imunisasi.created_at as tgl_cek, cek_imunisasi.catatan as catatan, imunisasi.nama as namaImunisasi, kegiatan.nama as namaKegiatan, lokasi, anak.nama as namaAnak, jenis_kelamin, no_kk, nama_ayah, nama_ibu');
        $this->builder->join('imunisasi', 'cek_imunisasi.id_imunisasi = imunisasi.id_imunisasi', 'left');
        $this->builder->join('kunjungan', 'cek_imunisasi.id_kunjungan = kunjungan.id_kunjungan', 'left');
        $this->builder->join('kegiatan', 'kunjungan.id_kegiatan = kegiatan.id', 'left');
        $this->builder->join('kms', 'kunjungan.id_kms = kms.id_kms', 'left');
        $this->builder->join('anak', 'kms.id_anak = anak.id_anak', 'left');
        $this->builder->join('users', 'anak.id_user = users.id', 'left');
        // $month = date('m');
        // $year = date('Y');
        $this->builder->where('MONTH(cek_imunisasi.created_at)', $month);
        $this->builder->where('YEAR(cek_imunisasi.created_at)', $year);
        return $this->builder->get()->getResult();
    }

    public function view_by_year($year)
    {

        $this->builder =  $this->db->table('cek_imunisasi');
        $this->builder->Select('umur, cek_imunisasi.created_at as tgl_cek, cek_imunisasi.catatan as catatan, imunisasi.nama as namaImunisasi, kegiatan.nama as namaKegiatan, lokasi, anak.nama as namaAnak, jenis_kelamin, no_kk, nama_ayah, nama_ibu');
        $this->builder->join('imunisasi', 'cek_imunisasi.id_imunisasi = imunisasi.id_imunisasi', 'left');
        $this->builder->join('kunjungan', 'cek_imunisasi.id_kunjungan = kunjungan.id_kunjungan', 'left');
        $this->builder->join('kegiatan', 'kunjungan.id_kegiatan = kegiatan.id', 'left');
        $this->builder->join('kms', 'kunjungan.id_kms = kms.id_kms', 'left');
        $this->builder->join('anak', 'kms.id_anak = anak.id_anak', 'left');
        $this->builder->join('users', 'anak.id_user = users.id', 'left');
        // $year = date('Y');
        $this->builder->where('YEAR(cek_imunisasi.created_at)', $year);
        return $this->builder->get()->getResult();
    }

    public function view_all()
    {

        $this->builder =  $this->db->table('cek_imunisasi');
        $this->builder->Select('umur, cek_imunisasi.created_at as tgl_cek, cek_imunisasi.catatan as catatan, imunisasi.nama as namaImunisasi, kegiatan.nama as namaKegiatan, lokasi, anak.nama as namaAnak, jenis_kelamin, no_kk, nama_ayah, nama_ibu');
        $this->builder->join('imunisasi', 'cek_imunisasi.id_imunisasi = imunisasi.id_imunisasi', 'left');
        $this->builder->join('kunjungan', 'cek_imunisasi.id_kunjungan = kunjungan.id_kunjungan', 'left');
        $this->builder->join('kegiatan', 'kunjungan.id_kegiatan = kegiatan.id', 'left');
        $this->builder->join('kms', 'kunjungan.id_kms = kms.id_kms', 'left');
        $this->builder->join('anak', 'kms.id_anak = anak.id_anak', 'left');
        $this->builder->join('users', 'anak.id_user = users.id', 'left');
        return $this->builder->get()->getResult();
    }

    public function option_tahun()
    {
        $this->builder =  $this->db->table('cek_imunisasi');
        $this->builder->Select('umur, cek_imunisasi.created_at as tgl_cek, YEAR(cek_imunisasi.created_at) as tahun, cek_imunisasi.catatan as catatan, imunisasi.nama as namaImunisasi, kegiatan.nama as namaKegiatan, lokasi, anak.nama as namaAnak, jenis_kelamin, no_kk, nama_ayah, nama_ibu');
        $this->builder->join('imunisasi', 'cek_imunisasi.id_imunisasi = imunisasi.id_imunisasi', 'left');
        $this->builder->join('kunjungan', 'cek_imunisasi.id_kunjungan = kunjungan.id_kunjungan', 'left');
        $this->builder->join('kegiatan', 'kunjungan.id_kegiatan = kegiatan.id', 'left');
        $this->builder->join('kms', 'kunjungan.id_kms = kms.id_kms', 'left');
        $this->builder->join('anak', 'kms.id_anak = anak.id_anak', 'left');
        $this->builder->join('users', 'anak.id_user = users.id', 'left');

        $this->builder->orderBy('YEAR(cek_imunisasi.created_at)');
        $this->builder->groupBy('YEAR(cek_imunisasi.created_at)');
        return $this->builder->get()->getResult();
    }
}

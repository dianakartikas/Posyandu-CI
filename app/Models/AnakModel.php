<?php

namespace App\Models;

use CodeIgniter\Model;
use DateTime;

class AnakModel extends Model
{
    protected $table = 'anak';
    protected $primaryKey = 'id_anak';
    protected $allowedFields = ['id_user', 'nama', 'jenis_kelamin', 'tanggal_lahir', 'gambar_anak'];
    protected $useTimestamps = true;

    // public function joinAnakUser()
    // {
    //     return $this->db->table('anak')
    //         ->join('users', 'users.id = anak.id_user')
    //         ->get()->getResultArray();
    // }

    public function dataAnak()
    {
        return $this->db->table('anak')
            ->join('users', 'users.id = anak.id_user')
            ->where('id_anak', user_id())
            ->get()->getResultArray();
    }
    // public function getTable($table)
    // {
    //     return $this->db->table($table);
    // }


    public function countAnak()
    {
        return $this->db->table('anak')
            ->countAllResults();
    }
    // public function countAnak()
    // {
    //     return $this->db->table('anak')
    //         ->where('anak.id_', user()->id)
    //         ->countAllResults();
    // }

    public function getAnakById()
    {
        return $this->db->table('anak')
            ->join('users', 'users.id = anak.id_user')
            ->where('anak.id_user', user_id())
            ->get()->getResultArray();
    }
    public function getKMSanak()
    {
        return $this->db->table('anak')
            ->select('anak.id_anak as id_anak, id_kms, nama, jenis_kelamin, tanggal_lahir, gambar_anak')
            ->join('kms', 'kms.id_anak = anak.id_anak')
            ->join('users', 'users.id = anak.id_user')
            ->where('anak.id_user', user_id())
            ->get()->getResultArray();
    }
    public function anakNonKMS()
    {
        $this->builder = $this->db->table('anak');
        $this->builder->select('anak.id_anak as id_anak, nama, jenis_kelamin, gambar_anak, tanggal_lahir, gambar_anak, bb_lahir, tb_lahir');
        $this->builder->join('kms', 'kms.id_anak = anak.id_anak', 'left');
        $this->builder->join('users', 'users.id = anak.id_user');
        $this->builder->where('anak.id_user', user_id());
        $this->builder->where('kms.id_anak', NULL);
        return $this->builder->get()->getResultArray();
    }
    public function anakKMS()
    {
        $this->builder = $this->db->table('anak');
        $this->builder->select('anak.id_anak as id_anak, nama, jenis_kelamin, gambar_anak, tanggal_lahir, gambar_anak, bb_lahir, tb_lahir');
        $this->builder->join('kms', 'kms.id_anak = anak.id_anak', 'left');
        $this->builder->where('kms.id_anak', NULL);
        return $this->builder->get()->getResultArray();
    }
    public function joinKMS()
    {
        return  $this->db->table('anak')
            ->select('id_kms, nama, jenis_kelamin, tanggal_lahir, gambar_anak')
            ->join('kms', 'kms.id_anak = anak.id_anak')
            ->join('users', 'users.id = anak.id_user')
            ->where('users.id', user_id())
            ->get()->getResultArray();
    }

    // function cek_umur($tanggal_lahir)
    // {

    //     $d1 = new DateTime(date('Y-m-d'));
    //     $d2 = new DateTime(date($tanggal_lahir));
    //     $interval_kpi = $d1->diff($d2);
    //     $sprint = '';
    //     if ($interval_kpi->y != 0) {
    //         $sprint .= $interval_kpi->y . ' Tahun ';
    //     }
    //     if ($interval_kpi->m != 0) {
    //         $sprint .= $interval_kpi->m . ' Bulan ';
    //     }
    //     if ($interval_kpi->d != 0) {
    //         $sprint .= $interval_kpi->d . ' Hari ';
    //     }
    //     if ($interval_kpi->h != 0) {
    //         $sprint .= $interval_kpi->h . ' Jam ';
    //     }
    //     if ($interval_kpi->i != 0) {
    //         $sprint .= $interval_kpi->i . ' Menit ';
    //     }
    //     if ($interval_kpi->s != 0) {
    //         $sprint .= $interval_kpi->s . ' Detik ';
    //     }
    //     return $sprint;
    // }

    // public function tidakBerkunjung()
    // {
    //     $this->builder = $this->db->table('anak');
    //     $this->builder->select('anak.id_anak as id_anak, anak.nama as namaAnak, jenis_kelamin, gambar_anak, tanggal_lahir, gambar_anak, bb_lahir, tb_lahir');

    //     $this->builder->join('kms', 'kms.id_anak = anak.id_anak', 'left');
    //     $this->builder->join('kunjungan', 'kunjungan.id_kms = kms.id_kms', 'left');
    //     $this->builder->join('kegiatan', 'kunjungan.id_kegiatan = kegiatan.id', 'left');
    //     $this->builder->where('kunjungan.status', NULL);
    //     return $this->builder->get()->getResult();
    // }
}

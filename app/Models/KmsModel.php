<?php

namespace App\Models;

use CodeIgniter\Model;

class KmsModel extends Model
{
    protected $table = 'kms';
    protected $primaryKey = 'id_kms';
    protected $allowedFields = ['id_anak', 'bb_lahir', 'tb_lahir'];
    protected $useTimestamps = true;
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';

    public function getAnakNama()
    {
        return $this->db->table('kms')
            ->select('kms.id_anak AS id_anak, nama, bb_lahir, tb_lahir, kms.id_kms AS id')
            ->join('anak', 'anak.id_anak = kms.id_anak')
            ->get()->getResultArray();
    }
    // public function getAnakNonKMS()
    // {
    //     return $this->db->table('kms')
    //         ->select('anak.id_anak, gambar_anak, nama, jenis_kelamin, tanggal_lahir, bb_lahir, tb_lahir')
    //         ->join('anak', 'anak.id_anak != kms.id_anak', 'left')

    //         ->get()->getResultArray();
    // }
    public function joinAntrian()
    {
        $this->builder =  $this->db->table('kms');
        $this->builder->select('kms.id_kms as id_kms, bb_lahir, kms.id_anak as dataAnak, tb_lahir, anak.nama as namaAnak, jenis_kelamin, tanggal_lahir, gambar_anak, fullname, user_image');
        $this->builder->join('anak', 'anak.id_anak = kms.id_anak');
        $this->builder->join('users', 'users.id = anak.id_user');
        return $this->builder->get()->getResultArray();
    }
    public function view_all()
    {
        $query = "SELECT nama, jenis_kelamin, no_kk, nama_ibu, nama_ayah, tanggal_lahir
       FROM kms
       LEFT JOIN anak ON kms.id_anak = anak.id_anak 
       LEFT JOIN users ON anak.id_user = users.id 
       WHERE id_kms
       NOT IN  
       (SELECT id_kms 
       FROM kunjungan
       WHERE DATE(kunjungan.created_at) = CURDATE())";
        return $this->db->query($query)->getResult();
    }
}

<?php

namespace App\Models;

use CodeIgniter\Model;

class KegiatanModel extends Model
{
    protected $table = 'kegiatan';
    protected $primaryKey = 'id';
    protected $allowedFields = ['id_kader', 'nama', 'tanggal', 'lokasi'];
    protected $useTimestamps = true;
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';

    public function getKaderNama()
    {
        return $this->db->table('kegiatan')
            ->select('fullname, nama, tanggal, lokasi, kegiatan.id AS kegid')
            ->join('users', 'users.id = kegiatan.id_kader')
            ->get()->getResultArray();
    }

    public function getKunjunganHariIni()
    {

        $this->builder =  $this->db->table('kegiatan');
        $current_date = date("Y-m-d");

        $this->builder->select('id, nama, lokasi, tanggal');

        $this->builder->where('tanggal', $current_date);
        return $this->builder->get()->getResultArray();
    }

    public function getKegiatanHariIni()
    {

        $this->builder =  $this->db->table('kegiatan');
        $current_date = date("Y-m-d");

        $this->builder->select('id, nama, lokasi, tanggal');
        $this->builder->where('tanggal', $current_date);

        return $this->builder->get()->getRow();
    }
}

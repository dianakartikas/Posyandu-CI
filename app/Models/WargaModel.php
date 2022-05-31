<?php

namespace App\Models;

use CodeIgniter\Model;
use Myth\Auth\Models\UserModel;

class WargaModel extends Model
{
    protected $table = 'warga';
    protected $primaryKey = 'id_user';
    protected $allowedFields = ['id', 'no_kk', 'nama_ibu', 'nama_ayah', 'email', 'password', 'alamat', 'no_telp', 'updated_at'];
    protected $useTimestamps = true;

    public function getUserById()
    {
        return $this->db->table('warga')
            ->join('users', 'users.id = warga.id')
            ->where('warga.id', session()->get('id'))
            ->get()->getResultArray();
    }

    public function getWargaById()
    {
        return $this->db->table('warga')
            ->where('id_user', session()->get('id_user'))
            ->get()->getRowArray();
    }
}

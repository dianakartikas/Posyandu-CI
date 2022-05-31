<?php

namespace App\Models;

use CodeIgniter\Model;

class TinggiBadanUmur extends Model
{
    protected $table = 'tbu';
    protected $primaryKey = 'notbu';
    protected $allowedFields = ['jenis_kelamin', 'sdmin1', 'sdplus1', 'median', 'umur'];
    protected $useTimestamps = true;
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';

    public function getAllData()
    {
        $this->db->table('tbu')
            ->select('umur', 'jenis_kelamin', 'sdmin1', 'sdplus1', 'median');
        return $this->get()->getResultArray();
    }
}

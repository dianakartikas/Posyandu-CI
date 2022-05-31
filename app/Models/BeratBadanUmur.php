<?php

namespace App\Models;

use CodeIgniter\Model;

class BeratBadanUmur extends Model
{
    protected $table = 'bbu';
    protected $primaryKey = 'nobbu';
    protected $allowedFields = ['umur', 'jenis_kelamin', 'sdmin1', 'sdplus1', 'median'];
    protected $useTimestamps = true;
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';


    public function getAllData()
    {
        $this->db->table('bbu')
            ->select('umur', 'jenis_kelamin', 'sdmin1', 'sdplus1', 'median');
        return $this->get()->getResultArray();
    }
}

<?php

namespace App\Models;

use CodeIgniter\Model;

class BBperTB1 extends Model
{
    protected $table = 'bbtb1';
    protected $primaryKey = 'nobbtb';
    protected $allowedFields = ['jenis_kelamin', 'sdmin1', 'sdplus1', 'median', 'tinggi_badan'];
    protected $useTimestamps = true;
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';

    public function getAllData()
    {
        $this->db->table('bbtb1')
            ->select('tinggi_badan', 'jenis_kelamin', 'sdmin1', 'sdplus1', 'median');
        return $this->get()->getResultArray();
    }
}

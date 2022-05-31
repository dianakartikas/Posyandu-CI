<?php

namespace App\Models;

use CodeIgniter\Model;

class ImunisasiModel extends Model
{
    protected $table = 'imunisasi';
    protected $primaryKey = 'id_imunisasi';
    protected $allowedFields = ['nama', 'dari_usia', 'sampai_usia', 'catatan'];
    protected $useTimestamps = true;
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';


    public function countImunisasi()
    {
        return $this->db->table('imunisasi')
            ->countAllResults();
    }
    // public function getImunisasi($id_kms)
    // {
    //     return $this->db->table('imunisasi')
    //         ->countAllResults();
    // }
}

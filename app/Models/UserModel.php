<?php

namespace App\Models;

use Myth\Auth\Models\UserModel as MythModel;

class UserModel extends MythModel
{
    protected $table = 'users';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;

    protected $returnType     = 'array';
    protected $useSoftDeletes = true;
    protected $useTimestamps = false;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    protected $validationRules    = [];
    protected $validationMessages = [];
    protected $skipValidation     = false;
    protected $allowedFields = [
        'email', 'username', 'fullname', 'no_kk', 'user_image', 'password_hash', 'reset_hash', 'reset_at', 'reset_expires', 'activate_hash', 'status', 'status_message', 'active', 'force_pass_reset', 'permissions', 'deleted_at', 'firstname', 'lastname', 'phone', 'nama_ayah', 'nama_ibu',
    ];

    public function getRole()
    {
        $this->db      = \Config\Database::connect();
        $this->builder = $this->db->table('users');
        $this->builder->select('users.id as userid, username, email,no_kk, name, user_image, fullname, group_id');
        $this->builder->join('auth_groups_users', 'auth_groups_users.user_id = users.id');
        $this->builder->join('auth_groups', 'auth_groups.id= auth_groups_users.group_id');
        $this->builder->get();
    }

    public function countKader()
    {

        $this->builder = $this->db->table('users');
        $this->builder->select('users.id as userid, name');
        $this->builder->join('auth_groups_users', 'auth_groups_users.user_id = users.id');
        $this->builder->join('auth_groups', 'auth_groups.id= auth_groups_users.group_id');
        $role = 'kader';
        $this->builder->where('name', $role);
        return $this->builder->countAllResults();
    }
    public function countUser()
    {

        $this->builder = $this->db->table('users');
        $this->builder->select('users.id as userid, name');
        $this->builder->join('auth_groups_users', 'auth_groups_users.user_id = users.id');
        $this->builder->join('auth_groups', 'auth_groups.id= auth_groups_users.group_id');
        $role = 'user';
        $this->builder->where('name', $role);
        return $this->builder->countAllResults();
    }


    // public function view_all()
    // {

    //     $this->builder = $this->db->table('users');

    //     $this->builder->select('anak.id_anak as id_anak, anak.nama as namaAnak, jenis_kelamin, nama_ayah, nama_ibu, no_kk, tanggal_lahir');
    //     $this->builder->join('anak', 'anak.id_user = users.id', 'left');
    //     $this->builder->join('kms', 'kms.id_anak = anak.id_anak', 'left');
    //     $this->builder->join('kunjungan', 'kunjungan.id_kms = kms.id_kms', 'left');
    //     $current_date = date("Y-m-d");
    //     $this->builder->where('DATE(kunjungan.created_at) !=', $current_date);
    //     $this->builder->where('users.no_kk !=', NULL);




    //     return $this->builder->get()->getResult();
    // }

    public function lihatProfile()
    {
        $this->builder = $this->db->table('users');
        $this->builder->select('users.id as userid, username, email, name, user_image, fullname, no_kk,group_id');
        $this->builder->join('auth_groups_users', 'auth_groups_users.user_id = users.id');
        $this->builder->join('auth_groups', 'auth_groups.id= auth_groups_users.group_id');
        $this->builder->where('users.id', user_id());
        return $this->builder->get()->getResult();
    }

    public function updateProfile()
    {
        $this->builder = $this->db->table('users');
        $this->builder->select('users.id as userid, name');
        $this->builder->join('auth_groups_users', 'auth_groups_users.user_id = users.id');
        $this->builder->join('auth_groups', 'auth_groups.id= auth_groups_users.group_id');

        $this->builder->where('users.id', user_id());
        return $this->builder->get()->getRow();
    }
    public function lihatPassword()
    {
        $this->builder = $this->db->table('users');
        $this->builder->select('users.id as userid, password_hash');
        $this->builder->where('users.id', user_id());
        return $this->builder->get()->getRow();
    }

    public function daftarPengguna()
    {
        $this->builder = $this->db->table('users');
        $this->builder->select('users.id as userid, username, email, name, user_image, fullname, group_id');
        $this->builder->join('auth_groups_users', 'auth_groups_users.user_id = users.id');
        $this->builder->join('auth_groups', 'auth_groups.id= auth_groups_users.group_id');
        return $this->builder->get()->getResult();
    }

    public function RoleUser()
    {
        $this->builder = $this->db->table('users');
        $this->builder->select('users.id as userid, username, email, name, user_image, fullname, group_id');
        $this->builder->join('auth_groups_users', 'auth_groups_users.user_id = users.id');
        $this->builder->join('auth_groups', 'auth_groups.id= auth_groups_users.group_id');
        $role = 'user';
        $this->builder->where('name', $role);
        return $this->builder->get()->getResult();
    }

    public function RoleAllUserID($id)
    {
        $this->builder->select('users.id as userid, username, email, user_image, fullname, name, no_kk');
        $this->builder->join('auth_groups_users', 'auth_groups_users.user_id = users.id');
        $this->builder->join('auth_groups', 'auth_groups.id= auth_groups_users.group_id');
        $this->builder->where('users.id', $id);
        return $this->builder->get()->getRow();
    }
    public function RoleUserIDAnak($id)
    {
        $this->builder->select('users.id as userid, username, email, user_image, fullname, name, id_user, nama, jenis_kelamin, tanggal_lahir, gambar_anak,id_anak');
        $this->builder->join('auth_groups_users', 'auth_groups_users.user_id = users.id');
        $this->builder->join('auth_groups', 'auth_groups.id= auth_groups_users.group_id');
        $this->builder->join('anak', 'anak.id_user= users.id');
        $role = 'user';
        $this->builder->where('name', $role);
        $this->builder->where('users.id', $id);
        return $this->builder->get()->getResultArray();
    }
}

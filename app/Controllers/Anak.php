<?php

namespace App\Controllers;

use DateTime;
use App\Models\AnakModel;
use App\Models\UserModel;

class Anak extends BaseController
{

    protected $AnakModel;
    protected $UserModel;
    public function __construct()
    {
        $this->AnakModel = new AnakModel();
        $this->UserModel = new UserModel();
        $this->db      = \Config\Database::connect();
    }

    public function index()
    {
        $data = [

            'title' => 'Data Anak',
            'validation' => \Config\Services::validation(),
            'anakKMS' => $this->AnakModel->getKMSanak(),
            'anakNonKMS' => $this->AnakModel->anakNonKMS(),
            'jumlah' => $this->AnakModel->countAnak(),
            'dataanak' => $this->AnakModel->dataAnak(),
            'anak' => $this->AnakModel->getAnakById(),
            // 'umur' => $this->AnakModel->cek_umur(),
            'keterangan' => 'Informasi Data Anak pada Posyandu Batu Horpak',
        ];
        // $this->db      = \Config\Database::connect();
        // $this->builder = $this->db->table('users');
        // $this->builder->select('users.id as userid, username, email, user_image, fullname, name, no_kk');
        // $this->builder->join('auth_groups_users', 'auth_groups_users.user_id = users.id');
        // $this->builder->join('auth_groups', 'auth_groups.id= auth_groups_users.group_id');
        // $this->builder->where('users.id');
        // $query = $this->builder->get();
        // $data['kms'] = $query->getResult();
        $this->builder =  $this->db->table('users');
        $this->builder->select('no_kk');
        $this->builder->where('id', user_id());
        $query = $this->builder->get();
        $data['warga'] = $query->getRow();
        if (empty($data['warga']->no_kk)) {
            session()->setFlashdata('warning', 'data Nomor KK, Nama OrangTua harus diisi.');
            return redirect()->to('/profile');
        }
        return view('user/anak_v', $data);
    }

    public function save()
    {
        if (!$this->validate([
            'nama' => [
                'label' => 'Nama Anak',
                'rules' => 'required|min_length[3]|max_length[20]|is_unique[anak.nama,id_anak,{id_anak}]',
                'errors' => [
                    'required' => '{field} tidak boleh kosong',
                    'min_length' => '{field} nama terlalu pendek',
                    'max_length' => '{field} nama terlalu panjang'
                ]
            ],
            'jenis_kelamin' => [
                'label' => 'Jenis Kelamin',
                'rules' => 'required',
                'errors' => [
                    'required' => '{field} tidak boleh kosong'
                ]
            ],
            'tanggal_lahir' => [
                'label' => 'Tanggal Lahir',
                'rules' => 'required|ultah',
                'errors' => [
                    'required' => '{field} tidak boleh kosong',
                    'ultah' => 'umur tidak diperbolehkan'
                ]
            ],
            'gambar_anak' => [
                // jangan pake spasi 
                'rules' => 'max_size[gambar_anak,1024]|is_image[gambar_anak]|mime_in[gambar_anak,image/jpg,image/jpeg,image/png,image/svg]',
                'errors' => [
                    // 'uploaded' => 'Pilih gambar terlebih dahulu',
                    'max_size' => 'Ukuran gambar terlalu besar',
                    'is_image' => 'Yang anda pilih bukan gambar',
                    'mime_in' => 'Yang anda pilih bukan gmbar'
                ]
            ]
        ])) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }
        $fileGambar = $this->request->getFile('gambar_anak');
        if ($fileGambar->getError() == 4) {
            $namaGambar = 'default.svg';
        } else {
            $namaGambar = $fileGambar->getRandomName();
            // pindahkan file ke folder img fungsi move untuk langsung ke folder publik
            $fileGambar->move('img/anak', $namaGambar);
        }

        $save = [
            'id_user' => user_id(),
            'nama' => $this->request->getVar('nama'),
            'jenis_kelamin' => $this->request->getVar('jenis_kelamin'),
            'tanggal_lahir' => $this->request->getVar('tanggal_lahir'),
            'gambar_anak' => $namaGambar,
        ];
        $anak = new AnakModel;
        $anak->insert($save);
        session()->setFlashdata('success', 'Data anak Berhasil Ditambahkan.');
        return redirect()->back();
    }

    public function update($id)
    {

        // $namaLama = $this->AnakModel->getAnakById($this->request->getVar('id_anak'));
        // if ($namaLama['nama'] == $this->request->getVar('nama')) {
        //     $rule_nama = 'required';
        // } else {
        //     $rule_nama = 'required|is_unique[anak.nama]';
        // }

        if (!$this->validate([
            'nama' => [
                'label' => 'Nama Anak',
                'rules' => 'required|is_unique[anak.id_anak!=' . $id . ' AND ' . 'nama=]',
                'errors' => [
                    'required' => '{field} harus di isi.',
                    'is_unique' => '{field} sudah terdaftar'
                ]
            ],
            'jenis_kelamin' => [
                'label' => 'Jenis Kelamin',
                'rules' => 'required',
                'errors' => [
                    'required' => '{field} tidak boleh kosong'
                ]
            ],
            'tanggal_lahir' => [
                'label' => 'Tanggal Lahir',
                'rules' => 'required|ultah',
                'errors' => [
                    'required' => '{field} tidak boleh kosong',
                    'ultah' => 'umur tidak diperbolehkan'
                ]
            ],
            'gambar_anak' => [
                // jangan pake spasi 
                'rules' => 'max_size[gambar_anak,1024]|is_image[gambar_anak]|mime_in[gambar_anak,image/jpg,image/jpeg,image/png,image/svg]',
                'errors' => [
                    // 'uploaded' => 'Pilih gambar terlebih dahulu',
                    'max_size' => 'Ukuran gambar terlalu besar',
                    'is_image' => 'Yang anda pilih bukan gambar',
                    'mime_in' => 'Yang anda pilih bukan gmbar'
                ]
            ]

        ])) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }
        $fileGambar = $this->request->getFile('gambar_anak');
        if ($fileGambar->getError() == 4) {
            $namaGambar = $this->request->getVar('gambarLama');
        } else {
            // generate nama foto
            $namaGambar = $fileGambar->getRandomName();
            // pindahkan ke folder
            $fileGambar->move('img/anak', $namaGambar);
            // hapus foto

            if ($fileGambar != "") {
                if (file_exists('img/anak/' .  $this->request->getVar('gambarLama') != 'default.svg')) {
                    unlink('img/anak/' . $this->request->getVar('gambarLama'));
                }
            }
        }

        $this->AnakModel->save([
            'id_anak' => $id,
            'id_user' => user_id(),
            'nama' => $this->request->getVar('nama'),
            'jenis_kelamin' => $this->request->getVar('jenis_kelamin'),
            'tanggal_lahir' => $this->request->getVar('tanggal_lahir'),
            'gambar_anak' => $namaGambar,
        ]);
        session()->setFlashdata('success', 'data anak telah diubah.');
        return redirect()->back();
    }
}

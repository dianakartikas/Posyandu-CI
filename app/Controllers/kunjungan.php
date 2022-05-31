<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\KegiatanModel;
use App\Models\AnakModel;
use App\Models\UserModel;
use App\Models\ImunisasiModel;
use App\Models\KunjunganModel;
use App\Models\KmsModel;
use App\Models\CekImunisasiModel;
use App\Models\CekPertumbuhanModel;

class Kunjungan extends BaseController
{
    protected $KegiatanModel;
    protected $AnakModel;
    protected $UserModel;
    protected $KmsModel;
    protected $ImunisasiModel;
    protected $KunjunganModel;
    protected $CekImunisasiModel;
    protected $CekPertumbuhanModel;
    public function __construct()
    {
        $this->db      = \Config\Database::connect();
        $this->KunjunganModel = new KunjunganModel();
        $this->KegiatanModel = new KegiatanModel();
        $this->UserModel = new UserModel();
        $this->AnakModel = new AnakModel();
        $this->ImunisasiModel = new ImunisasiModel();
        $this->AnakModel = new AnakModel();
        $this->KmsModel = new KmsModel();
        $this->CekImunisasiModel = new CekImunisasiModel();
        $this->CekPertumbuhanModel = new CekPertumbuhanModel();
    }
    public function index()
    {
        $data = [
            'title' => 'Kunjungan',
            'keterangan' => 'Informasi kunjungan pada Posyandu Batu Horpak',
            'countkader' => $this->UserModel->countKader(),
            'countuser' => $this->UserModel->countUser(),
            'jumlah' => $this->AnakModel->countAnak(),
            'countimunisasi' => $this->ImunisasiModel->countImunisasi(),
            'getKunjunganHariIni' => $this->KegiatanModel->getKunjunganHariIni(),
            'joinKunjungan' => $this->KunjunganModel->joinKunjungan(),
            'countKunjungan' => $this->KunjunganModel->countKunjungan(),
            'tampilAntrian' => $this->KunjunganModel->tampilAntrian(),
            'tampilAnakAntri' => $this->KunjunganModel->tampilDataAnakSedangAntri(),
            'chart' => $this->KunjunganModel->chart_antrian(),
            'reset' => $this->KunjunganModel->resetKunjungan()


        ];

        $joinKunjungan = $this->KunjunganModel->joinKunjungan();
        $this->builder =  $this->db->table('kegiatan');
        $current_date = date("Y-m-d");
        // $this->builder->select('id, nama, lokasi, tanggal');
        // $this->builder->where('tanggal', $current_date);
        // $query = $this->builder->get();
        // $data['kegiatan'] = $query->getRow();
        $this->builder->select('id, nama, lokasi, tanggal');
        $this->builder->where('tanggal', $current_date);
        $query = $this->builder->get();
        $data['kegiatan'] = $query->getRow();
        if (empty($data['kegiatan']) || empty($current_date)) {
            return redirect()->to('/kegiatan');
        }
        return view('kader/kunjungan_v', $data);

        // if (!empty($data['kegiatan']) || !empty($current_date)) {
        //     $this->builder =  $this->db->table('kunjungan');
        //     $status = 'antri';
        //     $this->builder->select('id_kunjungan');

        //     $this->builder->where('status', $status);
        //     $this->builder->orderBy('id_kunjungan', 'ASC');
        //     $this->builder->limit(1);
        //     $data['antrian'] = $query->getRow();
        //     return view('kader/kunjungan', $data);
        // }
        // return redirect()->to('/kegiatan');
    }



    public function tambahAntrian($id = 0)
    {
        $data = [
            'kunjungan' => $this->KunjunganModel->dataKunjungan(),
            'validation' => \Config\Services::validation(),
            'title' => 'Kunjungan',
            'keterangan' => 'Informasi tambah antrian pada Posyandu Batu Horpak',
            'countkader' => $this->UserModel->countKader(),
            'countuser' => $this->UserModel->countUser(),
            'jumlah' => $this->AnakModel->countAnak(),
            'joinAntrian' => $this->KmsModel->joinAntrian(),
            'countimunisasi' => $this->ImunisasiModel->countImunisasi(),
            'getKunjunganHariIni' => $this->KegiatanModel->getKunjunganHariIni(),
            'tambahAntrian' => $this->KunjunganModel->tambahAntrian($id),
            'cekKode' => $this->KunjunganModel->cekKode(),
        ];
        // $this->builder =  $this->db->table('kunjungan');
        // $this->builder->select('id_kegiatan, tanggal, no_antri, bb_lahir, pb_lahir, nama, jenis_kelamin, tanggal_lahir, gambar_anak, fullname');
        // $this->builder->join('kegiatan', 'kegiatan.id = kunjungan.id_kegiatan');
        // $this->builder->join('kms', 'kms.id_kms = kunjungan.id_kms');
        // $this->builder->join('anak', 'anak.id_anak = kms.id_anak');
        // $this->builder->join('users', 'users.id = anak.id_user');
        // $this->builder->where('kegiatan.id', $id);
        $this->builder =  $this->db->table('kegiatan');
        $current_date = date("Y-m-d");
        // $this->builder->select('id, nama, lokasi, tanggal');
        // $this->builder->where('tanggal', $current_date);
        // $query = $this->builder->get();
        // $data['kegiatan'] = $query->getRow();
        $this->builder->select('id, nama, lokasi, tanggal');
        $this->builder->where('tanggal', $current_date);
        $query = $this->builder->get();
        $data['kegiatan'] = $query->getRow();
        if (empty($data['kegiatan']) || empty($current_date)) {
            return redirect()->to('/kegiatan');
        }

        return view('kader/tambahAntrean_v', $data);
        // $data = [
        //     'title' => 'Kunjungan',
        //     'keterangan' => 'Informasi kunjungan pada Posyandu Batu Horpak',
        //     'countkader' => $this->UserModel->countKader(),
        //     'countuser' => $this->UserModel->countUser(),
        //     'jumlah' => $this->AnakModel->countAnak(),
        //     'countimunisasi' => $this->ImunisasiModel->countImunisasi(),
        //     'getKunjunganHariIni' => $this->KegiatanModel->getKunjunganHariIni(),
        //     'joinKunjungan' => $this->KunjunganModel->joinKunjungan(),
        //     'countKunjungan' => $this->KunjunganModel->countKunjungan(),
        //     'tampilAntrian' => $this->KunjunganModel->tampilAntrian($id),


        // ];
        // return view('kader/kunjungan', $data);
    }

    // public function detail($id = 0)
    // {
    //     $data = [
    //         'validation' => \Config\Services::validation(),
    //         'title' => 'Detail User',
    //         'keterangan' => 'Informasi detail Pengguna pada Posyandu Batu Horpak',
    //         'countkader' => $this->UserModel->countKader(),
    //         'countuser' => $this->UserModel->countUser(),
    //         'jumlah' => $this->AnakModel->countAnak(),
    //         'countimunisasi' => $this->ImunisasiModel->countImunisasi()
    //     ];
    //     $this->builder->select('users.id as userid, username, email, user_image, fullname, name, no_kk');
    //     $this->builder->join('auth_groups_users', 'auth_groups_users.user_id = users.id');
    //     $this->builder->join('auth_groups', 'auth_groups.id= auth_groups_users.group_id');

    //     $this->builder->where('users.id', $id);
    //     $query = $this->builder->get();
    //     $data['user'] = $query->getRow();

    //     if (empty($data['user']) || empty($id)) {
    //         return redirect()->to('/admin');
    //     }
    //     $this->builder->select('users.id as userid, username, email, no_kk, user_image, fullname, name, id_user, nama, jenis_kelamin, tanggal_lahir, umur, gambar_anak');
    //     $this->builder->join('auth_groups_users', 'auth_groups_users.user_id = users.id');
    //     $this->builder->join('auth_groups', 'auth_groups.id= auth_groups_users.group_id');
    //     $this->builder->join('anak', 'anak.id_user= users.id');
    //     $this->builder->where('users.id', $id);
    //     $query = $this->builder->get();
    //     return view('admin/detail', $data);
    // }

    public function pilih($id)
    {

        if (!$this->validate([
            'kode' => [
                'label' => 'Nama Anak',
                'rules' => 'is_unique[kunjungan.kode]',
                'errors' => [
                    'is_unique' => '{field} sudah dalam antrian ',
                ]
            ]
        ])) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }
        $hasil = 'antri';
        $this->KunjunganModel->save([
            'id_kegiatan' => $id,
            'id_kms' => $this->request->getVar('id_kms'),
            'status' => $hasil,
            'kode' => $this->request->getVar('kode'),

        ]);
        session()->setFlashdata('success', 'data yang dipilih telah dimasukkan.');
        return redirect()->back();
    }

    public function AntrianSelanjutnya($id)
    {
        $status = 'proses';
        $this->KunjunganModel->save([
            'id_kunjungan' => $id,
            'status' => $status,
        ]);
        session()->setFlashdata('success', 'Antrian Selanjutnya.');
        return redirect()->back();
    }

    public function LewatiAntrian($id)
    {
        $status = 'terlewat';
        $this->KunjunganModel->save([
            'id_kunjungan' => $id,
            'status' => $status,
        ]);
        session()->setFlashdata('warning', 'Antrian Dilewatin.');

        return redirect()->back();
    }
    public function AntrianByWarga()
    {
        $data = [
            'title' => 'Antrian Warga',
            'keterangan' => 'Informasi Pengambilan Nomor Antrian oleh Warga pada Posyandu Batu Horpak',
            'validation' => \Config\Services::validation(),
            'anak' => $this->AnakModel->getAnakById(),
            'joinAntrian' => $this->KmsModel->joinAntrian(),
            'kunjungan' => $this->KunjunganModel->dataKunjungan(),
            'joinKMS' => $this->AnakModel->joinKMS(),
            'dataImunisasi' => $this->CekImunisasiModel->cekPemeriksaanUser(),
            'dataPertumbuhan' => $this->CekPertumbuhanModel->CekPemeriksaanUser(),
            'kegiatan' => $this->KegiatanModel->getKegiatanHariIni()

        ];
        $this->builder =  $this->db->table('kegiatan');
        $current_date = date("Y-m-d");
        // $this->builder->select('id, nama, lokasi, tanggal');
        // $this->builder->where('tanggal', $current_date);
        // $query = $this->builder->get();
        // $data['kegiatan'] = $query->getRow();
        $this->builder->select('id, nama, lokasi, tanggal');
        $this->builder->where('tanggal', $current_date);
        $query = $this->builder->get();
        $data['kegiatan'] = $query->getRow();
        if (empty($data['kegiatan']) || empty($current_date)) {
            return redirect()->to('/');
        }
        return view('user/antrean_v', $data);
    }
}

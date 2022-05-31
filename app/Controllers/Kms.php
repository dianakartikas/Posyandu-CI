<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\KmsModel;
use App\Models\AnakModel;
use App\Models\UserModel;
use App\Models\ImunisasiModel;
use App\Models\KunjunganModel;

class Kms extends BaseController
{
    protected $KmsModel;
    protected $AnakModel;
    protected $UserModel;
    protected $ImunisasiModel;

    public function __construct()
    {
        $this->db      = \Config\Database::connect();
        $this->builder = $this->db->table('kms');
        $this->KmsModel = new KmsModel();
        $this->AnakModel = new AnakModel();
        $this->UserModel = new UserModel();
        $this->ImunisasiModel = new ImunisasiModel();
        $this->KunjunganModel = new KunjunganModel();
    }
    public function index()

    {

        $data = [
            'kms' => $this->KmsModel->getAnakNama(),
            'nonkms' => $this->AnakModel->anakKMS(),
            'anak' => $this->AnakModel->findAll(),
            'validation' => \Config\Services::validation(),
            'title'     => 'Daftar KMS',
            'keterangan' => 'Informasi daftar KMS pada Posyandu Batu Horpak',
            'countuser' => $this->UserModel->countUser(),
            'countkader' => $this->UserModel->countKader(),
            'jumlah' => $this->AnakModel->countAnak(),
            'countimunisasi' => $this->ImunisasiModel->countImunisasi()

        ];
        return view('kader/kms_v', $data);
    }
    public function detail($id = 0)
    {
        $data = [
            'title' => 'Detail KMS',
            'keterangan' => 'Informasi detail KMS pada Posyandu Batu Horpak',
            'countuser' => $this->UserModel->countUser(),
            'countkader' => $this->UserModel->countKader(),
            'jumlah' => $this->AnakModel->countAnak(),
            'countimunisasi' => $this->ImunisasiModel->countImunisasi(),
            'detailkms' => $this->KunjunganModel->detailKMS($id)

        ];
        $this->builder->select('id_kms, users.id as userid, no_kk, fullname, nama, jenis_kelamin, tanggal_lahir, kms.created_at as tanggalterdaftar, bb_lahir, tb_lahir ');
        $this->builder->join('anak', 'anak.id_anak = kms.id_anak');
        $this->builder->join('users', 'users.id = anak.id_user');
        $this->builder->where('kms.id_kms', $id);
        $query = $this->builder->get();
        $data['user'] = $query->getRow();
        // $this->builder = $this->db->table('imunisasi');
        // $this->builder->select('nama, cek_imunisasi.created_at as created_at, status,  cek_imunisasi.umur as umur, cek_imunisasi.catatan as catatan, kunjungan.created_at as tanggal, kunjungan.id_kunjungan as id_kunjungan');
        // $this->builder->join('cek_imunisasi', 'cek_imunisasi.id_imunisasi = imunisasi.id_imunisasi');
        // $this->builder->join('kunjungan', 'kunjungan.id_kunjungan = cek_imunisasi.id_kunjungan');
        // $this->builder->where('kunjungan.id_kms', $id);

        $query = $this->builder->get();
        $this->builder = $this->db->table('kunjungan');
        $this->builder->select('nama, cek_imunisasi.created_at as created_at, status,  cek_imunisasi.umur as umur, cek_imunisasi.catatan as catatan, kunjungan.created_at as tanggal, kunjungan.id_kunjungan as id_kunjungan, hasil_bbu, hasil_tbu, hasil_bbtb, berat_badan, tinggi_badan, cek_pertumbuhan.created_at as created_at2, cek_pertumbuhan.umur as cekumur, cek_pertumbuhan.catatan as catatan2');
        $this->builder->join('cek_imunisasi', 'cek_imunisasi.id_kunjungan = kunjungan.id_kunjungan', 'left');
        $this->builder->join('cek_pertumbuhan', 'cek_pertumbuhan.id_kunjungan = kunjungan.id_kunjungan', 'left');
        $this->builder->join('imunisasi', 'imunisasi.id_imunisasi = cek_imunisasi.id_imunisasi', 'left');

        $this->builder->where('kunjungan.id_kms', $id);

        $query = $this->builder->get();
        $data['detail'] = $query->getResultArray();

        // $this->builder = $this->db->table('kunjungan');
        // $this->builder->select('nama, cek_imunisasi.created_at as created_at, status,  cek_imunisasi.umur as umur, cek_imunisasi.catatan as catatan, kunjungan.created_at as tanggal, kunjungan.id_kunjungan as id_kunjungan, hasil_bbu, hasil_tbu, berat_badan, tinggi_badan, cek_pertumbuhan.created_at as created_at2, umur');
        // $this->builder->join('cek_imunisasi', 'cek_imunisasi.id_kunjungan = imunisasi.id_kunjungan');
        // $this->builder->join('cek_pertumbuhan', 'cek_pertumbuhan.id_kunjungan = kunjungan.id_kunjungan', 'left');
        // $this->builder->join('imunisasi', 'imunisasi.id_imunisasi = cek_imunisasi.id_imunisasi');
        // $this->builder->where('kunjungan.id_kms', $id);
        // $query = $this->builder->get();
        // $data['detail2'] = $query->getRow();
        return view('kader/detailKms_v', $data);
    }
    public function save($id)
    {
        if (!$this->validate([

            'bb_lahir' => [
                'label' => 'Berat Badan Lahir',
                'rules' => 'required|is_natural_no_zero|max_length[3]',
                'errors' => [
                    'required' => '{field} tidak boleh kosong',
                    'is_natural_no_zero' => '{field} tidak valid',
                    'max_length' => '{field} tidak valid'
                ]
            ],
            'tb_lahir' => [
                'label' => 'Panjang Badan Lahir',
                'rules' => 'required|is_natural_no_zero|max_length[3]',
                'errors' => [
                    'required' => '{field} tidak boleh kosong',
                    'is_natural_no_zero' => '{field} tidak valid',
                    'max_length' => '{field} tidak valid'
                ]
            ]
        ])) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $save = [

            'id_anak' => $id,
            'bb_lahir' => $this->request->getVar('bb_lahir'),
            'tb_lahir' => $this->request->getVar('tb_lahir'),



        ];
        $kms = new KmsModel();
        $kms->insert($save);
        session()->setFlashdata('success', 'Data KMS Berhasil Ditambahkan.');
        return redirect()->back();
    }

    public function update($id)
    {
        if (!$this->validate([

            'bb_lahir' => [
                'label' => 'Berat Badan Lahir',
                'rules' => 'required|is_natural_no_zero|max_length[3]',
                'errors' => [
                    'required' => '{field} tidak boleh kosong',
                    'is_natural_no_zero' => '{field} tidak valid',
                    'max_length' => '{field} tidak valid'
                ]
            ],
            'tb_lahir' => [
                'label' => 'Panjang Badan Lahir',
                'rules' => 'required|is_natural_no_zero|max_length[3]',
                'errors' => [
                    'required' => '{field} tidak boleh kosong',
                    'is_natural_no_zero' => '{field} tidak valid',
                    'max_length' => '{field} tidak valid'
                ]
            ]
        ])) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }


        $this->KmsModel->save([
            'id_kms' => $id,
            'bb_lahir' => $this->request->getVar('bb_lahir'),
            'tb_lahir' => $this->request->getVar('tb_lahir'),
        ]);
        session()->setFlashdata('success', 'data KMS berhasil diperbarui.');
        return redirect()->back();
    }

    public function confirmdelete($id = null)
    {
        $this->KmsModel->delete($id);
        $data = [
            'status' => 'berhasil dihapus',
            'status_test' => 'data KMS sudah berhasil dihapus',
            'status_icon' => 'success'
        ];
        return $this->response->setJSON($data);
    }
}

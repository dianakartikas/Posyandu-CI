<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\AnakModel;
use App\Models\ImunisasiModel;
use App\Models\UserModel;

class Imunisasi extends BaseController
{
    protected $ImunisasiModel;
    protected $UserModel;
    protected $AnakModel;


    public function __construct()
    {
        $this->UserModel = new UserModel();
        $this->AnakModel = new AnakModel();
        $this->ImunisasiModel = new ImunisasiModel();
    }
    public function index()

    {

        $data = [
            'imunisasi' => $this->ImunisasiModel->findAll(),
            'validation' => \Config\Services::validation(),
            'title'     => 'Daftar Imunisasi',
            'keterangan' => 'Informasi daftar imunisasi pada Posyandu Batu Horpak',
            'countkader' => $this->UserModel->countKader(),
            'countuser' => $this->UserModel->countUser(),
            'jumlah' => $this->AnakModel->countAnak(),
            'countimunisasi' => $this->ImunisasiModel->countImunisasi()


        ];
        return view('admin/imunisasi_v', $data);
    }


    public function save()
    {
        if (!$this->validate([
            'nama' => [
                'label' => 'Nama Imunisasi',
                'rules' => 'required|min_length[3]|max_length[20]|is_unique[imunisasi.nama,id,{id}]',
                'errors' => [
                    'required' => '{field} tidak boleh kosong',
                    'min_length' => '{field} nama terlalu pendek',
                    'max_length' => '{field} nama terlalu panjang'
                ]
            ],
            'dari_usia' => [
                'label' => 'Dari Usia',
                'rules' => 'required|numeric',
                'errors' => [
                    'required' => '{field} tidak boleh kosong',
                    'numeric' => '{field} tidak valid'
                ]

            ],
            'sampai_usia' => [
                'label' => 'Sampai Usia',
                'rules' => 'required|numeric',
                'errors' => [
                    'required' => '{field} tidak boleh kosong',
                    'numeric' => '{field} tidak valid'
                ]
            ]
        ])) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }
        $save = [
            'id_imunisasi' => $this->request->getVar('id_imunisasi'),
            'nama' => $this->request->getVar('nama'),
            'dari_usia' => $this->request->getVar('dari_usia'),
            'sampai_usia' => $this->request->getVar('sampai_usia'),
            'catatan' => $this->request->getVar('catatan'),

        ];
        $imunisasi = new ImunisasiModel;
        $imunisasi->insert($save);
        session()->setFlashdata('success', 'Data Imunisasi Berhasil Ditambahkan.');
        return redirect()->to('/imunisasi');
    }



    // public function edit()
    // {
    //     if ($this->request->isAJAX()) {

    //         $id_imunisasi = $this->request->getVar('id_imunisasi');
    //         $imunisasi = new ImunisasiModel();
    //         $row = $imunisasi->find($id_imunisasi);

    //         $data = [
    //             'id_imunisasi' => $row['id_imunisasi'],
    //             'nama'         => $row['nama'],
    //             'dari_usia'    => $row['dari_usia'],
    //             'sampai_usia'  => $row['sampai_usia'],
    //             'catatan'  => $row['catatan'],
    //         ];
    //         $msg = [
    //             'sukses' =>  redirect()->to('/admin/imunisasi')->withInput($data)
    //         ];
    //         echo json_encode($msg);
    //     }
    // }

    public function update($id)
    {
        if (!$this->validate([
            'nama' => [
                'label' => 'Nama Imunisasi',
                'rules' => 'required|min_length[3]|max_length[20]|is_unique[imunisasi.id_imunisasi!=' . $id . ' AND ' . 'nama=]',
                'errors' => [
                    'required' => '{field} tidak boleh kosong',
                    'min_length' => '{field} nama terlalu pendek',
                    'max_length' => '{field} nama terlalu panjang',
                    'is_unique' => '{field} sudah tersedia'
                ]
            ],
            'dari_usia' => [
                'label' => 'Dari Usia',
                'rules' => 'required|numeric',
                'errors' => [
                    'required' => '{field} tidak boleh kosong',
                    'numeric' => '{field} tidak valid'
                ]

            ],
            'sampai_usia' => [
                'label' => 'Sampai Usia',
                'rules' => 'required|numeric',
                'errors' => [
                    'required' => '{field} tidak boleh kosong',
                    'numeric' => '{field} tidak valid'
                ]
            ]
        ])) {

            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }
        $this->ImunisasiModel->save([
            'id_imunisasi' => $id,
            'nama' => $this->request->getVar('nama'),
            'dari_usia' => $this->request->getVar('dari_usia'),
            'sampai_usia' => $this->request->getVar('sampai_usia'),
            'catatan' => $this->request->getVar('catatan'),
        ]);
        session()->setFlashdata('success', 'data imunisasi berhasil diperbarui.');
        return redirect()->to('/imunisasi');
    }




    public function hapus()
    {
        if ($this->request->isAJAX()) {
            $id_imunisasi = $this->request->getVar('id_imunisasi');

            $Imunisasi = new ImunisasiModel;

            $Imunisasi->delete($id_imunisasi);

            $msg = [
                'sukses' => "Data Imunisasi berhasil dihapus"
            ];
            echo json_encode($msg);
        }
    }
}

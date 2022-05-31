<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\KegiatanModel;
use App\Models\AnakModel;
use App\Models\UserModel;
use App\Models\ImunisasiModel;

class Kegiatan extends BaseController
{
    protected $KegiatanModel;
    protected $AnakModel;
    protected $UserModel;
    protected $ImunisasiModel;

    public function __construct()
    {
        $this->db      = \Config\Database::connect();
        $this->builder = $this->db->table('kegiatan');
        $this->KegiatanModel = new KegiatanModel();
        $this->UserModel = new UserModel();
        $this->AnakModel = new AnakModel();
        $this->ImunisasiModel = new ImunisasiModel();
    }
    public function index()

    {

        $data = [
            'kegiatan' => $this->KegiatanModel->getKaderNama(),
            'validation' => \Config\Services::validation(),
            'countuser' => $this->UserModel->countUser(),
            'countkader' => $this->UserModel->countKader(),
            'jumlah' => $this->AnakModel->countAnak(),
            'countimunisasi' => $this->ImunisasiModel->countImunisasi(),
            'title'     => 'Daftar Kegiatan',
            'keterangan' => 'Informasi daftar kegiatan pada Posyandu Batu Horpak',

        ];
        return view('kader/kegiatan_v', $data);
    }

    public function save()

    {
        if ($this->request->isAJAX()) {
            $validation = \Config\Services::validation();

            $valid = $this->validate([
                'nama' => [
                    'label' => 'Nama Kegiatan',
                    'rules' => 'required|min_length[3]',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong',
                        'min_length' => '{field} nama terlalu pendek'
                    ]
                ],
                'tanggal' => [
                    'label' => 'Tanggal Kegiatan',
                    'rules' => 'required|kegiatanwaktu|is_unique[kegiatan.tanggal]',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong',
                        'kegiatanwaktu' => '{field} waktu tidak diperbolehkan',
                        'is_unique' => '{field} sudah tersedia',
                    ]
                ],
                'lokasi' => [
                    'label' => 'Lokasi Kegiatan',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong',
                    ]
                ]
            ]);
            if (!$valid) {
                $msg = [
                    'error' => [
                        'nama' => $validation->getError('nama'),
                        'tanggal' => $validation->getError('tanggal'),
                        'lokasi' => $validation->getError('lokasi')
                    ]
                ];
            } else {
                $save = [
                    'id_kader' => user_id(),
                    'nama' => $this->request->getVar('nama'),
                    'tanggal' => $this->request->getVar('tanggal'),
                    'lokasi' => $this->request->getVar('lokasi'),
                ];

                $kegiatan = new KegiatanModel();
                $kegiatan->insert($save);

                $msg = [
                    'sukses' => 'Data Kegiatan Berhasil Ditambahkan'

                ];
            }
            echo json_encode($msg);
        } else {
            exit('maaf tidak dapat diproses');
        }
    }

    public function edit()
    {
        if ($this->request->isAJAX()) {
            $kegid = $this->request->getVar('id');
            $kegiatan = new KegiatanModel;
            $row = $kegiatan->find($kegid);

            $data = [
                'id' => $row['kegid'],

                'nama' => $row['nama'],
                'tanggal' => $row['tanggal'],
                'lokasi' => $row['lokasi'],

            ];
            $msg = [
                'sukses' => view('kader/kegiatan', $data)
            ];
            echo json_encode($msg);
        }
    }
    public function update($id)
    {
        if (!$this->validate([
            'nama' => [
                'label' => 'Nama Kegiatan',
                'rules' => 'required|min_length[3]',
                'errors' => [
                    'required' => '{field} tidak boleh kosong',
                    'min_length' => '{field} nama terlalu pendek'

                ]
            ],
            'tanggal' => [
                'label' => 'Tanggal Kegiatan',
                'rules' => 'required',
                'errors' => [
                    'required' => '{field} tidak boleh kosong',
                    'kegiatanwaktu' => '{field} waktu tidak diperbolehkan',
                ]
            ],
            'lokasi' => [
                'label' => 'Lokasi Kegiatan',
                'rules' => 'required',
                'errors' => [
                    'required' => '{field} tidak boleh kosong',

                ]
            ]
        ])) {

            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $this->KegiatanModel->save([
            'id' => $id,
            'nama' => $this->request->getVar('nama'),
            'tanggal' => $this->request->getVar('tanggal'),
            'lokasi' => $this->request->getVar('lokasi'),
        ]);
        session()->setFlashdata('success', 'data kegiatan berhasil diperbarui.');
        return redirect()->to('/kegiatan');
    }


    public function confirmdelete($id = null)
    {
        $this->KegiatanModel->delete($id);
        $data = [
            'status' => 'berhasil dihapus',
            'status_test' => 'data kegiatan sudah berhasil dihapus',
            'status_icon' => 'success'
        ];
        return $this->response->setJSON($data);
    }



    // public function TampilanKunjungan()
    // {
    //     $data = [
    //         'title' => 'Kunjungan',
    //         'keterangan' => 'Informasi kunjungan pada Posyandu Batu Horpak',
    //         'countkader' => $this->UserModel->countKader(),
    //         'countuser' => $this->UserModel->countUser(),
    //         'jumlah' => $this->AnakModel->countAnak(),
    //         'countimunisasi' => $this->ImunisasiModel->countImunisasi(),
    //         'getKunjunganHariIni' => $this->KegiatanModel->getKunjunganHariIni(),
    //     ];
    //     $this->builder =  $this->db->table('kegiatan');
    //     $current_date = date("Y-m-d");

    //     $this->builder->select('id, nama, lokasi, tanggal');
    //     $this->builder->where('tanggal', $current_date);
    //     $query = $this->builder->get();
    //     $data['kegiatan'] = $query->getRow();


    //     if (empty($data['kegiatan']) || empty($current_date)) {
    //         return redirect()->to('/kegiatan');
    //     }

    //     return view('kader/kunjungan', $data);
    // }
}

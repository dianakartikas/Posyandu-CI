<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\AnakModel;
use App\Models\UserModel;
use App\Models\ImunisasiModel;
use App\Models\KunjunganModel;
use App\Models\CekPertumbuhanModel;
use App\Models\CekImunisasiModel;
use DateTime;

class CekImunisasi extends BaseController
{
    protected $AnakModel;
    protected $UserModel;
    protected $ImunisasiModel;
    protected $CekImunisasiModel;
    public function __construct()
    {
        $this->AnakModel = new AnakModel();
        $this->UserModel = new UserModel();
        $this->ImunisasiModel = new ImunisasiModel();
        $this->KunjunganModel = new KunjunganModel();
        $this->CekImunisasiModel = new CekImunisasiModel();
        $this->CekPertumbuhanModel = new CekPertumbuhanModel();
        $this->db      = \Config\Database::connect();
    }

    public function index()
    {
        $data = [

            'title' => 'Pemeriksaan',
            'validation' => \Config\Services::validation(),
            'anakKMS' => $this->AnakModel->anakKMS(),
            'jumlah' => $this->AnakModel->countAnak(),
            'dataanak' => $this->AnakModel->dataAnak(),
            'countkader' => $this->UserModel->countKader(),
            'countuser' => $this->UserModel->countUser(),
            'jumlah' => $this->AnakModel->countAnak(),
            'countimunisasi' => $this->ImunisasiModel->countImunisasi(),
            'keterangan' => 'Pemeriksaan Imunisasi pada Anak pada Posyandu Batu Horpak',
            'kunjungan' => $this->KunjunganModel->joinKunjunganCekProses2(),
            'terlewat' => $this->KunjunganModel->joinKunjunganCekLewat(),
            'cekimunisasi' => $this->CekImunisasiModel->cekimunisasi(),
            'reset' => $this->KunjunganModel->resetKunjungan()


        ];
        return view('kader/cekImunisasi_v', $data);
    }
    public function simpan($id_kunjungan)
    {
        if (!$this->validate([
            'id_imunisasi' => [
                'label' => 'diberikan Imunisasi',
                'rules' => 'required',
                'errors' => [
                    'required' => 'belum {field}',
                ]
            ]
        ])) {

            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $this->CekImunisasiModel->save([
            'id_kunjungan' => $id_kunjungan,
            'id_imunisasi' => $this->request->getVar('id_imunisasi'),
            'umur' => $this->request->getVar('umur'),
            'id_pengurus' => user_id(),
            'catatan' => $this->request->getVar('catatan'),
        ]);
        $status = 'selesai';
        $this->KunjunganModel->save([
            'id_kunjungan' => $id_kunjungan,
            'status' => $status,
        ]);
        session()->setFlashdata('success', 'pemberian imunisasi berhasil dilakukan.');

        return redirect()->to('/cekimunisasi');
    }
    public function cekPertumbuhan($id_kunjungan)
    {
        if (!$this->validate([
            'id_imunisasi' => [
                'label' => 'diberikan Imunisasi',
                'rules' => 'required',
                'errors' => [
                    'required' => 'belum {field}',
                ]
            ]
        ])) {

            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $this->CekImunisasiModel->save([
            'id_kunjungan' => $id_kunjungan,
            'id_imunisasi' => $this->request->getVar('id_imunisasi'),
            'umur' => $this->request->getVar('umur'),
            'id_pengurus' => user_id(),
            'catatan' => $this->request->getVar('catatan'),
        ]);
        $status = 'cekgizi';
        $this->KunjunganModel->save([
            'id_kunjungan' => $id_kunjungan,
            'status' => $status,
        ]);
        session()->setFlashdata('success', 'pemberian imunisasi telah dilakukan, pemeriksaan pertumbuhan akan dilakukan.');

        return redirect()->to('/cekimunisasi');
    }

    public function cekimunisasi($id_kunjungan = 0)
    {
        $data = [

            'title' => 'Pemberian Imunisasi',
            'validation' => \Config\Services::validation(),
            'anakKMS' => $this->AnakModel->anakKMS(),
            'jumlah' => $this->AnakModel->countAnak(),
            'dataanak' => $this->AnakModel->dataAnak(),
            'countkader' => $this->UserModel->countKader(),
            'countuser' => $this->UserModel->countUser(),
            'jumlah' => $this->AnakModel->countAnak(),
            'countimunisasi' => $this->ImunisasiModel->countImunisasi(),
            'keterangan' => 'Informasi Anak pada Posyandu Batu Horpak',
            'imunisasi' => $this->KunjunganModel->joinKunjunganCheckout($id_kunjungan),
            'terlewat' => $this->KunjunganModel->joinKunjunganCekLewat(),
            'cekimunisasi' => $this->CekImunisasiModel->cekimunisasi(),


        ];
        $umur = (strtotime(date('d-m-Y')) - strtotime($data['imunisasi']->tanggal_lahir)) / (60 * 60 * 24 * 30);
        $umur_bulat = floor($umur);

        $d1 = new DateTime(date('Y-m-d'));
        $d2 = new DateTime(date($data['imunisasi']->tanggal_lahir));
        $interval_kpi = $d1->diff($d2);
        $data['imunisasi']->umur = '';
        if ($interval_kpi->y != 0) {
            $data['imunisasi']->umur .= $interval_kpi->y . ' Tahun ';
        }
        if ($interval_kpi->m != 0) {
            $data['imunisasi']->umur .= $interval_kpi->m . ' Bulan ';
        }
        if ($interval_kpi->d != 0) {
            $data['imunisasi']->umur .= $interval_kpi->d . ' Hari ';
        }
        // $string_val = $data['imunisasi']->umur;

        // $parts = explode(' ', $string_val);
        // if ($parts[1] === "Hari") {
        //     $umur = 1; // range umur dalam hitungan hari 
        // } else if ($parts[1] === "Bulan") {
        //     $umur = $parts[0]; // range umur dalam hitungan bulan
        // } else if ($parts[1] === "Tahun") {
        //     $umur = $parts[0] * 12; //range umur dalam hitungan tahun , convert ke dalam jumlah bulan
        // }
        $this->builder =  $this->db->table('imunisasi');
        $this->builder->select('imunisasi.nama as nama, dari_usia, id_imunisasi, sampai_usia');

        $this->builder->where('dari_usia <=', $umur_bulat);

        $this->builder->where('sampai_usia >=', $umur_bulat);


        $query = $this->builder->get();
        $data['beriimunisasi'] = $query->getResultArray();
        return view('kader/cekImunisasiId_v', $data);
    }

    public function datapemeriksaan()
    {
        $data = [
            'title' => 'Pemeriksaan',
            'validation' => \Config\Services::validation(),
            'anakKMS' => $this->AnakModel->anakKMS(),
            'jumlah' => $this->AnakModel->countAnak(),
            'dataanak' => $this->AnakModel->dataAnak(),
            'countkader' => $this->UserModel->countKader(),
            'countuser' => $this->UserModel->countUser(),
            'jumlah' => $this->AnakModel->countAnak(),
            'countimunisasi' => $this->ImunisasiModel->countImunisasi(),
            'keterangan' => 'Pemeriksaan Imunisasi pada Anak pada Posyandu Batu Horpak',
            'dataImunisasi' => $this->CekImunisasiModel->cekPemeriksaan(),
            'dataPertumbuhan' => $this->CekPertumbuhanModel->cekPemeriksaan(),


        ];
        return view('kader/dataPemeriksaan_v', $data);
    }
}

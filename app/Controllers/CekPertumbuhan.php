<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\AnakModel;
use App\Models\UserModel;
use App\Models\ImunisasiModel;
use App\Models\KunjunganModel;
use App\Models\TinggiBadanUmur;
use App\Models\CekImunisasiModel;
use App\Models\CekPertumbuhanModel;
use App\Models\BeratBadanUmur;
use App\Models\BBperTB1;
use App\Models\BBperTB2;
use DateTime;

class CekPertumbuhan extends BaseController
{
    protected $AnakModel;
    protected $UserModel;
    protected $ImunisasiModel;
    public function __construct()
    {
        $this->AnakModel = new AnakModel();
        $this->UserModel = new UserModel();
        $this->ImunisasiModel = new ImunisasiModel();
        $this->KunjunganModel = new KunjunganModel();
        $this->CekImunisasiModel = new CekImunisasiModel();
        $this->CekPertumbuhanModel = new CekPertumbuhanModel();
        $this->BeratBadanUmur = new BeratBadanUmur();
        $this->TinggiBadanUmur = new TinggiBadanUmur();
        $this->BBperTB1 = new BBperTB1();
        $this->BBperTB2 = new BBperTB2();
        $this->db      = \Config\Database::connect();
    }

    public function index()
    {
        $data = [

            'title' => 'Pemeriksaan Pertumbuhan',
            'validation' => \Config\Services::validation(),
            'anakKMS' => $this->AnakModel->anakKMS(),
            'jumlah' => $this->AnakModel->countAnak(),
            'dataanak' => $this->AnakModel->dataAnak(),
            'countkader' => $this->UserModel->countKader(),
            'countuser' => $this->UserModel->countUser(),
            'jumlah' => $this->AnakModel->countAnak(),
            'countimunisasi' => $this->ImunisasiModel->countImunisasi(),

            'keterangan' => 'Pemeriksaan Pertumbuhan pada Anak pada Posyandu Batu Horpak',
            'kunjungan' => $this->KunjunganModel->joinKunjunganCekProses(),
            'terlewat' => $this->KunjunganModel->joinKunjunganCekLewat(),
            'periksa' => $this->KunjunganModel->joinKunjunganPeriksa(),
            'cekimunisasi' => $this->CekImunisasiModel->cekimunisasi(),
            'hasilcek' => $this->CekPertumbuhanModel->cekHasil(),
            'bbu' => $this->BeratBadanUmur->getAllData(),
            'tbu' => $this->TinggiBadanUmur->getAllData(),
            'bbtb1' => $this->BBperTB1->getAllData(),
            'bbtb2' => $this->BBperTB2->getAllData(),
            'reset' => $this->KunjunganModel->resetKunjungan()


        ];
        return view('kader/cekPertumbuhan_v', $data);
    }
    public function pertumbuhan($id_kunjungan = 0)
    {
        $data = [

            'title' => 'Pemeriksaan Pertumbuhan Anak',
            'validation' => \Config\Services::validation(),
            'anakKMS' => $this->AnakModel->anakKMS(),
            'jumlah' => $this->AnakModel->countAnak(),
            'dataanak' => $this->AnakModel->dataAnak(),
            'countkader' => $this->UserModel->countKader(),
            'countuser' => $this->UserModel->countUser(),
            'jumlah' => $this->AnakModel->countAnak(),
            'countimunisasi' => $this->ImunisasiModel->countImunisasi(),
            'keterangan' => 'Pemeriksaan Pertumbuhan pada Anak pada Posyandu Batu Horpak',
            'pertumbuhan' => $this->KunjunganModel->joinKunjunganCheckout($id_kunjungan),
            'terlewat' => $this->KunjunganModel->joinKunjunganCekLewat(),
            'cekimunisasi' => $this->CekImunisasiModel->cekimunisasi(),



        ];
        $d1 = new DateTime(date('Y-m-d'));
        $d2 = new DateTime(date($data['pertumbuhan']->tanggal_lahir));
        $interval_kpi = $d1->diff($d2);
        $data['pertumbuhan']->umur = '';
        if ($interval_kpi->y != 0) {
            $data['pertumbuhan']->umur .= $interval_kpi->y . ' Tahun ';
        }
        if ($interval_kpi->m != 0) {
            $data['pertumbuhan']->umur .= $interval_kpi->m . ' Bulan ';
        }
        if ($interval_kpi->d != 0) {
            $data['pertumbuhan']->umur .= $interval_kpi->d . ' Hari ';
        }
        return view('kader/cekPertumbuhanId_v', $data);
    }
    public function simpan($id_kunjungan)
    {
        if (!$this->validate([
            'tinggi_badan' => [
                'label' => 'tinggi badan',
                'rules' => 'required',
                'errors' => [
                    'required' => '{field} belum diisi',
                ]
            ],
            'berat_badan' => [
                'label' => 'berat badan badan',
                'rules' => 'required',
                'errors' => [
                    'required' => '{field} belum diisi',
                ]
            ]
        ])) {

            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $this->CekPertumbuhanModel->save([
            'id_kunjungan' => $id_kunjungan,
            'umur' => $this->request->getVar('umur'),
            'berat_badan' => $this->request->getVar('berat_badan'),
            'tinggi_badan' => $this->request->getVar('tinggi_badan'),
            'id_pengurus' => user_id(),

        ]);
        $status = 'periksa';
        $this->KunjunganModel->save([
            'id_kunjungan' => $id_kunjungan,
            'status' => $status,
        ]);
        session()->setFlashdata('success', 'data telah diisi, selanjutnya lakukan pemeriksaan.');

        return redirect()->to('/pertumbuhan');
    }

    // public function periksa($id_cek_pertumbuhan)
    // {

    //     $data = [

    //         'title' => 'Pemeriksaan Pertumbuhan',
    //         'validation' => \Config\Services::validation(),
    //         'anakKMS' => $this->AnakModel->anakKMS(),
    //         'jumlah' => $this->AnakModel->countAnak(),
    //         'dataanak' => $this->AnakModel->dataAnak(),
    //         'countkader' => $this->UserModel->countKader(),
    //         'countuser' => $this->UserModel->countUser(),
    //         'jumlah' => $this->AnakModel->countAnak(),
    //         'countimunisasi' => $this->ImunisasiModel->countImunisasi(),
    //         'keterangan' => 'Pemeriksaan Pertumbuhanp pada Anak Posyandu Batu Horpak',
    //         'pertumbuhan' => $this->KunjunganModel->joinKunjunganPeriksa(),
    //         // 'pertumbuhan' => $this->KunjunganModel->joinKunjunganCheckout($id_kunjungan),
    //         // 'periksagizi' => $this->CekPertumbuhanModel->periksagizi($id_kunjungan),
    //         'hasilcek' => $this->CekPertumbuhanModel->cekHasil(),
    //         'getid' => $this->CekPertumbuhanModel->getID(),
    //         // 'terlewat' => $this->KunjunganModel->joinKunjunganCekLewat(),
    //         // 'cekimunisasi' => $this->CekImunisasiModel->cekimunisasi(),
    //         'bbu' => $this->BeratBadanUmur->getAllData(),
    //         'tbu' => $this->TinggiBadanUmur->getAllData(),
    //         'bbtb1' => $this->BBperTB1->getAllData(),
    //         'bbtb2' => $this->BBperTB2->getAllData(),


    //     ];
    //     $this->builder =  $this->db->table('kegiatan');
    //     $current_date = date("Y-m-d");
    //     // $this->builder->select('id, nama, lokasi, tanggal');
    //     // $this->builder->where('tanggal', $current_date);
    //     // $query = $this->builder->get();
    //     // $data['kegiatan'] = $query->getRow();
    //     $this->builder->select('id, nama, lokasi, tanggal');
    //     $this->builder->where('tanggal', $current_date);
    //     $query = $this->builder->get();
    //     $data['kegiatan'] = $query->getRow();
    //     if (empty($data['kegiatan']) || empty($current_date)) {
    //         return redirect()->to('/kegiatan');
    //     }

    //     $id =  $data['kegiatan']->id;

    //     $this->builder =  $this->db->table('cek_pertumbuhan');
    //     $status1 = 'periksa';
    //     $this->builder->select('umur, berat_badan, tinggi_badan, hasil_bbu, hasil_tbu, hasil_bbtb, id_cek_pertumbuhan, catatan, id_cek_pertumbuhan');
    //     $this->builder->join('kunjungan', 'cek_pertumbuhan.id_kunjungan=kunjungan.id_kunjungan');
    //     $this->builder->join('kegiatan', 'kunjungan.id_kegiatan=kegiatan.id');
    //     $this->builder->join('kms', 'kunjungan.id_kms=kunjungan.id_kms');
    //     $this->builder->join('anak', 'kms.id_anak=kms.id_anak');
    //     $this->builder->where('kunjungan.status', $status1);
    //     $this->builder->where('id_kegiatan', $id);
    //     $this->builder->where('id_cek_pertumbuhan', $id_cek_pertumbuhan);
    //     // return  $data['periksagizi'];
    //     return view('kader/periksagizi', $data);
    // }

    public function hasil($id_cek_pertumbuhan, $id_kunjungan)
    {

        if (!$this->validate([
            'hasil_bbu' => [
                'label' => 'Hasil gizi BB/U',
                'rules' => 'required',
                'errors' => [
                    'required' => '{field} belum diisi',
                ]
            ],
            'hasil_tbu' => [
                'label' => 'Hasil gizi TB/U',
                'rules' => 'required',
                'errors' => [
                    'required' => '{field} belum diisi',
                ]
            ],
            'hasil_bbtb' => [
                'label' => 'Hasil gizi BB/TB',
                'rules' => 'required',
                'errors' => [
                    'required' => '{field} belum diisi',
                ]
            ],
        ])) {

            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $this->CekPertumbuhanModel->save([
            'id_cek_pertumbuhan' => $id_cek_pertumbuhan,
            'hasil_bbu' => $this->request->getVar('hasil_bbu'),
            'hasil_tbu' => $this->request->getVar('hasil_tbu'),
            'hasil_bbtb' => $this->request->getVar('hasil_bbtb'),
            'catatan' => $this->request->getVar('catatan'),
            'id_pengurus' => user_id(),

        ]);

        $status = 'selesai';
        $this->KunjunganModel->save([
            'id_kunjungan' => $id_kunjungan,
            'status' => $status,
        ]);

        session()->setFlashdata('success', 'pemeriksaan pertumbuhan selesai.');

        return redirect()->to('/pertumbuhan');
    }
}

<?php

namespace App\Controllers;

use App\Models\AnakModel;
use App\Entities\User;
use App\Models\ImunisasiModel;
use App\Models\UserModel;
use App\Models\CekImunisasiModel;
use App\Models\CekPertumbuhanModel;

class Warga extends BaseController
{
    protected $db, $builder;
    protected $UserModel;
    protected $AnakModel;
    protected $ImunisasiModel;
    protected $User;
    protected $CekImunisasiModel;
    protected $CekPertumbuhanModel;
    public function __construct()
    {
        $this->db      = \Config\Database::connect();
        $this->builder = $this->db->table('users');
        $this->UserModel = new UserModel();
        $this->AnakModel = new AnakModel();
        $this->ImunisasiModel = new ImunisasiModel();
        $this->CekImunisasiModel = new CekImunisasiModel();
        $this->CekPertumbuhanModel = new CekPertumbuhanModel();
        $this->User = new User();
    }


    public function index()
    {
        $data = [
            'title' => 'Daftar Pengguna',
            'validation' => \Config\Services::validation(),
            'countkader' => $this->UserModel->countKader(),
            'countuser' => $this->UserModel->countUser(),
            'jumlah' => $this->AnakModel->countAnak(),
            'countimunisasi' => $this->ImunisasiModel->countImunisasi(),
            'keterangan' => 'Informasi daftar pengguna pada Posyandu Batu Horpak',
            'users' => $this->UserModel->RoleUser(),
        ];
        // $users = new \Myth\Auth\Models\UserModel();
        // $data['users'] = $users->findAll();

        return view('kader/warga_v', $data);
    }
    public function detail($id = 0)
    {
        $data = [
            'title' => 'Detail User',
            'validation' => \Config\Services::validation(),
            'countuser' => $this->UserModel->countUser(),
            'countkader' => $this->UserModel->countKader(),
            'jumlah' => $this->AnakModel->countAnak(),
            'countimunisasi' => $this->ImunisasiModel->countImunisasi(),
            'keterangan' => 'Informasi detail user pada Posyandu Batu Horpak',
            'user' => $this->UserModel->RoleAllUserID($id),
            'anak' => $this->UserModel->RoleUserIDAnak($id),

        ];
        // $this->builder->select('users.id as userid, username, email, user_image, fullname, name');
        // $this->builder->join('auth_groups_users', 'auth_groups_users.user_id = users.id');
        // $this->builder->join('auth_groups', 'auth_groups.id= auth_groups_users.group_id');

        // $this->builder->where('users.id', $id);
        // $query = $this->builder->get();
        // $data['user'] = $query->getRow();

        if (empty($data['user']) || empty($id)) {
            return redirect()->to('/warga');
        }

        // $this->builder->select('users.id as userid, username, email, user_image, fullname, name, id_user, nama, jenis_kelamin, tanggal_lahir, gambar_anak,id_anak');
        // $this->builder->join('auth_groups_users', 'auth_groups_users.user_id = users.id');
        // $this->builder->join('auth_groups', 'auth_groups.id= auth_groups_users.group_id');
        // $this->builder->join('anak', 'anak.id_user= users.id');
        // $role = 'user';
        // $this->builder->where('name', $role);
        // $this->builder->where('users.id', $id);

        // $query = $this->builder->get();
        // $data['anak'] = $query->getResultArray();
        return view('kader/detailWarga_v', $data);
    }

    public function save()
    {
        if (!$this->validate([
            'username' => [
                'rules' => 'required|is_unique[users.username]',
                'errors' => [
                    'required' => '{field} wajib di isi.',
                    'is_unique' => '{field} sudah terdaftar.'
                ]
            ],
            'email' => [
                'rules' => 'required|is_unique[users.email]',
                'errors' => [
                    'required' => '{field} wajib di isi.',
                    'is_unique' => '{field} sudah terdaftar.'
                ]
            ],
            'fullname' => [
                'rules' => 'required',
                'errors' => [
                    'required' => '{field} wajib di isi.'
                ]
            ],
            'password' => [
                'rules' => 'required',
                'errors' => [
                    'required' => '{field} wajib di isi.'
                ]
            ],
            'confirm_password' => [
                'label' => 'Konfirmasi password',
                'rules' => 'required|matches[password]',
                'errors' => [
                    'required' => '{field} wajib di isi.',
                    'matches' => '{field} tidak sama.',
                ]
            ],
            'user_image' => [
                // jangan pake spasi 
                'rules' => 'max_size[user_image,1024]|is_image[user_image]|mime_in[user_image,image/jpg,image/jpeg,image/png,image/svg]',
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
        $fileGambar = $this->request->getFile('user_image');
        if ($fileGambar->getError() == 4) {
            $namaGambar = 'default.svg';
        } else {
            $namaGambar = $fileGambar->getRandomName();
            // pindahkan file ke folder img fungsi move untuk langsung ke folder publik
            $fileGambar->move('img', $namaGambar);
        }
        $password   = $this->request->getPost('password');
        $save = [
            'username' => $this->request->getVar('username'),
            'email' => $this->request->getVar('email'),
            'fullname' => $this->request->getVar('fullname'),
            'password_hash' => password_hash(
                base64_encode(
                    hash('sha384', $password, true)
                ),
                PASSWORD_DEFAULT,
                ['cost' => 10]
            ),
            'group_id' => $this->request->getVar('group_id'),
            'user_image' => $namaGambar,
            'active' => '1',
        ];
        $user = new UserModel;
        $user->withGroup('user')->insert($save);
        session()->setFlashdata('success', 'Data Warga Berhasil Ditambahkan.');
        return redirect()->back();
    }
    public function update($id)
    {
        if (!$this->validate([
            'username' => [
                'rules' => 'required|is_unique[users.id!=' . $id . ' AND ' . 'username=]',
                'errors' => [
                    'required' => '{field} wajib di isi.',
                    'is_unique' => '{field} sudah terdaftar.'
                ]
            ],
            'email' => [
                'rules' => 'required|is_unique[users.id!=' . $id . ' AND ' . 'email=]',
                'errors' => [
                    'required' => '{field} wajib di isi.',
                    'is_unique' => '{field} sudah terdaftar.'
                ]
            ],
            'fullname' => [
                'rules' => 'required',
                'errors' => [
                    'required' => '{field} wajib di isi.'
                ]
            ],
            'user_image' => [
                // jangan pake spasi 
                'rules' => 'max_size[user_image,1024]|is_image[user_image]|mime_in[user_image,image/jpg,image/jpeg,image/png,image/svg]',
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
        $fileGambar = $this->request->getFile('user_image');
        if ($fileGambar->getError() == 4) {
            $namaGambar = $this->request->getVar('gambarLama');
        } else {
            // generate nama foto
            $namaGambar = $fileGambar->getRandomName();
            // pindahkan ke folder
            $fileGambar->move('img', $namaGambar);
            // hapus foto
            if ($fileGambar != "") {
                if (file_exists('img/' .  $this->request->getVar('gambarLama') != 'default.svg')) {
                    unlink('img/' . $this->request->getVar('gambarLama'));
                }
            }
        }
        $this->UserModel->save([
            'id' => $id,
            'username' => $this->request->getVar('username'),
            'email' => $this->request->getVar('email'),
            'fullname' => $this->request->getVar('fullname'),
            'user_image' => $namaGambar

        ]);
        session()->setFlashdata('success', 'data pengguna berhasil diubah.');
        return redirect()->back();
    }
    public function confirmdelete($id = null)
    {
        $this->UserModel->delete($id);
        $user = new UserModel();
        $user->purgeDeleted();
        $data = [
            'status' => 'berhasil dihapus',
            'status_test' => 'data user sudah berhasil dihapus',
            'status_icon' => 'success'
        ];
        return $this->response->setJSON($data);
    }

    public function saveanak($id)
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
            'id_user' => $id,
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
    public function updateanak($id)
    {
        if (!$this->validate([
            'nama' => [
                'label' => 'Nama Anak',
                'rules' => 'required',
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
            'nama' => $this->request->getVar('nama'),
            'jenis_kelamin' => $this->request->getVar('jenis_kelamin'),
            'tanggal_lahir' => $this->request->getVar('tanggal_lahir'),
            'gambar_anak' => $namaGambar,
        ]);
        session()->setFlashdata('success', 'data anak telah diubah.');
        return redirect()->back();
    }
    //--------------------------------------------------------------------
    public function hapus()
    {
        if ($this->request->isAJAX()) {
            $id_anak = $this->request->getVar('id_anak');

            $Imunisasi = new AnakModel();

            $Imunisasi->delete($id_anak);

            $msg = [
                'sukses' => "Data Anak berhasil dihapus"
            ];
            echo json_encode($msg);
        }
    }

    public function datapemeriksaan()
    {
        $data = [
            'title' => 'Data Pemeriksaan Anak',
            'validation' => \Config\Services::validation(),
            'anakKMS' => $this->AnakModel->anakKMS(),
            'jumlah' => $this->AnakModel->countAnak(),
            'dataanak' => $this->AnakModel->dataAnak(),
            'countkader' => $this->UserModel->countKader(),
            'countuser' => $this->UserModel->countUser(),
            'jumlah' => $this->AnakModel->countAnak(),
            'countimunisasi' => $this->ImunisasiModel->countImunisasi(),
            'keterangan' => 'Pemeriksaan Imunisasi pada Anak pada Posyandu Batu Horpak',
            'dataImunisasi' => $this->CekImunisasiModel->cekPemeriksaanUser(),
            'dataPertumbuhan' => $this->CekPertumbuhanModel->CekPemeriksaanUser(),


        ];
        return view('user/dataPemeriksaanAnak_v', $data);
    }
}

<?php

namespace App\Controllers;

use App\Models\FakultasModel;
use App\Models\UserModel;
use App\Models\PenjualModel;
use App\Models\AdminModel;
use CodeIgniter\Controller;

class AdminController extends BaseController
{
    public function dashboard()
    {
        $session = session();
        $id_admin = $session->get('id_admin');

        if (!$id_admin) {
            return redirect()->to('/auth/logout');
        }

        $adminModel = new \App\Models\AdminModel();
        $db = \Config\Database::connect();

        // Data admin
        $admin = $adminModel->find($id_admin);

        // Query role count
        $builder = $db->table('user');
        $builder->select('Role, COUNT(*) as jumlah');
        $builder->groupBy('Role');
        $query = $builder->get();

        $roleCounts = [
            'admin' => 0,
            'penjual' => 0,
            'pembeli' => 0
        ];

        foreach ($query->getResultArray() as $row) {
            $role = strtolower($row['Role']);
            $roleCounts[$role] = $row['jumlah'];
        }

        return view('admin/dashboard', [
            'admin' => $admin,
            'roleCounts' => $roleCounts,
        ]);
    }
    public function hapusPembeli($id_user, $id_admin)
    {
        $session = session();

        // Validasi login dan peran admin
        if (!$session->get('id_admin') || $session->get('id_admin') != $id_admin) {
            return redirect()->to('/auth/login');
        }

        $userModel = new \App\Models\UserModel();
        $pembeliModel = new \App\Models\PembeliModel();

        // Hapus dari tabel pembeli berdasarkan id_user
        $pembeliModel->where('id_user', $id_user)->delete();

        // Hapus dari tabel user
        $userModel->delete($id_user);

        return redirect()->to("/admin/kelola-pengguna?id_admin=$id_admin")->with('success', 'hapus');
    }



    public function hapusKantin($id_user, $id_admin)
    {
        $userModel = new \App\Models\UserModel();
        $penjualModel = new \App\Models\PenjualModel();

        $penjualModel->where('id_user', $id_user)->delete();
        $userModel->delete($id_user); // 

        return redirect()->to('/admin/kelola-kantin?success=hapus');
    }

    public function kelolaPengguna()
    {
        $session = session();
        $id_admin = $session->get('id_admin');

        if (!$id_admin) {
            return redirect()->to('/auth/logout');
        }

        $userModel = new \App\Models\UserModel();

        $pembeliList = $userModel->where('Role', 'pembeli')->findAll();

        return view('admin/kelola_pengguna', [
            'pembeliList' => $pembeliList,
            'id_admin' => $id_admin,
        ]);
    }

    public function kelolaKantin()
    {
        $id_admin = session()->get('id_admin');
        if (!$id_admin) {
            return redirect()->to('/auth/login');
        }

        $db = \Config\Database::connect();

        $query = $db->query("SELECT u.*, p.nama_kantin, f.nama_fakultas 
                            FROM user u 
                            JOIN penjual p ON u.id_user = p.id_user 
                            JOIN fakultas f ON p.id_fakultas = f.id_fakultas 
                            WHERE u.role = 'penjual'");
                            
        $penjualList = $query->getResultArray();

        return view('admin/kelola_kantin', [
            'penjualList' => $penjualList,
            'id_admin' => $id_admin
        ]);
    }

    public function editProfile()
    {
        $id_admin = session()->get('id_admin');

        if (!$id_admin) {
            return redirect()->to(base_url('admin/dashboard'));
        }

        $adminModel = new \App\Models\AdminModel();
        $admin = $adminModel->find($id_admin);

        if (!$admin) {
            return redirect()->to(base_url('admin/dashboard'))->with('error', 'Admin not found');
        }

        return view('admin/profile_admin', ['admin' => $admin]);
    }


    public function updateProfile()
    {
        $id_admin = session()->get('id_admin');
        $nama = trim($this->request->getPost('nama'));
        $jabatan = trim($this->request->getPost('jabatan'));

        if ($nama !== '' && $jabatan !== '') {
            $adminModel = new \App\Models\AdminModel();
            $adminModel->updateInfo($id_admin, [
                'nama' => $nama,
                'jabatan' => $jabatan
            ]);

            return redirect()->to(base_url("admin/profile"))->with('success', 'true');
        } else {
            return redirect()->to(base_url("admin/profile"))->with('error', 'error');
        }
    }


    public function registerPenjual()
    {
        return view('admin/register_penjual');
    }

    public function editDataPembeli($id_pembeli)
    {
        $id_admin = session('id_admin');
        if (!$id_admin) return redirect()->to('/auth/login');

        $userModel = new \App\Models\UserModel();
        $pembeli = $userModel->find($id_pembeli);

        if (!$pembeli) {
            return redirect()->to('/admin/kelola_pengguna')->with('error', 'Pembeli tidak ditemukan');
        }

        // Tambahkan ini
        $adminModel = new \App\Models\AdminModel();
        $admin = $adminModel->find($id_admin);

        return view('admin/edit-data-pembeli', [
            'pembeli' => $pembeli,
            'id_admin' => $id_admin,
            'admin' => $admin,
        ]);
    }


    public function updateDataPembeli($id_pembeli)
    {
        $id_admin = session('id_admin');
        $nama_admin = $this->request->getPost('nama');
        $password_admin = $this->request->getPost('password');

        $username_user = $this->request->getPost('username');
        $new_password = $this->request->getPost('new_password');

        $adminModel = new \App\Models\AdminModel();
        $admin = $adminModel->find($id_admin);

        if (!$admin) {
            return redirect()->back()->with('error', 'Data admin tidak ditemukan');
        }

        $userModel = new \App\Models\UserModel();
        $admin_user = $userModel->find($admin['id_user']);

        if (!password_verify($password_admin, $admin_user['password'])) {
            return redirect()->back()->with('error', 'Password admin salah');
        }

        $data_update = [
            'username' => $username_user,
            'password' => password_hash($new_password, PASSWORD_DEFAULT)
        ];

        $userModel->update($id_pembeli, $data_update);

        return redirect()->to('/admin/kelola_pengguna')->with('success', 'Password berhasil diubah');
    }


    public function editDataPenjual($id_penjual, $id_admin)
    {
        helper(['form', 'url']);

        $adminModel = new AdminModel();
        $userModel = new UserModel();
        $session = session();

        // Cek admin login
        if (!$session->get('id_admin') || $session->get('id_admin') != $id_admin) {
            return redirect()->to('/auth/login');
        }

        // Ambil data admin
        $admin = $adminModel
            ->select('admin.*, user.username AS admin_username')
            ->join('user', 'user.id_user = admin.id_user')
            ->where('id_admin', $id_admin)
            ->first();

        if (!$admin) {
            return redirect()->to('/admin/dashboard')->with('error', 'Admin not found.');
        }

        // Jika ada form POST
        if ($this->request->getMethod() === 'post') {
            $password_admin = $this->request->getPost('password');
            $username_user = $this->request->getPost('username');
            $new_password = $this->request->getPost('new_password');

            // Verifikasi password admin
            $adminUser = $userModel->find($admin['id_user']);
            if ($adminUser && password_verify($password_admin, $adminUser['password'])) {
                // Update password user penjual
                $userToUpdate = $userModel->find($id_penjual);
                if ($userToUpdate) {
                    $userModel->update($id_penjual, [
                        'username' => $username_user,
                        'password' => password_hash($new_password, PASSWORD_DEFAULT),
                    ]);
                    return redirect()->to(base_url("admin/kelola-kantin"))->with('success', 'Password pengguna berhasil diperbarui.');
                } else {
                    return redirect()->back()->with('error', 'User tidak ditemukan.');
                }
            } else {
                return redirect()->back()->with('error', 'Autentikasi admin gagal. Password salah.');
            }
        }

        // GET: tampilkan form
        return view('admin/edit-data-penjual', [
            'id_admin' => $id_admin,
            'id_user' => $id_penjual,
            'admin' => $admin,
            'error_message' => session()->getFlashdata('error'),
        ]);
    }


    public function tambahKantin($id_admin)
    {
        $fakultasModel = new FakultasModel();
        $fakultasList = $fakultasModel->findAll();

        return view('admin/tambah_kantin', [
            'id_admin' => $id_admin,
            'fakultasList' => $fakultasList,
        ]);
    }

    public function simpanKantin()
    {
        $id_admin = $this->request->getPost('id_admin');
        $username = $this->request->getPost('username');
        $nama_penjual = $this->request->getPost('nama_penjual');
        $nama_kantin = $this->request->getPost('nama_kantin');
        $id_fakultas = $this->request->getPost('id_fakultas');
        $link = $this->request->getPost('link');
        $password = $this->request->getPost('password');
        $konfirmasi = $this->request->getPost('konfirmasi_password');

        // Validasi password
        if ($password !== $konfirmasi) {
            return redirect()->back()->withInput()->with('error', 'Konfirmasi password tidak cocok.');
        }

        if (!$this->validatePassword($password)) {
            return redirect()->back()->withInput()->with('error', 'Password harus minimal 8 karakter dan mengandung huruf besar, kecil, angka, dan simbol.');
        }

        // Simpan user baru
        $userModel = new UserModel();
        $penjualModel = new PenjualModel();

        $id_user = $userModel->insert([
            'nama' => $nama_penjual,
            'username' => $username,
            'password' => password_hash($password, PASSWORD_DEFAULT),
            'role'     => 'penjual',
            'is_verified' => 1
        ]);

        $penjualModel->insert([
            'id_user' => $id_user,
            'nama' => $nama_penjual,
            'nama_kantin' => $nama_kantin,
            'id_fakultas' => $id_fakultas,
            'link' => $link
        ]);

        return redirect()->to("/admin/kelola-kantin")->with('success', 'Kantin berhasil ditambahkan!');
    }

    private function validatePassword($password)
    {
        return strlen($password) >= 8 &&
               preg_match('/[A-Z]/', $password) &&
               preg_match('/[a-z]/', $password) &&
               preg_match('/[0-9]/', $password) &&
               preg_match('/[\W_]/', $password);
    }
}

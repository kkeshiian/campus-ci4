<?php

namespace App\Models;

use CodeIgniter\Model;

class PembeliModel extends Model
{
    protected $table            = 'pembeli';
    protected $primaryKey       = 'id_pembeli';
    protected $allowedFields    = ['id_user', 'nama', 'gambar'];

    // ✅ Tambah pembeli saat register berhasil
    public function tambahPembeli($id_user, $nama = null, $gambar = null)
    {
        return $this->insert([
            'id_user' => $id_user,
            'nama'    => $nama ?? 'Pembeli',
            'gambar'  => $gambar
        ]);
    }

    // 🔄 Update profil pembeli
    public function updateProfile($id_pembeli, $data)
    {
        return $this->update($id_pembeli, $data); // data bisa: nama, gambar
    }

    // 🧹 Hapus pembeli
    public function hapusPembeli($id_pembeli)
    {
        return $this->delete($id_pembeli);
    }

    // 📥 Get data pembeli berdasarkan id_user
    public function getByUserId($id_user)
    {
        return $this->where('id_user', $id_user)->first();
    }
}

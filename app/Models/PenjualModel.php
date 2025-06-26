<?php

namespace App\Models;

use CodeIgniter\Model;

class PenjualModel extends Model
{
    protected $table            = 'penjual';
    protected $primaryKey       = 'id_penjual';
    protected $allowedFields    = [
        'id_user', 'id_fakultas', 'nama', 'nama_kantin', 'gambar', 'link'
    ];

    // ✅ Tambah penjual (setelah register dan verifikasi)
    public function tambahPenjual($id_user, $data)
    {
        $data['id_user'] = $id_user;
        return $this->insert($data);
    }

    // 🔄 Update profil penjual
    public function updateProfile($id_penjual, $data)
    {
        return $this->update($id_penjual, $data); // nama, gambar, nama_kantin, dsb
    }

    // 🧹 Hapus penjual
    public function hapusPenjual($id_penjual)
    {
        return $this->delete($id_penjual);
    }

    // 🔍 Ambil penjual berdasarkan id_user
    public function getByUserId($id_user)
    {
        return $this->where('id_user', $id_user)->first();
    }

    // 🔍 Ambil penjual berdasarkan nama_kantin (opsional)
    public function getByNamaKantin($nama_kantin)
    {
        return $this->where('nama_kantin', $nama_kantin)->first();
    }
}

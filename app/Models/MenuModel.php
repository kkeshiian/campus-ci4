<?php

namespace App\Models;

use CodeIgniter\Model;

class MenuModel extends Model
{
    protected $table            = 'menu';
    protected $primaryKey       = 'id_menu';
    protected $allowedFields    = ['id_penjual', 'nama_menu', 'harga', 'gambar'];

    // ✅ Tambah menu
    public function tambahMenu($data)
    {
        return $this->insert($data);
    }

    // 🔄 Update menu
    public function updateMenu($id_menu, $data)
    {
        return $this->update($id_menu, $data);
    }

    // 🧹 Hapus menu
    public function hapusMenu($id_menu)
    {
        return $this->delete($id_menu);
    }

    // 🔍 Ambil semua menu milik penjual
    public function getByPenjual($id_penjual)
    {
        return $this->where('id_penjual', $id_penjual)->findAll();
    }

    // 🔍 Ambil satu menu
    public function getMenu($id_menu)
    {
        return $this->find($id_menu);
    }
}

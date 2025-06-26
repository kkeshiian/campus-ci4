<?php

namespace App\Models;

use CodeIgniter\Model;

class FakultasModel extends Model
{
    protected $table            = 'fakultas';
    protected $primaryKey       = 'id_fakultas';
    protected $allowedFields    = ['nama_fakultas'];

    // 🔍 Ambil semua fakultas untuk dropdown, dsb
    public function getAll()
    {
        return $this->findAll();
    }

    // 🔍 Ambil satu fakultas
    public function getById($id_fakultas)
    {
        return $this->find($id_fakultas);
    }

    // ✅ Tambah fakultas (kalau admin bisa input)
    public function tambahFakultas($nama_fakultas)
    {
        return $this->insert(['nama_fakultas' => $nama_fakultas]);
    }

    // 🔄 Update fakultas
    public function updateFakultas($id_fakultas, $nama_fakultas)
    {
        return $this->update($id_fakultas, ['nama_fakultas' => $nama_fakultas]);
    }

    // 🧹 Hapus fakultas
    public function hapusFakultas($id_fakultas)
    {
        return $this->delete($id_fakultas);
    }
}

<?php

namespace App\Models;

use CodeIgniter\Model;

class RiwayatPembelianModel extends Model
{
    protected $table            = 'riwayat_pembelian';
    protected $primaryKey       = 'order_id';
    protected $allowedFields = [
        'id_user', 'id_kantin', 'order_id', 'status',
        'status_pembayaran', 'total', 'tanggal','nama_kantin', 'tipe', 'menu',
    ];


    // ✅ Simpan pesanan awal (digunakan sebelum midtrans token)
    public function buatPesanan($data)
    {
        return $this->insert($data);
    }

    // 🔍 Ambil semua pesanan milik pembeli
    public function getByPembeli($id_pembeli)
    {
        return $this->where('id_pembeli', $id_pembeli)->orderBy('tanggal', 'DESC')->findAll();
    }

    // 🔍 Ambil pesanan by order_id
    public function getByOrderId($order_id)
    {
        return $this->find($order_id);
    }

    // 🔄 Update status pembayaran (dipakai midtrans callback)
    public function updateStatus($order_id, $status)
    {
        return $this->update($order_id, ['status' => $status]);
    }

    // 🔄 Tambah bukti pembayaran manual (jika pakai sistem upload bukti)
    public function uploadBuktiPembayaran($order_id, $fileName)
    {
        return $this->update($order_id, ['bukti_pembayaran' => $fileName]);
    }
}

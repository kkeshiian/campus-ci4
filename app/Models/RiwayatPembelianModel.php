<?php

namespace App\Models;

use CodeIgniter\Model;

class RiwayatPembelianModel extends Model
{
    protected $table            = 'riwayat_pembelian';
    protected $primaryKey       = 'id_rp';
    protected $allowedFields    = [
        'order_id', 'id_pembeli', 'nama_kantin', 'menu',
        'quantity', 'harga', 'total', 'status', 'tanggal',
        'notes', 'tipe', 'status_pembayaran', 'bukti_pembayaran'
    ];

    // ✅ Simpan pesanan awal (digunakan sebelum midtrans token)
    public function buatPesanan($data)
    {
        return $this->insert($data);
    }

    // 🔍 Ambil semua pesanan milik pembeli
    public function getByPembeli($id_pembeli)
    {
        return $this->where('id_pembeli', $id_pembeli)
                    ->orderBy('tanggal', 'DESC')
                    ->findAll();
    }

    // 🔍 Ambil pesanan berdasarkan order_id (BUKAN primary key)
    public function getByOrderId($order_id)
    {
        return $this->where('order_id', $order_id)->first();
    }

    // 🔄 Update status pembayaran berdasarkan order_id (dipakai midtrans callback)
    public function updateStatus($order_id, $status)
    {
        return $this->where('order_id', $order_id)->set(['status' => $status])->update();
    }

    // 🔄 Tambah bukti pembayaran manual (jika pakai sistem upload bukti)
    public function uploadBuktiPembayaran($order_id, $fileName)
    {
        return $this->where('order_id', $order_id)->set(['bukti_pembayaran' => $fileName])->update();
    }
}

<?php

namespace App\Models;

use CodeIgniter\Model;

class IsDoneModel extends Model
{
    protected $table            = 'is_done';
    protected $primaryKey       = 'id_done';
    protected $allowedFields    = ['order_id', 'id_penjual', 'status', 'tanggal'];

    // ✅ Tambah status done baru
    public function tambahStatus($order_id, $id_penjual)
    {
        return $this->insert([
            'order_id'    => $order_id,
            'id_penjual'  => $id_penjual,
            'status'      => 'pending',
            'tanggal'     => date('Y-m-d H:i:s')
        ]);
    }

    // 🔄 Ubah status jadi 'done'
    public function tandaiSelesai($order_id, $id_penjual)
    {
        return $this->where('order_id', $order_id)
                    ->where('id_penjual', $id_penjual)
                    ->set(['status' => 'done', 'tanggal' => date('Y-m-d H:i:s')])
                    ->update();
    }

    // 🔍 Ambil status berdasarkan order_id dan id_penjual
    public function getStatus($order_id, $id_penjual)
    {
        return $this->where('order_id', $order_id)
                    ->where('id_penjual', $id_penjual)
                    ->first();
    }

    // 📩 (Opsional) Get semua yang done hari ini (bisa dikaitkan dengan notifikasi WA)
    public function getSelesaiHariIni()
    {
        return $this->where('status', 'done')
                    ->like('tanggal', date('Y-m-d'), 'after')
                    ->findAll();
    }
}

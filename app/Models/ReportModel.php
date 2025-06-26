<?php

namespace App\Models;

use CodeIgniter\Model;

class ReportModel extends Model
{
    protected $table            = 'report';
    protected $primaryKey       = 'id_report';
    protected $allowedFields    = [
        'id_penjual', 'id_pembeli', 'order_id', 'nama_kantin',
        'tanggal', 'kategori', 'deskripsi', 'bukti'
    ];

    // ✅ Tambahkan laporan
    public function submitReport($data)
    {
        return $this->insert($data);
    }

    // 🔍 Ambil laporan berdasarkan penjual
    public function getByPenjual($id_penjual)
    {
        return $this->where('id_penjual', $id_penjual)->findAll();
    }

    // 🔍 Ambil laporan berdasarkan pembeli
    public function getByPembeli($id_pembeli)
    {
        return $this->where('id_pembeli', $id_pembeli)->findAll();
    }

    // 🧹 Hapus laporan (oleh admin atau user sendiri)
    public function hapusReport($id_report)
    {
        return $this->delete($id_report);
    }

    // 🔍 Ambil semua laporan + join penjual dan pembeli (opsional untuk admin)
    public function getLaporanLengkap()
    {
        return $this->select('report.*, pembeli.nama AS nama_pembeli, penjual.nama AS nama_penjual')
                    ->join('pembeli', 'pembeli.id_pembeli = report.id_pembeli')
                    ->join('penjual', 'penjual.id_penjual = report.id_penjual')
                    ->findAll();
    }
}

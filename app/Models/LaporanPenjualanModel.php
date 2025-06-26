<?php

namespace App\Models;

use CodeIgniter\Model;

class RiwayatPembelianModel extends Model
{
    protected $table = 'riwayat_pembelian';
    protected $primaryKey = 'id';
    protected $allowedFields = ['nama_kantin', 'tanggal', 'quantity', 'total', 'status'];
}

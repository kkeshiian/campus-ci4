<?php

namespace App\Models;

use CodeIgniter\Model;

class AdminModel extends Model
{
    protected $table            = 'admin';
    protected $primaryKey       = 'id_admin';
    protected $allowedFields    = ['id_user', 'nama', 'jabatan'];

    public function updateInfo($id_admin, $data)
    {
        return $this->update($id_admin, $data);
    }

    public function hapusPembeli($id_pembeli)
    {
        $pembeliModel = new \App\Models\PembeliModel();
        return $pembeliModel->delete($id_pembeli);
    }

    public function hapusPenjual($id_penjual)
    {
        $penjualModel = new \App\Models\PenjualModel();
        return $penjualModel->delete($id_penjual);
    }

    public function hapusReport($id_report)
    {
        $reportModel = new \App\Models\ReportModel();
        return $reportModel->delete($id_report);
    }
}

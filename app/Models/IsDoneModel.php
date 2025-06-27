<?php namespace App\Models;

use CodeIgniter\Model;

class IsDoneModel extends Model
{
    protected $table = 'is_done';
    protected $primaryKey = 'id_done';
    protected $allowedFields = [
        'id_user', 'id_penjual', 'nomor_wa', 'menu',
        'order_id', 'tanggal', 'is_sent'
    ];
    public $useTimestamps = false;
}

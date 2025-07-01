<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class FakultasSeeder extends Seeder
{
    public function run()
    {
        $data = [
            ['nama_fakultas' => 'Teknik Banjarmasin'],
            ['nama_fakultas' => 'Teknik Banjarbaru'],
            ['nama_fakultas' => 'Matematika dan Ilmu Pengetahuan Alam'],
            ['nama_fakultas' => 'Keguruan dan Ilmu Pendidikan'],
            ['nama_fakultas' => 'Ekonomi dan Bisnis'],
            ['nama_fakultas' => 'Kedokteran Gigi'],
            ['nama_fakultas' => 'Perikanan dan Ilmu Kelautan'],
            ['nama_fakultas' => 'Ilmu Sosial dan Politik'],
            ['nama_fakultas' => 'Kedokteran dan Ilmu Kesehatan'],
            ['nama_fakultas' => 'Kehutanan'],
            ['nama_fakultas' => 'Pertanian'],
        ];

        $this->db->table('fakultas')->insertBatch($data);
    }
}

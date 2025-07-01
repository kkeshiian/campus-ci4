<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class AdminSeeder extends Seeder
{
    public function run()
    {
        $adminUsernames = [
            'ghanimudzakir' => 'Backend Developer',
            'muhammadrizky' => 'Frontend Developer',
            'randyfebrian'  => 'UI/UX Developer'
        ];

        $data = [];

        foreach ($adminUsernames as $username => $jabatan) {
            $user = $this->db->table('user')->where('username', $username)->get()->getRow();

            if ($user) {
                $data[] = [
                    'id_user' => $user->id_user,
                    'jabatan' => $jabatan
                ];
            }
        }

        if (!empty($data)) {
            $this->db->table('admin')->insertBatch($data);
            echo count($data) . " admin berhasil ditambahkan.\n";
        } else {
            echo "Seeder gagal: tidak ditemukan user yang sesuai.\n";
        }
    }
}

<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class PembeliSeeder extends Seeder
{
    public function run()
    {
        $pembeliUsers = $this->db->table('user')
            ->where('role', 'pembeli')
            ->get()
            ->getResult();

        foreach ($pembeliUsers as $user) {
            // Cek apakah sudah ada di tabel pembeli
            $exists = $this->db->table('pembeli')
                ->where('id_user', $user->id_user)
                ->countAllResults();

            if ($exists == 0) {
                $this->db->table('pembeli')->insert([
                    'id_user' => $user->id_user,
                    'nama'    => $user->nama,
                ]);
            }
        }

        echo count($pembeliUsers) . " pembeli berhasil diproses.\n";
    }
}

<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class UserSeeder extends Seeder
{
    public function run()
    {
        $users = [
            [
                'nama'       => 'Ghani Mudzakir',
                'username'   => 'ghanimudzakir',
                'password'   => password_hash('admin@123', PASSWORD_DEFAULT),
                'role'       => 'admin',
                'nomor_wa'   => NULL,
                'email'      => NULL,
                'is_verified'=> 1,
            ],
                        [
                'nama'       => 'Muhammad Rizky',
                'username'   => 'muhammadrizky',
                'password'   => password_hash('admin@123', PASSWORD_DEFAULT),
                'role'       => 'admin',
                'nomor_wa'   => NULL,
                'email'      => NULL,
                'is_verified'=> 1,
            ],
            [
                'nama'       => 'Randy Febrian',
                'username'   => 'randyfebrian',
                'password'   => password_hash('admin@123', PASSWORD_DEFAULT),
                'role'       => 'admin',
                'nomor_wa'   => NULL,
                'email'      => NULL,
                'is_verified'=> 1,
            ],
            [
                'nama'       => 'Rizky Sulaiman',
                'username'   => 'sulaiman',
                'password'   => password_hash('user@123', PASSWORD_DEFAULT),
                'role'       => 'pembeli',
                'nomor_wa'   => '085157249366',
                'email'      => NULL,
                'is_verified'=> 1,
            ],
            [
                'nama'       => 'Dian Novita',
                'username'   => 'diann',
                'password'   => password_hash('penjual@123', PASSWORD_DEFAULT),
                'role'       => 'penjual',
                'nomor_wa'   => NULL,
                'email'      => NULL,
                'is_verified'=> 1, 
            ],
            [
                'nama'       => 'Arif Wicaksono',
                'username'   => 'arifw',
                'password'   => password_hash('penjual@123', PASSWORD_DEFAULT),
                'role'       => 'penjual',
                'nomor_wa'   => NULL,
                'email'      => NULL,
                'is_verified'=> 1, 
            ],
            [
                'nama'       => 'Yoga Pranata',
                'username'   => 'yogap',
                'password'   => password_hash('penjual@123', PASSWORD_DEFAULT),
                'role'       => 'penjual',
                'nomor_wa'   => NULL,
                'email'      => NULL,
                'is_verified'=> 1, 
            ],
            [
                'nama'       => 'Vina Maharani',
                'username'   => 'vinam',
                'password'   => password_hash('penjual@123', PASSWORD_DEFAULT),
                'role'       => 'penjual',
                'nomor_wa'   => NULL,
                'email'      => NULL,
                'is_verified'=> 1, 
            ],
        ];

        $this->db->table('user')->insertBatch($users);
    }
}

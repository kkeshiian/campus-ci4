<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        $this->call(UserSeeder::class);
        $this->call(FakultasSeeder::class);
        $this->call(PenjualSeeder::class);
        $this->call(PembeliSeeder::class);
        $this->call(MenuSeeder::class);
        $this->call(AdminSeeder::class);
    }
}

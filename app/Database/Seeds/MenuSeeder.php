<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class MenuSeeder extends Seeder
{
    public function run()
    {
        // Ambil semua penjual dari tabel penjual
        $penjualList = $this->db->table('penjual')->get()->getResult();

        if (!$penjualList) {
            echo "Tidak ada penjual ditemukan.\n";
            return;
        }

        $menuTemplate = [
            [
                'nama_menu' => 'Nasi Goreng Kampus',
                'harga' => 15000,
                'gambar' => 'assets/6846d61b08a9f.jpg'
            ],
            [
                'nama_menu' => 'Mie Ayam Jumbo',
                'harga' => 12000,
                'gambar' => 'assets/6846dd33c3f49.png'
            ],
            [
                'nama_menu' => 'Es Teh Manis',
                'harga' => 5000,
                'gambar' => 'assets/6846d69217717.jpeg'
            ]
        ];

        $totalMenuInserted = 0;

        foreach ($penjualList as $penjual) {
            $data = [];

            foreach ($menuTemplate as $menu) {
                $data[] = [
                    'id_penjual' => $penjual->id_penjual,
                    'nama_menu' => $menu['nama_menu'],
                    'harga' => $menu['harga'],
                    'gambar' => $menu['gambar']
                ];
            }

            $this->db->table('menu')->insertBatch($data);
            $totalMenuInserted += count($data);
        }

        echo "$totalMenuInserted menu berhasil dimasukkan untuk " . count($penjualList) . " kantin.\n";
    }
}

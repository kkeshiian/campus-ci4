<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class PenjualSeeder extends Seeder
{
    public function run()
    {
        // Ambil semua fakultas
        $fakultasList = $this->db->table('fakultas')->get()->getResult();
        $fakultasMap = [];

        // Buat mapping nama -> id
        foreach ($fakultasList as $fakultas) {
            $fakultasMap[$fakultas->nama_fakultas] = $fakultas->id_fakultas;
        }

        // Ambil semua user ber-role penjual
        $penjualUsers = $this->db->table('user')->where('role', 'penjual')->get()->getResult();

        // Mapping manual user ke fakultas
        $userFakultasMapping = [
            'diann'  => 'Teknik Banjarmasin',
            'arifw'  => 'Teknik Banjarbaru',
            'yogap'  => 'Ekonomi dan Bisnis',
            'vinam'  => 'Kedokteran Gigi',
        ];

        $data = [];

        foreach ($penjualUsers as $user) {
            $namaFakultas = $userFakultasMapping[$user->username] ?? 'Fakultas Hukum';

            $data[] = [
                'id_user'     => $user->id_user,
                'id_fakultas' => $fakultasMap[$namaFakultas] ?? null,
                'nama_kantin' => 'Kantin ' . $user->nama,
                'gambar'      => 'assets/default.jpg',
                'link'        => 'https://maps.app.goo.gl/HFPhUfiBR7LuYHZx7',
            ];
        }

        if (!empty($data)) {
            $this->db->table('penjual')->insertBatch($data);
            echo count($data) . " penjual berhasil dimasukkan ke tabel penjual.\n";
        } else {
            echo "Tidak ada data penjual yang valid.\n";
        }
    }
}

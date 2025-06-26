<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateRiwayatPembelianTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'order_id' => [
                'type'       => 'VARCHAR',
                'constraint' => 255
            ],
            'id_pembeli' => [
                'type'     => 'INT',
                'unsigned' => true
            ],
            'total' => [
                'type' => 'INT'
            ],
            'tanggal' => [
                'type' => 'DATETIME'
            ],
            'status' => [
                'type'       => 'ENUM',
                'constraint' => ['belum dibayar', 'dibayar', 'batal'],
                'default'    => 'belum dibayar'
            ],
            'bukti_pembayaran' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
                'null'       => true
            ]
        ]);

        $this->forge->addKey('order_id', true);
        $this->forge->addForeignKey('id_pembeli', 'pembeli', 'id_pembeli', 'CASCADE', 'CASCADE');
        $this->forge->createTable('riwayat_pembelian');
    }

    public function down()
    {
        $this->forge->dropTable('riwayat_pembelian');
    }
}

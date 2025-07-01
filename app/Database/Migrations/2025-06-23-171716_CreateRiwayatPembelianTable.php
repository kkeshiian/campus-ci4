<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateRiwayatPembelianTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_rp' => [
                'type'           => 'INT',
                'unsigned'       => true,
                'auto_increment' => true
            ],
            'order_id' => [
                'type'       => 'VARCHAR',
                'constraint' => 255
            ],
            'id_pembeli' => [
                'type'     => 'INT',
                'unsigned' => true
            ],
            'nama_kantin' => [
                'type'       => 'VARCHAR',
                'constraint' => 255
            ],
            'menu' => [
                'type'       => 'VARCHAR',
                'constraint' => 255
            ],
            'quantity' => [
                'type' => 'INT'
            ],
            'harga' => [
                'type' => 'INT'
            ],
            'total' => [
                'type' => 'INT'
            ],
            'status' => [
                'type'       => 'ENUM',
                'constraint' => ['Waiting to Confirm', 'Being Cooked', 'Ready to Pickup', 'Done',],
                'default'    => 'Waiting to Confirm'
            ],
            'tanggal' => [
                'type' => 'DATETIME'
            ],
            'notes' => [
                'type' => 'TEXT',
                'null' => true
            ],
            'tipe' => [
                'type'       => 'VARCHAR',
                'constraint' => 50
            ],
            'status_pembayaran' => [
                'type'       => 'VARCHAR',
                'constraint' => 100,
                'default'    => 'belum dibayar'
            ],
            'bukti_pembayaran' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
                'null'       => true
            ]
        ]);

        $this->forge->addKey('id_rp', true); // PRIMARY
        $this->forge->addKey('order_id');    // Index biasa
        $this->forge->addForeignKey('id_pembeli', 'pembeli', 'id_pembeli', 'CASCADE', 'CASCADE');
        $this->forge->createTable('riwayat_pembelian');
    }

    public function down()
    {
        $this->forge->dropTable('riwayat_pembelian');
    }
}
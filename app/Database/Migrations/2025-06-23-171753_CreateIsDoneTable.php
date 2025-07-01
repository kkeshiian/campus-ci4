<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateIsDoneTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_done' => [
                'type'           => 'INT',
                'unsigned'       => true,
                'auto_increment' => true
            ],
            'order_id' => [
                'type'       => 'VARCHAR',
                'constraint' => 255
            ],
            'id_user' => [
                'type'     => 'INT',
                'unsigned' => true
            ],
            'id_penjual' => [
                'type'     => 'INT',
                'unsigned' => true
            ],
            'nomor_wa' => [
                'type'       => 'VARCHAR',
                'constraint' => 25  // Sesuaikan dengan tabel user
            ],
            'menu' => [
                'type'       => 'VARCHAR',
                'constraint' => 255
            ],
            'is_sent' => [
                'type'       => 'TINYINT',
                'constraint' => 1,
                'default'    => 0,
                'unsigned'   => true
            ],
            'tanggal' => [
                'type' => 'DATETIME'
            ]
        ]);

        $this->forge->addKey('id_done', true);
        
        // Tambah foreign key dengan hati-hati
        $this->forge->addForeignKey('id_user', 'user', 'id_user', 'RESTRICT', 'CASCADE');
        $this->forge->addForeignKey('id_penjual', 'penjual', 'id_penjual', 'RESTRICT', 'CASCADE');
        
        $this->forge->createTable('is_done');
    }

    public function down()
    {
        $this->forge->dropTable('is_done');
    }
}
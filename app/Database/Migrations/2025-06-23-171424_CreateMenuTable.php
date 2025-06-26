<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateMenuTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_menu' => [
                'type'           => 'INT',
                'unsigned'       => true,
                'auto_increment' => true
            ],
            'id_penjual' => [
                'type'     => 'INT',
                'unsigned' => true,
                'null'     => true
            ],
            'nama_menu' => [
                'type'       => 'VARCHAR',
                'constraint' => 255
            ],
            'harga' => [
                'type'       => 'INT',
                'constraint' => 11
            ],
            'gambar' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
                'null'       => true
            ]
        ]);

        $this->forge->addKey('id_menu', true);
        $this->forge->addForeignKey('id_penjual', 'penjual', 'id_penjual', 'CASCADE', 'CASCADE');
        $this->forge->createTable('menu');
    }

    public function down()
    {
        $this->forge->dropTable('menu');
    }
}

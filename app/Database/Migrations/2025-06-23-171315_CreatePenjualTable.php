<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreatePenjualTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_penjual' => [
                'type'           => 'INT',
                'unsigned'       => true,
                'auto_increment' => true
            ],
            'id_user' => [
                'type'     => 'INT',
                'unsigned' => true
            ],
            'id_fakultas' => [
                'type'     => 'INT',
                'unsigned' => true,
                'null'     => true
            ],
            'nama' => [
                'type'       => 'VARCHAR',
                'constraint' => 255
            ],
            'nama_kantin' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
                'null'       => true,
                'unique'     => true
            ],
            'gambar' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
                'null'       => true
            ],
            'link' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
                'null'       => true
            ]
        ]);

        $this->forge->addKey('id_penjual', true);
        $this->forge->addForeignKey('id_user', 'user', 'id_user', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('id_fakultas', 'fakultas', 'id_fakultas', 'SET NULL', 'CASCADE');
        $this->forge->createTable('penjual');
    }

    public function down()
    {
        $this->forge->dropTable('penjual');
    }
}

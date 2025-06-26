<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreatePembeliTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_pembeli' => [
                'type'           => 'INT',
                'unsigned'       => true,
                'auto_increment' => true
            ],
            'id_user' => [
                'type'     => 'INT',
                'unsigned' => true
            ],
            'nama' => [
                'type'       => 'VARCHAR',
                'constraint' => 255
            ],
            'gambar' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
                'null'       => true
            ]
        ]);

        $this->forge->addKey('id_pembeli', true);
        $this->forge->addForeignKey('id_user', 'user', 'id_user', 'CASCADE', 'CASCADE');
        $this->forge->createTable('pembeli');
    }

    public function down()
    {
        $this->forge->dropTable('pembeli');
    }
}

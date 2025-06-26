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
            'id_penjual' => [
                'type'     => 'INT',
                'unsigned' => true
            ],
            'status' => [
                'type'       => 'ENUM',
                'constraint' => ['pending', 'done'],
                'default'    => 'pending'
            ],
            'tanggal' => [
                'type' => 'DATETIME'
            ]
        ]);

        $this->forge->addKey('id_done', true);
        $this->forge->addForeignKey('id_penjual', 'penjual', 'id_penjual', 'CASCADE', 'CASCADE');
        $this->forge->createTable('is_done');
    }

    public function down()
    {
        $this->forge->dropTable('is_done');
    }
}

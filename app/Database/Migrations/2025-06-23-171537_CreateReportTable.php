<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateReportTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_report' => [
                'type'           => 'INT',
                'unsigned'       => true,
                'auto_increment' => true
            ],
            'id_penjual' => [
                'type'     => 'INT',
                'unsigned' => true
            ],
            'id_pembeli' => [
                'type'     => 'INT',
                'unsigned' => true
            ],
            'order_id' => [
                'type'       => 'VARCHAR',
                'constraint' => 255
            ],
            'nama_kantin' => [
                'type'       => 'VARCHAR',
                'constraint' => 255
            ],
            'tanggal' => [
                'type' => 'DATE'
            ],
            'kategori' => [
                'type'       => 'VARCHAR',
                'constraint' => 255
            ],
            'deskripsi' => [
                'type' => 'TEXT'
            ],
            'bukti' => [
                'type'       => 'VARCHAR',
                'constraint' => 255
            ]
        ]);

        $this->forge->addKey('id_report', true);
        $this->forge->addForeignKey('id_penjual', 'penjual', 'id_penjual', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('id_pembeli', 'pembeli', 'id_pembeli', 'CASCADE', 'CASCADE');
        $this->forge->createTable('report');
    }

    public function down()
    {
        $this->forge->dropTable('report');
    }
}

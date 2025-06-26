<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateOtpVerificationsTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type'           => 'INT',
                'unsigned'       => true,
                'auto_increment' => true
            ],
            'id_user' => [
                'type'     => 'INT',
                'unsigned' => true
            ],
            'otp_code' => [
                'type'       => 'VARCHAR',
                'constraint' => 8
            ],
            'expires_at' => [
                'type' => 'DATETIME'
            ],
            'is_used' => [
                'type'       => 'TINYINT',
                'constraint' => 1
            ]
        ]);

        $this->forge->addKey('id', true);
        $this->forge->addForeignKey('id_user', 'user', 'id_user', 'CASCADE', 'CASCADE');
        $this->forge->createTable('otp_verifications');
    }

    public function down()
    {
        $this->forge->dropTable('otp_verifications');
    }
}

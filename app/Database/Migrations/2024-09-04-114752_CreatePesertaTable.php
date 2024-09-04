<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreatePesertaTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'auto_increment' => true,
            ],
            'nama' => [
                'type' => 'VARCHAR',
                'constraint' => '100',
            ],
            'nim' => [
                'type' => 'VARCHAR',
                'constraint' => '20',
            ],
            'domisili' => [
                'type' => 'VARCHAR',
                'constraint' => '100',
            ],
            'ktm' => [
                'type' => 'VARCHAR',
                'constraint' => '255',
            ],
            'ktm2' => [
                'type' => 'VARCHAR',
                'constraint' => '255',
            ],
            'created_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
            'updated_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
            'deleted_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
        ]);

        $this->forge->addKey('id', true);
        $this->forge->createTable('peserta');
    }

    public function down()
    {
        $this->forge->dropTable('peserta');
    }
}

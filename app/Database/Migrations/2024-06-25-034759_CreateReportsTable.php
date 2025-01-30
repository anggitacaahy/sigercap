<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateReportsTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type' => 'INT',
                'constraint' => 5,
                'unsigned' => true,
                'auto_increment' => true,
            ],
            'nomor' => [
                'type' => 'VARCHAR',
                'constraint' => '255',
            ],
            'jenis' => [
                'type' => 'VARCHAR',
                'constraint' => '255',
            ],
            'waktu' => [
                'type' => 'TIMESTAMP',
            ],
            'latitude' => [
                'type' => 'DECIMAL',
                'constraint' => '10,8',
            ],
            'longitude' => [
                'type' => 'DECIMAL',
                'constraint' => '11,8',
            ],
            'kronologi' => [
                'type' => 'TEXT',
            ],
            'pengungsi' => [
                'type' => 'TEXT',
            ],
            'image_path' => [  // Kolom untuk menyimpan path gambar
                'type' => 'VARCHAR',
                'constraint' => '255',
            ],
        ]);

        $this->forge->addKey('id', true);
        $this->forge->createTable('reports');
    }

    public function down()
    {
        $this->forge->dropTable('reports');
    }
}

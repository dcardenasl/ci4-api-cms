<?php

declare(strict_types=1);

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateCmspostsTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'section_id' => [
                'type' => 'INT',
                'unsigned' => true,
                'null' => false,
            ],
            'post_type_id' => [
                'type' => 'INT',
                'unsigned' => true,
                'null' => false,
            ],
            'title' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => false,
            ],
            'slug' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => false,
            ],
            'content' => [
                'type' => 'TEXT',
                'null' => false,
            ],
            'custom_data' => [
                'type' => 'JSON',
                'null' => false,
            ],
            'status' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => false,
            ],
            'published_at' => [
                'type' => 'DATETIME',
                'null' => false,
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
        $this->forge->addKey('section_id');
        $this->forge->addKey('post_type_id');
        $this->forge->addForeignKey('section_id', 'cmssections', 'id', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('post_type_id', 'cmsposttypes', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('cmsposts');
    }

    public function down()
    {
        $this->forge->dropTable('cmsposts');
    }
}

<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Stok extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type' => 'INT',
                'unsigned' => true,
                'auto_increment' => true
            ],
            'produk' => [
                'type' => 'VARCHAR',
                'constraint' => '20'
            ],
            'tipe' => [
                'type' => 'ENUM',
                'constraint' => ['in', 'out'],
                'default' => 'in'
            ],
            'detail' => [
                'type' => 'VARCHAR',
                'constraint' => '200'
            ],
            'supplier' => [
                'type' => 'INT',
                'unsigned' => true,
                'null' => true
            ],
            'qty' => [
                'type' => 'INT',
                'unsigned' => true
            ],
            'tanggal' => [
                'type' => 'DATE'
            ],
            'user' => [
                'type' => 'INT',
                'unsigned' => true
            ],
            'created_at datetime default current_timestamp',
            'updated_at datetime default current_timestamp on update current_timestamp',
            'deleted_at datetime null'
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addForeignKey('produk', 'produk', 'barcode', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('supplier', 'supplier', 'id', 'RESTRICT', 'RESTRICT');
        $this->forge->addForeignKey('user', 'users', 'id', 'RESTRICT', 'RESTRICT');
        $this->forge->createTable('stok');
    }

    public function down()
    {
        $this->forge->dropTable('stok');
    }
}

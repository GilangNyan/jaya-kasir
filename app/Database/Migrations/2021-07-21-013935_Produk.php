<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Produk extends Migration
{
	public function up()
	{
		$this->forge->addField([
			'barcode' => [
				'type' => 'VARCHAR',
				'constraint' => '20'
			],
			'nama' => [
				'type' => 'VARCHAR',
				'constraint' => '100'
			],
			'kategori' => [
				'type' => 'INT',
				'unsigned' => true
			],
			'satuan' => [
				'type' => 'INT',
				'unsigned' => true
			],
			'harga_beli' => [
				'type' => 'INT',
				'unsigned' => true
			],
			'harga_jual' => [
				'type' => 'INT',
				'unsigned' => true
			],
			'stok' => [
				'type' => 'INT',
				'unsigned' => true
			],
			'created_at datetime default current_timestamp',
			'updated_at datetime default current_timestamp on update current_timestamp',
			'deleted_at datetime null'
		]);
		$this->forge->addKey('barcode', true);
		$this->forge->addForeignKey('kategori', 'kategori', 'id', 'CASCADE', 'RESTRICT');
		$this->forge->addForeignKey('satuan', 'satuan', 'id', 'CASCADE', 'RESTRICT');
		$this->forge->createTable('produk');
	}

	public function down()
	{
		$this->forge->dropTable('produk');
	}
}

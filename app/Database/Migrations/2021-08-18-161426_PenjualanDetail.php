<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class PenjualanDetail extends Migration
{
	public function up()
	{
		$this->forge->addField([
			'detail_id' => [
				'type' => 'INT',
				'unsigned' => true,
				'auto_increment' => true
			],
			'faktur' => [
				'type' => 'VARCHAR',
				'constraint' => '12'
			],
			'barcode' => [
				'type' => 'VARCHAR',
				'constraint' => '20'
			],
			'harga' => [
				'type' => 'INT',
				'unsigned' => true
			],
			'qty' => [
				'type' => 'INT',
				'unsigned' => true
			],
			'diskon' => [
				'type' => 'INT',
				'unsigned' => true
			],
			'subtotal' => [
				'type' => 'INT',
				'unsigned' => true
			]
		]);
		$this->forge->addKey('detail_id', true);
		// $this->forge->addForeignKey('faktur', 'penjualan', 'faktur', 'CASCADE', 'RESTRICT');
		$this->forge->addForeignKey('barcode', 'produk', 'barcode', 'CASCADE', 'RESTRICT');
		$this->forge->createTable('penjualan_detail');
	}

	public function down()
	{
		$this->forge->dropTable('penjualan_detail');
	}
}

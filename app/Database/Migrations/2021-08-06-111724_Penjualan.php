<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Penjualan extends Migration
{
	public function up()
	{
		$this->forge->addField([
			'faktur' => [
				'type' => 'VARCHAR',
				'constraint' => '12',
			],
			'tanggal' => [
				'type' => 'DATE'
			],
			'id_kasir' => [
				'type' => 'INT',
				'unsigned' => true
			],
			'id_member' => [
				'type' => 'INT',
				'unsigned' => true,
				'null' => true
			],
			'diskon_uang' => [
				'type' => 'DOUBLE'
			],
			'diskon_persen' => [
				'type' => 'DOUBLE'
			],
			'total_bruto' => [
				'type' => 'DOUBLE'
			],
			'total_netto' => [
				'type' => 'DOUBLE'
			],
			'bayar' => [
				'type' => 'DOUBLE'
			],
			'kembali' => [
				'type' => 'DOUBLE'
			],
			'created_at datetime default current_timestamp',
			'updated_at datetime default current_timestamp on update current_timestamp',
			'deleted_at datetime null'
		]);
		$this->forge->addKey('faktur', true);
		$this->forge->addForeignKey('id_kasir', 'users', 'id', 'CASCADE', 'RESTRICT');
		$this->forge->addForeignKey('id_member', 'member', 'id', 'CASCADE', 'RESTRICT');
		$this->forge->createTable('penjualan');
	}

	public function down()
	{
		$this->forge->dropTable('penjualan');
	}
}

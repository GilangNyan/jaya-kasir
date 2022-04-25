<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Member extends Migration
{
	public function up()
	{
		$this->forge->addField([
			'id' => [
				'type' => 'INT',
				'unsigned' => true,
				'auto_increment' => true
			],
			'nama_lengkap' => [
				'type' => 'VARCHAR',
				'constraint' => '100'
			],
			'email' => [
				'type' => 'VARCHAR',
				'constraint' => '100',
			],
			'telepon' => [
				'type' => 'VARCHAR',
				'constraint' => '15',
			],
			'alamat' => [
				'type' => 'TEXT'
			],
			'created_at datetime default current_timestamp',
			'updated_at datetime default current_timestamp on update current_timestamp',
			'deleted_at datetime null'
		]);
		$this->forge->addKey('id', true);
		$this->forge->addKey('email');
		$this->forge->addKey('telepon');
		$this->forge->createTable('member');
	}

	public function down()
	{
		$this->forge->dropTable('member');
	}
}

<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Satuan extends Migration
{
	public function up()
	{
		$this->forge->addField([
			'id' => [
				'type' => 'INT',
				'unsigned' => true,
				'auto_increment' => true
			],
			'satuan' => [
				'type' => 'VARCHAR',
				'constraint' => '100'
			],
			'created_at datetime default current_timestamp',
			'updated_at datetime default current_timestamp on update current_timestamp',
			'deleted_at datetime null'
		]);
		$this->forge->addKey('id', true);
		$this->forge->createTable('satuan');
	}

	public function down()
	{
		$this->forge->dropTable('satuan');
	}
}

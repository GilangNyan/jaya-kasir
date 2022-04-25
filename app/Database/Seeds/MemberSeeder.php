<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class MemberSeeder extends Seeder
{
	public function run()
	{
		$data = [
			'id' => '0',
			'nama_lengkap' => 'Umum',
			'email' => '-',
			'telepon' => '-',
			'alamat' => '-'
		];

		$this->db->table('member')->insert($data);
	}
}

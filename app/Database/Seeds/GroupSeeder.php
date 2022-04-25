<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class GroupSeeder extends Seeder
{
    public function run()
    {
        $data = [
            [
                'name' => 'admin',
                'description' => 'Administrator situs'
            ],
            [
                'name' => 'kasir',
                'description' => 'Pengguna yang dapat mengakses fungsi kasir'
            ],
            [
                'name' => 'gudang',
                'description' => 'Pengguna yang dapat mengelola barang'
            ],
            [
                'name' => 'tamu',
                'description' => 'Pengguna yang baru mendaftar dan belum diberi role'
            ]
        ];

        $this->db->table('auth_groups')->insertBatch($data);
    }
}

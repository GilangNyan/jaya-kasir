<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class PermissionSeeder extends Seeder
{
    public function run()
    {
        $data = [
            [
                'name' => 'access_transaction',
                'description' => 'Mengakses menu transaksi'
            ],
            [
                'name' => 'access_product',
                'description' => 'Mengakses menu data produk dan turunannya'
            ],
            [
                'name' => 'access_customer',
                'description' => 'Mengakses menu pelanggan dan turunannya'
            ],
            [
                'name' => 'access_supplier',
                'description' => 'Mengakses menu supplier'
            ],
            [
                'name' => 'access_stock',
                'description' => 'Mengakses menu stock-in dan stock-out'
            ]
        ];

        $this->db->table('auth_permissions')->insertBatch($data);
    }
}

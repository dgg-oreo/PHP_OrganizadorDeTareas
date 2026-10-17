<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class UserSeeder extends Seeder
{
    public function run()
    {
        $now = date('Y-m-d H:i:s');

        $this->db->table('users')->insert([
            'name'       => 'Diego',
            'email'      => 'admin@gmail.com',
            'password'   => password_hash('admin123', PASSWORD_DEFAULT),
            'active'     => 1,
            'is_admin'   => 1,
            'created_at' => $now,
            'updated_at' => $now,
        ]);
    }
}
<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('users')->insert([
            [
                'nama' => 'Admin',
                'email' => 'admin@gmail.com',
                'username' => 'admin',
                'password' => bcrypt('admin'),
                'no_tlpn' => '081287728681',
                'role' => 'admin',
                'is_active' => 1
            ],
            [
                'nama' => 'Kasir 1',
                'email' => 'kasir@gmail.com',
                'username' => 'kasir',
                'password' => bcrypt('kasir'),
                'no_tlpn' => '081200000000',
                'role' => 'kasir',
                'is_active' => 1
            ]
        ]);
    }
}

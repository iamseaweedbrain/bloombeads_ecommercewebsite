<?php

namespace Database\Seeders;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('admin_users')->insert([
            'username' => 'BloombeadsAdmin',
            'password' => Hash::make('Bloombeadsbyjinx'),
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}

<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class UserAccountSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('useraccount')->insert([
            'fullName' => 'Test User',
            'email' => 'test@example.com',
            'password' => Hash::make('password123'),
            'contact_number' => '09123456789',
            'address' => '123 Sample Street, Makati City',
            'status' => 'active',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}

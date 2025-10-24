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
            'username' => 'testuser',
            'email' => 'test@example.com',
            'password' => Hash::make('password123'),
            'status' => 'active',
            'date_joined' => Carbon::now(),
            'user_id' => uniqid('user_'),
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}

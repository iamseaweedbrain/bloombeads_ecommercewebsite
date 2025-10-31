<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class HashUserPasswords extends Command
{
    protected $signature = 'users:hash-passwords';
    protected $description = 'Hashes all plain text passwords in the useraccount table.';

    public function handle()
    {
        $users = DB::table('useraccount')->get();
        $count = 0;

        foreach ($users as $user) {
            // Only hash if it's not already hashed
            if (!str_starts_with($user->password, '$2y$')) {
                DB::table('useraccount')
                    ->where('user_id', $user->user_id)
                    ->update(['password' => Hash::make($user->password)]);
                $count++;
            }
        }

        $this->info("✅ Hashed {$count} user passwords successfully!");
        return 0;
    }
}

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('useraccount', function (Blueprint $table) {
            
            $table->id('user_id'); 

            $table->string('fullName', 100);
            $table->string('username', 100)->unique();
            $table->string('email', 100)->unique();
            $table->string('password', 255);
            $table->string('status', 20)->default('active');
            $table->timestamp('date_joined')->useCurrent();
            
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('useraccount');
    }
};

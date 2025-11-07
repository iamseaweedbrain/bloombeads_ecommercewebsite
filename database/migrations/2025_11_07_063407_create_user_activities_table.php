<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('user_activities', function (Blueprint $table) {
            $table->id();
            
            // Link to the user this activity belongs to
            $table->foreignId('user_id')->constrained('useraccount', 'user_id')->onDelete('cascade');
            
            // The activity message, e.g., "Placed Order #BB-123"
            $table->string('message');
            
            // An optional link for the activity
            $table->string('url')->nullable();
            
            $table->timestamps();
        });
    }
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_activities');
    }
};

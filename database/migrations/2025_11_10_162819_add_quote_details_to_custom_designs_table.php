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
        Schema::table('custom_designs', function (Blueprint $table) {
            $table->string('customer_name')->after('user_id');
            $table->string('customer_email')->after('customer_name');
            $table->json('design_data')->nullable()->after('customer_email');
            $table->string('status')->default('pending')->after('design_data');
            $table->decimal('final_price', 8, 2)->nullable()->after('status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('custom_designs', function (Blueprint $table) {
            $table->dropColumn([
                'customer_name', 
                'customer_email', 
                'design_data', 
                'status', 
                'final_price'
            ]);
        });
    }
};
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
        Schema::create('orders', function (Blueprint $table) {
            $table->id(); // Order ID
            
            // Link to the user who placed the order
            $table->foreignId('user_id')->constrained('useraccount')->onDelete('cascade');
            
            // Your unique tracking ID (e.g., BB-1234ABCD)
            $table->string('order_tracking_id')->unique();
            
            // Customer & Shipping Info (Add any other fields you need)
            // $table->string('customer_name');
            // $table->text('address');
            // $table->string('phone');
            
            // Order Details
            $table->decimal('total_amount', 10, 2);
            $table->string('payment_method');
            
            // Status Fields
            $table->string('payment_status')->default('pending'); // pending, unpaid, paid, failed
            $table->string('order_status')->default('pending'); // pending, processing, shipped, delivered, cancelled
            
            $table->timestamps(); // created_at and updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};

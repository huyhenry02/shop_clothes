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
            $table->id();
            $table->foreignId('customer_id')->constrained('customers');
            $table->string('order_code', 20)->unique();
            $table->integer('total_amount');
            $table->enum('status', ['pending', 'processing', 'shipping', 'completed', 'cancelled']);
            $table->enum('payment_status', ['unpaid', 'paid', 'failed']);
            $table->enum('payment_method', ['cod', 'vnpay']);
            $table->text('shipping_address');
            $table->text('note')->nullable();
            $table->timestamps();
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

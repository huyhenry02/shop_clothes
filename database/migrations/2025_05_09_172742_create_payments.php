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
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_id')->constrained('orders')->onDelete('cascade');
            $table->integer('amount');
            $table->enum('payment_method', ['cod', 'vnpay']);
            $table->timestamp('payment_time');
            $table->string('transaction_no', 100);
            $table->string('bank_code', 50);
            $table->string('vnp_response_code', 10);
            $table->enum('transaction_status', ['success', 'fail']);
            $table->timestamp('created_at')->useCurrent();
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};

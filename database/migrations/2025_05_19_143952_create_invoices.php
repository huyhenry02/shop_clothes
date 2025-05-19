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
        Schema::create('invoices', function (Blueprint $table) {
            $table->id();
            $table->string('invoice_code', 20)->unique();
            $table->string('customer_name', 255);
            $table->string('customer_phone', 20);
            $table->integer('total_amount');
            $table->enum('status', ['draft', 'completed', 'cancelled'])->default('completed');
            $table->enum('payment_method', ['cash', 'vnpay']);
            $table->enum('payment_status', ['unpaid', 'paid', 'failed'])->default('paid');
            $table->timestamp('payment_time')->nullable();
            $table->foreignId('employee_id')->nullable()->constrained('employees')->nullOnDelete();
            $table->timestamps();
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('invoices');
    }
};

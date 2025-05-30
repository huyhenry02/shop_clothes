<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
//    tạo file migration sẽ bằng câu lệnh: php artisan make:migration create_users
//  chạy lênh thực thi file migration:  php artisan migrate
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id(); // tạo cột id
            $table->string('phone', 100)->unique(); // tạo cột phone với độ dài tối đa 100 ký tự và không trùng lặp
            $table->string('password', 255);
            $table->enum('role', ['admin', 'employee', 'customer']);
            $table->rememberToken();
            $table->timestamps();
        });

        Schema::create('password_reset_tokens', function (Blueprint $table) {
            $table->string('email')->primary();
            $table->string('token');
            $table->timestamp('created_at')->nullable();
        });

        Schema::create('sessions', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->foreignId('user_id')->nullable()->index();
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->longText('payload');
            $table->integer('last_activity')->index();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
        Schema::dropIfExists('password_reset_tokens');
        Schema::dropIfExists('sessions');
    }
};

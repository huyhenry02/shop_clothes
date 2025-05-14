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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->foreignId('category_id')->constrained('categories');
            $table->string('code', 100);
            $table->string('name', 255);
            $table->string('slug', 255);
            $table->text('description');
            $table->integer('price');
            $table->integer('discount_price')->nullable();
            $table->integer('stock_quantity');
            $table->string('image', 255)->nullable();
            $table->string('image_detail_1', 255)->nullable();
            $table->string('image_detail_2', 255)->nullable();
            $table->string('image_detail_3', 255)->nullable();
            $table->string('color', 50)->nullable();
            $table->string('material', 100)->nullable();
            $table->enum('style', ['basic', 'casual', 'sport', 'formal'])->nullable();
            $table->boolean('is_active')->default(1);
            $table->timestamps();
        });


    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};

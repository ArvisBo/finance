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
        Schema::create('expenses', function (Blueprint $table) {
            $table->id()->autoIncrement();
            $table->foreignId('created_user_id')->constrained('users');
            $table->foreignId('user_id')->constrained('users');
            $table->foreignId('category_id')->constrained('expense_categories');
            $table->string('product_name',150);
            $table->date('date')->nullable();
            $table->integer('count')->default(1);
            $table->decimal('price', 10, 2)->nullable();
            $table->decimal('total_price', 10, 2)->nullable();
            $table->string('receipt_image')->nullable();
            $table->text('additional_information')->nullable();
            $table->date('warranty_until')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('expenses');
    }
};

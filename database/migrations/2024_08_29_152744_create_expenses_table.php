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
            $table->id();
			$table->foreignId('created_user_id')->nullable()->constrained('users')->onDelete('set null');
			$table->string('expense_name');
			$table->date('expense_date')->nullable();
            $table->foreignId('expense_category_id')->nullable()->constrained('expense_categories')->onDelete('set null');
			$table->foreignId('account_id')->nullable()->constrained('accounts')->onDelete('set null');
			$table->integer('count');
            $table->decimal('unit_price', 10, 2);
			$table->decimal('total_price', 10, 2);
			$table->string('file')->nullable();
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

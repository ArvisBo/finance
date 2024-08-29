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
        Schema::create('incomes', function (Blueprint $table) {
            $table->id();
		    $table->foreignId('created_user_id')->nullable()->constrained('users')->onDelete('set null');
            $table->foreignId('income_category_id')->nullable()->constrained('income_categories')->onDelete('set null');
		    $table->foreignId('account_id')->nullable()->constrained('accounts')->onDelete('set null');
		    $table->date('income_date');
            $table->decimal('amount', 10, 2);
            $table->text('description')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('incomes');
    }
};

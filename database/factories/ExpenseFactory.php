<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Expense>
 */
class ExpenseFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'expense_name' => 'Office Chair',
            'expense_date' => now()->format('Y-m-d'),
            'count' => 1,
            'unit_price' => 100.00,
            'total_price' => 100.00,
        ];
    }
}

<?php

namespace Database\Seeders;

use App\Models\Expense;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ExpenseSeeder extends Seeder
{
    public function run()
    {
        Expense::create([
            'created_user_id' => 1,
            'expense_name' => 'Laptop',
            'expense_date' => now(),
            'expense_category_id' => 1,
            'account_id' => 1,
            'count' => 1,
            'unit_price' => 1000.00,
            'total_price' => 1000.00,
            'file' => null,
            'additional_information' => 'Purchased new laptop',
            'warranty_until' => now()->addYear(),
        ]);

        Expense::create([
            'created_user_id' => 2,
            'expense_name' => 'Office Rent',
            'expense_date' => now(),
            'expense_category_id' => 2,
            'account_id' => 2,
            'count' => 1,
            'unit_price' => 500.00,
            'total_price' => 500.00,
            'file' => null,
            'additional_information' => 'Monthly office rent',
            'warranty_until' => null,
        ]);
    }
}

<?php

namespace Database\Seeders;

use App\Models\Expense_category;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ExpenseCategorySeeder extends Seeder
{
    public function run()
    {
        Expense_category::create([
            'created_user_id' => 1,
            'expense_category_name' => 'Electronics',
            'is_visible' => true,
        ]);

        Expense_category::create([
            'created_user_id' => 2,
            'expense_category_name' => 'Office Expenses',
            'is_visible' => true,
        ]);

        Expense_category::create([
            'created_user_id' => 1,
            'expense_category_name' => 'Food',
            'is_visible' => true,
        ]);

        Expense_category::create([
            'created_user_id' => 1,
            'expense_category_name' => 'Car',
            'is_visible' => true,
        ]);

        Expense_category::create([
            'created_user_id' => 1,
            'expense_category_name' => 'House',
            'is_visible' => true,
        ]);
    }
}

<?php

namespace Database\Seeders;

use App\Models\ExpenseCategory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ExpenseCategorySeeder extends Seeder
{
    public function run()
    {
        ExpenseCategory::create([
            'created_user_id' => 1,
            'ExpenseCategory_name' => 'Electronics',
            'is_visible' => true,
        ]);

        ExpenseCategory::create([
            'created_user_id' => 2,
            'ExpenseCategory_name' => 'Office Expenses',
            'is_visible' => true,
        ]);

        ExpenseCategory::create([
            'created_user_id' => 1,
            'ExpenseCategory_name' => 'Food',
            'is_visible' => true,
        ]);

        ExpenseCategory::create([
            'created_user_id' => 1,
            'ExpenseCategory_name' => 'Car',
            'is_visible' => true,
        ]);

        ExpenseCategory::create([
            'created_user_id' => 1,
            'ExpenseCategory_name' => 'House',
            'is_visible' => true,
        ]);
    }
}

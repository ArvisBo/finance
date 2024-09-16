<?php

namespace Database\Seeders;

use App\Models\Income;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class IncomeSeeder extends Seeder
{
    public function run()
    {
        Income::create([
            'created_user_id' => 1,
            'income_category_id' => 1,
            'account_id' => 1,
            'income_date' => now(),
            'amount' => 1500.00,
            'description' => 'Monthly Salary',
        ]);

        Income::create([
            'created_user_id' => 2,
            'income_category_id' => 2,
            'account_id' => 2,
            'income_date' => now(),
            'amount' => 500.00,
            'description' => 'Freelance Work',
        ]);

        Income::create([
            'created_user_id' => 4,
            'income_category_id' => 1,
            'account_id' => 4,
            'income_date' => '2024-05-05',
            'amount' => 1000.00,
            'description' => 'April salary',
        ]);

        Income::create([
            'created_user_id' => 4,
            'income_category_id' => 1,
            'account_id' => 4,
            'income_date' => '2024-06-05',
            'amount' => 1500.00,
            'description' => 'May salary',
        ]);

        Income::create([
            'created_user_id' => 4,
            'income_category_id' => 1,
            'account_id' => 4,
            'income_date' => '2024-07-05',
            'amount' => 1750.00,
            'description' => 'June salary',
        ]);

        Income::create([
            'created_user_id' => 4,
            'income_category_id' => 1,
            'account_id' => 4,
            'income_date' => '2024-08-05',
            'amount' => 1550.00,
            'description' => 'July salary',
        ]);

        Income::create([
            'created_user_id' => 4,
            'income_category_id' => 1,
            'account_id' => 4,
            'income_date' => '2024-09-05',
            'amount' => 1600.00,
            'description' => 'August salary',
        ]);

    }
}

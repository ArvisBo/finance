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
    }
}

<?php

namespace Database\Seeders;

use App\Models\IncomeCategory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class IncomeCategorySeeder extends Seeder
{
    public function run()
    {
        IncomeCategory::create([
            'created_user_id' => 1,
            'income_category_name' => 'Salary',
            'is_visible' => true,
        ]);

        IncomeCategory::create([
            'created_user_id' => 2,
            'income_category_name' => 'Freelancing',
            'is_visible' => true,
        ]);
    }
}

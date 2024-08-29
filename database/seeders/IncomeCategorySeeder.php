<?php

namespace Database\Seeders;

use App\Models\Income_category;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class IncomeCategorySeeder extends Seeder
{
    public function run()
    {
        Income_category::create([
            'created_user_id' => 1,
            'income_category_name' => 'Salary',
            'is_visible' => true,
        ]);

        Income_category::create([
            'created_user_id' => 1,
            'income_category_name' => 'Freelancing',
            'is_visible' => true,
        ]);

        Income_category::create([
            'created_user_id' => 1,
            'income_category_name' => 'Cash prize',
            'is_visible' => true,
        ]);
    }
}

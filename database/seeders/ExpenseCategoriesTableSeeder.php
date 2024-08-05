<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ExpenseCategoriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('expense_categories')->insert([
            ['category_name' => 'Dzīvoklis', 'is_visible' => 1],
            ['category_name' => 'Automašīna', 'is_visible' => 1],
            ['category_name' => 'Pārtika', 'is_visible' => 1],
        ]);
    }
}

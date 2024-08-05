<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class IncomeCategoriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('income_categories')->insert([
            ['category_name' => 'Alga', 'is_visible' => 1],
            ['category_name' => 'Prēmija', 'is_visible' => 1],
            ['category_name' => 'Piemaksa', 'is_visible' => 1],
        ]);
    }
}

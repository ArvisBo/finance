<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ExpensesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('expenses')->insert([
            [
                'user_id' => 1,
                'category_id' => 1,
                'product_name' => 'Dīvāns',
                'date' => '2024-08-01',
                'count' => 1,
                'price' => 1000,
                'total_price' => 1000,
                'additional_information' => 'labs dīvāns',
                'warranty_until' => '2025-08-01',
                'created_user_id' => 1
            ],
            [
                'user_id' => 1,
                'category_id' => 1,
                'product_name' => 'Aizskari',
                'date' => '2024-08-01',
                'count' => 2,
                'price' => 300,
                'total_price' => 600,
                'additional_information' => 'gaišie un tumšie aizskari',
                'warranty_until' => '2025-08-01',
                'created_user_id' => 1
            ],
            [
                'user_id' => 1,
                'category_id' => 2,
                'product_name' => 'Diski',
                'date' => '2024-08-01',
                'count' => 4,
                'price' => 100,
                'total_price' => 400,
                'additional_information' => 'Ziemas diski',
                'warranty_until' => '2025-08-01',
                'created_user_id' => 1
            ],
            [
                'user_id' => 1,
                'category_id' => 2,
                'product_name' => 'Riepas',
                'date' => '2024-08-01',
                'count' => 4,
                'price' => 150,
                'total_price' => 600,
                'additional_information' => 'Vasaras riepas',
                'warranty_until' => '2025-08-01',
                'created_user_id' => 1
            ],
            [
                'user_id' => 1,
                'category_id' => 3,
                'product_name' => 'Pārtika nedēļai',
                'date' => '2024-08-01',
                'count' => 1,
                'price' => 75,
                'total_price' => 75,
                'additional_information' => 'Weekly groceries',
                'warranty_until' => '2025-08-01',
                'created_user_id' => 1
            ],
            [
                'user_id' => 1,
                'category_id' => 3,
                'product_name' => 'Junk food',
                'date' => '2024-08-01',
                'count' => 1,
                'price' => 15,
                'total_price' => 15,
                'additional_information' => 'Maķīts',
                'warranty_until' => '2025-08-01',
                'created_user_id' => 1
            ],
            // Add more expense records here
        ]);
    }
}

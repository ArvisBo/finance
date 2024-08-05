<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class IncomesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('incomes')->insert([
            [
                'user_id' => 1,
                'category_id' => 1,
                'date' => '2024-08-01',
                'amount' => 3000,
                'additional_information' => 'Ikmēneša alga',
                'created_user_id' => 1
            ],
            [
                'user_id' => 1,
                'category_id' => 2,
                'date' => '2024-08-03',
                'amount' => 500,
                'additional_information' => 'Par labu darbu',
                'created_user_id' => 1
            ],
            [
                'user_id' => 1,
                'category_id' => 3,
                'date' => '2024-08-01',
                'amount' => 200,
                'additional_information' => 'Par prjekta izpildi',
                'created_user_id' => 1
            ],
            // Add more income records here
        ]);
    }
}

<?php

namespace Database\Seeders;

use App\Models\Expense;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ExpenseSeeder extends Seeder
{
    public function run()
    {
        Expense::create([
            'created_user_id' => 1,
            'expense_name' => 'Laptop',
            'expense_date' => now(),
            'expense_category_id' => 1,
            'account_id' => 1,
            'count' => 1,
            'unit_price' => 1000.00,
            'total_price' => 1000.00,
            'file' => null,
            'additional_information' => 'Purchased new laptop',
            'warranty_until' => now()->addYear(),
        ]);

        Expense::create([
            'created_user_id' => 2,
            'expense_name' => 'Office Rent',
            'expense_date' => now(),
            'expense_category_id' => 2,
            'account_id' => 2,
            'count' => 1,
            'unit_price' => 500.00,
            'total_price' => 500.00,
            'file' => null,
            'additional_information' => 'Monthly office rent',
            'warranty_until' => null,
        ]);

        Expense::create([
            'created_user_id' => 4,
            'expense_name' => 'Pica',
            'expense_date' => '2024-07-15',
            'expense_category_id' => 4,
            'account_id' => 4,
            'count' => 1,
            'unit_price' => 25.00,
            'total_price' => 25.00,
            'file' => null,
            'additional_information' => null,
            'warranty_until' => null,
        ]);

        Expense::create([
            'created_user_id' => 4,
            'expense_name' => 'Brakes',
            'expense_date' => '2024-07-20',
            'expense_category_id' => 3,
            'account_id' => 4,
            'count' => 2,
            'unit_price' => 150.00,
            'total_price' => 300.00,
            'file' => null,
            'additional_information' => 'Front and rear brakes',
            'warranty_until' => null,
        ]);

        Expense::create([
            'created_user_id' => 4,
            'expense_name' => 'Car',
            'expense_date' => '2024-08-10',
            'expense_category_id' => 5,
            'account_id' => 4,
            'count' => 4,
            'unit_price' => 200.00,
            'total_price' => 800.00,
            'file' => null,
            'additional_information' => 'Winter tyres',
            'warranty_until' => null,
        ]);

        Expense::create([
            'created_user_id' => 4,
            'expense_name' => 'Fuel',
            'expense_date' => '2024-09-14',
            'expense_category_id' => 5,
            'account_id' => 4,
            'count' => 50,
            'unit_price' => 1.50,
            'total_price' => 75.00,
            'file' => null,
            'additional_information' => null,
            'warranty_until' => null,
        ]);

        Expense::create([
            'created_user_id' => 4,
            'expense_name' => 'Some Food',
            'expense_date' => '2024-09-05',
            'expense_category_id' => 4,
            'account_id' => 4,
            'count' => 1,
            'unit_price' => 56.50,
            'total_price' => 56.50,
            'file' => null,
            'additional_information' => null,
            'warranty_until' => null,
        ]);

        Expense::create([
            'created_user_id' => 4,
            'expense_name' => 'Some Food',
            'expense_date' => '2024-09-09',
            'expense_category_id' => 4,
            'account_id' => 4,
            'count' => 1,
            'unit_price' => 46.50,
            'total_price' => 46.50,
            'file' => null,
            'additional_information' => null,
            'warranty_until' => null,
        ]);

        Expense::create([
            'created_user_id' => 4,
            'expense_name' => 'Some Food',
            'expense_date' => '2024-09-10',
            'expense_category_id' => 4,
            'account_id' => 4,
            'count' => 1,
            'unit_price' => 25.50,
            'total_price' => 25.50,
            'file' => null,
            'additional_information' => null,
            'warranty_until' => null,
        ]);

        Expense::create([
            'created_user_id' => 4,
            'expense_name' => 'Some Food',
            'expense_date' => '2024-09-14',
            'expense_category_id' => 4,
            'account_id' => 4,
            'count' => 1,
            'unit_price' => 30.50,
            'total_price' => 30.50,
            'file' => null,
            'additional_information' => null,
            'warranty_until' => null,
        ]);

        Expense::create([
            'created_user_id' => 4,
            'expense_name' => 'Some Food',
            'expense_date' => '2024-09-14',
            'expense_category_id' => 4,
            'account_id' => 4,
            'count' => 1,
            'unit_price' => 30.50,
            'total_price' => 30.50,
            'file' => null,
            'additional_information' => null,
            'warranty_until' => null,
        ]);

        Expense::create([
            'created_user_id' => 1,
            'expense_name' => 'Some Food shared',
            'expense_date' => '2024-09-07',
            'expense_category_id' => 4,
            'account_id' => 5,
            'count' => 1,
            'unit_price' => 31.50,
            'total_price' => 31.50,
            'file' => null,
            'additional_information' => null,
            'warranty_until' => null,
        ]);

        Expense::create([
            'created_user_id' => 1,
            'expense_name' => 'Some Food shared',
            'expense_date' => '2024-09-08',
            'expense_category_id' => 4,
            'account_id' => 5,
            'count' => 1,
            'unit_price' => 35.50,
            'total_price' => 35.50,
            'file' => null,
            'additional_information' => null,
            'warranty_until' => null,
        ]);
    }
}

<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        $this->call([
            UserSeeder::class,
            AccountSeeder::class,
            RoleSeeder::class,
            PermissionSeeder::class,
            UserAccountRoleSeeder::class,
            UserAccountPermissionSeeder::class,
            ExpenseCategorySeeder::class,
            IncomeCategorySeeder::class,
            IncomeSeeder::class,
            ExpenseSeeder::class,

        ]);
    }
}

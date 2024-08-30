<?php

namespace Database\Seeders;

use App\Models\Account;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AccountSeeder extends Seeder
{
    public function run()
    {
        Account::create([
            'name' => 'Main Account',
            'account_number'=>'LV45HABA1234567891012',
            'created_user_id' => 1,
            'account_owner_id' => 1,
        ]);

        Account::create([
            'name' => 'Savings Account',
            'account_number'=>'LV45HABA1234567891014',
            'created_user_id' => 2,
            'account_owner_id' => 2,
        ]);
    }
}

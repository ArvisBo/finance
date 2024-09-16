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
            'name' => 'Main Account Arvis',
            'account_number'=>'LV45HABA1234567891012',
            'created_user_id' => 1,
            'account_owner_id' => 1,
        ]);

        Account::create([
            'name' => 'Savings Account Kintija',
            'account_number'=>'LV45HABA1234567891014',
            'created_user_id' => 2,
            'account_owner_id' => 2,
        ]);

        Account::create([
            'name' => 'Savings Account testadmin',
            'account_number'=>'LV45HABA1234567891999',
            'created_user_id' => 3,
            'account_owner_id' => 3,
        ]);

        Account::create([
            'name' => 'Main Account Test user',
            'account_number'=>'LV45HABA1234567892999',
            'created_user_id' => 4,
            'account_owner_id' => 4,
        ]);

        Account::create([
            'name' => 'Savings Account Arvis',
            'account_number'=>'LV45HABA1234567891030',
            'created_user_id' => 1,
            'account_owner_id' => 1,
        ]);
    }
}

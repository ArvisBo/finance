<?php

namespace Database\Seeders;

use App\Models\User_account_role;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserAccountRoleSeeder extends Seeder
{
    public function run()
    {
        User_account_role::create([
            'user_id' => 1,
            'account_id' => 1,
            'role_id' => 1,
        ]);

        User_account_role::create([
            'user_id' => 2,
            'account_id' => 2,
            'role_id' => 2,
        ]);
    }
}

<?php

namespace Database\Seeders;

use App\Models\UserAccountRole;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserAccountRoleSeeder extends Seeder
{
    public function run()
    {
        UserAccountRole::create([
            'user_id' => 1,
            'account_id' => 1,
            'role_id' => 1,
        ]);

        UserAccountRole::create([
            'user_id' => 2,
            'account_id' => 2,
            'role_id' => 2,
        ]);
    }
}

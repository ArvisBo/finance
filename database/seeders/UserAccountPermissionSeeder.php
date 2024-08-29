<?php

namespace Database\Seeders;

use App\Models\User_account_permission;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserAccountPermissionSeeder extends Seeder
{
    public function run()
    {
        User_account_permission::create([
            'user_id' => 1,
            'account_id' => 1,
            'permission_id' => 1,
        ]);

        User_account_permission::create([
            'user_id' => 2,
            'account_id' => 2,
            'permission_id' => 2,
        ]);
    }
}

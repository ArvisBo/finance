<?php

namespace Database\Seeders;

use App\Models\UserAccountPermission;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserAccountPermissionSeeder extends Seeder
{
    public function run()
    {
        UserAccountPermission::create([
            'user_id' => 1,
            'account_id' => 1,
            'permission_id' => 1,
        ]);

        UserAccountPermission::create([
            'user_id' => 2,
            'account_id' => 2,
            'permission_id' => 2,
        ]);
    }
}

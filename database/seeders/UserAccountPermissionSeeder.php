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
            'user_id' => 4,
            'account_id' => 5,
            'permission_id' => 1,
        ]);
    }
}

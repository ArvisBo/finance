<?php

namespace Database\Seeders;

use App\Models\Permission;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PermissionSeeder extends Seeder
{
    public function run()
    {
        Permission::create(['name' => 'view_accounts']);
        Permission::create(['name' => 'manage_accounts']);
    }
}

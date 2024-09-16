<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run()
    {
        User::create([
            'name' => 'Arvis',
            'surname' => 'Arvis',
            'email' => 'avatars8@protonmail.com',
            'password' => Hash::make('Parole123!'),
            'is_admin' => true,
            'default_account_id' => null,
        ]);

        User::create([
            'name' => 'Kintija',
            'surname' => 'Kintija',
            'email' => 'kintija@local.com',
            'password' => Hash::make('Parole123!'),
            'is_admin' => false,
            'default_account_id' => null,
        ]);

        User::create([
            'name' => 'Test',
            'surname' => 'Admin',
            'email' => 'test_admin@local.local',
            'password' => Hash::make('Parole123!'),
            'is_admin' => true,
            'default_account_id' => null,
        ]);

        User::create([
            'name' => 'Test',
            'surname' => 'User',
            'email' => 'test_user@local.local',
            'password' => Hash::make('Parole123!'),
            'is_admin' => false,
            'default_account_id' => null,
        ]);
    }
}

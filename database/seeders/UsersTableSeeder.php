<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('users')->insert([
            [
                'name' => 'Arvis',
                'surname' => 'Test',
                'email' => 'avatars8@protonmail.com',
                'password' => Hash::make('Parole123!'),
                'email_verified_at' => '2024-08-01',
                'is_admin' => '1',
            ],
            [
                'name' => 'Kintija',
                'surname' => 'Test2',
                'email' => 'arvis@test.local',
                'password' => Hash::make('Parole123!'),
                'email_verified_at' => '2024-08-05',
                'is_admin' => '0',
            ],
            // Add more user records here
        ]);

    }
}

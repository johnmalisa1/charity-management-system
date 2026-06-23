<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UsersTableSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('users')->insert([
            [
                'name' => 'Admin User',
                'email' => 'admin@example.com',
                'password' => Hash::make('password'),
                'role_id' => 1, // Admin
            ],
            [
                'name' => 'Manager User',
                'email' => 'manager@example.com',
                'password' => Hash::make('password'),
                'role_id' => 2, // Manager
            ],
            [
                'name' => 'Donor User',
                'email' => 'donor@example.com',
                'password' => Hash::make('password'),
                'role_id' => 3, // Donor
            ],
            [
                'name' => 'Volunteer User',
                'email' => 'volunteer@example.com',
                'password' => Hash::make('password'),
                'role_id' => 4, // Volunteer
            ],
        ]);
    }
}


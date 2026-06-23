<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RolesTableSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('roles')->insert([
            ['name' => 'Admin', 'description' => 'System administrator'],
            ['name' => 'Manager', 'description' => 'Charity manager'],
            ['name' => 'Donor', 'description' => 'Charity donor'],
            ['name' => 'Volunteer', 'description' => 'Charity volunteer'],
        ]);
    }
}


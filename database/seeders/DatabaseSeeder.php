<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Setting;
use Spatie\Permission\Models\Role;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Create roles using Spatie (safe if already exist)
        $adminRole = Role::firstOrCreate(['name' => 'Admin']);
        $managerRole = Role::firstOrCreate(['name' => 'Manager']);
        $donorRole = Role::firstOrCreate(['name' => 'Donor']);
        $volunteerRole = Role::firstOrCreate(['name' => 'Volunteer']);

        // Create demo users and assign roles
        $admin = User::create([
            'name' => 'Admin User',
            'email' => 'admin@example.com',
            'password' => Hash::make('password'),
        ]);
        $admin->assignRole($adminRole);

        $manager = User::create([
            'name' => 'Manager User',
            'email' => 'manager@example.com',
            'password' => Hash::make('password'),
        ]);
        $manager->assignRole($managerRole);

        $donor = User::create([
            'name' => 'Donor User',
            'email' => 'donor@example.com',
            'password' => Hash::make('password'),
        ]);
        $donor->assignRole($donorRole);

        $volunteer = User::create([
            'name' => 'Volunteer User',
            'email' => 'volunteer@example.com',
            'password' => Hash::make('password'),
        ]);
        $volunteer->assignRole($volunteerRole);

        // Bulk role-based test users
        User::factory()->count(3)->admin()->create();
        User::factory()->count(5)->manager()->create();
        User::factory()->count(10)->donor()->create();
        User::factory()->count(7)->volunteer()->create();

        // Register additional seeders for sample data
        $this->call([
            CharitySeeder::class,
            CampaignSeeder::class,
            DonationSeeder::class,
            VolunteerActivitySeeder::class,
            EventSeeder::class, // ✅ Added here
        ]);

        // --- Default Settings Seeder ---
        $defaults = [
            'site_name' => 'Charity Management System',
            'timezone'  => 'Africa/Dar_es_Salaam',
            'currency'  => 'USD',
        ];

        foreach ($defaults as $key => $value) {
            Setting::updateOrCreate(['key' => $key], ['value' => $value]);
        }
    }
}







<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Donation;

class DonationSeeder extends Seeder
{
    public function run()
    {
        // Create donations across months
        for ($i = 1; $i <= 6; $i++) {
            Donation::factory()->create([
                'amount' => rand(100, 2000),
                'created_at' => now()->subMonths(6 - $i),
            ]);
        }
    }
}


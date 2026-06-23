<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Campaign;
use App\Models\Charity;

class CampaignSeeder extends Seeder
{
    public function run()
    {
        // Ensure charities exist
        $charities = Charity::all();
        if ($charities->isEmpty()) {
            $charities = Charity::factory()->count(3)->create();
        }

        // Create campaigns linked to charities
        foreach ($charities as $charity) {
            // Create 2 normal campaigns
            Campaign::factory()->count(2)->create([
                'charity_id' => $charity->id,
                'is_featured' => false,
            ]);

            // Create 1 featured campaign
            Campaign::factory()->create([
                'charity_id' => $charity->id,
                'is_featured' => true,
            ]);
        }
    }
}



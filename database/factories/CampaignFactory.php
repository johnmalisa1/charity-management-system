<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Charity;

class CampaignFactory extends Factory
{
    public function definition(): array
    {
        $goal = $this->faker->numberBetween(500000, 5000000);
        $raised = $this->faker->numberBetween(0, $goal);

        return [
            'charity_id' => Charity::inRandomOrder()->first()?->id 
                ?? Charity::factory()->create()->id,

            // Meaningful campaign titles
            'title' => $this->faker->randomElement([
                'School Supplies Drive',
                'Medical Aid for Children',
                'Food Distribution Campaign',
                'Scholarship Fundraiser',
                'Community Health Outreach',
                'Orphanage Support Program',
                'Clean Water Initiative',
                'Child Nutrition Project',
            ]),

            'description' => $this->faker->sentence(12),

            // Larger, realistic fundraising goals
            'goal_amount' => $goal,
            'raised_amount' => $raised,

            // New: featured flag
            'is_featured' => $this->faker->boolean(30), // ~30% chance featured


            'start_date' => now()->subDays(rand(1, 30)),
            'end_date' => now()->addDays(rand(10, 60)),
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}




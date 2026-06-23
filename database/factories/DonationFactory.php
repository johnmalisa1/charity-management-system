<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Campaign;
use App\Models\User;

class DonationFactory extends Factory
{
    public function definition(): array
    {
        return [
            'campaign_id' => Campaign::inRandomOrder()->first()?->id ?? Campaign::factory()->create()->id,
            'donor_id' => User::whereHas('roles', fn($q) => $q->where('name','Donor'))->inRandomOrder()->first()?->id 
                          ?? User::factory()->create()->id,
            'amount' => $this->faker->numberBetween(50, 2000),
            'created_at' => $this->faker->dateTimeBetween('-6 months', 'now'),
            'updated_at' => now(),
        ];
    }
}



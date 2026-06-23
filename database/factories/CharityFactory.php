<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\User;

class CharityFactory extends Factory
{
    public function definition(): array
    {
        return [
            'name' => $this->faker->company,
            'description' => $this->faker->sentence(10),
            'registration_number' => strtoupper($this->faker->bothify('REG###??')),
            // Assign a random manager user
            'manager_id' => User::whereHas('roles', fn($q) => $q->where('name','Manager'))->inRandomOrder()->first()?->id ?? User::factory()->create()->id,
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}



<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Event;
use App\Models\Charity;

class EventSeeder extends Seeder
{
    public function run(): void
    {
        // Ensure at least one charity exists
        $charity = Charity::first() ?? Charity::factory()->create();

        $events = [
            [
                'title' => 'Community Clean-Up Day',
                'location' => 'Dar es Salaam Beach',
                'start_time' => now()->addDays(5),
                'end_time' => now()->addDays(5)->addHours(3),
                'charity_id' => $charity->id,
            ],
            [
                'title' => 'Health Awareness Workshop',
                'location' => 'City Hall Conference Room',
                'start_time' => now()->addDays(10)->setHour(9),
                'end_time' => now()->addDays(10)->setHour(12),
                'charity_id' => $charity->id,
            ],
            [
                'title' => 'Charity Fun Run',
                'location' => 'Uhuru Stadium',
                'start_time' => now()->addDays(20)->setHour(7),
                'end_time' => now()->addDays(20)->setHour(11),
                'charity_id' => $charity->id,
            ],
        ];

        foreach ($events as $event) {
            Event::create($event);
        }
    }
}




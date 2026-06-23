<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\VolunteerActivity;

class VolunteerActivitySeeder extends Seeder
{
    public function run(): void
    {
        // Pick a few users (adjust IDs to match your DB)
        $users = User::take(3)->get();

        foreach ($users as $user) {
            VolunteerActivity::create([
                'user_id' => $user->id,
                'activity_name' => 'Tree Planting',
                'description' => 'Participated in community tree planting initiative.',
                'date' => now()->subDays(10),
            ]);

            VolunteerActivity::create([
                'user_id' => $user->id,
                'activity_name' => 'Food Distribution',
                'description' => 'Helped distribute food to families in need.',
                'date' => now()->subDays(5),
            ]);
        }
    }
}


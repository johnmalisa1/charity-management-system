<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Charity;

class CharitySeeder extends Seeder
{
    public function run()
    {
        Charity::factory()->count(5)->create();
    }
}


<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Team; // Make sure to include your Team model

class TeamSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Define the team names
        $teams = [
            ['name' => 'Wakty Team'],
            ['name' => 'Dev Team'],
            ['name' => 'PM Team'],
        ];

        // Insert the teams into the database
        foreach ($teams as $team) {
            Team::create($team);
        }
    }
}

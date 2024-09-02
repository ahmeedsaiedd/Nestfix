<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Status; // Ensure to include your Status model

class StatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Define the status names
        $statuses = [
            ['name' => 'Open'],
            ['name' => 'In Progress'],
            ['name' => 'Solved'],
            ['name' => 'Done'],
            ['name' => 'Closed'],
        ];

        // Insert the statuses into the database
        foreach ($statuses as $status) {
            Status::create($status);
        }
    }
}

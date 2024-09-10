<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User; // Adjust this if your user model is in a different namespace

class AdminSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'name' => 'admin',
            'email' => 'Wakty.ticketing@ebetech.com.eg',
            'password' => Hash::make('WT78*&ijn'),
            'role' => 'admin',
        ]);
    }
}

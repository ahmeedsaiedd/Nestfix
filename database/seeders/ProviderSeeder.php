<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Provider; // Ensure the Provider model is imported

class ProviderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Define the providers to be seeded
        $providers = [
            ['name' => 'ممكن'],
            ['name' => 'سداد'],
            ['name' => 'ضامن'],
            ['name' => 'ماجيك'],
            ['name' => 'خدماتي'],
            ['name' => 'تضامن'],
            ['name' => 'E-Khales'],
            ['name' => 'سيدات اعمال المستقبل'],
            ['name' => 'وان كارد'],
        ];

        // Insert providers into the database
        foreach ($providers as $provider) {
            Provider::create($provider);
        }
    }
}

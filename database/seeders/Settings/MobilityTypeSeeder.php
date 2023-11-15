<?php

namespace Database\Seeders\Settings;

use App\Models\Settings\MobilityType;
use Illuminate\Database\Seeder;

class MobilityTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $mobility_types = [
            ['mobility_type_name' => 'Aucune', 'mobility_type_is_active' => 1],
            ['mobility_type_name' => 'Horizontale', 'mobility_type_is_active' => 1],
            ['mobility_type_name' => 'Verticale', 'mobility_type_is_active' => 1],
            ['mobility_type_name' => 'Géographique', 'mobility_type_is_active' => 1],
            ['mobility_type_name' => 'Reconversion', 'mobility_type_is_active' => 1]
        ];

        foreach ($mobility_types as $mobility_type) {
            MobilityType::create($mobility_type);
        }
    }
}

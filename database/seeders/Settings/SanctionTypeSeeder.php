<?php

namespace Database\Seeders\Settings;

use App\Models\Settings\SanctionType;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SanctionTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $sanction_types = [
            ['sanction_type_name' => 'Avertissement'],
            ['sanction_type_name' => 'Mis á Pied 1 à 3 jours'],
            ['sanction_type_name' => 'Mis á Pied 4 á 8 jours']
        ];

        foreach ($sanction_types as $sanction_type) {
            SanctionType::create($sanction_type);
        }
    }
}

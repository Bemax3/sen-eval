<?php

namespace Database\Seeders\Settings;

use App\Models\Settings\ClaimType;
use Illuminate\Database\Seeder;

class ClaimTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $claim_types = [
            ['claim_type_name' => 'Aucune'],
            ['claim_type_name' => 'Problème d\'organisation'],
            ['claim_type_name' => 'Problème de formation'],
            ['claim_type_name' => 'Problème de carrière'],
            ['claim_type_name' => 'Problème de moyen'],
            ['claim_type_name' => 'Problème d\'effectif'],
            ['claim_type_name' => 'Problème de motivation'],
            ['claim_type_name' => 'Contestation de l\'évaluation des performances'],
        ];

        foreach ($claim_types as $claim_type) {
            ClaimType::create($claim_type);
        }
    }
}

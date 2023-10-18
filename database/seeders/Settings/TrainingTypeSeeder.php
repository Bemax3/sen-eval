<?php

namespace Database\Seeders\Settings;

use App\Models\Settings\TrainingType;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TrainingTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $training_types = [
            ['training_type_name' => 'Informatique'],
            ['training_type_name' => 'Finances et Comptabilité'],
            ['training_type_name' => 'Audit et Contrôle'],
            ['training_type_name' => 'Management et Leadership'],
            ['training_type_name' => 'Développement Personnel'],
            ['training_type_name' => 'Administration'],
            ['training_type_name' => 'Langue'],
            ['training_type_name' => 'Electricité'],
            ['training_type_name' => 'Métrologie'],
            ['training_type_name' => 'Maintenance'],
            ['training_type_name' => 'Marketing'],
            ['training_type_name' => 'Benchmarking'],
            ['training_type_name' => 'Communication'],
            ['training_type_name' => 'Qualité'],
            ['training_type_name' => 'Gestion'],
            ['training_type_name' => 'Logistique'],
            ['training_type_name' => 'Conduite'],
            ['training_type_name' => 'Passation de Marché'],
            ['training_type_name' => 'Formation Continue'],
        ];

        foreach ($training_types as $training_type) {
            TrainingType::create($training_type);
        }
    }
}

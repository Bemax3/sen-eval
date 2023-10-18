<?php

namespace Database\Seeders\Settings;

use App\Models\Settings\SkillType;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SkillTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $skill_types = [
            ['skill_type_name' => 'Compétences Spécifiques'],
            ['skill_type_name' => 'Compétences Générales'],
        ];

        foreach ($skill_types as $skill_type) {
            SkillType::create($skill_type);
        }
    }
}

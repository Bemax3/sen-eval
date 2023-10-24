<?php

namespace Database\Seeders\Settings;


use App\Models\Settings\Skill;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SkillSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $skill_types = [
            [
                'skill_name' => 'Savoir',
                'skill_marking' => 5,
                'skill_desc' => '',
                'skill_type_id' => 1
            ],
            [
                'skill_name' => 'Savoir Être',
                'skill_marking' => 5,
                'skill_desc' => '',
                'skill_type_id' => 1
            ],
            [
                'skill_name' => 'Savoir Faire',
                'skill_marking' => 5,
                'skill_desc' => '',
                'skill_type_id' => 1
            ],
            [
                'skill_name' => 'Management',
                'skill_marking' => 15,
                'skill_desc' => 'Communication, Leadership, Organisation, Planification, Motivation, Délégation, Evaluation, Résolution de problèmes, Innovation, Persuasion',
                'skill_type_id' => 2,
            ],
            [
                'skill_name' => 'Gestion des ressources financières et matérielles',
                'skill_marking' => 10,
                'skill_desc' => 'Optimisation et Efficience',
                'skill_type_id' => 2,
            ],
            [
                'skill_name' => 'Engagement',
                'skill_marking' => 5,
                'skill_desc' => 'Respect des valeurs éthiques et du règlement intérieur, Ponctualité, Assiduité',
                'skill_type_id' => 2,
            ],
            [
                'skill_name' => 'Disponibilité',
                'skill_marking' => 10,
                'skill_desc' => 'Respect des dispositions internes et du règlement intérieur, Ponctualité, Assiduité',
                'skill_type_id' => 2,
            ],
             [
                'skill_name' => 'Relation Humaines',
                 'skill_marking' => 5,
                'skill_desc' => 'Ouverture d\'esprit, Esprit d\'équipe, Convivialité, Communication, Persuasion',
                'skill_type_id' => 2,
            ],
            [
                'skill_name' => 'Esprit d\'organisation',
                'skill_marking' => 5,
                'skill_desc' => 'Gestion efficiente du temps, du matériel et des moyens de travail',
                'skill_type_id' => 2,
            ],
            [
                'skill_name' => 'Initiative',
                'skill_marking' => 5,
                'skill_desc' => 'Créativité',
                'skill_type_id' => 2,
            ],
            [
                'skill_name' => 'Prévention - Sécurité',
                'skill_marking' => 5,
                'skill_desc' => 'Esprit et attitude sécurisants',
                'skill_type_id' => 2,
            ],
        ];

        foreach ($skill_types as $skill_type) {
            Skill::create($skill_type);
        }
    }
}

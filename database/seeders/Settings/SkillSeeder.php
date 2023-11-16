<?php

namespace Database\Seeders\Settings;


use App\Models\Group;
use App\Models\Settings\Skill;
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
                'skill_name' => 'Autre',
                'skill_marking' => 5,
                'skill_desc' => '',
                'skill_type_id' => 1
            ],
            [
                'skill_name' => 'Rigueur et Discrétion',
                'skill_marking' => 5,
                'skill_desc' => '',
                'skill_type_id' => 1,
            ],
            [
                'skill_name' => 'Impartialité et Équité',
                'skill_marking' => 5,
                'skill_desc' => '',
                'skill_type_id' => 1,
            ],
            [
                'skill_name' => 'Créativité et Esprit Innovant',
                'skill_marking' => 5,
                'skill_desc' => '',
                'skill_type_id' => 1,
            ],
            [
                'skill_name' => 'Courtoisie et Convivialité',
                'skill_marking' => 5,
                'skill_desc' => '',
                'skill_type_id' => 1,
            ],
            [
                'skill_name' => 'Moralité et Intégrité',
                'skill_marking' => 5,
                'skill_desc' => '',
                'skill_type_id' => 1,
            ],
            [
                'skill_name' => 'Méthodologie et Organisation',
                'skill_marking' => 5,
                'skill_desc' => '',
                'skill_type_id' => 1,
            ],
            [
                'skill_name' => 'Réactivité et Proactivité',
                'skill_marking' => 5,
                'skill_desc' => '',
                'skill_type_id' => 1,
            ],
            [
                'skill_name' => 'Ouverture d\'ésprit',
                'skill_marking' => 5,
                'skill_desc' => '',
                'skill_type_id' => 1,
            ],
            [
                'skill_name' => 'Discipline',
                'skill_marking' => 5,
                'skill_desc' => '',
                'skill_type_id' => 1,
            ],
            [
                'skill_name' => 'Management',
                'skill_marking' => 15,
                'skill_desc' => 'Communication, Leadership, Organisation, Planification, Motivation, Délégation, Évaluation, Résolution de problèmes, Innovation, Persuasion',
                'skill_type_id' => 2,
                'group_id' => Group::CADRE
            ],
            [
                'skill_name' => 'Gestion des ressources financières et matérielles',
                'skill_marking' => 10,
                'skill_desc' => 'Optimisation et Efficience',
                'skill_type_id' => 2,
                'group_id' => Group::CADRE
            ],
            [
                'skill_name' => 'Engagement',
                'skill_marking' => 5,
                'skill_desc' => 'Respect des valeurs éthiques et du règlement intérieur, Ponctualité, Assiduité',
                'skill_type_id' => 2,
                'group_id' => Group::CADRE
            ],
            [
                'skill_name' => 'Disponibilité',
                'skill_marking' => 10,
                'skill_desc' => 'Respect des dispositions internes et du règlement intérieur, Ponctualité, Assiduité',
                'skill_type_id' => 2,
                'group_id' => Group::MAITRISE
            ],
            [
                'skill_name' => 'Relation Humaines',
                'skill_marking' => 5,
                'skill_desc' => 'Ouverture d\'esprit, Esprit d\'équipe, Convivialité, Communication, Persuasion',
                'skill_type_id' => 2,
                'group_id' => Group::MAITRISE
            ],
            [
                'skill_name' => 'Esprit d\'organisation',
                'skill_marking' => 5,
                'skill_desc' => 'Gestion efficiente du temps, du matériel et des moyens de travail et réactivité',
                'skill_type_id' => 2,
                'group_id' => Group::MAITRISE
            ],
            [
                'skill_name' => 'Initiative',
                'skill_marking' => 5,
                'skill_desc' => 'Créativité',
                'skill_type_id' => 2,
                'group_id' => Group::MAITRISE
            ],
            [
                'skill_name' => 'Prévention - Sécurité',
                'skill_marking' => 5,
                'skill_desc' => 'Esprit et attitude sécurisants',
                'skill_type_id' => 2,
                'group_id' => Group::MAITRISE
            ],
        ];

        foreach ($skill_types as $skill_type) {
            Skill::create($skill_type);
        }
    }
}

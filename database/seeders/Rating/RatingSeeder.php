<?php

namespace Database\Seeders\Rating;

use App\Models\Group;
use App\Models\Phase\Phase;
use App\Models\Phase\PhaseSkill;
use App\Models\Rating\Claim;
use App\Models\Rating\Goal;
use App\Models\Rating\Mobility;
use App\Models\Rating\Promotion;
use App\Models\Rating\Rating;
use App\Models\Rating\RatingSkill;
use App\Models\Rating\Sanction;
use App\Models\Rating\Training;
use App\Models\Rating\Validator;
use App\Models\Settings\ClaimType;
use App\Models\Settings\MobilityType;
use App\Models\Settings\PromotionType;
use App\Models\Settings\SanctionType;
use App\Models\Settings\TrainingType;
use App\Models\User;
use App\Services\Security\UserService;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class RatingSeeder extends Seeder
{
    public function run(): void
    {
        $users = User::all();

        $phases = Phase::all();

        foreach ($users as $user) {
            if (!$user->org_id) continue;
            $possibleN1s = (new UserService())->findSameOrgUsers($user);
            do {
                $possibleN1 = $possibleN1s[rand(0, count($possibleN1s) - 1)]->user_id;
            } while ($possibleN1 == $user->user_id);
            $user->update([
                'n1_id' => $possibleN1
            ]);
        }

        foreach ($users as $user) {
            if (!$user->org_id) continue;
            $operator = $user->isCadre() ? '=' : '!=';
            foreach ($phases as $phase) {
                $skills = PhaseSkill::where('phase_id', '=', $phase->phase_id)->whereRelation('skill', 'group_id', $operator, Group::CADRE)->get();

                $rating = Rating::create([
                    'phase_id' => $phase->phase_id,
                    'evaluated_id' => $user->user_id,
                    'evaluator_id' => $user->n1_id,
                ]);

                $rand1 = rand(0, 1);
                $validation1 = Validator::create([
                    'validator_id' => $rating->evaluated_id,
                    'rating_id' => $rating->rating_id,
                    'has_validated' => $rand1,
                    'rating_validator_comment' => fake()->realText,
                ]);
                if ($rand1) $validation1->update(['validated_at' => Carbon::now()->toDateTimeString()]);

                $rand2 = rand(0, 1);
                $validation2 = Validator::create([
                    'validator_id' => $rating->evaluator_id,
                    'rating_id' => $rating->rating_id,
                    'has_validated' => $rand2,
                    'rating_validator_comment' => fake()->realText,
                ]);
                if ($rand2) $validation2->update(['validated_at' => Carbon::now()->toDateTimeString()]);

                $rand3 = rand(0, 1);
                $validation3 = Validator::create([
                    'validator_id' => $user->n1->n1_id,
                    'rating_id' => $rating->rating_id,
                    'has_validated' => $rand3,
                    'rating_validator_comment' => fake()->realText,
                ]);
                if ($rand3) $validation3->update(['validated_at' => Carbon::now()->toDateTimeString()]);

                if ($rand1 && $rand2 && $rand3) $rating->update(['rating_is_validated' => 1]);

                foreach ($skills as $skill) {
                    $randMark = rand(3, $skill->phase_skill_marking);
                    RatingSkill::create([
                        'rating_id' => $rating->rating_id,
                        'phase_skill_id' => $skill->phase_skill_id,
                        'rating_skill_mark' => $randMark
                    ]);
                    $rating->increment('rating_mark', $randMark);
                }

                $skills = PhaseSkill::where('phase_id', '=', $phase->phase_id)->whereRelation('skill', 'group_id', '=', null)->inRandomOrder()->limit(6)->get();

                foreach ($skills as $skill) {
                    $randMark = rand(3, $skill->phase_skill_marking);
                    RatingSkill::create([
                        'rating_id' => $rating->rating_id,
                        'phase_skill_id' => $skill->phase_skill_id,
                        'rating_skill_mark' => $randMark
                    ]);
                    $rating->increment('rating_mark', $randMark);
                }

                foreach ($phase->periods()->get() as $period) {
                    for ($i = 0; $i < 4; $i++) {
                        $randMark = rand(3, 5);
                        Goal::create([
                            'goal_name' => fake()->sentence,
                            'goal_means_available' => rand(0, 1),
                            'goal_expected_date' => Carbon::createFromDate($phase->phase_year)->addDays(rand(0, 365))->toDateTimeString(),
                            'goal_expected_result' => fake()->realText,
                            'goal_marking' => 5,
                            'goal_rate' => rand(0, 100),
                            'evaluation_period_id' => $period->evaluation_period_id,
                            'phase_id' => $period->phase_id,
                            'goal_is_accepted' => rand(0, 1),
                            'goal_comment' => fake()->realText,
                            'goal_mark' => $randMark,
                            'evaluator_id' => $user->n1_id,
                            'evaluated_id' => $user->user_id
                        ]);
                        $rating->increment('rating_mark', $randMark);
                    }
                }

                $if = rand(0, 1);
                if ($if) Claim::create([
                    'rating_id' => $rating->rating_id,
                    'claim_type_id' => ClaimType::inRandomOrder()->first()->claim_type_id,
                    'rating_claim_comment' => fake()->realText
                ]);

                $if = rand(0, 1);
                if ($if) Mobility::create([
                    'rating_id' => $rating->rating_id,
                    'mobility_type_id' => MobilityType::inRandomOrder()->first()->mobility_type_id,
                    'asked_by' => $user->user_id,
                    'rating_mobility_comment' => fake()->realText,
                    'rating_mobility_title' => fake()->sentence
                ]);

                $if = rand(0, 1);
                if ($if) Mobility::create([
                    'rating_id' => $rating->rating_id,
                    'mobility_type_id' => MobilityType::inRandomOrder()->first()->mobility_type_id,
                    'asked_by' => $user->n1_id,
                    'rating_mobility_comment' => fake()->realText,
                    'rating_mobility_title' => fake()->sentence
                ]);

                $if = rand(0, 1);
                if ($if) Promotion::create([
                    'rating_id' => $rating->rating_id,
                    'promotion_type_id' => PromotionType::inRandomOrder()->first()->promotion_type_id,
                    'rating_promotion_comment' => fake()->realText,
                    'evaluated_is_eligible' => rand(0, 1)
                ]);

                $if = rand(0, 1);
                if ($if) Sanction::create([
                    'rating_id' => $rating->rating_id,
                    'rating_sanction_comment' => fake()->realText,
                    'sanction_type_id' => SanctionType::inRandomOrder()->first()->sanction_type_id
                ]);

                $howMuch = rand(1, 10);

                for ($i = 0; $i <= $howMuch; $i++) {
                    $byted = rand(0, 1);
                    $bytor = rand(0, 1);
                    if (!$bytor && !$byted) continue;
                    Training::create([
                        'rating_id' => $rating->rating_id,
                        'asked_by_evaluated' => $byted === 1 ? 1 : NULL,
                        'asked_by_evaluator' => $bytor === 1 ? 1 : NULL,
                        'evaluated_comment' => $byted ? fake()->realText : '',
                        'evaluator_comment' => $bytor ? fake()->realText : '',
                        'training_type_id' => TrainingType::inRandomOrder()->first()->training_type_id,
                    ]);
                }
            }

        }
    }
}

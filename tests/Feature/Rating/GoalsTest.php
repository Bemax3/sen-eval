<?php

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use function Pest\Laravel\actingAs;
use function Pest\Laravel\assertDatabaseHas;

uses(RefreshDatabase::class);

beforeEach(function () {
    $this->seed([\Database\Seeders\DatabaseSeeder::class]);
    $this->evaluator = User::factory()->create();
    $this->evaluated = User::factory()->create();
    $this->evaluated->update(['n1_id' => $this->evaluator->user_id]);
    $this->phase = \App\Models\Phase\Phase::first();
});


it('Creates a goal', function () {
    actingAs($this->evaluator)->post(route('agent-goals.store', ['agent' => $this->evaluated->user_id]), [
        'goal_id' => 1,
        'goal_name' => 'Objectif 1',
        'goal_expected_result' => 'Valeur Cible 1',
        'goal_expected_date' => Carbon::createFromDate(2023, 1, 1)->toDateTimeString(),
        'goal_means_available' => 1,
        'evaluation_period_id' => $this->phase->periods->first()->evaluation_period_id,
        'goal_marking' => 5,
        'phase_id' => $this->phase->phase_id,
        'evaluator_id' => $this->evaluator->user_id,
        'evaluated_id' => $this->evaluated->user_id,
        'updated_by' => $this->evaluator->user_id
    ]);

    assertDatabaseHas('goals', [
        'goal_id' => 1,
        'goal_name' => 'Objectif 1',
        'goal_expected_result' => 'Valeur Cible 1',
        'goal_expected_date' => Carbon::createFromDate(2023, 1, 1)->toDateTimeString(),
        'goal_means_available' => 1,
        'evaluation_period_id' => $this->phase->periods->first()->evaluation_period_id,
        'goal_marking' => 5,
        'phase_id' => $this->phase->phase_id,
        'evaluator_id' => $this->evaluator->user_id,
        'evaluated_id' => $this->evaluated->user_id,
        'updated_by' => $this->evaluator->user_id
    ]);
});

it('updates a goal', function () {
    actingAs($this->evaluator)->post(route('agent-goals.store', ['agent' => $this->evaluated->user_id]), [
        'goal_id' => 1,
        'goal_name' => 'Objectif 1',
        'goal_expected_result' => 'Valeur Cible 1',
        'goal_expected_date' => Carbon::createFromDate(2023, 1, 1)->toDateTimeString(),
        'goal_means_available' => 1,
        'evaluation_period_id' => $this->phase->periods->first()->evaluation_period_id,
        'goal_marking' => 5,
        'phase_id' => $this->phase->phase_id,
        'evaluator_id' => $this->evaluator->user_id,
        'evaluated_id' => $this->evaluated->user_id,
        'updated_by' => $this->evaluator->user_id
    ]);

    actingAs($this->evaluator)->put(route('agent-goals.update', ['agent' => $this->evaluated->user_id, 'agent_goal' => 1]), [
        'goal_name' => 'Objectif 2',
        'goal_expected_result' => 'Valeur Cible 2',
        'goal_expected_date' => Carbon::createFromDate(2023, 1, 2)->toDateTimeString(),
        'goal_means_available' => 0,
        'evaluation_period_id' => $this->phase->periods->first()->evaluation_period_id,
        'goal_marking' => 10,
        'phase_id' => $this->phase->phase_id,
        'goal_rate' => 15,
        'comment' => 'ok',
        'updated_by' => $this->evaluator->user_id
    ]);

    assertDatabaseHas('goals', [
        'goal_id' => 1,
        'goal_name' => 'Objectif 2',
        'goal_expected_result' => 'Valeur Cible 2',
        'goal_expected_date' => Carbon::createFromDate(2023, 1, 2)->toDateTimeString(),
        'goal_means_available' => 0,
        'evaluation_period_id' => $this->phase->periods->first()->evaluation_period_id,
        'goal_marking' => 10,
        'phase_id' => $this->phase->phase_id,
        'evaluator_id' => $this->evaluator->user_id,
        'evaluated_id' => $this->evaluated->user_id,
        'goal_rate' => 15,
        'updated_by' => $this->evaluator->user_id
    ]);

    assertDatabaseHas('goal_history', [
        'goal_id' => 1,
        'goal_rate' => 15,
        'comment' => 'ok',
        'updated_by' => $this->evaluator->user_id
    ]);

});


it('adds a comment', function () {
    actingAs($this->evaluator)->post(route('agent-goals.store', ['agent' => $this->evaluated->user_id]), [
        'goal_id' => 1,
        'goal_name' => 'Objectif 1',
        'goal_expected_result' => 'Valeur Cible 1',
        'goal_expected_date' => Carbon::createFromDate(2023, 1, 1)->toDateTimeString(),
        'goal_means_available' => 1,
        'evaluation_period_id' => $this->phase->periods->first()->evaluation_period_id,
        'goal_marking' => 5,
        'phase_id' => $this->phase->phase_id,
        'evaluator_id' => $this->evaluator->user_id,
        'evaluated_id' => $this->evaluated->user_id,
        'updated_by' => $this->evaluator->user_id
    ]);

    actingAs($this->evaluated)->put(route('goals.update', ['goal' => 1]), [
        'comment' => 'yes'
    ]);

    assertDatabaseHas('goal_history', [
        'goal_id' => 1,
        'goal_rate' => 0,
        'comment' => 'yes',
        'updated_by' => $this->evaluated->user_id
    ]);

});


it('can\'t create a goal which exceeds the goals marking', function () {
    $validated = [
        'goal_id' => 1,
        'goal_name' => 'Objectif 1',
        'goal_expected_result' => 'Valeur Cible 1',
        'goal_expected_date' => Carbon::createFromDate(2023, 1, 1)->toDateTimeString(),
        'goal_means_available' => 1,
        'evaluation_period_id' => $this->phase->periods->first()->evaluation_period_id,
        'goal_marking' => 41,
        'phase_id' => $this->phase->phase_id,
        'evaluator_id' => $this->evaluator->user_id,
        'evaluated_id' => $this->evaluated->user_id,
        'updated_by' => $this->evaluator->user_id
    ];
    (new \App\Services\Rating\GoalService())->create($validated, $this->evaluated->user_id);


})->throws(\App\Exceptions\Goal\GoalsMarkingExceededException::class);

it('can\'t create a goal when the limit for the period is exceeded', function () {
    for ($i = 1; $i <= 5; $i++) {
        $validated = [
            'goal_id' => $i,
            'goal_name' => 'Objectif ' . $i,
            'goal_expected_result' => 'Valeur Cible ' . $i,
            'goal_expected_date' => Carbon::createFromDate(2023, 1, 1)->toDateTimeString(),
            'goal_means_available' => 1,
            'evaluation_period_id' => $this->phase->periods->first()->evaluation_period_id,
            'goal_marking' => 5,
            'phase_id' => $this->phase->phase_id,
            'evaluator_id' => $this->evaluated->user_id,
            'evaluated_id' => $this->evaluated->user_id,
            'updated_by' => $this->evaluated->user_id
        ];
        actingAs($this->evaluator);
        (new \App\Services\Rating\GoalService())->create($validated, $this->evaluated->user_id);
    }


})->throws(\App\Exceptions\Goal\PeriodGoalsCountLimitReachedException::class);

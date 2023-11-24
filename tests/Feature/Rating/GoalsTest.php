<?php

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use function Pest\Laravel\actingAs;
use function Pest\Laravel\assertDatabaseHas;

uses(RefreshDatabase::class);

beforeEach(function () {
    $this->seed([\Database\Seeders\GroupSeeder::class, \Database\Seeders\RoleSeeder::class, \Database\Seeders\DatabaseSeeder::class]);
    $this->evaluator = User::factory()->create();
    $this->evaluated = User::factory()->create();
    $this->evaluated->update(['n1_id' => $this->evaluator->user_id]);
    $this->phase = \App\Models\Phase\Phase::first();
});


it('Creates a goal', function () {
    actingAs($this->evaluator)->post(route('agent-goals.store', ['agent' => $this->evaluated->user_id]), [
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

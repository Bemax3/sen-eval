<?php

use App\Models\Phase\Phase;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use function Pest\Laravel\actingAs;
use function Pest\Laravel\assertDatabaseHas;

uses(RefreshDatabase::class);

beforeEach(function () {
    $this->seed([\Database\Seeders\DatabaseSeeder::class]);
    $this->evaluator = User::factory()->create();
    $this->evaluated = User::factory()->create();
    $this->evaluated->update(['n1_id' => $this->evaluator->user_id]);
    $this->phase = Phase::first();
});


it('Creates an evaluation', function () {
    actingAs($this->evaluator)->post(route('agent-ratings.store', ['agent' => $this->evaluated->user_id]), [
        'evaluated_id' => $this->evaluated->user_id,
        'evaluator_id' => $this->evaluator->user_id,
        'phase_id' => $this->phase->phase_id,
    ]);

    assertDatabaseHas('ratings', [
        'evaluator_id' => $this->evaluator->user_id,
        'evaluated_id' => $this->evaluated->user_id,
        'phase_id' => $this->phase->phase_id
    ]);

    assertDatabaseHas('rating_validators', [
        'validator_id' => $this->evaluator->user_id,
    ]);

    assertDatabaseHas('rating_validators', [
        'validator_id' => $this->evaluated->user_id,
    ]);

});


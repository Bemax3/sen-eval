<?php

use App\Models\Settings\SkillType;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use function Pest\Laravel\actingAs;
use function Pest\Laravel\assertDatabaseHas;
use function Pest\Laravel\assertDatabaseMissing;

uses(RefreshDatabase::class);

beforeEach(function () {
    $this->seed([\Database\Seeders\DatabaseSeeder::class]);
    $this->user = User::factory()->create(['role_id' => 1]);
});


it('Shows validation errors when creating a SkillTypes Type', function (string $name, string $desc, int $marking) {
    actingAs($this->user)->post(route('skillTypes.store'), [
        'skill_type_name' => $name,
        'skill_type_marking' => $marking,
        'skill_type_desc' => $desc
    ])->assertSessionHasErrors(['skill_type_name', 'skill_type_marking']);
})->with([
    ['', '', 0],
    ['', 'Test', 0],
]);

it('Creates a new type', function (string $name, string $desc, int $marking) {
    actingAs($this->user)->post(route('skillTypes.store'), [
        'skill_type_name' => $name,
        'skill_type_marking' => $marking,
        'skill_type_desc' => $desc
    ]);

    assertDatabaseHas('skill_types', [
        'skill_type_name' => $name,
        'skill_type_marking' => $marking,
        'skill_type_desc' => $desc
    ]);
})->with([
    ['Design', 'Test Design', 5],
]);

it('Updates a type', function () {
    $type = SkillType::create(['skill_type_name' => 'Info', 'skill_type_desc' => 'Test Info', 'skill_type_marking' => 5]);
    actingAs($this->user)->put(route('skillTypes.update', ['skillType' => $type->skill_type_id]), [
        'skill_type_name' => 'Design',
        'skill_type_marking' => 10,
        'skill_type_desc' => 'Test Design'
    ]);
    assertDatabaseHas('skill_types', [
        'skill_type_id' => $type->skill_type_id,
        'skill_type_marking' => 10,
        'skill_type_name' => 'Design',
        'skill_type_desc' => 'Test Design'
    ]);
});

it('Deletes a type', function () {
    $type = SkillType::create(['skill_type_name' => 'Info', 'skill_type_desc' => 'Test Info', 'skill_type_marking' => 5]);

    actingAs($this->user)
        ->delete(route('skillTypes.destroy', ['skillType' => $type->skill_type_id]));

    assertDatabaseMissing('skill_types', [
        'skill_type_id' => $type->skill_type_id,
    ]);
});

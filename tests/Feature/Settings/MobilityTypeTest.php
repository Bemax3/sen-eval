<?php

use App\Models\Settings\MobilityType;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use function Pest\Laravel\actingAs;
use function Pest\Laravel\assertDatabaseHas;
use function Pest\Laravel\assertDatabaseMissing;

uses(RefreshDatabase::class);

beforeEach(function () {
    $this->seed([\Database\Seeders\GroupSeeder::class, \Database\Seeders\RoleSeeder::class]);
    $this->user = User::factory()->create();
});


it('Shows validation errors when creating a Mobility Type', function (string $name, string $desc) {
    actingAs($this->user)->post(route('mobilityTypes.store'), [
        'mobility_type_name' => $name,
        'mobility_type_desc' => $desc
    ])->assertSessionHasErrors(['mobility_type_name']);
})->with([
    ['', ''],
    ['', 'Test']
]);

it('Creates a new type', function (string $name, string $desc) {
    actingAs($this->user)->post(route('mobilityTypes.store'), [
        'mobility_type_name' => $name,
        'mobility_type_desc' => $desc
    ])->assertRedirect(route('mobilityTypes.create'));

    assertDatabaseHas('mobility_types', [
        'mobility_type_id' => 1,
        'mobility_type_name' => $name,
        'mobility_type_desc' => $desc
    ]);
})->with([
    ['Design', 'Test Design'],
]);

it('Updates a type', function () {
    $type = MobilityType::create(['mobility_type_name' => 'Info', 'mobility_type_desc' => 'Test Info']);
    actingAs($this->user)->put(route('mobilityTypes.update', ['mobilityType' => $type->mobility_type_id]), [
        'mobility_type_name' => 'Design',
        'mobility_type_desc' => 'Test Design'
    ]);
    assertDatabaseHas('mobility_types', [
        'mobility_type_id' => $type->mobility_type_id,
        'mobility_type_name' => 'Design',
        'mobility_type_desc' => 'Test Design'
    ]);
});

it('Deletes a type', function () {
    $type = MobilityType::create(['mobility_type_name' => 'Info', 'mobility_type_desc' => 'Test Info']);

    actingAs($this->user)
        ->delete(route('mobilityTypes.destroy', ['mobilityType' => $type->mobility_type_id]));

    assertDatabaseMissing('mobility_types', [
        'mobility_type_id' => $type->mobility_type_id,
    ]);
});

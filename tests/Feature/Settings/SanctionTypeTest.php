<?php

use App\Models\Settings\SanctionType;
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


it('Shows validation errors when creating a Sanction Type', function (string $name, string $desc) {
    actingAs($this->user)->post(route('sanctionTypes.store'), [
        'sanction_type_name' => $name,
        'sanction_type_desc' => $desc
    ])->assertSessionHasErrors(['sanction_type_name']);
})->with([
    ['', ''],
    ['', 'Test']
]);

it('Creates a new type', function (string $name, string $desc) {
    actingAs($this->user)->post(route('sanctionTypes.store'), [
        'sanction_type_name' => $name,
        'sanction_type_desc' => $desc
    ]);

    assertDatabaseHas('sanction_types', [
        'sanction_type_name' => $name,
        'sanction_type_desc' => $desc
    ]);
})->with([
    ['Design', 'Test Design'],
]);

it('Updates a type', function () {
    $type = SanctionType::create(['sanction_type_name' => 'Info', 'sanction_type_desc' => 'Test Info']);
    actingAs($this->user)->put(route('sanctionTypes.update', ['sanctionType' => $type->sanction_type_id]), [
        'sanction_type_name' => 'Design',
        'sanction_type_desc' => 'Test Design'
    ]);
    assertDatabaseHas('sanction_types', [
        'sanction_type_id' => $type->sanction_type_id,
        'sanction_type_name' => 'Design',
        'sanction_type_desc' => 'Test Design'
    ]);
});

it('Deletes a type', function () {
    $type = SanctionType::create(['sanction_type_name' => 'Info', 'sanction_type_desc' => 'Test Info']);

    actingAs($this->user)
        ->delete(route('sanctionTypes.destroy', ['sanctionType' => $type->sanction_type_id]));

    assertDatabaseMissing('sanction_types', [
        'sanction_type_id' => $type->sanction_type_id,
    ]);
});

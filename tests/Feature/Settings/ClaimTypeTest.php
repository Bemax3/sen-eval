<?php
use App\Models\Role;
use App\Models\Settings\ClaimType;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use function Pest\Laravel\actingAs;
use function Pest\Laravel\assertDatabaseHas;
use function Pest\Laravel\assertDatabaseMissing;

uses(RefreshDatabase::class);

beforeEach(function () {
    Role::factory()->create();
    $this->user = User::factory()->create();
});


it('Shows validation errors when creating a Claim Type', function (string $name, string $desc) {
    actingAs($this->user)->post(route('claimTypes.store'),[
        'claim_type_name' => $name,
        'claim_type_desc' => $desc
    ])->assertSessionHasErrors(['claim_type_name']);
})->with([
    ['',''],
    ['','Test']
]);

it('Creates a new type',function (string $name, string $desc) {
    actingAs($this->user)->post(route('claimTypes.store'),[
        'claim_type_name' => $name,
        'claim_type_desc' => $desc
    ])->assertRedirect(route('claimTypes.create'));

    assertDatabaseHas('claim_types',[
        'claim_type_id' => 1,
        'claim_type_name' => $name,
        'claim_type_desc' => $desc
    ]);
})->with([
    ['Design','Test Design'],
]);

it('Updates a type', function () {
    $type = ClaimType::create(['claim_type_name'=> 'Info','claim_type_desc' => 'Test Info']);
    actingAs($this->user)->put(route('claimTypes.update',['claimType'=>$type->claim_type_id]),[
        'claim_type_name' => 'Design',
        'claim_type_desc' => 'Test Design'
    ]);
    assertDatabaseHas('claim_types',[
        'claim_type_id' => $type->claim_type_id,
        'claim_type_name' => 'Design',
        'claim_type_desc' => 'Test Design'
    ]);
});

it('Deletes a type', function () {
    $type = ClaimType::create(['claim_type_name'=> 'Info','claim_type_desc' => 'Test Info']);

    actingAs($this->user)
        ->delete(route('claimTypes.destroy', ['claimType' => $type->claim_type_id]));

    assertDatabaseMissing('claim_types', [
        'claim_type_id' => $type->claim_type_id,
    ]);
});

<?php
use App\Models\Role;
use App\Models\Settings\TrainingType;
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


it('Shows validation errors when creating a Training Type', function () {
    actingAs($this->user)->post(route('trainingTypes.store'))->assertSessionHasErrors(['training_type_name']);
});

it('Creates a new type',function () {
   actingAs($this->user)->post(route('trainingTypes.store'),[
       'training_type_name' => 'Design',
       'training_type_desc' => 'Test Design'
   ])->assertRedirect(route('trainingTypes.create'));

   assertDatabaseHas('training_types',[
       'training_type_id' => 1,
       'training_type_name' => 'Design',
       'training_type_desc' => 'Test Design'
   ]);
});

it('Updates a type', function () {
    $type = TrainingType::create(['training_type_name'=> 'Info','training_type_desc' => 'Test Info']);
    actingAs($this->user)->put(route('trainingTypes.update',['trainingType'=>$type->training_type_id]),[
        'training_type_name' => 'Design',
        'training_type_desc' => 'Test Design'
    ]);
    assertDatabaseHas('training_types',[
        'training_type_id' => $type->training_type_id,
        'training_type_name' => 'Design',
        'training_type_desc' => 'Test Design'
    ]);
});

it('Deletes a type', function () {
    $type = TrainingType::create(['training_type_name'=> 'Info','training_type_desc' => 'Test Info']);

    actingAs($this->user)
        ->delete(route('trainingTypes.destroy', ['trainingType' => $type->training_type_id]));

    assertDatabaseMissing('training_types', [
        'training_type_id' => $type->training_type_id,
    ]);
});

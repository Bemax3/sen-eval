<?php

namespace Database\Factories;

use App\Models\Role;
use Illuminate\Database\Eloquent\Factories\Factory;

class RoleFactory extends Factory
{
    protected $model = Role::class;

    public function definition(): array
    {
        return [
            'role_name' => 'Root',
            'role_code' => 'root',
            'role_desc' => 'Has access to all the application.'
        ];
    }
}

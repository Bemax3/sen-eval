<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Role::factory()->create([
            'role_id' => 1,
            'role_name' => 'root',
            'role_code' => 'root',
            'role_desc' => 'Has access to all the application.'
        ]);

        Role::factory()->create([
            'role_id' => 2,
            'role_name' => 'admin',
            'role_code' => 'admin',
            'role_desc' => 'Manages the application settings.'
        ]);

        Role::factory()->create([
            'role_id' => 3,
            'role_name' => 'user',
            'role_code' => 'user',
            'role_desc' => 'Default application user.'
        ]);

        Role::factory()->create([
            'role_id' => 4,
            'role_name' => 'viewer',
            'role_code' => 'viewer',
            'role_desc' => 'Able to See The Dashboard Of Organisations'
        ]);


    }
}

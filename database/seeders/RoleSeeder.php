<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Role::factory()->create([
            'role_name' => 'root',
            'role_code' => 'root',
            'role_desc' => 'Has access to all the application.'
        ]);

        Role::factory()->create([
            'role_name' => 'admin',
            'role_code' => 'admin',
            'role_desc' => 'Manages the application settings.'
        ]);

        Role::factory()->create([
            'role_name' => 'user',
            'role_code' => 'user',
            'role_desc' => 'Default application user.'
        ]);

        
    }
}

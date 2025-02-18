<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class RoleSeeder extends Seeder
{
    public function run(): void
    {
        Role::create(['name' => 'practicante']);
        Role::create(['name' => 'coach']);
        Role::create(['name' => 'superadmin']);
    }
}

<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Ejecutar primero el seeder de roles si es necesario
        $this->call([
            RoleSeeder::class,
            UserSeeder::class,
        ]);
    }
}

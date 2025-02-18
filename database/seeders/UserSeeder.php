<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Usuario Practicante
        $practicante = User::create([
            'first_name'       => 'Practicante',
            'second_name'      => 'Demo',
            'first_lastname'   => 'Demo',
            'second_lastname'  => 'User',
            'username'         => 'practicante',
            'email'            => 'practicante@example.com',
            'password'         => 'password', // Se encriptará automáticamente gracias al mutador en el modelo
            'role'             => 'practicante',
        ]);
        $practicante->assignRole('practicante');

        // Usuario Coach
        $coach = User::create([
            'first_name'       => 'Coach',
            'second_name'      => 'Demo',
            'first_lastname'   => 'Demo',
            'second_lastname'  => 'User',
            'username'         => 'coach',
            'email'            => 'coach@example.com',
            'password'         => 'password',
            'role'             => 'coach',
        ]);
        $coach->assignRole('coach');

        // Usuario Superadmin
        $superadmin = User::create([
            'first_name'       => 'Superadmin',
            'second_name'      => 'Demo',
            'first_lastname'   => 'Demo',
            'second_lastname'  => 'User',
            'username'         => 'superadmin',
            'email'            => 'aisor@gmail.com',
            'password'         => 'aisor123',
            'role'             => 'superadmin',
        ]);
        $superadmin->assignRole('superadmin');
    }
}

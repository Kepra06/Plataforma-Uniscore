<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;

class EncryptPassword extends Command
{
    protected $signature = 'password:encrypt {password}';
    protected $description = 'Encripta una contraseña usando Bcrypt';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        $password = $this->argument('password');
        $hashedPassword = Hash::make($password);

        $this->info('Contraseña encriptada:');
        $this->info($hashedPassword);
    }
}

@extends('layouts.app')

@section('content')
<div class="container mx-auto fade-in">
    <div class="bg-white shadow-md rounded-lg p-6 max-w-lg mx-auto">
        <h1 class="text-2xl font-bold mb-6 text-center text-gray-700">Crear nuevo usuario</h1>

        <form method="POST" action="{{ route('users.store') }}">
            @csrf

            <!-- Primer Nombre -->
            <div class="mb-4">
                <label for="first_name" class="block text-sm font-medium text-gray-700">Primer Nombre</label>
                <input type="text" name="first_name" id="first_name" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm" placeholder="Ingresa el primer nombre" value="{{ old('first_name') }}" required>
                @if ($errors->has('first_name'))
                    <span class="text-red-500 text-xs">{{ $errors->first('first_name') }}</span>
                @endif
            </div>

            <!-- Segundo Nombre (opcional) -->
            <div class="mb-4">
                <label for="second_name" class="block text-sm font-medium text-gray-700">Segundo Nombre</label>
                <input type="text" name="second_name" id="second_name" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm" placeholder="Ingresa el segundo nombre" value="{{ old('second_name') }}">
                @if ($errors->has('second_name'))
                    <span class="text-red-500 text-xs">{{ $errors->first('second_name') }}</span>
                @endif
            </div>

            <!-- Primer Apellido -->
            <div class="mb-4">
                <label for="first_lastname" class="block text-sm font-medium text-gray-700">Primer Apellido</label>
                <input type="text" name="first_lastname" id="first_lastname" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm" placeholder="Ingresa el primer apellido" value="{{ old('first_lastname') }}" required>
                @if ($errors->has('first_lastname'))
                    <span class="text-red-500 text-xs">{{ $errors->first('first_lastname') }}</span>
                @endif
            </div>

            <!-- Segundo Apellido (opcional) -->
            <div class="mb-4">
                <label for="second_lastname" class="block text-sm font-medium text-gray-700">Segundo Apellido</label>
                <input type="text" name="second_lastname" id="second_lastname" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm" placeholder="Ingresa el segundo apellido" value="{{ old('second_lastname') }}">
                @if ($errors->has('second_lastname'))
                    <span class="text-red-500 text-xs">{{ $errors->first('second_lastname') }}</span>
                @endif
            </div>

            <!-- Nombre de Usuario -->
            <div class="mb-4">
                <label for="username" class="block text-sm font-medium text-gray-700">Nombre de Usuario</label>
                <input type="text" name="username" id="username" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm" placeholder="Ingresa el nombre de usuario" value="{{ old('username') }}" required>
                @if ($errors->has('username'))
                    <span class="text-red-500 text-xs">{{ $errors->first('username') }}</span>
                @endif
            </div>

            <!-- Correo Electrónico -->
            <div class="mb-4">
                <label for="email" class="block text-sm font-medium text-gray-700">Correo Electrónico</label>
                <input type="email" name="email" id="email" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm" placeholder="Ingresa el correo electrónico" value="{{ old('email') }}" required>
                @if ($errors->has('email'))
                    <span class="text-red-500 text-xs">{{ $errors->first('email') }}</span>
                @endif
            </div>

            <!-- Contraseña -->
            <div class="mb-4">
                <label for="password" class="block text-sm font-medium text-gray-700">Contraseña</label>
                <div class="relative">
                    <input type="password" name="password" id="password" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm" placeholder="Ingresa la contraseña" required>
                    <span toggle="#password" class="absolute right-3 top-3 cursor-pointer toggle-password">
                        <svg class="h-5 w-5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-.1.34-.21.677-.331 1.006"></path>
                        </svg>
                    </span>
                </div>
                @if ($errors->has('password'))
                    <span class="text-red-500 text-xs">{{ $errors->first('password') }}</span>
                @endif
            </div>

            <!-- Confirmar Contraseña -->
            <div class="mb-4">
                <label for="password_confirmation" class="block text-sm font-medium text-gray-700">Confirmar Contraseña</label>
                <input type="password" name="password_confirmation" id="password_confirmation" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm" placeholder="Confirma la contraseña" required>
                @if ($errors->has('password_confirmation'))
                    <span class="text-red-500 text-xs">{{ $errors->first('password_confirmation') }}</span>
                @endif
            </div>

            <!-- Rol -->
            <div class="mb-4">
                <label for="role" class="block text-sm font-medium text-gray-700">Rol</label>
                <select name="role" id="role" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                    <option value="trainee">Practicante</option>
                    <option value="coach">Coach</option>
                    <option value="superadmin">Superadmin</option>
                </select>
                @if ($errors->has('role'))
                    <span class="text-red-500 text-xs">{{ $errors->first('role') }}</span>
                @endif
            </div>
            <!-- Botón de volver -->
            <div class="flex justify-center mb-4">
                <a href="{{ route('users.index') }}" class="bg-gray-200 text-gray-700 py-2 px-4 rounded-md shadow-md hover:bg-gray-300 transition duration-300 flex items-center">
                    <i class="fas fa-arrow-left mr-2"></i> Volver
                </a>
            </div>
            <!-- Botón de Enviar -->
            <div class="flex justify-center mt-6">
                <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                    Crear Usuario
                </button>
            </div>

        </form>
    </div>
</div>
@endsection

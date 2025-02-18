@extends('layouts.app')

@section('content')
<div class="min-h-screen flex items-center justify-center bg-gray-100 px-4 py-8">
    <div class="bg-white shadow-xl rounded-lg p-8 max-w-md w-full">
        <!-- Título principal -->
        <h1 class="text-3xl font-extrabold text-center text-gray-900 mb-6">Detalle del Usuario</h1>

        <!-- Información del usuario -->
        <div class="space-y-4">
            <p class="text-lg"><span class="font-semibold text-gray-800">Primer Nombre:</span> {{ $user->first_name }}</p>
            <p class="text-lg"><span class="font-semibold text-gray-800">Segundo Nombre:</span> {{ $user->second_name }}</p>
            <p class="text-lg"><span class="font-semibold text-gray-800">Primer Apellido:</span> {{ $user->first_lastname }}</p>
            <p class="text-lg"><span class="font-semibold text-gray-800">Segundo Apellido:</span> {{ $user->second_lastname }}</p>
            <p class="text-lg"><span class="font-semibold text-gray-800">Usuario:</span> {{ $user->username }}</p>
            <p class="text-lg"><span class="font-semibold text-gray-800">Email:</span> {{ $user->email }}</p>
            <p class="text-lg"><span class="font-semibold text-gray-800">Rol:</span> {{ ucfirst($user->role) }}</p>
        </div>

        <!-- Botones -->
        <div class="mt-8 flex flex-col sm:flex-row sm:space-x-4 justify-center">
            <a href="{{ route('users.index') }}" class="w-full bg-gray-600 text-white py-2 px-4 rounded-lg shadow-md hover:bg-gray-700 transition duration-300 flex items-center justify-center mb-4 sm:mb-0">
                <i class="fas fa-arrow-left mr-2"></i> Volver
            </a>
            <a href="{{ route('users.edit', $user->id) }}" class="w-full bg-yellow-500 text-white py-2 px-4 rounded-lg shadow-md hover:bg-yellow-600 transition duration-300 flex items-center justify-center">
                <i class="fas fa-edit mr-2"></i> Editar
            </a>
        </div>
    </div>
</div>
@endsection

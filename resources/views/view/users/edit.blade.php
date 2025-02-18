@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 sm:px-6 lg:px-8 py-8 fade-in">
    <div class="relative bg-white shadow-lg rounded-lg p-8 max-w-md sm:max-w-lg mx-auto">

        <!-- Título -->
        <h1 class="text-3xl font-extrabold mb-10 text-center text-gray-900">Editar Usuario</h1>

        <!-- Mensajes de error -->
        @if ($errors->any())
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-6" role="alert">
                <strong class="font-bold">Error:</strong>
                <ul class="mt-2 list-disc pl-5 space-y-1">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <!-- Formulario -->
        <form action="{{ route('users.update', $user->id) }}" method="POST" class="space-y-6">
            @csrf
            @method('PUT')

            <!-- Primer Nombre -->
            <div>
                <label for="first_name" class="block text-gray-700 text-sm font-semibold mb-1">Primer Nombre</label>
                <input type="text" name="first_name" id="first_name" value="{{ old('first_name', $user->first_name) }}" class="appearance-none border border-gray-300 rounded-md w-full py-2 px-4 text-gray-700 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200">
            </div>

            <!-- Segundo Nombre -->
            <div>
                <label for="second_name" class="block text-gray-700 text-sm font-semibold mb-1">Segundo Nombre</label>
                <input type="text" name="second_name" id="second_name" value="{{ old('second_name', $user->second_name) }}" class="appearance-none border border-gray-300 rounded-md w-full py-2 px-4 text-gray-700 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200">
            </div>

            <!-- Primer Apellido -->
            <div>
                <label for="first_lastname" class="block text-gray-700 text-sm font-semibold mb-1">Primer Apellido</label>
                <input type="text" name="first_lastname" id="first_lastname" value="{{ old('first_lastname', $user->first_lastname) }}" class="appearance-none border border-gray-300 rounded-md w-full py-2 px-4 text-gray-700 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200">
            </div>

            <!-- Segundo Apellido -->
            <div>
                <label for="second_lastname" class="block text-gray-700 text-sm font-semibold mb-1">Segundo Apellido</label>
                <input type="text" name="second_lastname" id="second_lastname" value="{{ old('second_lastname', $user->second_lastname) }}" class="appearance-none border border-gray-300 rounded-md w-full py-2 px-4 text-gray-700 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200">
            </div>

            <!-- Usuario -->
            <div>
                <label for="username" class="block text-gray-700 text-sm font-semibold mb-1">Usuario</label>
                <input type="text" name="username" id="username" value="{{ old('username', $user->username) }}" class="appearance-none border border-gray-300 rounded-md w-full py-2 px-4 text-gray-700 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200" required>
            </div>

            <!-- Email -->
            <div>
                <label for="email" class="block text-gray-700 text-sm font-semibold mb-1">Email</label>
                <input type="email" name="email" id="email" value="{{ old('email', $user->email) }}" class="appearance-none border border-gray-300 rounded-md w-full py-2 px-4 text-gray-700 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200" required>
            </div>

            <!-- Rol -->
            <div>
                <label for="role" class="block text-gray-700 text-sm font-semibold mb-1">Rol</label>
                <select name="role" id="role" class="appearance-none border border-gray-300 rounded-md w-full py-2 px-4 bg-white text-gray-700 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200">
                    <option value="student" {{ $user->role == 'student' ? 'selected' : '' }}>Estudiante</option>
                    <option value="docent" {{ $user->role == 'docent' ? 'selected' : '' }}>Docente</option>
                    <option value="superadmin" {{ $user->role == 'superadmin' ? 'selected' : '' }}>SuperAdmin</option>
                </select>
                @if ($errors->has('role'))
                    <span class="text-red-500 text-xs mt-1">{{ $errors->first('role') }}</span>
                @endif
            </div>

            <!-- Botón de volver -->
            <div class="flex justify-center mb-4">
                <a href="{{ route('users.index') }}" class="bg-gray-200 text-gray-700 py-2 px-4 rounded-md shadow-md hover:bg-gray-300 transition duration-300 flex items-center">
                    <i class="fas fa-arrow-left mr-2"></i> Volver
                </a>
            </div>

            <!-- Botón de guardar -->
            <div class="flex justify-center">
                <button type="submit" class="bg-blue-600 text-white py-2 px-6 rounded-md shadow-md hover:bg-blue-700 transition duration-300 flex items-center">
                    <i class="fas fa-save mr-2"></i> Guardar Cambios
                </button>
            </div>
        </form>
    </div>
</div>
@endsection

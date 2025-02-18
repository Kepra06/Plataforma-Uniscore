@extends('layouts.app')

@section('content')
<div class="container mx-auto fade-in">
    <div class="bg-white shadow-md rounded-lg p-6">
        <h1 class="text-3xl font-bold text-gray-700 mb-6">Gestión de Usuarios</h1>

        <!-- Success Message -->
        @if (session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4">
                <strong class="font-bold">¡Éxito!</strong>
                <span class="block sm:inline">{{ session('success') }}</span>
            </div>
        @endif

        <!-- Botón para crear usuario -->
        <div class="mb-4">
            <a href="{{ route('users.create') }}" class="bg-blue-600 text-white py-2 px-4 rounded-md shadow-md hover:bg-blue-700 transition duration-300">
                <i class="fas fa-user-plus mr-2"></i> Crear Usuario
            </a>
        </div>

        <!-- Diseño mobile-first: Tarjetas en pantallas pequeñas -->
        <div class="grid grid-cols-1 gap-6 md:hidden">
            @foreach ($users as $user)
            <div class="bg-white rounded-lg shadow-md p-4 border border-gray-200">
                <div class="flex justify-between items-center mb-4">
                    <h2 class="text-lg font-bold text-gray-700">{{ $user->first_name }} {{ $user->first_lastname }}</h2>
                    <div class="flex space-x-2">
                        <a href="{{ route('users.show', $user->id) }}" class="text-blue-500 hover:text-blue-700"><i class="fas fa-eye"></i></a>
                        <a href="{{ route('users.edit', $user->id) }}" class="text-yellow-500 hover:text-yellow-700"><i class="fas fa-edit"></i></a>
                        <button type="button" class="text-red-500 hover:text-red-700" onclick="openModal({{ $user->id }}, '{{ $user->first_name }}')">
                            <i class="fas fa-trash"></i>
                        </button>
                    </div>
                </div>
                <p><strong>Segundo Nombre:</strong> {{ $user->second_name }}</p>
                <p><strong>Segundo Apellido:</strong> {{ $user->second_lastname }}</p>
                <p><strong>Usuario:</strong> {{ $user->username }}</p>
                <p><strong>Email:</strong> {{ $user->email }}</p>
                <p><strong>Rol:</strong> {{ $user->role }}</p>
            </div>
            @endforeach
        </div>

        <!-- Tabla en pantallas grandes -->
        <div class="hidden md:block">
            <div class="overflow-x-auto">
                <table class="min-w-full bg-white rounded-lg shadow-md">
                    <thead class="bg-gray-200 text-gray-600 uppercase text-sm leading-normal">
                        <tr>
                            <th class="py-3 px-4 text-left">Primer Nombre</th>
                            <th class="py-3 px-4 text-left">Segundo Nombre</th>
                            <th class="py-3 px-4 text-left">Primer Apellido</th>
                            <th class="py-3 px-4 text-left">Segundo Apellido</th>
                            <th class="py-3 px-4 text-left">Usuario</th>
                            <th class="py-3 px-4 text-left">Email</th>
                            <th class="py-3 px-4 text-left">Rol</th>
                            <th class="py-3 px-4 text-center">Acciones</th>
                        </tr>
                    </thead>
                    <tbody class="text-gray-600 text-sm font-light">
                        @foreach ($users as $user)
                        <tr class="border-b border-gray-200 hover:bg-gray-100">
                            <td class="py-3 px-4 text-left">{{ $user->first_name }}</td>
                            <td class="py-3 px-4 text-left">{{ $user->second_name }}</td>
                            <td class="py-3 px-4 text-left">{{ $user->first_lastname }}</td>
                            <td class="py-3 px-4 text-left">{{ $user->second_lastname }}</td>
                            <td class="py-3 px-4 text-left">{{ $user->username }}</td>
                            <td class="py-3 px-4 text-left">{{ $user->email }}</td>
                            <td class="py-3 px-4 text-left">{{ $user->role }}</td>
                            <td class="py-3 px-4 text-center">
                                <a href="{{ route('users.show', $user->id) }}" class="text-blue-500 hover:text-blue-700"><i class="fas fa-eye"></i></a>
                                <a href="{{ route('users.edit', $user->id) }}" class="text-yellow-500 hover:text-yellow-700"><i class="fas fa-edit"></i></a>
                                <button type="button" class="text-red-500 hover:text-red-700" onclick="openModal({{ $user->id }}, '{{ $user->first_name }}')">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Modal for confirmation -->
<div id="deleteModal" class="hidden fixed z-50 inset-0 bg-gray-900 bg-opacity-50 flex items-center justify-center">
    <div class="bg-white rounded-lg shadow-lg p-6 max-w-lg w-full">
        <h2 class="text-xl font-bold mb-4">Eliminar Usuario</h2>
        <p id="modalMessage" class="mb-6">¿Está seguro de que desea eliminar este usuario?</p>
        
        <div class="flex justify-end space-x-4">
            <button id="cancelButton" class="bg-gray-500 text-white px-4 py-2 rounded-md" onclick="closeModal()">Cancelar</button>
            <form id="deleteForm" method="POST">
                @csrf
                @method('DELETE')
                <button type="submit" class="bg-red-600 text-white px-4 py-2 rounded-md">Eliminar</button>
            </form>
        </div>
    </div>
</div>

<script>
    function openModal(userId, userName) {
        document.getElementById('modalMessage').textContent = `¿Está seguro de que desea eliminar a ${userName}?`;
        document.getElementById('deleteForm').action = `/users/${userId}`;
        document.getElementById('deleteModal').classList.remove('hidden');
    }

    function closeModal() {
        document.getElementById('deleteModal').classList.add('hidden');
    }
</script>
@endsection

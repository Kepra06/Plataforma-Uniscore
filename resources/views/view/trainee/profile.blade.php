@extends('layouts.app-master')

@section('title', 'Perfil del Estudiante')

@section('content')
<div class="container mx-auto py-8">
    <h1 class="text-2xl font-bold mb-6 max-w-4xl m-auto">Perfil del Estudiante</h1>
    @if (session('success'))
    <div id="success-message" class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-4 transition-opacity duration-1000 opacity-100 max-w-4xl m-auto">
        <p>{{ session('success') }}</p>
    </div>
    @endif

    <div class="flex gap-4 justify-end max-w-4xl m-auto">
        <!-- Botón para habilitar el modo de edición -->
        <button id="edit-button" class="bg-blue-500 text-white px-4 py-2 mb-6 rounded" onclick="enableEdit()">Editar Perfil</button>
        
        <!-- Botón para cancelar el modo de edición (oculto inicialmente) -->
        <button id="cancel-button" class="bg-red-500 text-white px-4 py-2 mb-6 rounded hidden" onclick="cancelEdit()">Cancelar Edición</button>
    </div>

    <div class="max-w-4xl m-auto">
        <form action="{{ route('profile.update', $data['profile']->user_id) }}" method="POST">
            @csrf
            @method('PUT')
        
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Cada input con su respectivo label -->
                <div>
                    <label for="name" class="block text-gray-700">Nombre</label>
                    <input type="text" id="name" name="name" value="{{ $data['profile']->name }}" class="border border-gray-300 p-2 w-full" disabled>
                </div>
        
                <div>
                    <label for="surname" class="block text-gray-700">Apellido</label>
                    <input type="text" id="surname" name="surname" value="{{ $data['profile']->surname }}" class="border border-gray-300 p-2 w-full" disabled>
                </div>
        
                <div>
                    <label for="position" class="block text-gray-700">Posición</label>
                    <input type="text" id="position" name="position" value="{{ $data['profile']->position }}" class="border border-gray-300 p-2 w-full" disabled>
                </div>
        
                <div>
                    <label for="experience_level" class="block text-gray-700">Nivel de Experiencia</label>
                    <input type="text" id="experience_level" name="experience_level" value="{{ $data['profile']->experience_level }}" class="border border-gray-300 p-2 w-full" disabled>
                </div>
        
                <div>
                    <label for="phone" class="block text-gray-700">Teléfono</label>
                    <input type="text" id="phone" name="phone" value="{{ $data['profile']->phone }}" class="border border-gray-300 p-2 w-full" disabled>
                </div>
            </div>
            
            <!-- Botón de Actualizar (solo visible en modo edición) -->
            <button id="update-button" type="submit" class="bg-green-500 text-white px-4 py-2 rounded hidden w-full mt-4">Actualizar Perfil</button>
        </form>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const successMessage = document.getElementById('success-message');
        if (successMessage) {
            setTimeout(() => {
                successMessage.classList.add('opacity-0');
                setTimeout(() => {
                    successMessage.style.display = 'none';
                }, 1000); // Tiempo para que termine la transición
            }, 2000); // 2000 milisegundos = 2 segundos
        }
    });

    function enableEdit() {
        console.log('Habilitar edición');
        // Habilitar todos los inputs
        document.getElementById('name').disabled = false;
        document.getElementById('surname').disabled = false;
        document.getElementById('position').disabled = false;
        document.getElementById('experience_level').disabled = false;
        document.getElementById('phone').disabled = false;

        // Mostrar botones de actualizar y cancelar
        const updateButton = document.getElementById('update-button');
        const cancelButton = document.getElementById('cancel-button');
        const editButton = document.getElementById('edit-button');

        updateButton.classList.remove('hidden');
        cancelButton.classList.remove('hidden');
        editButton.classList.add('hidden');

        // Deshabilitar botón de edición
        editButton.disabled = true;
    }

    function cancelEdit() {
        // Deshabilitar todos los inputs
        document.getElementById('name').disabled = true;
        document.getElementById('surname').disabled = true;
        document.getElementById('position').disabled = true;
        document.getElementById('experience_level').disabled = true;
        document.getElementById('phone').disabled = true;

        // Ocultar botones de actualizar y cancelar
        document.getElementById('update-button').classList.add('hidden');
        document.getElementById('cancel-button').classList.add('hidden');

        // Habilitar botón de edición
        const editButton = document.getElementById('edit-button');
        editButton.classList.remove('hidden');
        editButton.disabled = false;
    }
</script>
<style>
    .transition-opacity {
        transition: opacity 1s ease-in-out;
    }
</style>
@endsection

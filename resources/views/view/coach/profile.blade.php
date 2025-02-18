@extends('layouts.app')

@section('title', 'Perfil del Coach')

@section('content')
    <div class="container mx-auto py-8">
        <h1 class="text-2xl font-bold mb-6">Perfil del Coach</h1>
        @if (session('success'))
            <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-4">
                <p>{{ session('success') }}</p>
            </div>
        @endif

        <div>
            <form action="{{ route('profile.updateCoach', $data['coach']->user_id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="name" class="block">Nombre</label>
                        <input type="text" id="name" name="name" value="{{ $data['coach']->name }}" class="border p-2 w-full" disabled>
                    </div>

                    <div>
                        <label for="surname" class="block">Apellido</label>
                        <input type="text" id="surname" name="surname" value="{{ $data['coach']->surname }}" class="border p-2 w-full" disabled>
                    </div>

                    <div>
                        <label for="experience" class="block">Experiencia (años)</label>
                        <input type="text" id="experience" name="experience" value="{{ $data['coach']->experience }}" class="border p-2 w-full" disabled>
                    </div>

                    <div>
                        <label for="specialty" class="block">Especialidad</label>
                        <input type="text" id="specialty" name="specialty" value="{{ $data['coach']->specialty }}" class="border p-2 w-full" disabled>
                    </div>

                    <div>
                        <label for="phone" class="block">Teléfono</label>
                        <input type="text" id="phone" name="phone" value="{{ $data['coach']->phone }}" class="border p-2 w-full" disabled>
                    </div>

                    <div>
                        <label for="email" class="block">Correo</label>
                        <input type="email" id="email" name="email" value="{{ $data['coach']->email }}" class="border p-2 w-full" disabled>
                    </div>
                </div>

                <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded mt-4">Actualizar Perfil</button>
            </form>
        </div>
    </div>
@endsection

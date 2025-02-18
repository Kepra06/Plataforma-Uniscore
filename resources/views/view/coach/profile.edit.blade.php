@extends('layouts.app')

@section('content')

<div class="container mt-4">
    <h1>Editar Perfil del Coach</h1>

    <!-- Formulario para editar el perfil del coach -->
    <form action="{{ route('coach.profile.update', ['id' => $coach->id]) }}" method="POST">
        @csrf
        @method('PUT')

        <!-- Campo de nombre -->
        <div class="form-group mb-3">
            <label for="name"><strong>Nombre:</strong></label>
            <input type="text" name="name" id="name" class="form-control" value="{{ old('name', $coach->name) }}" required>
        </div>

        <!-- Campo de apellido -->
        <div class="form-group mb-3">
            <label for="surname"><strong>Apellido:</strong></label>
            <input type="text" name="surname" id="surname" class="form-control" value="{{ old('surname', $coach->surname) }}" required>
        </div>

        <!-- Campo de experiencia -->
        <div class="form-group mb-3">
            <label for="experience"><strong>Años de experiencia:</strong></label>
            <input type="number" name="experience" id="experience" class="form-control" value="{{ old('experience', $coach->experience) }}">
        </div>

        <!-- Campo de especialidad -->
        <div class="form-group mb-3">
            <label for="specialty"><strong>Especialidad:</strong></label>
            <input type="text" name="specialty" id="specialty" class="form-control" value="{{ old('specialty', $coach->specialty) }}">
        </div>

        <!-- Campo de teléfono -->
        <div class="form-group mb-3">
            <label for="phone"><strong>Teléfono:</strong></label>
            <input type="text" name="phone" id="phone" class="form-control" value="{{ old('phone', $coach->phone) }}">
        </div>

        <!-- Campo de email -->
        <div class="form-group mb-3">
            <label for="email"><strong>Email:</strong></label>
            <input type="email" name="email" id="email" class="form-control" value="{{ old('email', $coach->email) }}">
        </div>

        <!-- Botón para guardar los cambios -->
        <button type="submit" class="btn btn-primary">Guardar Cambios</button>
    </form>
</div>

@endsection

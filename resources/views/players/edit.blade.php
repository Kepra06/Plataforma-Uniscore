@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <!-- Encabezado con botón Volver y Título -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <a href="{{ url()->previous() }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Volver
        </a>
        <h1 class="mb-0">
            <i class="fas fa-user-edit me-2"></i> Editar Jugador
        </h1>
    </div>

    <!-- Tarjeta que contiene el formulario -->
    <div class="card shadow-sm">
        <div class="card-body">
            <form action="{{ route('players.update', ['torneoId' => $jugador->equipo->torneo_id, 'equipoId' => $jugador->equipo_id, 'jugadorId' => $jugador->id]) }}" method="POST">
                @csrf
                @method('PUT')

                <!-- Campo: Nombre del Jugador -->
                <div class="mb-3">
                    <label for="name" class="form-label">
                        <i class="fas fa-user me-1"></i> Nombre del Jugador
                    </label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="fas fa-user"></i></span>
                        <input type="text" name="name" id="name" value="{{ $jugador->name }}" class="form-control" required>
                    </div>
                </div>

                <!-- Campo: Posición -->
                <div class="mb-3">
                    <label for="position" class="form-label">
                        <i class="fas fa-user-tag me-1"></i> Posición
                    </label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="fas fa-user-tag"></i></span>
                        <select class="form-select" id="position" name="position" required>
                            <option value="">Seleccionar posición</option>
                            @foreach($positions as $position)
                                <option value="{{ $position }}" {{ $jugador->position == $position ? 'selected' : '' }}>
                                    {{ $position }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <!-- Botón Actualizar -->
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save"></i> Actualizar
                </button>
            </form>
        </div>
    </div>
</div>
@endsection

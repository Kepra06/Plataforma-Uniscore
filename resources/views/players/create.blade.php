@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <!-- Encabezado con botón Volver -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <a href="{{ url()->previous() }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Volver
        </a>
        <h1 class="mb-0">
            Agregar Jugador al Equipo: 
            <span class="text-primary">{{ $equipo->name }}</span>
        </h1>
    </div>

    <!-- Tarjeta con formulario -->
    <div class="card shadow-sm">
        <div class="card-body">
            <form action="{{ route('players.store', ['torneoId' => $equipo->torneo_id, 'equipoId' => $equipo->id]) }}" method="POST">
                @csrf

                <input type="hidden" name="equipo_id" value="{{ $equipo->id }}">

                <div class="mb-3">
                    <label for="name" class="form-label">
                        <i class="fas fa-user me-1"></i> Nombre del Jugador
                    </label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="fas fa-user"></i></span>
                        <input type="text" class="form-control" id="name" name="name" placeholder="Ingrese el nombre del jugador" required>
                    </div>
                </div>

                <div class="mb-3">
                    <label for="number" class="form-label">
                        <i class="fas fa-hashtag me-1"></i> Número
                    </label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="fas fa-hashtag"></i></span>
                        <input type="number" class="form-control" id="number" name="number" placeholder="Ingrese el número" min="1">
                    </div>
                </div>

                <div class="mb-3">
                    <label for="position" class="form-label">
                        <i class="fas fa-user-tag me-1"></i> Posición
                    </label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="fas fa-user-tag"></i></span>
                        <select class="form-select" id="position" name="position">
                            <option value="">Seleccionar posición</option>
                            @foreach($positions as $position)
                                <option value="{{ $position }}">{{ $position }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <button type="submit" class="btn btn-success">
                    <i class="fas fa-save"></i> Guardar Jugador
                </button>
            </form>
        </div>
    </div>
</div>
@endsection

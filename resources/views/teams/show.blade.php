@extends('layouts.app')

@section('content')

<!-- Título -->
<h1 class="mb-4 text-center text-primary">Jugadores del Equipo: {{ $equipo->name }}</h1>

<!-- Verificación si el usuario puede agregar jugadores -->
@auth
    @if(Auth::user()->role === 'superadmin' && $equipo->torneo_id && $equipo->id)
        <div class="text-center mb-4">
            <a href="{{ route('players.create', ['torneoId' => $equipo->torneo_id, 'equipoId' => $equipo->id]) }}" class="btn btn-success btn-lg">
                <i class="fas fa-user-plus"></i> Agregar Jugador
            </a>
        </div>
    @elseif(Auth::user()->role !== 'superadmin')
        <div class="alert alert-warning text-center">
            No tienes permisos para agregar jugadores.
        </div>
    @endif
@endauth

<!-- Mensaje si no hay jugadores -->
@if($jugadores->isEmpty())
    <div class="alert alert-info text-center">
        No hay jugadores registrados para este equipo.
    </div>
@else
    <!-- Contenedor de tarjetas -->
    <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4">
        @foreach($jugadores as $jugador)
            <div class="col">
                <div class="card shadow-lg">
                    <div class="card-body text-center">
                        <!-- Ícono pequeño de jugador -->
                        <div class="mb-3">
                            <i class="fas fa-user fa-3x text-primary"></i> <!-- Ícono de jugador -->
                        </div>
                        <h5 class="card-title">{{ $jugador->name }}</h5>
                        <p class="card-text"><strong>Posición:</strong> {{ $jugador->position }}</p>

                        <!-- Botones de acción solo para superadmin -->
                        @auth
                            @if(Auth::user()->role === 'superadmin')
                                <div class="d-flex justify-content-between mt-3">
                                    <a href="{{ route('players.edit', ['torneoId' => $equipo->torneo_id, 'equipoId' => $equipo->id, 'jugadorId' => $jugador->id]) }}" class="btn btn-warning btn-sm">
                                        <i class="fas fa-edit"></i> Editar
                                    </a>
                                    
                                    <form action="{{ route('players.destroy', ['torneoId' => $equipo->torneo_id, 'equipoId' => $equipo->id, 'jugadorId' => $jugador->id]) }}" method="POST" style="display: inline-block;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('¿Estás seguro de eliminar a este jugador?')">
                                            <i class="fas fa-trash-alt"></i> Eliminar
                                        </button>
                                    </form>
                                </div>
                            @endif
                        @endauth
                    </div>
                </div>
            </div>
        @endforeach
    </div>
@endif

@endsection

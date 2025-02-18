@extends('layouts.app')

@section('content')
<h1>Jugadores del Equipo: {{ $equipo->name }}</h1>

<a href="{{ route('players.create', ['torneoId' => $equipo->torneo_id, 'equipoId' => $equipo->id]) }}" class="btn btn-primary mb-3">Agregar Jugador</a>

@if($jugadores->isEmpty())
    <p>No hay jugadores registrados.</p>
@else
    <table class="table">
        <thead>
            <tr>
                <th>Nombre</th>
                <th>Posición</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            @foreach($jugadores as $jugador)
                <tr>
                    <td>{{ $jugador->name }}</td>
                    <td>{{ $jugador->position }}</td>
                    <td>
                        <a href="{{ route('players.edit', ['equipoId' => $equipo->id, 'jugadorId' => $jugador->id]) }}" class="btn btn-warning">Editar</a>
                        <form action="{{ route('tournaments.destroy', $torneo) }}" method="POST" style="display: inline-block;">
    @csrf
    @method('DELETE')
    <button type="submit" class="btn btn-danger" onclick="return confirm('¿Estás seguro de eliminar este torneo?')">Eliminar</button>
</form>

                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endif
@endsection

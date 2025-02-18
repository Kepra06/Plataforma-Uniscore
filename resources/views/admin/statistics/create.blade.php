@extends('layouts.app')

@section('content')
<div class="container my-4">
    <div class="text-center mb-4">
        <h1 class="display-4" style="color: #003366; font-weight: bold;">Crear Estadística</h1>
    </div>

    <!-- Botón para borrar filtros -->
    <div class="mb-3">
        <button type="button" id="clearFilters" class="btn btn-warning">
            <i class="fas fa-eraser"></i> Borrar filtros
        </button>
    </div>

    <form action="{{ route('statistics.store') }}" method="POST" class="bg-light p-4 rounded shadow-sm">
        @csrf

        <div class="row">
            <!-- Selección de Equipo -->
            <div class="col-md-6 mb-3">
                <label for="equipo_id" class="form-label" style="color: #003366;">Equipo</label>
                <select id="equipo_id" class="form-control" style="border-color: #006699;" required>
                    <option value="" disabled selected>Seleccione un equipo</option>
                    @foreach($equipos as $equipo)
                        <option value="{{ $equipo->id }}">{{ $equipo->name }}</option>
                    @endforeach
                </select>
            </div>
        </div>

        <div class="row">
            <!-- Jugador (se actualiza según el equipo seleccionado) -->
            <div class="col-md-6 mb-3">
                <label for="jugador_id" class="form-label" style="color: #003366;">Jugador</label>
                <select name="jugador_id" id="jugador_id" class="form-control" style="border-color: #006699;" required>
                    <option value="" disabled selected>Seleccione un jugador</option>
                    @foreach($jugadores as $jugador)
                        <option value="{{ $jugador->id }}" data-team-id="{{ $jugador->equipo_id }}">
                            {{ $jugador->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <!-- Partido (se actualiza según el equipo seleccionado) -->
            <div class="col-md-6 mb-3">
                <label for="partido_id" class="form-label" style="color: #003366;">Partido</label>
                <select name="partido_id" id="partido_id" class="form-control" style="border-color: #006699;" required>
                    <option value="" disabled selected>Seleccione un partido</option>
                    @foreach($partidos as $partido)
                        <option value="{{ $partido->id }}" 
                            data-local-id="{{ $partido->equipo_local_id }}" 
                            data-visitante-id="{{ $partido->equipo_visitante_id }}">
                            {{ $partido->equipoLocal->name }} vs {{ $partido->equipoVisitante->name }}
                        </option>
                    @endforeach
                </select>
            </div>
        </div>

        <div class="row">
            <!-- Goles -->
            <div class="col-md-4 mb-3">
                <label for="goals" class="form-label" style="color: #003366;">Goles</label>
                <input type="number" name="goals" id="goals" class="form-control" style="border-color: #006699;" min="0" required>
            </div>

            <!-- Tarjetas Amarillas -->
            <div class="col-md-4 mb-3">
                <label for="yellow_cards" class="form-label" style="color: #003366;">Tarjetas Amarillas</label>
                <input type="number" name="yellow_cards" id="yellow_cards" class="form-control" style="border-color: #006699;" min="0" required value="0">
            </div>

            <!-- Tarjetas Rojas -->
            <div class="col-md-4 mb-3">
                <label for="red_cards" class="form-label" style="color: #003366;">Tarjetas Rojas</label>
                <input type="number" name="red_cards" id="red_cards" class="form-control" style="border-color: #006699;" min="0" required value="0">
            </div>
        </div>

        <div class="d-flex justify-content-between mt-4">
            <button type="submit" class="btn btn-success btn-lg" style="background-color: #006699; border-color: #006699;">
                <i class="fas fa-save"></i> Guardar
            </button>
            <a href="{{ route('statistics.index') }}" class="btn btn-secondary btn-lg">
                <i class="fas fa-arrow-left"></i> Volver
            </a>
        </div>

    </form>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const equipoSelect = document.getElementById('equipo_id');
    const jugadorSelect = document.getElementById('jugador_id');
    const partidoSelect = document.getElementById('partido_id');
    const clearFiltersBtn = document.getElementById('clearFilters');

    // Función para reiniciar todos los selects y mostrar todas las opciones
    function clearFilters() {
        // Reinicia el select de equipo
        Array.from(equipoSelect.options).forEach(option => {
            option.hidden = false;
        });
        equipoSelect.value = "";

        // Reinicia el select de jugador
        Array.from(jugadorSelect.options).forEach(option => {
            option.hidden = false;
        });
        jugadorSelect.value = "";

        // Reinicia el select de partido
        Array.from(partidoSelect.options).forEach(option => {
            option.hidden = false;
        });
        partidoSelect.value = "";
    }

    // Asigna el evento al botón "Borrar filtros"
    clearFiltersBtn.addEventListener('click', clearFilters);

    // Filtra jugadores y partidos al seleccionar un equipo
    equipoSelect.addEventListener('change', function() {
        const teamId = this.value;

        // Filtra jugadores según el equipo seleccionado
        Array.from(jugadorSelect.options).forEach(option => {
            const playerTeamId = option.getAttribute('data-team-id');
            option.hidden = option.value !== "" && playerTeamId !== teamId;
        });
        jugadorSelect.value = "";

        // Filtra partidos según el equipo seleccionado
        Array.from(partidoSelect.options).forEach(option => {
            const localId = option.getAttribute('data-local-id');
            const visitanteId = option.getAttribute('data-visitante-id');
            option.hidden = option.value !== "" && localId !== teamId && visitanteId !== teamId;
        });
        partidoSelect.value = "";
    });

    // Al seleccionar un jugador:
    // 1. Filtra el desplegable de partidos para mostrar solo aquellos en los que participa su equipo.
    // 2. Filtra el desplegable de equipos para mostrar únicamente el equipo al que pertenece el jugador.
    jugadorSelect.addEventListener('change', function() {
        // Obtiene el id del equipo del jugador seleccionado
        const selectedPlayerOption = jugadorSelect.options[jugadorSelect.selectedIndex];
        const playerTeamId = selectedPlayerOption.getAttribute('data-team-id');

        // Filtra partidos en función del equipo del jugador
        Array.from(partidoSelect.options).forEach(option => {
            const localId = option.getAttribute('data-local-id');
            const visitanteId = option.getAttribute('data-visitante-id');
            option.hidden = option.value !== "" && localId !== playerTeamId && visitanteId !== playerTeamId;
        });
        partidoSelect.value = "";

        // Filtra equipos para mostrar solo el equipo al que pertenece el jugador
        Array.from(equipoSelect.options).forEach(option => {
            option.hidden = option.value !== "" && option.value !== playerTeamId;
        });
        equipoSelect.value = playerTeamId;
    });
});
</script>
@endsection

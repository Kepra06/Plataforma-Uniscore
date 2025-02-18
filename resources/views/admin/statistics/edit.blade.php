@extends('layouts.app')

@section('content')
<div class="container my-4">
    <div class="text-center mb-4">
        <h1 class="display-4" style="color: #003366; font-weight: bold;">Editar Estadística</h1>
    </div>

    <form action="{{ route('statistics.update', $estadistica->id) }}" method="POST" class="bg-light p-4 rounded shadow-sm">
        @csrf
        @method('PUT')

        <div class="row">
            <!-- Equipo Ganador -->
            <div class="col-md-6 mb-3">
                <label for="ganador" class="form-label" style="color: #003366;">Equipo Ganador</label>
                <select name="ganador" id="ganador" class="form-control" style="border-color: #006699;" {{ old('es_empate', $estadistica->partido->ganador_id) === null ? 'disabled' : '' }}>
                    <option value="">Seleccione el equipo ganador</option>
                    <option value="{{ $estadistica->partido->equipoLocal->id }}" 
                        {{ $estadistica->partido->ganador_id == $estadistica->partido->equipoLocal->id ? 'selected' : '' }}>
                        {{ $estadistica->partido->equipoLocal->name }}
                    </option>
                    <option value="{{ $estadistica->partido->equipoVisitante->id }}"
                        {{ $estadistica->partido->ganador_id == $estadistica->partido->equipoVisitante->id ? 'selected' : '' }}>
                        {{ $estadistica->partido->equipoVisitante->name }}
                    </option>
                </select>
            </div>

            <!-- Empate -->
            <div class="col-md-6 mb-3 d-flex align-items-center">
                <div class="form-check">
                    <input type="checkbox" class="form-check-input" id="es_empate" name="es_empate" value="1" 
                        {{ old('es_empate', $estadistica->partido->ganador_id) === null ? 'checked' : '' }}
                        onclick="toggleGanadorInput(this)">
                    <label class="form-check-label" for="es_empate" style="color: #003366;">Marcar como Empate</label>
                </div>
            </div>
        </div>

        <div class="row">
            <!-- Jugador -->
            <div class="col-md-6 mb-3">
                <label for="jugador_id" class="form-label" style="color: #003366;">Jugador</label>
                <select name="jugador_id" id="jugador_id" class="form-control" style="border-color: #006699;">
                    @foreach($jugadores as $jugador)
                        <option value="{{ $jugador->id }}" {{ $jugador->id == $estadistica->jugador_id ? 'selected' : '' }}>
                            {{ $jugador->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <!-- Partido -->
            <div class="col-md-6 mb-3">
                <label for="partido_id" class="form-label" style="color: #003366;">Partido</label>
                <select name="partido_id" id="partido_id" class="form-control" style="border-color: #006699;">
                    @foreach($partidos as $partido)
                        <option value="{{ $partido->id }}" {{ $partido->id == $estadistica->partido_id ? 'selected' : '' }}>
                            {{ $partido->equipoLocal->name }} vs {{ $partido->equipoVisitante->name }}
                        </option>
                    @endforeach
                </select>
            </div>
        </div>

        <div class="row">
            <!-- Goles -->
            <div class="col-md-6 mb-3">
                <label for="goals" class="form-label" style="color: #003366;">Goles</label>
                <input type="number" name="goals" id="goals" class="form-control" value="{{ $estadistica->goals }}" style="border-color: #006699;">
            </div>

            <!-- Tarjetas Amarillas -->
            <div class="col-md-6 mb-3">
                <label for="yellow_cards" class="form-label" style="color: #003366;">Tarjetas Amarillas</label>
                <input type="number" name="yellow_cards" id="yellow_cards" class="form-control" value="{{ $estadistica->yellow_cards }}" style="border-color: #006699;">
            </div>
        </div>

        <div class="row">
            <!-- Tarjetas Rojas -->
            <div class="col-md-6 mb-3">
                <label for="red_cards" class="form-label" style="color: #003366;">Tarjetas Rojas</label>
                <input type="number" name="red_cards" id="red_cards" class="form-control" value="{{ $estadistica->red_cards }}" style="border-color: #006699;">
            </div>
        </div>

        <div class="d-flex justify-content-between mt-4">
            <button type="submit" class="btn btn-success btn-lg" style="background-color: #006699; border-color: #006699;">
                <i class="fas fa-save"></i> Actualizar
            </button>
            <a href="{{ route('statistics.index') }}" class="btn btn-secondary btn-lg">
                <i class="fas fa-arrow-left"></i> Volver
            </a>
        </div>
    </form>
</div>

<script>
    function toggleGanadorInput(checkbox) {
        const ganadorInput = document.getElementById('ganador');
        ganadorInput.disabled = checkbox.checked;
        if (checkbox.checked) {
            ganadorInput.value = '';
        }
    }
</script>
@endsection

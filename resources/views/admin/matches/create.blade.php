@extends('layouts.app')

@section('content')
<div class="text-center my-4">
    <h1 class="display-4" style="color: #00274D; font-weight: bold;">Programar Partido para {{ $tournament->name }}</h1>
</div>

@if (session('error'))
    <div class="alert alert-danger">
        <i class="fas fa-exclamation-triangle"></i> {{ session('error') }}
    </div>
@endif

<form action="{{ route('tournaments.matches.store', $tournament->id) }}" method="POST" class="bg-light p-4 rounded shadow-sm">
    @csrf
    <div class="row">
        <!-- Columna 1 -->
        <div class="col-md-6 mb-3">
            <label for="equipo_local_id" class="form-label" style="color: #00274D;">Equipo Local</label>
            <select name="equipo_local_id" class="form-control" required style="border-color: #004D40;">
                <option value="">Seleccione un equipo local</option>
                @foreach($tournament->equipos as $equipo)
                    <option value="{{ $equipo->id }}">{{ $equipo->name }}</option>
                @endforeach
            </select>
        </div>
        
        <div class="col-md-6 mb-3">
            <label for="equipo_visitante_id" class="form-label" style="color: #00274D;">Equipo Visitante</label>
            <select name="equipo_visitante_id" class="form-control" required style="border-color: #004D40;">
                <option value="">Seleccione un equipo visitante</option>
                @foreach($tournament->equipos as $equipo)
                    <option value="{{ $equipo->id }}">{{ $equipo->name }}</option>
                @endforeach
            </select>
        </div>

        <div class="col-md-6 mb-3">
            <label for="fecha" class="form-label" style="color: #00274D;">Fecha del Partido</label>
            <input type="date" name="fecha" class="form-control" required style="border-color: #004D40; width: 100%; max-width: 250px;">
        </div>

        <div class="col-md-6 mb-3">
            <label for="hora" class="form-label" style="color: #00274D;">Hora del Partido</label>
            <input type="time" name="hora" class="form-control" required style="border-color: #004D40; width: 100%; max-width: 250px;">
        </div>
    </div>

    <div class="row">
        <div class="col-md-6 mb-3">
            <label for="ubicacion" class="form-label" style="color: #00274D;">Ubicación del Partido</label>
            <input type="text" name="ubicacion" class="form-control" placeholder="Ingrese la ubicación" required style="border-color: #004D40;">
        </div>

        <div class="col-md-6 mb-3">
            <label for="ronda" class="form-label" style="color: #00274D;">Ronda del Partido</label>
            <select name="ronda" class="form-control" required style="border-color: #004D40;">
                <option value="">Seleccione la ronda</option>
                @foreach($rondas as $ronda)
                    <option value="{{ $ronda }}">{{ $ronda }}</option>
                @endforeach
            </select>
        </div>
    </div>

    <div class="d-flex justify-content-between mt-4">
        <button type="submit" class="btn btn-success btn-lg" style="background-color: #004D40; border-color: #004D40;">
            <i class="fas fa-save"></i> Guardar Partido
        </button>
        <a href="{{ route('tournaments.show', $tournament->id) }}" class="btn btn-secondary btn-lg">
            <i class="fas fa-times-circle"></i> Cancelar
        </a>
    </div>
</form>
@endsection

@extends('layouts.app')

@section('content')
<div class="text-center my-4">
    <h1 class="display-4" style="color: #00274D; font-weight: bold;">Editar Torneo: {{ $torneo->name }}</h1>
</div>

<form action="{{ route('tournaments.update', $torneo->id) }}" method="POST" class="bg-light p-4 rounded shadow-sm">
    @csrf
    @method('PUT')
    
    <div class="row">
        <!-- Nombre del Torneo -->
        <div class="col-md-6 mb-3">
            <label for="name" class="form-label" style="color: #00274D;">Nombre del Torneo</label>
            <input type="text" name="name" value="{{ old('name', $torneo->name) }}" class="form-control" required style="border-color: #004D40;">
        </div>
        
        <!-- Tipo de Deporte -->
        <div class="col-md-6 mb-3">
            <label for="sport_type" class="form-label" style="color: #00274D;">Deporte</label>
            <input type="text" name="sport_type" value="{{ old('sport_type', $torneo->sport_type) }}" class="form-control" required style="border-color: #004D40;">
        </div>
    </div>

    <div class="row">
        <!-- Tipo de Torneo -->
        <div class="col-md-6 mb-3">
            <label for="tournament_type" class="form-label" style="color: #00274D;">Tipo de Torneo</label>
            <input type="text" name="tournament_type" value="{{ old('tournament_type', $torneo->tournament_type) }}" class="form-control" required style="border-color: #004D40;">
        </div>
        
        <!-- Número de Equipos -->
        <div class="col-md-6 mb-3">
            <label for="number_of_teams" class="form-label" style="color: #00274D;">Número de Equipos</label>
            <input type="number" name="number_of_teams" value="{{ old('number_of_teams', $torneo->number_of_teams) }}" class="form-control" required style="border-color: #004D40;">
        </div>
    </div>

    <div class="row">
        <!-- Fecha de Inicio -->
        <div class="col-md-6 mb-3">
            <label for="start_date" class="form-label" style="color: #00274D;">Fecha de Inicio</label>
            <input type="date" name="start_date" value="{{ old('start_date', $torneo->start_date) }}" class="form-control" required style="border-color: #004D40;">
        </div>
        
        <!-- Fecha de Finalización -->
        <div class="col-md-6 mb-3">
            <label for="end_date" class="form-label" style="color: #00274D;">Fecha de Finalización</label>
            <input type="date" name="end_date" value="{{ old('end_date', $torneo->end_date) }}" class="form-control" required style="border-color: #004D40;">
        </div>
    </div>

    <div class="d-flex justify-content-between mt-4">
        <button type="submit" class="btn btn-success btn-lg" style="background-color: #004D40; border-color: #004D40;">
            <i class="fas fa-sync-alt"></i> Actualizar Torneo
        </button>
        <a href="{{ route('tournaments.index') }}" class="btn btn-secondary btn-lg">
            <i class="fas fa-times-circle"></i> Cancelar
        </a>
    </div>
</form>
@endsection

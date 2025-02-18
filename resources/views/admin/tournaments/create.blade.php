@extends('layouts.app')

@section('content')
<div class="text-center my-4">
    <h1 class="display-4" style="color: #00274D; font-weight: bold;">Crear Torneo</h1>
</div>

@if (session('error'))
    <div class="alert alert-danger">
        <i class="fas fa-exclamation-triangle"></i> {{ session('error') }}
    </div>
@endif

<form action="{{ route('tournaments.store') }}" method="POST" class="bg-light p-4 rounded shadow-sm">
    @csrf
    <div class="row">
        <!-- Columna 1 -->
        <div class="col-md-6 mb-3">
            <label for="name" class="form-label" style="color: #00274D;">Nombre del Torneo</label>
            <input type="text" name="name" class="form-control" required style="border-color: #004D40;">
        </div>

        <div class="col-md-6 mb-3">
            <label for="sport_type" class="form-label" style="color: #00274D;">Deporte</label>
            <input type="text" name="sport_type" class="form-control" required style="border-color: #004D40;">
        </div>

        <div class="col-md-6 mb-3">
            <label for="tournament_type" class="form-label" style="color: #00274D;">Tipo de Torneo</label>
            <input type="text" name="tournament_type" class="form-control" required style="border-color: #004D40;">
        </div>

        <div class="col-md-6 mb-3">
            <label for="number_of_teams" class="form-label" style="color: #00274D;">Número de Equipos</label>
            <input type="number" name="number_of_teams" class="form-control" required style="border-color: #004D40;">
        </div>

        <div class="col-md-6 mb-3">
            <label for="start_date" class="form-label" style="color: #00274D;">Fecha de Inicio</label>
            <input type="date" name="start_date" class="form-control" required style="border-color: #004D40; width: 100%; max-width: 250px;">
        </div>

        <div class="col-md-6 mb-3">
            <label for="end_date" class="form-label" style="color: #00274D;">Fecha de Finalización</label>
            <input type="date" name="end_date" class="form-control" required style="border-color: #004D40; width: 100%; max-width: 250px;">
        </div>
    </div>

    <div class="d-flex justify-content-between mt-4">
        <button type="submit" class="btn btn-success btn-lg" style="background-color: #004D40; border-color: #004D40;">
            <i class="fas fa-save"></i> Guardar Torneo
        </button>
        <a href="{{ route('tournaments.index') }}" class="btn btn-secondary btn-lg">
            <i class="fas fa-times-circle"></i> Cancelar
        </a>
    </div>
</form>
@endsection

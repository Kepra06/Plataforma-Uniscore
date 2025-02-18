@extends('layouts.app')

@section('content')
<div class="text-center my-4">
    <h1 class="display-4" style="color: #00274D; font-weight: bold;">Agregar Equipo</h1>
</div>

<form action="{{ route('teams.store', ['torneo' => $torneo->id]) }}" method="POST" class="bg-light p-4 rounded shadow-sm">
    @csrf

    <div class="row">
        <div class="col-md-6 mb-3">
            <label for="torneo_id" class="form-label" style="color: #00274D;">Seleccionar Torneo</label>
            <select name="torneo_id" class="form-control" required style="border-color: #004D40;">
                <option value="" selected disabled>Seleccione un torneo</option>
                @foreach($torneos as $item)
                    <option value="{{ $item->id }}" {{ $item->id == $torneo->id ? 'selected' : '' }}>
                        {{ $item->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="col-md-6 mb-3">
            <label for="grupo" class="form-label" style="color: #00274D;">Seleccionar Grupo</label>
            <select name="grupo" class="form-control" required style="border-color: #004D40;">
                <option value="" selected disabled>Seleccione un grupo</option>
                @foreach(['A', 'B'] as $grupo)
                    <option value="{{ $grupo }}">{{ "Grupo $grupo" }}</option>
                @endforeach
            </select>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6 mb-3">
            <label for="name" class="form-label" style="color: #00274D;">Nombre del Equipo</label>
            <input type="text" name="name" class="form-control" required style="border-color: #004D40;">
        </div>

        <div class="col-md-6 mb-3">
            <label for="coach" class="form-label" style="color: #00274D;">Nombre del Coach</label>
            <input type="text" name="coach" class="form-control" style="border-color: #004D40;">
        </div>
    </div>

    <div class="d-flex justify-content-between mt-4">
        <button type="submit" class="btn btn-success btn-lg" style="background-color: #004D40; border-color: #004D40;">
            <i class="fas fa-save"></i> Guardar
        </button>
        <a href="{{ route('tournaments.index') }}" class="btn btn-secondary btn-lg">
            <i class="fas fa-arrow-left"></i> Volver
        </a>
    </div>
</form>
@endsection

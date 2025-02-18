@extends('layouts.app')

@section('content')
<div class="text-center my-4">
    <h1 class="display-4" style="color: #00274D; font-weight: bold;">Editar Equipo: {{ $equipo->name }}</h1>
</div>

<form action="{{ route('teams.update', ['equipoId' => $equipo->id, 'torneo' => $torneo->id]) }}" method="POST" class="bg-light p-4 rounded shadow-sm">
    @csrf
    @method('PUT')

    <div class="row">
        <div class="col-md-6 mb-3">
            <label for="name" class="form-label" style="color: #00274D;">Nombre del Equipo</label>
            <input type="text" name="name" class="form-control" value="{{ old('name', $equipo->name) }}" required style="border-color: #004D40;">
        </div>

        <div class="col-md-6 mb-3">
            <label for="coach" class="form-label" style="color: #00274D;">Nombre del Coach</label>
            <input type="text" name="coach" class="form-control" value="{{ old('coach', $equipo->coach) }}" style="border-color: #004D40;">
        </div>
    </div>

    <div class="row">
        <div class="col-md-6 mb-3">
            <label for="torneo_id" class="form-label" style="color: #00274D;">Torneo Asociado</label>
            <select name="torneo_id" class="form-control" required style="border-color: #004D40;">
                @foreach($torneos as $t)
                    <option value="{{ $t->id }}" {{ $equipo->torneo_id == $t->id ? 'selected' : '' }}>
                        {{ $t->name }}
                    </option>
                @endforeach
            </select>

        </div>

        <div class="col-md-6 mb-3">
            <label for="grupo" class="form-label" style="color: #00274D;">Grupo</label>
            <select name="grupo" class="form-control" style="border-color: #004D40;">
                <option value="" {{ old('grupo', $equipo->grupo) == '' ? 'selected' : '' }}>Sin Grupo</option>
                <option value="A" {{ old('grupo', $equipo->grupo) == 'A' ? 'selected' : '' }}>A</option>
                <option value="B" {{ old('grupo', $equipo->grupo) == 'B' ? 'selected' : '' }}>B</option>
            </select>
        </div>
    </div>

    <div class="d-flex justify-content-between mt-4">
        <button type="submit" class="btn btn-success btn-lg" style="background-color: #004D40; border-color: #004D40;">
            <i class="fas fa-save"></i> Actualizar
        </button>
        <a href="{{ route('tournaments.index') }}" class="btn btn-secondary btn-lg">
            <i class="fas fa-arrow-left"></i> Volver
        </a>
    </div>
</form>
@endsection

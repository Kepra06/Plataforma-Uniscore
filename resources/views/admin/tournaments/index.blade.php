@extends('layouts.app')

@section('content')
<div class="container my-5">
  <!-- Encabezado -->
  <div class="row justify-content-center">
    <div class="col-12 text-center">
      <h1 class="display-4" style="color: #00274D; font-weight: bold;">Torneos</h1>
      <p class="lead" style="color: #004D40;">Explora y administra los torneos activos</p>
    </div>
  </div>

  <!-- Botón para crear torneo (visible para superadmin) -->
  @if(Auth::check() && Auth::user()->role === 'superadmin')
  <div class="row mb-4">
    <div class="col-12 d-flex justify-content-end">
      <a href="{{ route('tournaments.create') }}" class="btn btn-success btn-lg" style="background-color: #004D40; border-color: #004D40;">
        <i class="fas fa-plus-circle"></i> Crear Torneo
      </a>
    </div>
  </div>
  @endif

  <!-- Listado de torneos -->
  <div class="row">
    @forelse($torneos as $torneo)
      <div class="col-12 col-sm-6 col-md-4 mb-4" data-aos="fade-up">
        <div class="card h-100 shadow-sm border-0" style="border-radius: 15px; overflow: hidden; transition: transform 0.3s ease; cursor: pointer;"
             onmouseover="this.style.transform='scale(1.03)'" onmouseout="this.style.transform='scale(1)'">
          <!-- Header de la tarjeta con degradado -->
          <div class="card-header text-center py-4" style="background: linear-gradient(135deg, #004D40, #00274D);">
            <div class="mx-auto" style="width: 60px; height: 60px; background-color: #F8F9FA; border-radius: 50%; display: flex; justify-content: center; align-items: center;">
              <i class="fas fa-trophy" style="font-size: 28px; color: #00274D;"></i>
            </div>
            <h4 class="mt-3 mb-0" style="font-weight: bold; color: #F8F9FA;">{{ $torneo->name }}</h4>
            <small style="color: #D1E8E2;">{{ ucfirst($torneo->sport_type) }}</small>
          </div>
          <!-- Cuerpo de la tarjeta -->
          <div class="card-body" style="background-color: #F8F9FA;">
            <p class="mb-2"><strong>Tipo:</strong> {{ ucfirst($torneo->tournament_type) }}</p>
            <p class="mb-2"><strong>Equipos:</strong> {{ $torneo->number_of_teams }}</p>
            <p class="mb-1"><strong>Inicio:</strong> {{ \Carbon\Carbon::parse($torneo->start_date)->format('d/m/Y') }}</p>
            <p class="mb-0"><strong>Fin:</strong> {{ \Carbon\Carbon::parse($torneo->end_date)->format('d/m/Y') }}</p>
          </div>
          <!-- Pie de la tarjeta con acciones -->
          <div class="card-footer text-center py-3" style="background-color: #F8F9FA;">
            <div class="btn-group" role="group" aria-label="Acciones del Torneo">
              <a href="{{ route('tournaments.show', $torneo) }}" class="btn btn-outline-info" style="border-radius: 30px;">
                <i class="fas fa-eye"></i> Ver
              </a>
              @if(Auth::check() && Auth::user()->role === 'superadmin')
              <a href="{{ route('tournaments.edit', $torneo) }}" class="btn btn-outline-primary" style="border-radius: 30px;">
                <i class="fas fa-edit"></i> Editar
              </a>
              <form action="{{ route('tournaments.destroy', $torneo) }}" method="POST" class="d-inline">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-outline-danger" style="border-radius: 30px;"
                        onclick="return confirm('¿Estás seguro de eliminar este torneo?')">
                  <i class="fas fa-trash-alt"></i> Eliminar
                </button>
              </form>
              @endif
            </div>
          </div>
        </div>
      </div>
    @empty
      <div class="col-12 text-center">
        <p class="text-muted">No hay torneos registrados en este momento.</p>
      </div>
    @endforelse
  </div>
</div>
@endsection

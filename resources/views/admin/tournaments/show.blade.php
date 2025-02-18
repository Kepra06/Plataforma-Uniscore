@extends('layouts.app')

@section('content')
<div class="container my-5">
  <!-- Tarjeta principal del torneo -->
  <div class="card shadow-lg rounded-4 overflow-hidden border-0">
    <!-- Encabezado con gradiente y efecto parallax -->
    <div class="card-header text-center text-white py-5 position-relative" style="background: linear-gradient(135deg, #004D40 0%, #00274D 100%);">
      <div class="position-absolute w-100 h-100 bg-dark opacity-25 top-0 start-0"></div>
      <div class="position-relative">
        <h1 class="display-5 fw-bold mb-3 text-uppercase">{{ $torneo->name }}</h1>
        <div class="d-flex justify-content-center align-items-center">
          <span class="badge bg-white text-dark fs-6 rounded-pill px-4 py-2 shadow-sm">
            <i class="fas fa-trophy me-2"></i>{{ ucfirst($torneo->sport_type) }}
          </span>
        </div>
      </div>
    </div>
    
    <!-- Cuerpo de la tarjeta -->
    <div class="card-body bg-light">
      <!-- Sección de información principal -->
      <div class="row mb-5">
        <div class="col-lg-4 mb-4" data-aos="fade-right">
          <div class="p-4 bg-white rounded-4 shadow-sm h-100">
            <h4 class="fw-bold text-gradient mb-4">Detalles del Torneo</h4>
            <div class="d-flex flex-column gap-3">
              <div class="d-flex align-items-center">
                <i class="fas fa-chess-king fs-5 text-primary me-3"></i>
                <div>
                  <p class="mb-0 fw-bold">Tipo de Torneo</p>
                  <p class="mb-0 text-muted">{{ ucfirst($torneo->tournament_type) }}</p>
                </div>
              </div>
              <div class="d-flex align-items-center">
                <i class="fas fa-calendar-alt fs-5 text-success me-3"></i>
                <div>
                  <p class="mb-0 fw-bold">Fecha de Inicio</p>
                  <p class="mb-0 text-muted">
                    {{ \Carbon\Carbon::parse($torneo->start_date)->isoFormat('D MMM YYYY, h:mm A') }}
                  </p>
                </div>
              </div>
              <div class="d-flex align-items-center">
                <i class="fas fa-flag-checkered fs-5 text-danger me-3"></i>
                <div>
                  <p class="mb-0 fw-bold">Fecha de Finalización</p>
                  <p class="mb-0 text-muted">
                    {{ \Carbon\Carbon::parse($torneo->start_date)->isoFormat('D MMM YYYY, h:mm A') }}
                  </p>
                </div>
              </div>
            </div>
          </div>
        </div>

        <!-- Sección de progreso de inscripción -->
        <div class="col-lg-8 mb-4" data-aos="fade-left">
          <div class="p-4 bg-white rounded-4 shadow-sm h-100">
            <h4 class="fw-bold text-gradient mb-4">Progreso de Inscripción</h4>
            <div class="d-flex align-items-center gap-4">
              <div class="progress flex-grow-1" style="height: 25px;">
                <div class="progress-bar bg-gradient progress-bar-striped progress-bar-animated" 
                     role="progressbar" 
                     style="width: {{ ($torneo->equipos->count() / $torneo->number_of_teams) * 100 }}%" 
                     aria-valuenow="{{ $torneo->equipos->count() }}" 
                     aria-valuemin="0" 
                     aria-valuemax="{{ $torneo->number_of_teams }}">
                </div>
              </div>
              <div class="text-center">
                <h3 class="fw-bold mb-0 text-primary">{{ $torneo->equipos->count() }}</h3>
                <small class="text-muted">de {{ $torneo->number_of_teams }} equipos</small>
              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- Equipos Registrados -->
      <section class="mb-5">
        <h3 class="text-dark fw-bold mb-4 border-bottom pb-3">
          <i class="fas fa-users me-2"></i>Equipos Registrados
        </h3>
        
        @if($torneo->equipos->isEmpty())
          <div class="alert alert-warning text-center rounded-4">No hay equipos registrados en este torneo.</div>
        @else
          <div class="row g-4">
            @foreach($torneo->equipos as $equipo)
              <div class="col-12" data-aos="fade-up">
                <div class="card border-0 shadow-sm hover-shadow-lg transition-all">
                  <div class="card-body">
                    <!-- Se ajusta la disposición para móvil y escritorio -->
                    <div class="d-flex flex-column flex-md-row justify-content-between align-items-center mb-3">
                      <div class="d-flex align-items-center gap-3">
                        <div class="icon-square bg-gradient text-white rounded-3 p-3">
                          <i class="fas fa-shield-alt fs-4"></i>
                        </div>
                        <h4 class="mb-0 fw-bold">{{ $equipo->name }}</h4>
                      </div>
                      <span class="badge bg-primary rounded-pill badge-sm">
                        {{ $equipo->jugadores->count() }} Jugadores
                      </span>
                    </div>
                    
                    @if($equipo->jugadores->isNotEmpty())
                      <div class="row g-3">
                        @foreach($equipo->jugadores as $jugador)
                          <div class="col-md-4">
                            <div class="d-flex align-items-center p-3 bg-light rounded-4 border">
                              <div class="position-relative me-3">
                                <!-- Se cambia a avatar-sm para reducir el tamaño -->
                                <div class="avatar avatar-sm bg-gradient text-white">
                                  {{ strtoupper(substr($jugador->name, 0, 1)) }}
                                </div>
                                <span class="position-absolute bottom-0 end-0 badge bg-dark rounded-pill">#{{ $jugador->number }}</span>
                              </div>
                              <div>
                                <h6 class="mb-1 fw-bold">{{ $jugador->name }}</h6>
                                <small class="text-muted">{{ $jugador->position }}</small>
                              </div>
                            </div>
                          </div>
                        @endforeach
                      </div>
                    @endif
                  </div>
                </div>
              </div>
            @endforeach
          </div>
        @endif
      </section>

      <!-- Partidos Programados -->
      <section class="mb-4">
        <h3 class="text-dark fw-bold mb-4 border-bottom pb-3">
          <i class="fas fa-calendar-alt me-2"></i>Partidos Programados
        </h3>
        
        @if($torneo->partidos->isEmpty())
          <div class="alert alert-warning text-center rounded-4">No hay partidos programados para este torneo.</div>
        @else
          <div class="row g-4">
            @foreach($torneo->partidos as $partido)
              <div class="col-12 col-md-6" data-aos="fade-up">
                <div class="card match-card border-0 shadow-sm hover-shadow-lg transition-all">
                  <div class="card-body p-4">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                      <span class="badge bg-secondary rounded-pill">{{ $partido->ronda }}</span>
                      <span class="text-muted small">
                        <i class="fas fa-clock me-1"></i>{{ \Carbon\Carbon::parse($partido->match_time)->format('h:i A') }}
                      </span>
                    </div>
                    
                    <div class="match-teams py-3">
                      @if($partido->equipoLocal && $partido->equipoVisitante)
                        <div class="d-flex align-items-center justify-content-around">
                          <div class="team text-center">
                            <div class="avatar bg-gradient text-white mb-2">{{ substr($partido->equipoLocal->name, 0, 2) }}</div>
                            <h6 class="mb-0 fw-bold">{{ $partido->equipoLocal->name }}</h6>
                          </div>
                          <div class="vs-circle bg-primary text-white">VS</div>
                          <div class="team text-center">
                            <div class="avatar bg-gradient text-white mb-2">{{ substr($partido->equipoVisitante->name, 0, 2) }}</div>
                            <h6 class="mb-0 fw-bold">{{ $partido->equipoVisitante->name }}</h6>
                          </div>
                        </div>
                      @else
                        <div class="text-center text-muted py-4">
                          <i class="fas fa-exclamation-circle me-2"></i>Partido por definir
                        </div>
                      @endif
                    </div>
                    
                    <div class="d-flex justify-content-between align-items-center mt-3">
                      <span class="text-muted small">
                        <i class="fas fa-map-marker-alt me-1"></i>{{ $partido->location }}
                      </span>
                      <span class="badge bg-light text-dark border">
                        {{ \Carbon\Carbon::parse($partido->match_date)->isoFormat('D MMM YYYY') }}
                      </span>
                    </div>
                  </div>
                </div>
              </div>
            @endforeach
          </div>
        @endif
      </section>
    </div>

    <!-- Pie de la tarjeta con acciones -->
    <div class="card-footer bg-white text-center py-4">
      <div class="d-flex flex-wrap justify-content-center gap-3">
        <a href="{{ route('tournaments.index') }}" class="btn btn-lg btn-outline-secondary rounded-pill px-4">
          <i class="fas fa-arrow-left me-2"></i>Volver
        </a>
        @if(Auth::check() && Auth::user()->role === 'superadmin')
          <a href="{{ route('tournaments.edit', $torneo) }}" class="btn btn-lg btn-primary rounded-pill px-4 bg-gradient">
            <i class="fas fa-edit me-2"></i>Editar
          </a>
          <form action="{{ route('tournaments.destroy', $torneo) }}" method="POST" class="d-inline" onsubmit="return confirm('¿Estás seguro de eliminar este torneo?')">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn btn-lg btn-danger rounded-pill px-4 bg-gradient">
              <i class="fas fa-trash-alt me-2"></i>Eliminar
            </button>
          </form>
        @endif
      </div>
    </div>
  </div>
</div>

<style>
  .text-gradient {
    background: linear-gradient(45deg, #004D40, #00274D);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
  }
  
  .bg-gradient {
    background: linear-gradient(45deg, #004D40, #00274D) !important;
  }
  
  .avatar {
    display: flex;
    align-items: center;
    justify-content: center;
    font-weight: bold;
    border-radius: 12px;
  }
  
  /* Avatar tamaño normal */
  .avatar {
    width: 50px;
    height: 50px;
  }
  
  /* Avatar pequeño para jugadores */
  .avatar-sm {
    width: 40px;
    height: 40px;
    font-size: 0.9rem;
    border-radius: 10px;
  }
  
  .vs-circle {
    width: 45px;
    height: 45px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-weight: bold;
  }
  
  .match-card:hover {
    transform: translateY(-5px);
    transition: all 0.3s ease;
  }
  
  .hover-shadow-lg {
    transition: all 0.3s ease;
  }
  
  .progress-bar {
    background-size: 40px 40px;
    background-image: linear-gradient(
      45deg,
      rgba(255, 255, 255, 0.15) 25%,
      transparent 25%,
      transparent 50%,
      rgba(255, 255, 255, 0.15) 50%,
      rgba(255, 255, 255, 0.15) 75%,
      transparent 75%,
      transparent
    );
    animation: progressAnimation 1s linear infinite;
  }
  
  @keyframes progressAnimation {
    0% { background-position: 40px 0; }
    100% { background-position: 0 0; }
  }

  /* Badge pequeño para la cantidad de jugadores */
  .badge-sm {
    font-size: 0.8rem;
    padding: 0.25rem 0.5rem;
  }
  
  /* Ajuste responsivo para la cabecera del equipo (nombre y badge) */
  @media (max-width: 768px) {
    .d-flex.flex-column.flex-md-row {
      flex-direction: column !important;
      align-items: flex-start !important;
    }
    .d-flex.flex-column.flex-md-row .badge {
      margin-top: 0.5rem;
    }
  }
</style>

@endsection

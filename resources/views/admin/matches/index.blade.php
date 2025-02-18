@extends('layouts.app')

@section('content')
<div class="container my-5">
    <!-- Encabezado dinámico -->
    <div class="text-center mb-4 animate__animated animate__fadeIn">
        <div class="d-flex justify-content-center align-items-center">
            <i class="fas fa-trophy fa-3x me-3" style="color: #004D40;"></i>
            <h1 class="display-5 fw-bold m-0" style="color: #00274D;">
                {{ $torneo ? $torneo->name : "Selecciona un Torneo" }}
            </h1>
        </div>
        
        @if(Auth::check() && Auth::user()->role === 'superadmin' && $torneo)
            <a href="{{ route('tournaments.matches.create', ['tournament' => $torneo->id]) }}" 
               class="btn btn-lg text-white shadow-sm rounded-pill px-4 mt-3 hover-scale" 
               style="background-color: #004D40; transition: all 0.3s ease;">
                <i class="fas fa-plus-circle me-2"></i>Programar Partido
            </a>
        @endif
    </div>

    <!-- Selector de torneos estilo cards -->
    <div class="row g-4 mb-5">
        <div class="col-12">
            <h4 class="mb-3 fw-bold" style="color: #00274D;"><i class="fas fa-list-ol me-2"></i>Torneos Disponibles</h4>
        </div>
        @foreach($torneos as $torneoOption)
            <div class="col-md-4">
                <a href="?torneo_id={{ $torneoOption->id }}" 
                   class="card-torneo shadow-sm text-decoration-none {{ $torneo && $torneo->id == $torneoOption->id ? 'active' : '' }}">
                    <div class="card h-100 border-0 hover-scale" style="transition: all 0.3s ease;">
                        <div class="card-body text-center d-flex flex-column justify-content-center">
                            <h5 class="card-title fw-bold mb-3" style="color: #004D40;">
                                {{ $torneoOption->name }}
                            </h5>
                            <div class="d-flex justify-content-center gap-2">
                                <span class="badge rounded-pill bg-primary">
                                <i class="fas fa-calendar-alt me-2"></i>{{ \Carbon\Carbon::parse($torneoOption->start_date)->format('M Y') }}
                                </span>
                                <span class="badge rounded-pill bg-success">
                                    {{ $torneoOption->partidos_count }} Partidos
                                </span>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
        @endforeach
    </div>

    <!-- Lista de Partidos -->
    @if($torneo)
        <div class="mt-5 animate__animated animate__fadeInUp">
            @if($partidos->isEmpty())
                <div class="alert alert-warning text-center mt-5 p-4 shadow-sm">
                    <i class="fas fa-exclamation-circle fa-2x mb-3" style="color: #004D40;"></i>
                    <h5 class="fw-bold mb-0">No hay partidos programados para este torneo</h5>
                </div>
            @else
                <h4 class="mb-4 fw-bold" style="color: #00274D;"><i class="fas fa-futbol me-2"></i>Partidos Programados</h4>
                <div class="row g-4">
                @foreach($partidos as $partido)
    <div class="col-md-6 col-lg-4">
        <div class="card match-card h-100 shadow-sm border-0 hover-scale" 
             style="transition: all 0.3s ease; background: linear-gradient(145deg, #f8f9fa, #ffffff);">
            <div class="card-header bg-primary text-white rounded-top-3 py-3">
                <div class="d-flex justify-content-between align-items-center">
                    <span class="badge bg-white text-primary rounded-pill">
                        <i class="fas fa-futbol me-1"></i>{{ $partido->ronda }}
                    </span>
                    <small>{{ \Carbon\Carbon::parse($partido->match_date)->isoFormat('DD MMM YYYY') }}</small>
                </div>
            </div>
            
            <div class="card-body text-center py-4">
                <div class="vs-container mb-3">
                <div class="team">
    <div class="team-logo">
        <i class="fas fa-futbol fa-2x" style="color: #004D40;"></i>
    </div>
    <span class="team-name fw-bold">{{ $partido->equipoLocal->name }}</span>
    <span class="team-score fw-bold text-primary">
    {{ $partido->estadisticas->firstWhere('equipo_id', $partido->equipo_local_id)?->total_goals ?? 0 }}
    </span>
</div>

<div class="vs-circle bg-primary text-white">VS</div>

<div class="team">
    <div class="team-logo">
        <i class="fas fa-futbol fa-2x" style="color: #004D40;"></i>
    </div>
    <span class="team-name fw-bold">{{ $partido->equipoVisitante->name }}</span>
    <span class="team-score fw-bold text-primary">
    {{ $partido->estadisticas->firstWhere('equipo_id', $partido->equipo_visitante_id)?->total_goals ?? 0 }}
    </span>
</div>

                </div>
                
                <div class="match-info">
                    <div class="info-item">
                        <i class="far fa-clock me-2" style="color: #004D40;"></i>
                        {{ \Carbon\Carbon::parse($partido->match_time)->format('h:i A') }}
                        </div>
                    <div class="info-item">
                        <i class="fas fa-map-marker-alt me-2" style="color: #004D40;"></i>
                        {{ $partido->location }}
                    </div>
                </div>
            </div>

            @if(Auth::check() && Auth::user()->role === 'superadmin')
                <div class="card-footer bg-transparent border-top-0 py-3">
                    <div class="d-flex justify-content-center gap-2">
                        <a href="{{ route('tournaments.matches.edit', ['tournament' => $torneo->id, 'match' => $partido->id]) }}" 
                           class="btn btn-sm btn-primary rounded-pill px-3">
                           <i class="fas fa-edit me-2"></i>Editar
                        </a>
                        <form action="{{ route('tournaments.matches.destroy', ['tournament' => $torneo->id, 'match' => $partido->id]) }}" 
                              method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger rounded-pill px-3" 
                                    onclick="return confirm('¿Estás seguro de eliminar este partido?')">
                                <i class="fas fa-trash-alt me-2"></i>Eliminar
                            </button>
                        </form>
                    </div>
                </div>
            @endif
        </div>
    </div>
@endforeach

                </div>
            @endif
        </div>
    @endif
</div>
@endsection

@push('styles')
<style>
    .card-torneo.active .card {
        background: #004D40 !important;
        transform: translateY(-5px);
    }
    
    .card-torneo.active .card-title,
    .card-torneo.active .badge {
        color: white !important;
    }
    
    .card-torneo.active .card {
        border: 2px solid #00274D;
    }

    .hover-scale:hover {
        transform: translateY(-5px) scale(1.02);
        cursor: pointer;
    }

    .vs-container {
        display: grid;
        grid-template-columns: 1fr auto 1fr;
        align-items: center;
        gap: 1rem;
    }

    .vs-circle {
        width: 50px;
        height: 50px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: bold;
        margin: 0 auto;
    }

    .team {
        display: flex;
        flex-direction: column;
        align-items: center;
    }

    .team-logo {
    width: 60px;
    height: 60px;
    border-radius: 50%;
    background: #eee;
    margin-bottom: 0.5rem;
    /* Aseguramos que el contenido se centre */
    display: flex;
    justify-content: center;
    align-items: center;
}


    .match-info {
        background: rgba(0, 77, 64, 0.05);
        border-radius: 10px;
        padding: 1rem;
        margin-top: 1.5rem;
    }

    .info-item {
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0.5rem 0;
    }
</style>
@endpush
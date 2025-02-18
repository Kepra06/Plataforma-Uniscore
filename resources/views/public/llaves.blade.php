@extends('layouts.app')

@section('content')
@php
    // Se obtiene el partido correspondiente a la ronda "Final"
    $finalMatch = $partidos->firstWhere('ronda', 'Final');
@endphp
<div class="container my-5">
    <!-- Encabezado -->
    <div class="text-center mb-5">
        <div class="d-flex justify-content-center align-items-center">
            <i class="fas fa-chess-knight fa-3x me-3" style="color: #004D40;"></i>
            <h1 class="display-5 fw-bold m-0" style="color: #00274D;">
                {{ $torneoSeleccionado->name ?? 'Llave de Torneo' }}
            </h1>
        </div>
    </div>

    <!-- Selector de Torneos -->
    <div class="row g-4 mb-5">
        <div class="col-12">
            <h4 class="mb-4 fw-bold" style="color: #00274D;"><i class="fas fa-trophy me-2"></i>Seleccionar Torneo</h4>
        </div>
        @foreach($torneos as $torneo)
            <div class="col-md-3 col-sm-6">
            <a href="{{ route('public.llaves', ['torneo_id' => $torneo->id]) }}" class="text-decoration-none">
            <div class="card h-100 border-0 shadow-sm hover-scale {{ $torneoSeleccionado && $torneoSeleccionado->id == $torneo->id ? 'active-tournament' : '' }}">
                        <div class="card-body text-center">
                            <h5 class="card-title fw-bold mb-3" style="color: #004D40;">
                                {{ $torneo->name }}
                            </h5>
                            <div class="d-flex justify-content-center gap-2 flex-wrap">
                                <span class="badge rounded-pill bg-light text-dark">
                                    <i class="fas fa-calendar-day me-2"></i>{{ \Carbon\Carbon::parse($torneo->start_date)->format('d M') }}
                                </span>
                                <span class="badge rounded-pill bg-primary">
                                    <i class="fas fa-users me-2"></i>{{ $torneo->partidos_count }}
                                </span>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
        @endforeach
    </div>

    @if(isset($torneoSeleccionado) && $partidos->isNotEmpty())
    <!-- Llave de Torneo -->
    <div class="tournament-bracket">
        @foreach (['Primera Ronda', 'Octavos de Final', 'Cuartos de Final', 'Semifinales', 'Final'] as $index => $ronda)
            <div class="round" data-round="{{ $index + 1 }}">
                <div class="round-header">
                    <div class="round-title">{{ $ronda }}</div>
                    @if($index !== 4)
                        <div class="round-line"></div>
                    @endif
                </div>
                
                <div class="matches-wrapper">
                    @foreach ($partidos->where('ronda', $ronda) as $partido)
                    <div class="match">
                        <div class="team 
                            {{ $partido->ganador_id == $partido->equipo_local_id ? 'winner' : '' }}
                            {{ $ronda == 'Final' && $partido->ganador_id == $partido->equipo_local_id ? 'final-winner' : '' }}">
                            <div class="team-logo">
                                @if($partido->ganador_id == $partido->equipo_local_id)
                                    <i class="fas fa-crown winner-icon"></i>
                                @endif
                                <i class="fas fa-futbol team-icon"></i>
                            </div>
                            <div class="team-info">
                                <span class="team-name">{{ $partido->equipoLocal->name ?? 'Por Definir' }}</span>
                                <span class="team-score">
                                    @php
                                        $localEst = \App\Models\EstadisticaEquipo::where('equipo_id', $partido->equipo_local_id)
                                            ->where('partido_id', $partido->id)
                                            ->first();
                                    @endphp
                                    <i class="fas fa-star"></i> {{ $localEst ? $localEst->total_goals : '0' }}
                                </span>
                            </div>
                        </div>
                        
                        <div class="vs-divider">
                            <span class="vs">VS</span>
                            <div class="match-time">
                                <i class="fas fa-clock"></i>
                                {{ \Carbon\Carbon::parse($partido->match_time)->format('h:i A') }}
                            </div>
                        </div>
                        
                        <div class="team 
                            {{ $partido->ganador_id == $partido->equipo_visitante_id ? 'winner' : '' }}
                            {{ $ronda == 'Final' && $partido->ganador_id == $partido->equipo_visitante_id ? 'final-winner' : '' }}">
                            <div class="team-logo">
                                @if($partido->ganador_id == $partido->equipo_visitante_id)
                                    <i class="fas fa-crown winner-icon"></i>
                                @endif
                                <i class="fas fa-futbol team-icon"></i>
                            </div>
                            <div class="team-info">
                                <span class="team-name">{{ $partido->equipoVisitante->name ?? 'Por Definir' }}</span>
                                <span class="team-score">
                                    @php
                                        $visitanteEst = \App\Models\EstadisticaEquipo::where('equipo_id', $partido->equipo_visitante_id)
                                            ->where('partido_id', $partido->id)
                                            ->first();
                                    @endphp
                                    <i class="fas fa-star"></i> {{ $visitanteEst ? $visitanteEst->total_goals : '0' }}
                                </span>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        @endforeach
    </div>
    @else
    <div class="empty-state text-center py-5">
        <i class="fas fa-trophy fa-4x mb-4" style="color: #004D40;"></i>
        <h3 class="fw-bold mb-3">No hay partidos disponibles</h3>
        <p class="text-muted">Selecciona un torneo para ver su llave</p>
    </div>
    @endif
</div>
@endsection

@push('styles')
<style>
    .tournament-bracket {
        display: grid;
        grid-auto-flow: column;
        gap: 2rem;
        overflow-x: auto;
        padding: 2rem 0;
    }
    .round {
        position: relative;
        min-width: 280px;
    }
    .round-header {
        display: flex;
        align-items: center;
        margin-bottom: 2rem;
    }
    .round-title {
        background: #004D40;
        color: white;
        padding: 0.5rem 1.5rem;
        border-radius: 20px;
        font-size: 1.1rem;
        font-weight: 600;
        z-index: 2;
    }
    .round-line {
        height: 2px;
        background: #004D40;
        flex-grow: 1;
        margin-left: -1rem;
        opacity: 0.2;
    }
    .matches-wrapper {
        display: grid;
        gap: 1.5rem;
        position: relative;
    }
    .match {
        background: white;
        border-radius: 12px;
        padding: 1rem;
        box-shadow: 0 4px 12px rgba(0,0,0,0.08);
        position: relative;
        transition: transform 0.3s ease;
    }
    .match:after {
        content: "";
        position: absolute;
        right: -2rem;
        top: 50%;
        width: 2rem;
        height: 2px;
        background: #004D40;
        opacity: 0.3;
    }
    .round[data-round="5"] .match:after {
        display: none;
    }
    .team {
        display: flex;
        align-items: center;
        gap: 1rem;
        padding: 0.8rem;
        border-radius: 8px;
        margin: 0.5rem 0;
        background: rgba(0, 77, 64, 0.05);
        position: relative;
    }
    .team.winner {
        background: linear-gradient(135deg, #e8f5e9, #c8e6c9);
        border-left: 4px solid #4CAF50;
    }
    .team-logo {
        position: relative;
        width: 40px;
        height: 40px;
        border-radius: 8px;
        background: #eee;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    .team-icon {
        color: #004D40;
        font-size: 1.25rem;
    }
    .winner-icon {
        color: #FFD700;
        position: absolute;
        top: -8px;
        right: -8px;
        font-size: 1.2rem;
        background: rgba(0,0,0,0.8);
        border-radius: 50%;
        padding: 3px;
        z-index: 2;
    }
    .team-info {
        flex-grow: 1;
    }
    .team-name {
        font-weight: 600;
        color: #00274D;
        display: block;
        margin-bottom: 0.2rem;
    }
    /* Estilo actualizado para team-score (no tan grande) */
    .team-score {
        background: #004D40;
        color: #fff;
        font-size: 0.85rem;
        font-weight: bold;
        padding: 0.15rem 0.5rem;
        border-radius: 10px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 0.2rem;
        min-width: 40px;
        text-align: center;
    }
    .vs-divider {
        text-align: center;
        margin: 1rem 0;
        position: relative;
    }
    .vs {
        background: #004D40;
        color: white;
        width: 40px;
        height: 40px;
        border-radius: 50%;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        font-size: 0.9rem;
        font-weight: bold;
    }
    .match-time {
        color: #666;
        font-size: 0.8rem;
        margin-top: 0.5rem;
    }
    .active-tournament {
        border: 2px solid #004D40 !important;
        transform: translateY(-5px);
        box-shadow: 0 6px 15px rgba(0,77,64,0.2) !important;
    }
    @media (max-width: 768px) {
        .tournament-bracket {
            grid-auto-flow: row;
            gap: 3rem;
        }
        .round {
            min-width: 100%;
        }
        .match:after {
            display: none;
        }
        .round-header {
            margin-bottom: 1.5rem;
        }
        .round-title {
            font-size: 1rem;
            padding: 0.4rem 1.2rem;
        }
        .team {
            padding: 0.6rem;
        }
        .team-logo {
            width: 35px;
            height: 35px;
        }
        .vs {
            width: 35px;
            height: 35px;
            font-size: 0.8rem;
        }
    }
    .empty-state {
        background: rgba(0, 77, 64, 0.05);
        border-radius: 16px;
        padding: 3rem !important;
    }
    /* Estilo para resaltar al ganador en la final */
    .final-winner {
        animation: winnerHighlight 2s ease-in-out infinite;
    }
    @keyframes winnerHighlight {
        0%, 100% { box-shadow: 0 0 10px #FFD700; }
        50% { box-shadow: 0 0 20px #FFD700; }
    }
</style>
@endpush

@push('scripts')
<!-- Incluir la librería canvas-confetti desde un CDN -->
<script src="https://cdn.jsdelivr.net/npm/canvas-confetti@1.5.1/dist/confetti.browser.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Se dispara el confeti si en la final hay un ganador definido
        @if(isset($finalMatch) && $finalMatch->ganador_id)
            // Función para lanzar confeti de manera creativa
            function launchConfetti() {
                confetti({
                    particleCount: 150,
                    spread: 70,
                    origin: { y: 0.6 }
                });
            }
            
            // Lanza el confeti en intervalos para prolongar el efecto
            launchConfetti();
            let count = 0;
            const interval = setInterval(() => {
                launchConfetti();
                count++;
                if (count >= 5) clearInterval(interval);
            }, 1500);
        @endif
    });
</script>
@endpush

@extends('layouts.app')

@section('content')
    @php
        // Buscamos el partido de la ronda "Final" para aplicar el efecto de confeti, si corresponde.
        $finalMatch = null;
        foreach ($estadisticas as $matchStats) {
            if ($matchStats->first()->partido->ronda === 'Final') {
                $finalMatch = $matchStats->first()->partido;
                break;
            }
        }
    @endphp

    <div class="container my-5">
        {{-- Encabezado --}}
        <div class="text-center mb-5">
            <div class="d-flex justify-content-center align-items-center">
                <i class="fas fa-chart-bar fa-3x me-3" style="color: #004D40;"></i>
                <h1 class="display-5 fw-bold m-0" style="color: #00274D;">
                    {{ $torneo ? $torneo->name : 'Estadísticas de Torneo' }}
                </h1>
            </div>
            @if(Auth::check() && Auth::user()->role === 'superadmin' && $torneo)
                <a href="{{ route('statistics.create', ['tournament' => $torneo->id]) }}"
                   class="btn btn-lg text-white shadow-sm rounded-pill px-4 mt-3 hover-scale"
                   style="background-color: #004D40; transition: all 0.3s ease;">
                    <i class="fas fa-plus-circle me-2"></i> Agregar Estadística
                </a>
            @endif
        </div>

        {{-- Selector de Torneos --}}
        <div class="row g-4 mb-5 justify-content-center">
            <div class="col-12">
                <h4 class="mb-4 fw-bold" style="color: #00274D;">
                    <i class="fas fa-trophy me-2"></i>Seleccionar Torneo
                </h4>
            </div>
            @foreach($torneos as $t)
                <div class="col-md-3 col-sm-6">
                    <a href="{{ route('statistics.index', ['torneo_id' => $t->id]) }}" class="text-decoration-none">
                        <div class="card h-100 border-0 shadow-sm hover-scale {{ ($torneo && $torneo->id == $t->id) ? 'active-tournament' : '' }}">
                            <div class="card-body text-center">
                                <h5 class="card-title fw-bold mb-3" style="color: #004D40;">
                                    {{ $t->name }}
                                </h5>
                                <div class="d-flex justify-content-center gap-2 flex-wrap">
                                    <span class="badge rounded-pill bg-light text-dark">
                                        <i class="fas fa-calendar-day me-2"></i>{{ \Carbon\Carbon::parse($t->start_date)->format('d M') }}
                                    </span>
                                    <span class="badge rounded-pill bg-primary">
                                        <i class="fas fa-chart-bar me-2"></i>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
            @endforeach
        </div>

        {{-- Estadísticas del torneo seleccionado --}}
        @if($torneo && $estadisticas->isNotEmpty())
            <div class="row g-4">
                @foreach($estadisticas as $partidoId => $estadisticasPartido)
                    @php
                        $partido = $estadisticasPartido->first()->partido;
                    @endphp
                    <div class="col-md-6">
                        <div class="card match-card h-100 shadow-sm border-0 hover-scale"
                             style="transition: all 0.3s ease; background: linear-gradient(145deg, #f8f9fa, #ffffff);">
                            {{-- Cabecera del Partido --}}
                            <div class="card-header bg-primary text-white rounded-top-3 py-3">
                                <div class="d-flex justify-content-between align-items-center">
                                    <span class="badge bg-white text-primary rounded-pill">
                                        <i class="fas fa-futbol me-1"></i>{{ $partido->ronda ?? 'Partido' }}
                                    </span>
                                    <small>{{ \Carbon\Carbon::parse($partido->match_time)->isoFormat('DD MMM YYYY') }}</small>
                                </div>
                            </div>

                            {{-- Cuerpo del Partido --}}
<div class="card-body py-4">
    <div class="container text-center">

        <!-- Sección Ganador / Empate -->
        <div class="row justify-content-center mb-4">
            <div class="col-auto">
                @if($partido->ganador_id)
                    <span class="badge bg-success rounded-pill px-3 py-2 shadow">
                        <i class="fas fa-trophy me-2"></i>Ganador: {{ $partido->ganador->name }}
                    </span>
                @else
                    <span class="badge bg-warning rounded-pill px-3 py-2 shadow">
                        <i class="fas fa-handshake me-2"></i>Empate
                    </span>
                @endif
            </div>
        </div>

        <!-- Sección de Equipos -->
        <div class="row justify-content-center align-items-center mb-4">
            <!-- Equipo Local -->
            <div class="col-5 col-md-4">
                <div class="mb-2">
                    <i class="fas fa-futbol fa-3x" style="color: #004D40;"></i>
                </div>
                <h5 class="fw-bold team-local-text">{{ $partido->equipoLocal->name }}</h5>
                <h2 class="text-primary">
                    @php
                        $equipoLocalEst = \App\Models\EstadisticaEquipo::where('equipo_id', $partido->equipo_local_id)
                            ->where('partido_id', $partido->id)
                            ->first();
                    @endphp
                    {{ $equipoLocalEst ? $equipoLocalEst->total_goals : 0 }}
                </h2>
            </div>

            <!-- Círculo VS -->
            <div class="col-2 col-md-2">
                <div class="rounded-circle bg-primary d-flex align-items-center justify-content-center shadow"
                     style="width: 60px; height: 60px; margin: 0 auto;">
                    <span class="text-white fw-bold">VS</span>
                </div>
            </div>

            <!-- Equipo Visitante -->
            <div class="col-5 col-md-4">
                <div class="mb-2">
                    <i class="fas fa-futbol fa-3x" style="color: #004D40;"></i>
                </div>
                <h5 class="fw-bold team-visitante-text">{{ $partido->equipoVisitante->name }}</h5>
                <h2 class="text-primary">
                    @php
                        $equipoVisitanteEst = \App\Models\EstadisticaEquipo::where('equipo_id', $partido->equipo_visitante_id)
                            ->where('partido_id', $partido->id)
                            ->first();
                    @endphp
                    {{ $equipoVisitanteEst ? $equipoVisitanteEst->total_goals : 0 }}
                </h2>
            </div>
        </div>

        <!-- Información del Partido -->
        <div class="row justify-content-center mb-4">
            <div class="col-auto">
                <p class="mb-1">
                    <i class="far fa-clock me-2" style="color: #004D40;"></i>
                    {{ \Carbon\Carbon::parse($partido->match_time)->format('h:i A') }}
                </p>
                <p>
                    <i class="fas fa-map-marker-alt me-2" style="color: #004D40;"></i>
                    {{ $partido->location ?? 'Sin ubicación' }}
                </p>
            </div>
        </div>

        <!-- Estadísticas en Vista Escritorio (Tabla) -->
        <div class="d-none d-md-block">
            <table class="table table-bordered text-center mx-auto" style="width: auto;">
                <thead class="table-light">
                    <tr>
                        <th>Jugador</th>
                        <th>Goles</th>
                        <th>Tarjetas Amarillas</th>
                        <th>Tarjetas Rojas</th>
                        @if(Auth::check() && Auth::user()->role === 'superadmin')
                                            <th>Acciones</th>
                                        @endif                    </tr>
                </thead>
                <tbody>
                    @foreach($estadisticasPartido as $estadistica)
                        <tr>
                            <td>
                                <div class="d-flex flex-column align-items-center">
                                    {{-- Badge del Equipo --}}
                                    @if(optional($estadistica->jugador->equipo)->id == optional($partido->equipo_local)->id)
                                        <span class="badge bg-success team-badge">
                                            {{ optional($estadistica->jugador->equipo)->name }}
                                        </span>
                                    @elseif(optional($estadistica->jugador->equipo)->id == optional($partido->equipo_visitante)->id)
                                        <span class="badge bg-info team-badge">
                                            {{ optional($estadistica->jugador->equipo)->name }}
                                        </span>
                                    @else
                                        <span class="badge bg-secondary team-badge">
                                            {{ optional($estadistica->jugador->equipo)->name }}
                                        </span>
                                    @endif

                                    {{-- Nombre del Jugador con Clase según Equipo --}}
                                    @php
                                        $playerTeamId = optional($estadistica->jugador->equipo)->id;
                                        $localTeamId = optional($partido->equipo_local)->id;
                                        $visitanteTeamId = optional($partido->equipo_visitante)->id;
                                        $playerTeamClass = ($playerTeamId == $localTeamId)
                                            ? 'team-local-text'
                                            : (($playerTeamId == $visitanteTeamId) ? 'team-visitante-text' : '');
                                    @endphp
                                    <span class="player-name fw-bold {{ $playerTeamClass }}">
                                        {{ $estadistica->jugador->name }}
                                    </span>
                                </div>
                            </td>
                            <td>{{ $estadistica->goals }}</td>
                            <td>{{ $estadistica->yellow_cards }}</td>
                            <td>{{ $estadistica->red_cards }}</td>
                            @if(Auth::check() && Auth::user()->role === 'superadmin')

                            <td>

                                @if(Auth::check() && Auth::user()->role === 'superadmin')
                                    <a href="{{ route('statistics.edit', $estadistica->id) }}" class="btn btn-sm btn-primary">Editar</a>
                                    <form action="{{ route('statistics.destroy', $estadistica->id) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger" 
                                                onclick="return confirm('¿Estás seguro de eliminar esta estadística?')">
                                            Eliminar
                                        </button>
                                    </form>
                                @else
                                    N/A
                                @endif
                            </td>
                            @endif
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- Estadísticas en Vista Móvil (Tarjetas) -->
        <div class="d-block d-md-none">
            <div class="row">
                @foreach($estadisticasPartido as $estadistica)
                    <div class="col-12 mb-3">
                        <div class="card shadow-sm">
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-center mb-2">
                                    @if(optional($estadistica->jugador->equipo)->id == optional($partido->equipo_local)->id)
                                        <span class="badge bg-success team-badge">
                                            {{ optional($estadistica->jugador->equipo)->name }}
                                        </span>
                                    @elseif(optional($estadistica->jugador->equipo)->id == optional($partido->equipo_visitante)->id)
                                        <span class="badge bg-info team-badge">
                                            {{ optional($estadistica->jugador->equipo)->name }}
                                        </span>
                                    @else
                                        <span class="badge bg-secondary team-badge">
                                            {{ optional($estadistica->jugador->equipo)->name }}
                                        </span>
                                    @endif

                                    @php
                                        $playerTeamId = optional($estadistica->jugador->equipo)->id;
                                        $localTeamId = optional($partido->equipo_local)->id;
                                        $visitanteTeamId = optional($partido->equipo_visitante)->id;
                                        $playerTeamClass = ($playerTeamId == $localTeamId)
                                            ? 'team-local-text'
                                            : (($playerTeamId == $visitanteTeamId) ? 'team-visitante-text' : '');
                                    @endphp
                                    <h5 class="mb-0 fw-bold {{ $playerTeamClass }}">
                                        {{ $estadistica->jugador->name }}
                                    </h5>
                                </div>
                                <ul class="list-unstyled mb-0">
                                    <li><strong>Goles:</strong> {{ $estadistica->goals }}</li>
                                    <li><strong>Tarjetas Amarillas:</strong> {{ $estadistica->yellow_cards }}</li>
                                    <li><strong>Tarjetas Rojas:</strong> {{ $estadistica->red_cards }}</li>
                                </ul>
                                @if(Auth::check() && Auth::user()->role === 'superadmin')
                                    <div class="d-flex justify-content-end gap-2 mt-3">
                                        <a href="{{ route('statistics.edit', $estadistica->id) }}" class="btn btn-sm btn-primary">Editar</a>
                                        <form action="{{ route('statistics.destroy', $estadistica->id) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger"
                                                    onclick="return confirm('¿Estás seguro de eliminar esta estadística?')">
                                                Eliminar
                                            </button>
                                        </form>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

    </div>
</div>


                            @if(Auth::check() && Auth::user()->role === 'superadmin')
                                {{-- Opciones de edición a nivel de partido (superadmin) --}}
                                <div class="card-footer bg-transparent border-top-0 py-3 text-center">
                                    <div class="d-flex justify-content-center gap-2">
                                        <a href="{{ route('statistics.edit', $estadisticasPartido->first()->id) }}"
                                           class="btn btn-sm btn-primary rounded-pill px-3">
                                            <i class="fas fa-edit me-2"></i>Editar
                                        </a>
                                        <form action="{{ route('statistics.destroy', $estadisticasPartido->first()->id) }}"
                                              method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                    class="btn btn-sm btn-danger rounded-pill px-3"
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
        @else
            <div class="empty-state text-center py-5">
                <i class="fas fa-chart-bar fa-4x mb-4" style="color: #004D40;"></i>
                <h3 class="fw-bold mb-3">No hay estadísticas disponibles</h3>
                <p class="text-muted">Selecciona un torneo para ver las estadísticas</p>
            </div>
        @endif
    </div>
@endsection

@push('styles')
    <style>
        /* Selector de Torneos */
        .hover-scale:hover {
            transform: translateY(-5px) scale(1.02);
            cursor: pointer;
        }
        .active-tournament {
            border: 2px solid #004D40 !important;
            transform: translateY(-5px);
            box-shadow: 0 6px 15px rgba(0,77,64,0.2) !important;
        }
        /* Estilos para vs-container */
        .vs-container {
            display: flex;
            justify-content: center;
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
        }
        .team {
            display: flex;
            flex-direction: column;
            align-items: center;
            text-align: center;
        }
        .team-logo {
            width: 60px;
            height: 60px;
            border-radius: 50%;
            background: #eee;
            margin-bottom: 0.5rem;
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
        /* Alineación de tablas */
        .table td, .table th {
            vertical-align: middle;
            text-align: center;
        }
        /* Tarjetas de estadísticas individuales (vista móvil) */
        .statistic-card {
            border: 1px solid #ddd;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
        }
        .statistic-card .card-body {
            padding: 1rem;
            text-align: center;
        }
        /* Etiquetas de equipo */
        .team-badge {
            font-weight: bold;
            padding: 2px 6px;
            border-radius: 4px;
            font-size: 0.9em;
            margin-bottom: 4px;
            display: inline-block;
        }
        .team-local {
            background-color: #006400; /* verde oscuro */
            color: #fff;
        }
        .team-visitante {
            background-color: #00008b; /* azul oscuro */
            color: #fff;
        }
        /* Clases para el texto de los nombres de equipo */
        .team-local-text {
            color: #006400; /* verde oscuro */
        }
        .team-visitante-text {
            color: #00008b; /* azul oscuro */
        }

        /* Agrega estos estilos */
.resultado-partido .badge {
    font-size: 1.1em;
    padding: 0.75em 1.5em;
    transition: transform 0.2s ease;
}

.resultado-partido .badge:hover {
    transform: scale(1.05);
}

.bg-success {
    background-color: #28a745 !important;
}

.bg-warning {
    background-color: #ffc107 !important;
}
    </style>
@endpush

@push('scripts')
    <!-- Se incluye canvas-confetti para el efecto en la final -->
    <script src="https://cdn.jsdelivr.net/npm/canvas-confetti@1.5.1/dist/confetti.browser.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            @if(isset($finalMatch) && $finalMatch->ganador_id)
                function launchConfetti() {
                    confetti({
                        particleCount: 150,
                        spread: 70,
                        origin: { y: 0.6 }
                    });
                }
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

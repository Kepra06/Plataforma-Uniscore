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
            <a href="{{ route('statistics.create', ['tournament' => $torneo->id]) }}" 
               class="btn btn-lg text-white shadow-sm rounded-pill px-4 mt-3 hover-scale" 
               style="background-color: #004D40; transition: all 0.3s ease;">
                <i class="fas fa-plus-circle me-2"></i> Agregar Estadística
            </a>
        @endif
    </div>

    <!-- Selector de torneos estilo cards -->
    <div class="row g-4 mb-5">
        <div class="col-12">
            <h4 class="mb-3 fw-bold" style="color: #00274D;">
                <i class="fas fa-list-ol me-2"></i>Torneos Disponibles
            </h4>
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
                                    {{ $torneoOption->matches_count ?? 0 }} Partidos
                                </span>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
        @endforeach
    </div>

    <!-- Estadísticas del torneo seleccionado -->
    @if($torneo)
        @if($estadisticas->isEmpty())
            <div class="alert alert-info text-center">
                No hay estadísticas disponibles para este torneo. ¡Agrega una nueva estadística!
            </div>
        @else
            @foreach ($estadisticas as $partidoId => $estadisticasPartido)
                @php
                    // Obtenemos el partido de la primera estadística del grupo
                    $partido = $estadisticasPartido->first()->partido;
                @endphp
                <div class="card mt-3 shadow-sm rounded border-0 animate__animated animate__fadeInUp">
                    <!-- Cabecera del partido -->
                    <div class="card-header d-flex flex-wrap justify-content-between align-items-center" style="background-color: #00274D; color: white;">
                        <h3 class="mb-0" style="word-break: break-word;">
                            <i class="fas fa-futbol"></i> Partido: 
                            {{ $partido->equipoLocal->name }} vs 
                            {{ $partido->equipoVisitante->name }}
                        </h3>
                        <div class="mt-2 mt-md-0">
                            <span class="badge badge-primary" style="font-size: 1.1rem; padding: 0.5rem 1rem; margin-right: 10px; display: inline-block; white-space: normal; word-break: break-word;">
                               Resultado Final: {{ $resultados[$partidoId]['resultado_final'] }}
                            </span>
                            <span class="badge badge-success" style="font-size: 1.1rem; padding: 0.5rem 1rem;">
                               @if ($resultados[$partidoId]['es_empate'])
                                   Empate
                               @else
                                   Ganador: {{ $resultados[$partidoId]['ganador'] }}
                               @endif
                            </span>
                        </div>
                    </div>
                    <div class="card-body">
                        <!-- Vista para escritorio -->
                        <div class="table-responsive d-none d-md-block">
                            <table class="table table-bordered table-striped text-center mb-0">
                                <thead style="background-color: #00274D; color: white;">
                                    <tr>
                                        <th>Jugador</th>
                                        <th>Goles</th>
                                        <th>Tarjetas Amarillas</th>
                                        <th>Tarjetas Rojas</th>
                                        @if(Auth::check() && Auth::user()->role === 'superadmin')
                                            <th>Acciones</th>
                                        @endif
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($estadisticasPartido as $estadistica)
                                        @php
                                            // Se define el color según el equipo del jugador
                                            $playerTeamId = $estadistica->jugador->equipo->id;
                                            $teamColor = ($playerTeamId == $partido->equipo_local_id) 
                                                            ? '#003366' 
                                                            : (($playerTeamId == $partido->equipo_visitante_id) 
                                                                ? '#004d40' 
                                                                : '#000');
                                        @endphp
                                        <tr>
                                            <td>
                                                <div>{{ $estadistica->jugador->name }}</div>
                                                <small style="background-color: #eee; color: {{ $teamColor }}; padding: 2px 6px; border-radius: 3px; font-size: 0.75rem;">
                                                    {{ $estadistica->jugador->equipo->name }}
                                                </small>
                                            </td>
                                            <td>
                                                <span class="font-weight-bold">{{ $estadistica->goals }}</span> 
                                                <i class="fas fa-futbol text-success"></i>
                                            </td>
                                            <td>
                                                <span class="font-weight-bold">{{ $estadistica->yellow_cards }}</span> 
                                                <i class="fas fa-exclamation-triangle text-warning"></i>
                                            </td>
                                            <td>
                                                <span class="font-weight-bold">{{ $estadistica->red_cards }}</span> 
                                                <i class="fas fa-ban text-danger"></i>
                                            </td>
                                            @if(Auth::check() && Auth::user()->role === 'superadmin')
                                                <td>
                                                    <div class="btn-group" role="group">
                                                        <a href="{{ route('statistics.edit', $estadistica->id) }}" class="btn btn-outline-primary btn-sm">
                                                            <i class="fas fa-edit"></i> Editar
                                                        </a>
                                                        <form action="{{ route('statistics.destroy', $estadistica->id) }}" method="POST">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="btn btn-outline-danger btn-sm ml-2" onclick="return confirm('¿Está seguro?')">
                                                                <i class="fas fa-trash-alt"></i> Eliminar
                                                            </button>
                                                        </form>
                                                    </div>
                                                </td>
                                            @endif
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <!-- Vista para dispositivos móviles -->
                        <div class="d-md-none">
                            @foreach ($estadisticasPartido as $estadistica)
                                @php
                                    $playerTeamId = $estadistica->jugador->equipo->id;
                                    $teamColor = ($playerTeamId == $partido->equipo_local_id) 
                                                    ? '#003366' 
                                                    : (($playerTeamId == $partido->equipo_visitante_id) 
                                                        ? '#004d40' 
                                                        : '#000');
                                @endphp
                                <div class="card mb-3 shadow-sm border-0">
                                    <div class="card-body">
                                        <h5 class="card-title mb-1">
                                            {{ $estadistica->jugador->name }}
                                        </h5>
                                        <div class="mb-2">
                                            <small style="background-color: #eee; color: {{ $teamColor }}; padding: 3px 8px; border-radius: 3px; font-size: 0.85rem; display: inline-block; max-width: 100%; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">
                                                {{ $estadistica->jugador->equipo->name }}
                                            </small>
                                        </div>
                                        <p class="card-text">
                                            <strong>Goles:</strong> {{ $estadistica->goals }} <i class="fas fa-futbol text-success"></i><br>
                                            <strong>Tarjetas Amarillas:</strong> {{ $estadistica->yellow_cards }} <i class="fas fa-exclamation-triangle text-warning"></i><br>
                                            <strong>Tarjetas Rojas:</strong> {{ $estadistica->red_cards }} <i class="fas fa-ban text-danger"></i>
                                        </p>
                                        @if(Auth::check() && Auth::user()->role === 'superadmin')
                                            <div class="btn-group" role="group">
                                                <a href="{{ route('statistics.edit', $estadistica->id) }}" class="btn btn-outline-primary btn-sm">
                                                    <i class="fas fa-edit"></i> Editar
                                                </a>
                                                <form action="{{ route('statistics.destroy', $estadistica->id) }}" method="POST" class="d-inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-outline-danger btn-sm" onclick="return confirm('¿Está seguro?')">
                                                        <i class="fas fa-trash-alt"></i> Eliminar
                                                    </button>
                                                </form>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            @endforeach
        @endif
    @endif
</div>
@endsection

@push('styles')
<style>
    /* Estilos para resaltar el torneo seleccionado */
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
</style>
@endpush

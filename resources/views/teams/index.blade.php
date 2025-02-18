@extends('layouts.app')

@section('content')
<div class="text-center my-4">
    <h1 class="display-4" style="color: #00274D; font-weight: bold;">Administración de Equipos</h1>
    <p class="lead" style="color: #004D40;">Organización por Grupos y Torneos</p>
</div>

@forelse($torneos as $torneo)
    <div class="mb-5 torneo-section">
        <!-- Encabezado del Torneo -->
        <div class="text-center mb-4">
            <h2 class="display-5 torneo-title">
                <i class="fas fa-trophy trophy-icon"></i> 
                {{ $torneo->name }}
            </h2>
            
            @if(Auth::check() && Auth::user()->role === 'superadmin')
                <a href="{{ route('teams.create', ['torneo' => $torneo->id]) }}" 
                   class="btn btn-success btn-lg add-team-btn">
                    <i class="fas fa-plus-circle"></i> Agregar Equipo
                </a>
            @endif
        </div>

        <!-- Grupos del Torneo -->
        <div class="row grupos-container">
            @foreach(['A', 'B'] as $grupo)
                <div class="col-12 col-md-6 mb-4">
                    <div class="card shadow grupo-card">
                        <div class="card-header grupo-header {{ $grupo === 'A' ? 'grupo-a' : 'grupo-b' }}">
                            <h3 class="mb-0">Grupo {{ $grupo }}</h3>
                        </div>
                        
                        <div class="card-body grupo-body">
                            @forelse($torneo->equipos->where('grupo', $grupo) as $equipo)
                                <div class="equipo-item">
                                    <!-- Escudo del Equipo -->
                                    <div class="escudo-container">
                                        @if($equipo->escudo_url)
                                            <img src="{{ asset($equipo->escudo_url) }}" 
                                                 alt="Escudo de {{ $equipo->name }}" 
                                                 class="escudo-img">
                                        @else
                                            <div class="escudo-placeholder">
                                                <i class="fas fa-shield-alt"></i>
                                            </div>
                                        @endif
                                    </div>

                                    <!-- Información del Equipo -->
                                    <div class="equipo-info">
                                        <h4 class="equipo-nombre">{{ $equipo->name }}</h4>
                                        <p class="equipo-detalle">
                                            <strong>Coach:</strong> 
                                            {{ $equipo->coach ?? 'Sin entrenador' }}
                                        </p>
                                    </div>

                                    <!-- Acciones -->
                                    <div class="equipo-acciones">
                                        @if(Auth::check() && Auth::user()->role === 'superadmin')
                                            <a href="{{ route('teams.edit', ['torneo' => $torneo->id, 'equipoId' => $equipo->id]) }}" 
                                               class="btn btn-primary btn-sm action-btn"
                                               title="Editar">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                        @endif
                                        
                                        <a href="{{ route('teams.show', $equipo->id) }}" 
                                           class="btn btn-info btn-sm action-btn"
                                           title="Ver detalle">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        
                                        @if(Auth::check() && Auth::user()->role === 'superadmin')
                                            <form 
                                                action="{{ route('teams.destroy', ['torneo' => $torneo->id, 'equipo' => $equipo->id]) }}" 
                                                method="POST"
                                                class="d-inline"
                                            >
                                                @csrf
                                                @method('DELETE')
                                                <button 
                                                    type="submit" 
                                                    class="btn btn-danger btn-sm action-btn"
                                                    title="Eliminar"
                                                    onclick="return confirm('¿Estás seguro de eliminar este equipo?')"
                                                >
                                                    <i class="fas fa-trash-alt"></i>
                                                </button>
                                            </form>
                                        @endif
                                    </div>
                                </div>
                            @empty
                                <p class="text-muted no-equipos">No hay equipos en este grupo</p>
                            @endforelse
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@empty
    <div class="alert alert-warning text-center">
        No hay torneos registrados. Comienza creando uno nuevo.
    </div>
@endforelse

@endsection

@push('styles')
<style>
    .torneo-title {
        color: #00274D;
        font-weight: 600;
        margin-bottom: 1.5rem;
    }
    
    .trophy-icon {
        color: #FFD700;
        margin-right: 10px;
    }
    
    .add-team-btn {
        background-color: #004D40;
        border: none;
        padding: 0.5rem 1.5rem;
        border-radius: 25px;
        font-size: 1.1rem;
    }
    
    .grupo-header {
        padding: 1rem;
        border-radius: 8px 8px 0 0;
    }
    
    .grupo-a { background-color: #00274D; }
    .grupo-b { background-color: #004D40; }
    
    .equipo-item {
        display: flex;
        align-items: center;
        padding: 1rem;
        margin-bottom: 1rem;
        background: white;
        border-radius: 8px;
        box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        transition: transform 0.2s;
    }
    
    .equipo-item:hover {
        transform: translateY(-2px);
    }
    
    .escudo-container {
        flex: 0 0 60px;
        margin-right: 1rem;
    }
    
    .escudo-img {
        width: 60px;
        height: 60px;
        border-radius: 50%;
        object-fit: cover;
        border: 2px solid #ddd;
    }
    
    .escudo-placeholder {
        width: 60px;
        height: 60px;
        border-radius: 50%;
        background: #6c757d;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-size: 1.5rem;
    }
    
    .equipo-info {
        flex: 1;
        margin-right: 1rem;
    }
    
    .equipo-nombre {
        color: #00274D;
        font-size: 1.1rem;
        margin-bottom: 0.3rem;
    }
    
    .equipo-detalle {
        color: #004D40;
        margin-bottom: 0;
        font-size: 0.9rem;
    }
    
    .equipo-acciones {
        flex: 0 0 auto;
        display: flex;
        gap: 0.5rem;
    }
    
    .action-btn {
        width: 34px;
        height: 34px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 50% !important;
    }
    
    .no-equipos {
        text-align: center;
        padding: 1rem;
        font-style: italic;
    }
</style>
@endpush
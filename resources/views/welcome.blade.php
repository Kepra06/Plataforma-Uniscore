@extends('layouts.app')

@section('content')

    <!-- Sección de Bienvenida -->
    <section class="welcome-section bg-gradient-to-r from-green-500 to-blue-600 text-white py-8 md:py-16">
        <div class="container mx-auto px-4 sm:px-6 lg:px-8">
            <div class="max-w-3xl mx-auto">
                @guest
                <div class="p-6 md:p-8 bg-white/20 backdrop-blur-sm rounded-2xl shadow-2xl border border-white/10">
                    <div class="mb-4 text-6xl text-white">
                        <i class="fas fa-trophy"></i>
                    </div>
                    <h1 class="text-2xl md:text-4xl font-bold mb-4 text-white">¡Bienvenido a UNISCORE!</h1>
                    <p class="text-sm md:text-lg mb-6 text-white/90 leading-relaxed">
                        Explora torneos deportivos, consulta tablas de posiciones y próximos partidos en tiempo real.
                    </p>
                    <div class="flex flex-col md:flex-row gap-4 justify-center">
                        <a href="{{ route('login') }}" class="w-full md:w-auto px-6 py-3 bg-white/10 hover:bg-white/20 text-white font-semibold rounded-xl transition-all duration-300 flex items-center justify-center gap-2">
                            <i class="fas fa-sign-in-alt"></i>
                            Iniciar Sesión
                        </a>
                    </div>
                </div>
                @endguest

                @auth
                <div class="p-6 md:p-8 bg-white/20 backdrop-blur-sm rounded-2xl shadow-2xl border border-white/10">
                    <div class="mb-4 text-6xl text-white">
                        @if(auth()->user()->role == 'superadmin')
                            <i class="fas fa-crown"></i>
                        @elseif(auth()->user()->role == 'coach')
                            <i class="fas fa-whistle"></i>
                        @else
                            <i class="fas fa-user-graduate"></i>
                        @endif
                    </div>
                    <h2 class="text-2xl md:text-3xl font-bold mb-4 text-white">¡Hola, {{ auth()->user()->name ?? auth()->user()->username }}!</h2>
                    <p class="text-sm md:text-lg mb-6 text-white/90">
                        @if(auth()->user()->role == 'superadmin')
                        Gestiona torneos, usuarios y configuración del sistema con las herramientas avanzadas.
                        @elseif(auth()->user()->role == 'coach')
                        Administra tus equipos, revisa estadísticas y programa entrenamientos.
                        @else
                        Sigue tu progreso, participa en torneos y mejora tu rendimiento.
                        @endif
                    </p>
                    <div class="flex flex-col md:flex-row gap-4 justify-center">
                        <a href="{{ route('logout.perform') }}" class="px-6 py-3 bg-red-500/90 hover:bg-red-600 text-white font-semibold rounded-xl transition-all duration-300 flex items-center justify-center gap-2">
                            <i class="fas fa-sign-out-alt"></i>
                            Cerrar Sesión
                        </a>
                    </div>
                </div>
                @endauth
            </div>
        </div>
    </section>

    <!-- Partidos Programados -->
    <section class="py-8 md:py-12 bg-gray-50">
        <div class="container mx-auto px-4 sm:px-6 lg:px-8">
            @if(isset($torneos) && $torneos->count() > 0)
                @foreach($torneos as $torneo)
                <div class="mb-8 md:mb-12">
                    <h3 class="text-xl md:text-2xl font-bold text-gray-800 mb-4 md:mb-6 flex items-center gap-2">
                        <i class="fas fa-calendar-alt text-blue-500"></i>
                        Partidos Programados - {{ $torneo->name }}
                    </h3>
                    
                    @if($torneo->partidos->isEmpty())
                        <div class="p-4 bg-yellow-50 text-yellow-800 rounded-lg border border-yellow-200 flex items-center gap-3">
                            <i class="fas fa-exclamation-circle"></i>
                            No hay partidos programados para este torneo
                        </div>
                    @else
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                            @foreach($torneo->partidos as $partido)
                            <div class="bg-white p-4 md:p-6 rounded-xl shadow-sm hover:shadow-md transition-shadow duration-200">
                                <div class="flex flex-col gap-3">
                                    <div class="flex items-center justify-between">
                                        <span class="text-sm font-medium bg-blue-100 text-blue-800 px-3 py-1 rounded-full">
                                            {{ $partido->ronda }}
                                        </span>
                                        <span class="text-sm text-gray-500">
                                            <i class="fas fa-map-marker-alt mr-1"></i>{{ $partido->location }}
                                        </span>
                                    </div>
                                    
                                    <div class="my-4">
                                        <div class="flex items-center justify-center gap-4">
                                            @if($partido->equipoLocal && $partido->equipoVisitante)
                                            <div class="text-center">
                                                <p class="font-bold text-gray-800">{{ $partido->equipoLocal->name }}</p>
                                                <p class="text-lg font-semibold text-blue-500">
                                                    {{ $partido->estadisticas->firstWhere('equipo_id', $partido->equipo_local_id)?->total_goals ?? 0 }}
                                                </p>
                                            </div>
                                            <span class="text-2xl font-bold text-gray-500">vs</span>
                                            <div class="text-center">
                                                <p class="font-bold text-gray-800">{{ $partido->equipoVisitante->name }}</p>
                                                <p class="text-lg font-semibold text-blue-500">
                                                    {{ $partido->estadisticas->firstWhere('equipo_id', $partido->equipo_visitante_id)?->total_goals ?? 0 }}
                                                </p>
                                            </div>
                                            @else
                                            <p class="text-gray-500 italic">Equipos por definir</p>
                                            @endif
                                        </div>
                                    </div>
                                    
                                    <div class="border-t pt-4">
                                        <div class="flex items-center justify-between text-sm text-gray-600">
                                            <div class="flex items-center gap-2">
                                                <i class="fas fa-calendar-day"></i>
                                                {{ \Carbon\Carbon::parse($partido->match_date)->format('d/m/Y') }}
                                            </div>
                                            <div class="flex items-center gap-2">
                                                <i class="fas fa-clock"></i>
                                                {{ \Carbon\Carbon::parse($partido->match_time)->format('h:i A') }}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    @endif
                </div>
                @endforeach
            @else
                <p class="text-center text-gray-500">No hay torneos activos en este momento.</p>
            @endif
        </div>
    </section>

    <!-- Sección de Información General -->
    <section class="py-8 md:py-12 bg-white">
        <div class="container mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-8 md:mb-12">
                <h2 class="text-2xl md:text-3xl font-bold text-gray-800 mb-2">
                    <i class="fas fa-info-circle text-blue-500 mr-2"></i>Información General
                </h2>
                <p class="text-gray-600 max-w-2xl mx-auto">
                    UNISCORE es la plataforma definitiva para la gestión y visualización de torneos deportivos.
                </p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="bg-gradient-to-br from-blue-50 to-blue-100 p-6 md:p-8 rounded-2xl border border-blue-100">
                    <div class="flex items-center gap-4 mb-4">
                        <div class="bg-blue-500 p-3 rounded-lg">
                            <i class="fas fa-eye text-white text-2xl"></i>
                        </div>
                        <h3 class="text-xl font-semibold text-gray-800">Para Visitantes</h3>
                    </div>
                    <p class="text-gray-600 leading-relaxed">
                        Accede a información detallada de torneos, resultados en tiempo real y estadísticas históricas sin necesidad de registro.
                    </p>
                </div>

                <div class="bg-gradient-to-br from-green-50 to-green-100 p-6 md:p-8 rounded-2xl border border-green-100">
                    <div class="flex items-center gap-4 mb-4">
                        <div class="bg-green-500 p-3 rounded-lg">
                            <i class="fas fa-cogs text-white text-2xl"></i>
                        </div>
                        <h3 class="text-xl font-semibold text-gray-800">Para Administradores</h3>
                    </div>
                    <p class="text-gray-600 leading-relaxed">
                        Sistema completo de gestión con herramientas avanzadas para organización de torneos, control de resultados y análisis estadístico.
                    </p>
                </div>
            </div>
        </div>
    </section>

    @auth
    <!-- Sección de Administración -->
    <section class="py-8 md:py-12 bg-gray-50">
        <div class="container mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-8 md:mb-12">
                <h2 class="text-2xl md:text-3xl font-bold text-gray-800 mb-2">
                    <i class="fas fa-tools text-blue-500 mr-2"></i>Administración de Torneos
                </h2>
            </div>

            <div class="max-w-4xl mx-auto bg-white p-6 md:p-8 rounded-2xl shadow-sm">
                <div class="flex flex-col md:flex-row items-center gap-6">
                    <div class="bg-blue-100 p-4 rounded-xl">
                        <i class="fas fa-trophy text-blue-500 text-4xl"></i>
                    </div>
                    <div class="flex-1">
                        <h3 class="text-xl font-semibold text-gray-800 mb-2">Gestión de Torneos</h3>
                        <p class="text-gray-600 mb-4">
                            Administra todos los aspectos de tus torneos: crea nuevos eventos, edita información existente y realiza seguimiento detallado.
                        </p>
                        <a href="#" class="inline-flex items-center px-5 py-2.5 bg-blue-500 hover:bg-blue-600 text-white rounded-lg transition-colors duration-300">
                            <i class="fas fa-external-link-alt mr-2"></i>Acceder al Panel
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>
    @endauth

    <!-- Sección de Estadísticas -->
    <section class="py-8 md:py-12 bg-white">
        <div class="container mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-8 md:mb-12">
                <h2 class="text-2xl md:text-3xl font-bold text-gray-800 mb-2">
                    <i class="fas fa-chart-pie text-blue-500 mr-2"></i>Resultados y Estadísticas
                </h2>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                <div class="bg-white p-6 rounded-xl border border-gray-200 hover:border-blue-300 transition-all duration-300">
                    <div class="mb-4">
                        <div class="bg-blue-100 w-max p-3 rounded-lg mb-3">
                            <i class="fas fa-futbol text-blue-500 text-2xl"></i>
                        </div>
                        <h3 class="text-lg font-semibold text-gray-800 mb-2">Resultados en Vivo</h3>
                        <p class="text-gray-600 text-sm">Sigue los marcadores en tiempo real de todos los partidos activos</p>
                    </div>
                </div>

                <div class="bg-white p-6 rounded-xl border border-gray-200 hover:border-green-300 transition-all duration-300">
                    <div class="mb-4">
                        <div class="bg-green-100 w-max p-3 rounded-lg mb-3">
                            <i class="fas fa-list-ol text-green-500 text-2xl"></i>
                        </div>
                        <h3 class="text-lg font-semibold text-gray-800 mb-2">Tablas de Posición</h3>
                        <p class="text-gray-600 text-sm">Clasificaciones actualizadas automáticamente según los resultados</p>
                    </div>
                </div>

                <div class="bg-white p-6 rounded-xl border border-gray-200 hover:border-yellow-300 transition-all duration-300">
                    <div class="mb-4">
                        <div class="bg-yellow-100 w-max p-3 rounded-lg mb-3">
                            <i class="fas fa-star text-yellow-500 text-2xl"></i>
                        </div>
                        <h3 class="text-lg font-semibold text-gray-800 mb-2">Destacados</h3>
                        <p class="text-gray-600 text-sm">Goleadores, mejores jugadores y estadísticas individuales</p>
                    </div>
                </div>

                <div class="bg-white p-6 rounded-xl border border-gray-200 hover:border-red-300 transition-all duration-300">
                    <div class="mb-4">
                        <div class="bg-red-100 w-max p-3 rounded-lg mb-3">
                            <i class="fas fa-photo-video text-red-500 text-2xl"></i>
                        </div>
                        <h3 class="text-lg font-semibold text-gray-800 mb-2">Multimedia</h3>
                        <p class="text-gray-600 text-sm">Galería de fotos y videos de los mejores momentos</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

@endsection

<?php

use App\Http\Controllers\GaleriaController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\LogoutController;
use App\Http\Controllers\PublicController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\Auth\SuperAdminController;
use App\Http\Controllers\CoachController;
use App\Http\Controllers\ProfileCoachController;
use App\Http\Controllers\TraineeController;
use App\Http\Controllers\TournamentController;
use App\Http\Controllers\TeamController;
use App\Http\Controllers\PlayerController;
use App\Http\Controllers\MatchController;
use App\Http\Controllers\StatisticController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LlaveController;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
| Aquí se registran las rutas para la aplicación. Estas rutas son cargadas
| por el RouteServiceProvider dentro de un grupo que contiene el middleware "web".
|
*/

// Ruta de la página principal
Route::get('/', function () {
    return view('welcome');
});

// Rutas de autenticación para el SuperAdmin
Route::middleware(['auth', 'role:superadmin'])->group(function () {
    // CRUD de usuarios, accesible solo para el SuperAdmin
    Route::resource('users', UserController::class);

    // Ruta para la creación de roles (incluye los roles 'coach' y 'trainee')
    Route::post('/superadmin/create-role', [SuperAdminController::class, 'createRole'])
        ->name('superadmin.createRole');

    // Dashboard del SuperAdmin
    Route::get('/superadmin', [SuperAdminController::class, 'index'])
        ->name('superadmin.index');

    // Ruta para cerrar sesión del SuperAdmin
    Route::post('/superadmin/logout', [SuperAdminController::class, 'logout'])
        ->name('superadmin.logout');
});

// Rutas de registro solo para el SuperAdmin
Route::get('/register', [RegisterController::class, 'show'])
    ->name('register.show')
    ->middleware('guest');
Route::post('/register', [RegisterController::class, 'register'])
    ->name('register.perform')
    ->middleware('guest');

// Rutas de login (accesibles para cualquier usuario no autenticado)
Route::get('/login', [LoginController::class, 'show'])
    ->name('login')
    ->middleware('guest');
Route::post('/login', [LoginController::class, 'login'])
    ->name('login.perform')
    ->middleware('guest');

Route::middleware('auth')->group(function () {
    // Ruta accesible para superadmin y aprendiz
    Route::get('/trainee', function () {
        return view('view.trainee.index');
    })->name('trainee.dashboard')->middleware('role:trainee|superadmin');

    // Ruta accesible solo para superadmin y coach
    Route::get('/coach', function () {
        return view('view.coach.index');
    })->name('coach.dashboard')->middleware('role:coach|superadmin');

    Route::middleware(['auth'])->prefix('profile')->group(function () {
        Route::get('/{id}', [TraineeController::class, 'show'])
            ->name('profile.show');
    });
    
});

// Rutas para el perfil de los trainees
Route::middleware(['auth'])->group(function () {
    Route::get('/profile/{user_id}', [TraineeController::class, 'show'])->name('rofile.detail');
    Route::get('/trainees', [TraineeController::class, 'index'])->name('trainees.index');
    Route::get('/trainees/edit/{id}', [TraineeController::class, 'edit'])->name('profile.edit');
    Route::put('/profile/update/{user_id}', [TraineeController::class, 'update'])->name('profile.updatetrainess');
});

// Ruta para mostrar el home de usuarios autenticados
Route::get('/home', [HomeController::class, 'index'])
    ->name('home.index')
    ->middleware('auth');

// Ruta para cerrar sesión usando POST (accesible para todos los usuarios autenticados)
Route::post('/logout', [LogoutController::class, 'logout'])
    ->name('logout.perform')
    ->middleware('auth');

// Rutas para gestionar el perfil del aprendiz
Route::get('/perfil/{id}/editar', [TraineeController::class, 'edit'])
    ->name('perfil.editar')
    ->middleware('auth');


Route::put('/perfil/{id}', [TraineeController::class, 'update'])
    ->name('trainee.update')
    ->middleware('auth');



// Rutas para el perfil del coach
Route::middleware('auth')->group(function () {
    Route::get('/coach/perfil/{id}', [ProfileCoachController::class, 'show'])
        ->name('coach.perfil.show');
    Route::get('/coach/perfil-edit/{id}', [ProfileCoachController::class, 'edit'])
        ->name('coach.perfil.edit');
    Route::put('/coach/perfil/{id}', [ProfileCoachController::class, 'update'])
        ->name('coach.perfil.update');
});

// Rutas para los perfiles
Route::middleware(['auth'])->prefix('profile')->group(function () {
    Route::get('/{id}', [TraineeController::class, 'show'])
        ->name('profile.show');
    Route::put('/coach/{user_id}', [ProfileCoachController::class, 'update'])
        ->name('profile.updateCoach');
    Route::put('/{user_id}', [TraineeController::class, 'update'])
        ->name('profile.update');
});

// Rutas para la gestión de torneos y recursos relacionados
Route::middleware(['auth', 'role:superadmin'])->prefix('admin')->group(function () {
    // CRUD de Torneos
    Route::resource('tournaments', TournamentController::class);
    
    // CRUD de Equipos por Torneo
    Route::resource('tournaments.teams', TeamController::class)->shallow();
    

    
    // CRUD de Jugadores por Equipo
    
    Route::resource('teams.players', PlayerController::class)->shallow();
    

    // CRUD de Partidos por Torneo
    Route::resource('tournaments.matches', MatchController::class)->shallow();

    // CRUD de Estadísticas por Partido
    Route::resource('statistics', StatisticController::class)->parameters([
        'statistics' => 'estadistica'
    ])->shallow();

    // Ruta para crear un partido
    Route::get('tournaments/{torneo}/teams/{equipo}/players', [PlayerController::class, 'index'])
        ->name('players.index');
    // Rutas para la gestión de partidos
    Route::resource('tournaments.matches', MatchController::class)
        ->except(['show']);

    // Rutas personalizadas para equipos dentro de torneos
    Route::prefix('torneos/{torneo}/equipos')->group(function () {
        Route::get('/', [TeamController::class, 'index'])->name('teams.index');
        Route::get('/crear', [TeamController::class, 'create'])->name('teams.create');
        Route::post('/', [TeamController::class, 'store'])->name('teams.store');
    });

    // Rutas para gestionar los jugadores
    Route::prefix('torneos/{torneo}/equipos/{equipo}/players')->group(function () {
        Route::get('/create', [PlayerController::class, 'create'])->name('players.create');
        Route::post('/', [PlayerController::class, 'store'])->name('players.store');
    });
});



// Rutas protegidas para la administración de torneos, equipos y jugadores
Route::middleware(['auth', 'role:superadmin'])->prefix('admin')->group(function () {
    // Rutas para mostrar jugadores de un equipo en un torneo


    Route::get('tournaments/{torneo}', [TournamentController::class, 'show'])
        ->name('tournaments.show');

        //Equipo
    Route::resource('admin/equipos', TeamController::class);
    Route::get('teams/{equipo}', [TeamController::class, 'show'])->name('teams.show');
    Route::put('admin/torneos/{torneo}/equipos/{equipoId}', [TeamController::class, 'update'])->name('teams.update');
    Route::get('torneos/{torneo}/equipos', [TeamController::class, 'index'])->name('teams.index');
    Route::get('admin/torneos/{torneo}/equipos/{equipoId}/edit', [TeamController::class, 'edit'])->name('teams.edit');
    Route::delete('/teams/{torneo}/{equipo}', [TeamController::class, 'destroy'])->name('teams.destroy');

    

    //jugadores
    Route::get('admin/tournaments/{torneoId}/teams/{equipoId}/players/create', [PlayerController::class, 'create'])->name('players.create');
    Route::get('/torneo/{torneoId}/equipo/{equipoId}', [EquipoController::class, 'show'])->name('equipos.show');
    Route::get('/admin/teams/{equipo}', [TeamController::class, 'show'])->name('teams.show');
    Route::get('/torneos/{torneoId}/equipos/{equipoId}/jugadores/{jugadorId}/edit', [PlayerController::class, 'edit'])->name('players.edit');
    Route::delete('/torneos/{torneoId}/equipos/{equipoId}/jugadores/{jugadorId}', [PlayerController::class, 'destroy'])->name('players.destroy');
    Route::get('admin/teams/{equipo}', [TeamController::class, 'show'])->name('teams.show');
    

    Route::prefix('players')->group(function () {
        Route::get('create/{torneoId}/{equipoId}', [PlayerController::class, 'create'])->name('players.create');
        Route::post('store/{equipoId}', [PlayerController::class, 'store'])->name('players.store');
        Route::put('update/{equipoId}/{jugadorId}', [PlayerController::class, 'update'])->name('players.update');
        Route::delete('destroy/{equipoId}/{jugadorId}', [PlayerController::class, 'destroy'])->name('players.destroy');
    });
    //llave
    Route::post('/llaves/{id}/update-ganador', [LlaveController::class, 'updateGanador'])->name('llaves.updateGanador');
    // Ruta para mostrar la llave de un torneo específico
    Route::get('/torneos/{id}/llave', [LlaveController::class, 'index'])->name('torneos.llave');
    Route::post('/partidos/{id}/ganador', [PartidoController::class, 'seleccionarGanador']);
    Route::post('/llaves/{id}/update-ganador', [LlaveController::class, 'updateGanador']);



    
    // Ruta para crear un jugador en un equipo de un torneo
    Route::get('tournaments/{torneoId}/teams/{equipoId}/players/create', [PlayerController::class, 'create'])
        ->name('players.create');

    // Ruta para almacenar un nuevo jugador
    Route::post('tournaments/{torneoId}/teams/{equipoId}/players', [PlayerController::class, 'store'])
        ->name('players.store');

    // Ruta para editar un jugador existente
    Route::get('tournaments/{torneoId}/teams/{equipoId}/players/{jugadorId}/edit', [PlayerController::class, 'edit'])
        ->name('players.edit');

    // Ruta para actualizar un jugador
    Route::put('tournaments/{torneoId}/teams/{equipoId}/players/{jugadorId}', [PlayerController::class, 'update'])
        ->name('players.update');

    // Ruta para eliminar un jugador
    Route::delete('tournaments/{torneoId}/teams/{equipoId}/players/{jugadorId}', [PlayerController::class, 'destroy'])
        ->name('players.destroy');
});
// Rutas para la gestión de la galería
Route::middleware(['auth', 'role:superadmin'])->prefix('galeria')->group(function () {
    Route::get('/create', [GaleriaController::class, 'create'])->name('galeria.create'); // Muestra el formulario para crear una nueva galería
    Route::post('/', [GaleriaController::class, 'store'])->name('galeria.store'); // Almacena una nueva galería
    Route::get('/{galeria}/edit', [GaleriaController::class, 'edit'])->name('galeria.edit'); // Muestra el formulario para editar una galería
    Route::put('/{galeria}', [GaleriaController::class, 'update'])->name('galeria.update'); // Actualiza una galería existente
    Route::delete('/{galeria}', [GaleriaController::class, 'destroy'])->name('galeria.destroy'); // Elimina una galería
});

// Rutas públicas
// Rutas públicas (sin el prefijo 'site')
Route::get('/llaves', [LlaveController::class, 'index'])->name('public.llaves');
Route::get('/inicio', [PublicController::class, 'inicio'])->name('public.inicio');
Route::get('/tournaments', [PublicController::class, 'tournaments'])->name('public.tournaments');
Route::get('/teams', [PublicController::class, 'teams'])->name('public.teams');
Route::get('/players', [PublicController::class, 'players'])->name('public.players');
Route::get('/matches', [PublicController::class, 'matches'])->name('public.matches');
Route::get('/results', [PublicController::class, 'results'])->name('public.results');
Route::get('/statistics', [PublicController::class, 'statistics'])->name('public.statistics');
Route::get('/galeria', [GaleriaController::class, 'index'])->name('galeria.index');
Route::get('/players/{torneoId}/{equipoId}', [PlayerController::class, 'index'])->name('players.index');
Route::get('/', [HomeController::class, 'index'])->name('home');

// Esta ruta debe ir AL FINAL para evitar conflicto con las anteriores
Route::get('/{galeria}', [GaleriaController::class, 'show'])->name('galeria.show');

// Hacer la ruta de torneos accesible públicamente
Route::get('teams/{equipo}', [TeamController::class, 'show'])->name('teams.show');
// Hacer que las rutas de estadísticas sean públicas
Route::resource('statistics', StatisticController::class)->parameters([
    'statistics' => 'estadistica'
])->shallow();

Route::put('tournaments/{tournament}/matches/{match}/set-winner', [MatchController::class, 'setWinner'])
    ->name('tournaments.matches.setWinner');

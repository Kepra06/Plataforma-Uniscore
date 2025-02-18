<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Models\Torneo;
use Carbon\Carbon;

class HomeController extends Controller
{
    public function index()
    {
        // Obtener el usuario autenticado (si existe)
        $user = Auth::user();
    
        // Obtener la fecha actual
        $today = Carbon::today();
    
        // Obtener los torneos activos (limitados a 3) y cargar relaciones necesarias:
        // - partidos.estadisticas: para acceder al total de goles
        // - partidos.equipoLocal y partidos.equipoVisitante: para mostrar los nombres de los equipos
        $torneos = Torneo::where('start_date', '<=', $today)
                        ->where('end_date', '>=', $today)
                        ->with(['partidos.estadisticas', 'partidos.equipoLocal', 'partidos.equipoVisitante'])
                        ->take(3)
                        ->get();
    
        // Seleccionar el primer torneo (si existe)
        $torneo = $torneos->isNotEmpty() ? $torneos->first() : null;
    
        // Registro para depuración (opcional)
        if ($torneo === null) {
            logger('No se encontraron torneos activos para mostrar en el welcome');
        } else {
            logger('Torneo activo cargado correctamente:', $torneo->toArray());
        }
    
        // Retornar la vista con los datos necesarios
        return view('welcome', [
            'name'    => $user->name ?? 'Invitado',
            'role'    => $user->role ?? 'guest',
            'torneos' => $torneos,
            'torneo'  => $torneo,
        ]);
    }
}

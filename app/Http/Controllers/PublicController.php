<?php

namespace App\Http\Controllers;

use App\Models\Galeria;
use App\Models\Partido;
use App\Models\Jugador;
use App\Models\Estadistica;
use App\Models\Equipo;
use App\Models\Torneo;
use Carbon\Carbon;
use Illuminate\Http\Request;


class PublicController extends Controller
{
    /**
     * Mostrar la vista de la galería.
     */
    public function gallery()
    {
        $galerias = Galeria::all();
        return view('public.gallery', compact('galerias'));
    }

    /**
     * Mostrar la vista de los partidos.
     */
    public function matches(Request $request)
    {
        // Obtener todos los torneos disponibles
        $torneos = Torneo::all();
    
        // Obtener el torneo seleccionado (si existe)
        $torneoId = $request->input('torneo_id');
        $torneo = $torneoId ? Torneo::findOrFail($torneoId) : null;
    
        // Obtener los partidos del torneo seleccionado (si hay torneo)
        $partidos = $torneo ? Partido::where('torneo_id', $torneo->id)->get() : collect();
    
        return view('public.matches', compact('torneo', 'partidos', 'torneos'));
    }
    
    
    
    
    /**
     * Mostrar la vista de los jugadores.
     */
    public function players()
    {
        $jugadores = Jugador::with('equipo')->get();
        $equipos = Equipo::all(); // Assuming you have an Equipo model for teams
        $torneo = Torneo::first(); // Replace with your logic to get the specific tournament
        return view('public.players', compact('jugadores', 'equipos', 'torneo'));
    }
    
    
    /**
     * Mostrar la vista de las estadísticas.
     */
    public function statistics()
    {
        $estadisticas = Estadistica::with(['jugador', 'jugador.equipo'])->get();
        return view('public.statistics', compact('estadisticas'));
    }

    /**
     * Mostrar la vista de los equipos.
     */
    public function teams()
    {
        $equipos = Equipo::with('torneo')->get();
        $torneos = Torneo::all(); // Obtén todos los torneos
        $torneo = Torneo::first(); // Ajusta esto si es necesario para un torneo específico
    
        return view('public.teams', compact('equipos', 'torneos', 'torneo'));
    }
    
    
    /**
     * Mostrar la vista de los torneos.
     */
    public function tournaments()
    {
        $torneos = Torneo::all();
        return view('public.tournaments', compact('torneos'));
    }

    /**
     * Mostrar la vista de los resultados.
     */
    public function results()
    {
        $estadisticas = Estadistica::with(['jugador', 'jugador.equipo'])->get();
        return view('public.statistics', compact('estadisticas'));
    }

    public function inicio()
    {
        // Obtener la fecha actual
        $today = Carbon::today();

        // Obtener los torneos activos (por ejemplo, limitados a 3)
        $torneos = Torneo::where('start_date', '<=', $today)
                         ->where('end_date', '>=', $today)
                         ->take(3)
                         ->get();

        // Retornar la vista 'public.inicio' y pasar la variable $torneos
        return view('public.inicio', compact('torneos'));
    }
}

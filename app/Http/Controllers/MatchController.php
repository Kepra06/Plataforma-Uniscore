<?php

namespace App\Http\Controllers;

use App\Models\Partido;
use App\Models\Torneo;
use App\Models\Estadistica;

use Illuminate\Http\Request;

class MatchController extends Controller
{
    public function index(Request $request)
    {
        $torneoId = $request->query('torneo_id');
        $torneos = Torneo::withCount('partidos')->get();
        
        $torneo = $torneoId ? Torneo::find($torneoId) : null;
        
        $partidos = $torneo ? 
            Partido::with(['estadisticas', 'equipoLocal', 'equipoVisitante'])
                ->where('torneo_id', $torneoId)
                ->get() : collect();
    
        return view('admin.matches.index', compact('torneos', 'torneo', 'partidos'));
    }
    
    

    public function create(Torneo $tournament)
    {
        $tournament->load('equipos');

        if ($tournament->equipos->isEmpty()) {
            return redirect()->back()->with('error', 'No hay equipos disponibles para programar un partido.');
        }

        // Rondas disponibles para selección
        $rondas = [
            'Primera Ronda',
            'Octavos de Final',
            'Cuartos de Final',
            'Semifinales',
            'Final',
        ];

        return view('admin.matches.create', compact('tournament', 'rondas'));
    }

    public function store(Request $request, Torneo $tournament)
    {
        $request->validate([
            'equipo_local_id' => 'required|exists:equipos,id',
            'equipo_visitante_id' => 'required|exists:equipos,id|different:equipo_local_id',
            'fecha' => 'required|date',
            'hora' => 'required',
            'ubicacion' => 'nullable|string|max:255',
            'ronda' => 'required|in:Primera Ronda,Octavos de Final,Cuartos de Final,Semifinales,Final',
        ]);

        $partido = $tournament->partidos()->create([
            'equipo_local_id' => $request->equipo_local_id,
            'equipo_visitante_id' => $request->equipo_visitante_id,
            'match_date' => $request->fecha,
            'match_time' => $request->hora,
            'location' => $request->ubicacion,
            'ronda' => $request->ronda,
        ]);

        // Crear registros iniciales en estadísticas
        $this->createInitialStatistics($partido);

        return redirect()->route('tournaments.matches.index', ['tournament' => $tournament->id])
            ->with('success', 'Partido creado con éxito.');
    }

    protected function createInitialStatistics(Partido $partido)
    {
        $equipos = [$partido->equipo_local_id, $partido->equipo_visitante_id];

        foreach ($equipos as $equipoId) {
            Estadistica::create([
                'partido_id' => $partido->id,
                'jugador_id' => null,
                'equipo_id' => $equipoId,
                'goals' => 0,
                'yellow_cards' => 0,
                'red_cards' => 0,
            ]);
        }
    }

    public function edit(Torneo $tournament, $matchId)
    {
        $partido = Partido::find($matchId);

        if (!$partido) {
            return redirect()->back()->withErrors('Partido no encontrado');
        }

        $tournament->load('equipos');

        // Rondas disponibles para selección (corregido: agregar Octavos de Final)
        $rondas = [
            'Primera Ronda',
            'Octavos de Final', // Agregado aquí
            'Cuartos de Final',
            'Semifinales',
            'Final',
        ];

        return view('admin.matches.edit', compact('tournament', 'partido', 'rondas'));
    }

    public function update(Request $request, Torneo $tournament, $matchId)
    {
        $partido = Partido::find($matchId);

        if (!$partido) {
            return redirect()->back()->withErrors('Partido no encontrado');
        }

        $request->validate([
            'equipo_local_id' => 'required|exists:equipos,id',
            'equipo_visitante_id' => 'required|exists:equipos,id|different:equipo_local_id',
            'fecha' => 'required|date',
            'hora' => 'required',
            'ubicacion' => 'nullable|string|max:255',
            'ronda' => 'required|in:Primera Ronda,Octavos de Final,Cuartos de Final,Semifinales,Final',
        ]);

        $partido->update([
            'equipo_local_id' => $request->equipo_local_id,
            'equipo_visitante_id' => $request->equipo_visitante_id,
            'match_date' => $request->fecha,
            'match_time' => $request->hora,
            'location' => $request->ubicacion,
            'ronda' => $request->ronda,
        ]);

        return redirect()->route('tournaments.matches.index', ['tournament' => $tournament->id])
            ->with('success', 'Partido actualizado con éxito.');
    }

    public function destroy(Torneo $tournament, $matchId)
    {
        $partido = Partido::find($matchId);

        if (!$partido) {
            return redirect()->back()->withErrors('Partido no encontrado');
        }

        $partido->delete();

        return redirect()->route('tournaments.matches.index', ['tournament' => $tournament->id])
            ->with('success', 'Partido eliminado con éxito.');
    }

    public function setWinner(Request $request, Torneo $tournament, $matchId)
    {
        $partido = Partido::findOrFail($matchId);

        $request->validate([
            'ganador_id' => 'required|exists:equipos,id',
        ]);

        $partido->ganador_id = $request->ganador_id;
        $partido->save();

        return redirect()->route('tournaments.matches.index', ['tournament' => $tournament->id])
            ->with('success', 'Ganador seleccionado con éxito.');
    }
}
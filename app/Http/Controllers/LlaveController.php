<?php

namespace App\Http\Controllers;

use App\Models\Partido;
use App\Models\Torneo;
use Illuminate\Http\Request;

class LlaveController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth')->except(['index', 'show']);
    }

    /**
     * Muestra la vista de las llaves del torneo.
     */
    public function index(Request $request)
    {
        // Obtener todos los torneos disponibles
        $torneos = Torneo::all();
        $torneoSeleccionado = null;
        $partidos = collect(); // Colección vacía para partidos si no hay torneo seleccionado

        if ($request->has('torneo_id') && $request->input('torneo_id') != '') {
            // Buscar el torneo seleccionado
            $torneoSeleccionado = Torneo::find($request->input('torneo_id'));
            if ($torneoSeleccionado) {
                // Obtener partidos del torneo en orden de ronda
                $partidos = Partido::with(['equipoLocal', 'equipoVisitante', 'ganador'])
                    ->where('torneo_id', $torneoSeleccionado->id)
                    ->orderBy('ronda', 'asc')
                    ->get();
            }
        }

        return view('public.llaves', [
            'partidos' => $partidos,
            'torneos' => $torneos,
            'torneoSeleccionado' => $torneoSeleccionado, // Renombramos para que coincida con la vista
        ]);
    }

    /**
     * Actualiza el ganador de un partido y lo pasa a la siguiente ronda.
     */
    public function updateGanador(Request $request, $id)
    {
        $request->validate([
            'ganador_id' => 'nullable|exists:equipos,id',
        ]);

        $partido = Partido::findOrFail($id);

        // Actualiza o revierte el ganador
        $partido->ganador_id = $request->ganador_id;
        $partido->save();

        // Lógica adicional: gestionar siguiente ronda
        if ($request->ganador_id) {
            $this->gestionarSiguienteRonda($partido);
        }

        return response()->json(['success' => true]);
    }

    /**
     * Gestiona el paso del equipo ganador a la siguiente ronda.
     */
    private function gestionarSiguienteRonda(Partido $partido)
    {
        // Agrega 'Octavos de Final' al array de rondas
        $rondas = ['Primera Ronda', 'Octavos de Final', 'Cuartos de Final', 'Semifinales', 'Final'];
        $indiceActual = array_search($partido->ronda, $rondas);

        if ($indiceActual !== false && $indiceActual < count($rondas) - 1) {
            $nuevaRonda = $rondas[$indiceActual + 1];

            $partidoExistente = Partido::where('ronda', $nuevaRonda)
                ->where('torneo_id', $partido->torneo_id)
                ->whereNull('equipo_visitante_id')
                ->first();

            if ($partidoExistente) {
                $partidoExistente->equipo_visitante_id = $partido->ganador_id;
                $partidoExistente->save();
            } else {
                Partido::create([
                    'torneo_id' => $partido->torneo_id,
                    'ronda' => $nuevaRonda,
                    'equipo_local_id' => $partido->ganador_id,
                    'match_time' => now()->addDays(2) // Asegura fecha de partido
                ]);
            }
        }
    }

    /**
     * Muestra las llaves de un torneo específico.
     */
    public function show($torneoId)
    {
        // Verificar si el torneo existe
        $torneo = Torneo::findOrFail($torneoId);

        // Obtener partidos del torneo con sus equipos
        $partidos = Partido::with(['equipoLocal', 'equipoVisitante', 'ganador'])
            ->where('torneo_id', $torneo->id)
            ->orderBy('ronda', 'asc')
            ->get();

        return view('public.llaves', compact('torneo', 'partidos'));
    }

    /**
     * Seleccionar ganador desde una solicitud AJAX.
     */
    public function seleccionarGanador(Request $request, $partidoId)
    {
        $request->validate([
            'ganador_id' => 'required|exists:equipos,id',
        ]);

        $partido = Partido::findOrFail($partidoId);
        $partido->ganador_id = $request->ganador_id;
        $partido->save();

        // Gestión de siguiente ronda
        $this->gestionarSiguienteRonda($partido);

        return response()->json([
            'message' => 'Ganador actualizado correctamente.',
            'partido' => $partido,
        ]);
    }
}

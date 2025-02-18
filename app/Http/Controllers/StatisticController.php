<?php

namespace App\Http\Controllers;

use App\Models\Estadistica;
use App\Models\Partido;
use App\Models\Jugador;
use App\Models\Torneo;
use App\Models\Equipo;
use Illuminate\Http\Request;
// Se agrega para consultar el total de goles desde la BD
use App\Models\EstadisticaEquipo;

class StatisticController extends Controller
{
    public function index(Request $request)
    {
        // Capturamos el torneo seleccionado (si se envía en la query string, por ejemplo: ?torneo_id=1)
        $torneoId = $request->query('torneo_id');
        $torneo = $torneoId ? Torneo::find($torneoId) : null;

        // Si se seleccionó un torneo, filtramos las estadísticas de los partidos que pertenezcan a ese torneo.
        // Se asume que el modelo Partido tiene un campo 'torneo_id' para relacionarlo con el torneo.
        if ($torneo) {
            $estadisticas = Estadistica::with([
                'jugador', 
                'jugador.equipo', 
                'partido.equipoLocal:id,name', 
                'partido.equipoVisitante:id,name',
                'partido.ganador:id,name' // Agrega esta línea
            ])
            ->whereHas('jugador') // Sólo estadísticas con jugadores existentes
            ->whereHas('partido', function($query) use ($torneo) {
                $query->where('torneo_id', $torneo->id);
            })
            ->get()
            ->groupBy('partido_id');
        } else {
            // Si no se selecciona ningún torneo, se muestran todas las estadísticas
            $estadisticas = Estadistica::with([
                'jugador', 
                'jugador.equipo', 
                'partido.equipoLocal:id,name', 
                'partido.equipoVisitante:id,name'
            ])
            ->whereHas('jugador')
            ->get()
            ->groupBy('partido_id');
        }

        // Procesamos las estadísticas para determinar resultados y goles
        $resultados = [];
        foreach ($estadisticas as $partidoId => $estadisticasPartido) {
            $partido = $estadisticasPartido->first()->partido;
            $localId = $partido->equipo_local_id;
            $visitanteId = $partido->equipo_visitante_id;

            // Sumar goles por equipo según las estadísticas
            $golesLocalTotal = $estadisticasPartido->filter(function($estadistica) use ($localId) {
                return $estadistica->jugador->equipo_id == $localId;
            })->sum('goals');

            $golesVisitanteTotal = $estadisticasPartido->filter(function($estadistica) use ($visitanteId) {
                return $estadistica->jugador->equipo_id == $visitanteId;
            })->sum('goals');

            // Consultar en la BD las estadísticas de equipo para obtener el total de goles
            $equipoLocalEst = EstadisticaEquipo::where('equipo_id', $localId)
                ->where('partido_id', $partido->id)
                ->first();
            $equipoVisitanteEst = EstadisticaEquipo::where('equipo_id', $visitanteId)
                ->where('partido_id', $partido->id)
                ->first();

            $totalLocal = $equipoLocalEst ? $equipoLocalEst->total_goals : 0;
            $totalVisitante = $equipoVisitanteEst ? $equipoVisitanteEst->total_goals : 0;

            // Definir el resultado final usando el total de goles obtenido de la BD
            $resultadoFinal = "{$partido->equipoLocal->name} {$totalLocal} - {$partido->equipoVisitante->name} {$totalVisitante}";
            $partido->resultado_final = $resultadoFinal;

            // Determinar el ganador basado en la suma total de goles (calculados con las estadísticas)
            if ($golesLocalTotal > $golesVisitanteTotal) {
                $partido->ganador_id = $localId;
            } elseif ($golesVisitanteTotal > $golesLocalTotal) {
                $partido->ganador_id = $visitanteId;
            } else {
                $partido->ganador_id = null;
            }
            $partido->save();

            $resultados[$partidoId] = [
                'golesLocal'       => $golesLocalTotal,
                'golesVisitante'   => $golesVisitanteTotal,
                'resultado_final'  => $resultadoFinal,
                'ganador'          => $partido->ganador_id ? $partido->ganador->name : 'Empate',
                'es_empate'        => is_null($partido->ganador_id)
            ];
        }

        // Obtenemos todos los torneos disponibles para el selector en la vista
        $torneos = Torneo::all();

        return view('admin.statistics.index', compact('estadisticas', 'resultados', 'torneos', 'torneo'));
    }

    public function create()
    {
        $jugadores = Jugador::all();
        $partidos = Partido::with(['equipoLocal', 'equipoVisitante'])->get();
        $equipos = Equipo::all(); // Asegúrate de importar el modelo Equipo
        
        return view('admin.statistics.create', compact('jugadores', 'partidos', 'equipos'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'jugador_id'   => 'required|exists:jugadores,id',
            'partido_id'   => 'required|exists:partidos,id',
            'goals'        => 'required|integer|min:0',
            'yellow_cards' => 'required|integer|min:0',
            'red_cards'    => 'required|integer|min:0',
        ]);

        Estadistica::create($request->all());

        return redirect()->route('statistics.index')->with('success', 'Estadística agregada correctamente.');
    }

    public function edit($id)
    {
        $estadistica = Estadistica::findOrFail($id);
        $jugadores = Jugador::all();
        $partidos = Partido::all();
        return view('admin.statistics.edit', compact('estadistica', 'jugadores', 'partidos'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'jugador_id'   => 'required|exists:jugadores,id',
            'partido_id'   => 'required|exists:partidos,id',
            'goals'        => 'required|integer|min:0',
            'yellow_cards' => 'required|integer|min:0',
            'red_cards'    => 'required|integer|min:0',
            'ganador'      => 'nullable|exists:equipos,id',
            'es_empate'    => 'nullable|boolean',
        ]);
    
        $estadistica = Estadistica::findOrFail($id);
    
        // Actualizar estadísticas
        $estadistica->update($request->except(['ganador', 'es_empate']));
    
        // Actualizar el equipo ganador o empate en el partido relacionado
        $partido = $estadistica->partido;
        if ($request->filled('es_empate') && $request->es_empate) {
            $partido->ganador_id = null; // Empate
        } elseif ($request->filled('ganador')) {
            $partido->ganador_id = $request->ganador; // Establecer el ganador seleccionado
        }
        $partido->save();
    
        return redirect()->route('statistics.index')->with('success', 'Estadística actualizada correctamente.');
    }
    
    public function destroy($id)
    {
        $estadistica = Estadistica::findOrFail($id);
        $estadistica->delete();

        return redirect()->route('statistics.index')->with('success', 'Estadística eliminada correctamente.');
    }
}

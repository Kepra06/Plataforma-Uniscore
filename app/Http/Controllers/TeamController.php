<?php

namespace App\Http\Controllers;

use App\Models\Equipo;
use App\Models\Torneo;
use Illuminate\Http\Request;

class TeamController extends Controller
{
    public function index($torneoId = null)
    {
        $torneos = Torneo::with('equipos')->get(); // Obtiene todos los torneos con sus equipos
    
        // Intenta obtener el torneo según el ID proporcionado
        $torneoSeleccionado = $torneoId ? Torneo::find($torneoId) : null;
        
        // Si no se encontró el torneo (por ejemplo, fue eliminado), usa el primer torneo disponible
        if (!$torneoSeleccionado && $torneos->isNotEmpty()) {
            $torneoSeleccionado = $torneos->first();
        }
        
        return view('teams.index', [
            'torneos' => $torneos,
            'torneoSeleccionado' => $torneoSeleccionado
        ]);
    }
    

    public function create($torneoId)
    {
        $torneo = Torneo::findOrFail($torneoId);
        $torneos = Torneo::all(); // Se obtienen todos los torneos
        return view('teams.create', compact('torneo', 'torneos'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'      => 'required|string|max:255',
            'torneo_id' => 'required|exists:torneos,id',
            'grupo'     => 'nullable|in:A,B',
        ]);

        Equipo::create($request->all());

        return redirect()->route('teams.index', ['torneo' => $request->torneo_id])
                         ->with('success', 'Equipo creado exitosamente.');
    }

    public function edit($torneoId, $equipoId)
    {
        $torneo = Torneo::findOrFail($torneoId);
        $equipo = Equipo::findOrFail($equipoId);
        $torneos = Torneo::all();
    
        return view('teams.edit', compact('equipo', 'torneo', 'torneos'));
    }
    

    public function update(Request $request, $torneoId, $equipoId)
    {
        $equipo = Equipo::findOrFail($equipoId);
        
        $request->validate([
            'name'      => 'required|string|max:255',
            'coach'     => 'nullable|string|max:255',
            'torneo_id' => 'required|exists:torneos,id',
            'grupo'     => 'nullable|in:A,B',
        ]);

        $equipo->update($request->all());

        return redirect()->route('teams.index', ['torneo' => $torneoId])
                         ->with('success', 'Equipo actualizado exitosamente.');
    }

    public function destroy($torneoId, $equipoId)
    {
        $equipo = Equipo::findOrFail($equipoId);
        $equipo->delete();

        return redirect()->route('teams.index', ['torneo' => $torneoId])
                         ->with('success', 'Equipo eliminado exitosamente.');
    }

    public function show($id)
    {
        $equipo = Equipo::with('jugadores', 'torneo')->findOrFail($id);

        if (!$equipo->torneo) {
            return redirect()->route('teams.index')
                             ->with('error', 'El equipo no está asociado a un torneo válido.');
        }

        return view('teams.show', [
            'equipo'    => $equipo,
            'jugadores' => $equipo->jugadores
        ]);
    }
}

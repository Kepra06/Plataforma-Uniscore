<?php

namespace App\Http\Controllers;

use App\Models\Jugador;
use App\Models\Equipo;
use Illuminate\Http\Request;

class PlayerController extends Controller
{
    public function index($equipoId)
    {
        $equipo = Equipo::findOrFail($equipoId);
        $jugadores = $equipo->jugadores;

        return view('players.index', compact('jugadores', 'equipo'));
    }

    public function create($torneoId, $equipoId)
    {
        $equipo = Equipo::findOrFail($equipoId);
        $positions = ['Portero', 'Defensa', 'Centrocampista', 'Delantero']; // Opciones permitidas
        return view('players.create', compact('equipo', 'positions'));
    }

    public function store(Request $request, $torneoId, $equipoId)
    {
        // Validación de los datos recibidos
        $request->validate([
            'name' => 'required|string|max:255',
            'position' => 'nullable|in:Portero,Defensa,Centrocampista,Delantero',
            'number' => 'nullable|integer|min:1',
        ]);

        // Buscar el equipo dentro del torneo
        $equipo = Equipo::where('id', $equipoId)->where('torneo_id', $torneoId)->firstOrFail();

        // Crear el jugador y asociarlo al equipo
        $equipo->jugadores()->create($request->only(['name', 'position', 'number']));

        // Redirigir al show del equipo, pasando el torneo y el equipo_id
            // Redirigir al show del equipo, pasando el parámetro 'equipo' en lugar de 'id'
            return redirect()
                ->route('teams.show', ['equipo' => $equipoId])  // Cambiado 'id' por 'equipo'
                ->with('success', 'Jugador agregado exitosamente.');

                }

    public function edit($torneoId, $equipoId, $jugadorId)
    {
        $jugador = Jugador::where('id', $jugadorId)->where('equipo_id', $equipoId)->firstOrFail();
        $positions = ['Portero', 'Defensa', 'Centrocampista', 'Delantero']; // Opciones permitidas
        return view('players.edit', compact('jugador', 'positions'));
    }

    public function update(Request $request, $torneoId, $equipoId, $jugadorId)
    {
        // Validación de los datos
        $request->validate([
            'name' => 'required|string|max:255',
            'position' => 'nullable|in:Portero,Defensa,Centrocampista,Delantero',
            'number' => 'nullable|integer|min:1',
        ]);
    
        // Buscar el jugador
        $jugador = Jugador::where('id', $jugadorId)->where('equipo_id', $equipoId)->firstOrFail();
    
        // Actualizar los datos del jugador
        $jugador->update($request->only(['name', 'position', 'number']));
    
        // Redirigir al 'show' del equipo, pasando el equipoId
        return redirect()->route('teams.show', ['equipo' => $equipoId])
        ->with('success', 'Jugador actualizado exitosamente.');

    }
    

    public function destroy($torneoId, $equipoId, $jugadorId)
    {
        $jugador = Jugador::where('id', $jugadorId)->where('equipo_id', $equipoId)->firstOrFail();
        $jugador->delete();
    
        // Redirigir a la página anterior (show del equipo)
        return redirect()->to(url()->previous())  // Redirigir a la página anterior
                         ->with('success', 'Jugador eliminado exitosamente.');
    }
}

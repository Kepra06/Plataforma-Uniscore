<?php

namespace App\Http\Controllers;

use App\Models\Torneo;
use Illuminate\Http\Request;

class TournamentController extends Controller
{
    public function index()
    {
        $torneos = Torneo::with('equipos', 'partidos')->get();
        return view('admin.tournaments.index', compact('torneos'));
    }

    public function create()
    {
        return view('admin.tournaments.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'sport_type' => 'required|string|max:255',
            'tournament_type' => 'required|string|max:255',
            'number_of_teams' => 'required|integer|min:2',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
        ]);

        Torneo::create($request->all());
        return redirect()->route('tournaments.index')->with('success', 'Torneo creado con éxito.');
    }

    public function show($id)
    {
        $torneo = Torneo::with([
            'equipos.jugadores',
            'partidos.equipoLocal',
            'partidos.equipoVisitante'
        ])->findOrFail($id);
    
        return view('admin.tournaments.show', compact('torneo'));
    }
    



    public function edit($id)
{
    $torneo = Torneo::findOrFail($id);
    return view('admin.tournaments.edit', compact('torneo'));
}


    public function update(Request $request, $id)
    {
        // Encuentra el torneo por ID
        $torneo = Torneo::findOrFail($id);

        // Validar los datos del formulario
        $request->validate([
            'name' => 'required|string|max:255',
            'sport_type' => 'required|string|max:255',
            'tournament_type' => 'required|string|max:255',
            'number_of_teams' => 'required|integer|min:2',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
        ]);

        // Actualiza el torneo con los nuevos datos
        $torneo->update($request->only([
            'name', 
            'sport_type', 
            'tournament_type', 
            'number_of_teams', 
            'start_date', 
            'end_date'
        ]));

        // Redirige a la lista de torneos con un mensaje de éxito
        return redirect()->route('tournaments.index')->with('success', 'Torneo actualizado con éxito.');
    }



    public function destroy(Torneo $tournament)
    {
        // Eliminar los partidos asociados al torneo (si corresponde)
        $tournament->partidos()->delete();
    
        // Recorrer cada equipo asociado al torneo
        foreach ($tournament->equipos as $equipo) {
            // Eliminar los jugadores asociados a cada equipo
            $equipo->jugadores()->delete();
            // Eliminar el equipo
            $equipo->delete();
        }
    
        // Finalmente, eliminar el torneo
        $tournament->delete();
    
        return redirect()->route('tournaments.index')->with('success', 'Torneo eliminado con éxito.');
    }
    
    

    
}

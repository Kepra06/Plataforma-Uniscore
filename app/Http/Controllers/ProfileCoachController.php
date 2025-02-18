<?php

namespace App\Http\Controllers;

use App\Models\ProfileCoach;
use App\Models\User;
use Illuminate\Http\Request;

class ProfileCoachController extends Controller
{
    public function show($id)
    {
        $coach = ProfileCoach::with('user')->where('user_id', $id)->first();

        if (!$coach) {
            abort(404, 'Coach no encontrado.');
        }

        $data = ['coach' => $coach];

        return view('view.coach.profile', compact('data'));
    }

    public function create(Request $request, User $user)
    {
        // Validación de los datos
        $data = $request->validate([
            'name' => 'required|string',
            'surname' => 'required|string',
            'experience' => 'nullable|integer',
            'specialty' => 'nullable|string',
            'phone' => 'nullable|string',
            'email' => 'nullable|email',
        ]);

        // Crear el perfil del coach
        ProfileCoach::create(array_merge($data, ['user_id' => $user->id]));

        return redirect()->route('coach.perfil.show', ['id' => $user->id])
            ->with('success', 'Perfil del coach creado con éxito.');
    }

    public function edit($id)
    {
        $coach = ProfileCoach::findOrFail($id);
        return view('view.coach.profile.edit', ['coach' => $coach]);
    }

    public function update(Request $request, $id)
    {
        // Buscar el coach por su ID o devolver un error 404
        $coach = ProfileCoach::findOrFail($id);

        // Validar los datos
        $data = $request->validate([
            'name' => 'required|string',
            'surname' => 'required|string',
            'experience' => 'nullable|integer',
            'specialty' => 'nullable|string',
            'phone' => 'nullable|string',
            'email' => 'nullable|email',
        ]);

        // Actualizar el perfil del coach
        $coach->update($data);

        return redirect()->route('coach.perfil.show', ['id' => $coach->user_id])
            ->with('success', 'Perfil del coach actualizado con éxito.');
    }
}

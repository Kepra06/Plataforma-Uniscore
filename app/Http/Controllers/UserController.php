<?php

namespace App\Http\Controllers;

use App\Models\ProfileCoach;  // Usar el modelo actualizado ProfileCoach
use App\Models\ProfileTrainee;  // Usar el modelo actualizado ProfileTrainee
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Muestra la lista de usuarios.
     */
    public function index()
    {
        $users = User::all();
        return view('view.users.index', compact('users'));
    }

    /**
     * Muestra el formulario para crear un nuevo usuario.
     */
    public function create()
    {
        return view('view.users.create');
    }

    /**
     * Almacena un nuevo usuario en la base de datos.
     */
    public function store(Request $request)
    {
        $request->validate([
            'first_name' => 'required|string|max:255',
            'second_name' => 'nullable|string|max:255',
            'first_lastname' => 'required|string|max:255',
            'second_lastname' => 'nullable|string|max:255',
            'username' => 'required|string|max:255|unique:users,username',
            'email' => 'required|email|max:255|unique:users,email',
            'password' => 'required|string|confirmed|min:8',
            'role' => 'required|in:trainee,coach,superadmin',
        ]);

        // Crear un nuevo usuario y encriptar la contraseña
        $user = new User();
        $user->first_name = $request->first_name;
        $user->second_name = $request->second_name;
        $user->first_lastname = $request->first_lastname;
        $user->second_lastname = $request->second_lastname;
        $user->username = $request->username;
        $user->email = $request->email;
        $user->password = bcrypt($request->password);
        $user->role = $request->role;
        $user->save();

        // Crear perfil de coach
        if ($request->role == 'coach') {
            $coach = new ProfileCoach();
            $coach->user_id = $user->id;
            $coach->name = $user->first_name;  // Aquí asignamos el primer nombre del usuario
            $coach->surname = $user->first_lastname;  // Aquí asignamos el primer apellido del usuario
            $coach->phone = $request->phone; // Teléfono opcional
            $coach->email = $request->email; // Correo opcional
            $coach->save();
        }


        // Crear perfil de trainee
        if ($request->role == 'trainee') {
            $trainee = new ProfileTrainee();
            $trainee->user_id = $user->id;
            $trainee->document_type = $request->document_type; // Tipo de documento opcional
            $trainee->document_number = $request->document_number; // Número de documento opcional
            $trainee->phone = $request->phone; // Teléfono opcional
            $trainee->save();
        }

        return redirect()->route('users.index')->with('success', 'Usuario creado correctamente');
    }

    /**
     * Muestra los detalles de un usuario específico.
     */
    public function show($id)
    {
        $user = User::findOrFail($id);
        return view('view.users.show', compact('user'));
    }

    /**
     * Muestra el formulario para editar un usuario.
     */
    public function edit($id)
    {
        $user = User::findOrFail($id);
        return view('view.users.edit', compact('user'));
    }

    /**
     * Actualiza la información de un usuario en la base de datos.
     */
    public function update(Request $request, User $user)
    {
        $request->validate([
            'first_name' => 'nullable|string|max:255',
            'second_name' => 'nullable|string|max:255',
            'first_lastname' => 'nullable|string|max:255',
            'second_lastname' => 'nullable|string|max:255',
            'username' => 'required|string|max:255|unique:users,username,' . $user->id,
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'password' => 'sometimes|nullable|string|min:8|confirmed',
            'role' => 'required|string',
        ]);

        $user->update($request->all());

        return redirect()->route('users.index')->with('success', 'Usuario actualizado correctamente.');
    }

    /**
     * Elimina un usuario de la base de datos.
     */
    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->delete();

        return redirect()->route('users.index')->with('success', 'Usuario eliminado exitosamente.');
    }
}

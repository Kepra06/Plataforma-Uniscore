<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class SuperAdminController extends Controller
{
    // Mostrar el dashboard del SuperAdmin
    public function index()
    {
        return view('view.superadmin.index');
    }

    // Cerrar sesión del SuperAdmin
    public function logout(Request $request)
    {
        Auth::logout();
        return redirect('/login')->with('success', 'Sesión cerrada');
    }

    // Método para crear roles
    public function createRole(Request $request)
    {
        $request->validate([
            'role' => 'required|string|in:student,docent', // Solo permite 'student' y 'docent'
        ]);

        // Lógica para la creación de roles si usas una tabla de roles o lógica adicional.
        return redirect()->back()->with('success', 'Rol creado con éxito');
    }
}

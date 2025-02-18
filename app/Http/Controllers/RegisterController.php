<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\RegisterRequest;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class RegisterController extends Controller
{
    // Mostrar el formulario de registro
    public function show()
    {
        if (Auth::check() || User::where('role', 'superadmin')->exists()) {
            return redirect('/login')->withErrors('Ya existe un SuperAdmin registrado.');
        }

        return view('auth.register');
    }

    // Registrar al SuperAdmin
    public function register(RegisterRequest $request)
    {
        $user = User::create(array_merge(
            $request->validated(),
            ['role' => 'superadmin']
        ));

        return redirect('/login')->with('success', 'SuperAdmin creado exitosamente.');
    }
}

<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    // Mostrar la vista de login
    public function show()
    {
        if (Auth::check()) {
            return redirect('/home');
        }
        return view('auth.login');
    }

    // Validar el login
    public function login(LoginRequest $request)
    {
        $credentials = $request->getCredentials();

        if (!Auth::attempt($credentials)) {
            return redirect()->to('/login')->withErrors('Username y/o contraseña incorrectos');
        }

        $user = Auth::user();

        return $this->authenticated($request, $user);
    }

    // Redirigir según el rol del usuario autenticado
    public function authenticated(Request $request, $user)
    {
        if ($user->role === 'superadmin') {
            return redirect()->route('home.index');
        }

        if ($user->role === 'student') {
            return redirect()->route('home.index'); // Redirigir a 'student'
        }

        if ($user->role === 'docent') {
            return redirect()->route('home.index'); // Redirigir a 'docent'
        }

        return redirect()->route('home.index');
    }
}

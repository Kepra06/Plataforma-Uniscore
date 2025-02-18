<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CoachController extends Controller
{
    // Método para mostrar la lista de coaches
    public function index()
    {
        // Aquí puedes agregar la lógica para obtener la lista de coaches
        // Por ejemplo: $coaches = Coach::all();

        return view('view.list.list.coach'); // Redirige a list/coach.blade.php
    }
}
<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DocentController extends Controller
{
    // Método para mostrar la lista de docentes
    public function index()
    {
        // Aquí puedes agregar la lógica para obtener la lista de docentes
        // Por ejemplo: $docents = Docent::all();

        return view('view.list.list.docent'); // Redirige a list/docent.blade.php
    }
}

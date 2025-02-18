<?php

namespace App\Http\Controllers;

use App\Models\Galeria;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class GaleriaController extends Controller
{
    public function index()
    {
        $galerias = Galeria::all();
        return view('admin.galeria.index', compact('galerias'));
    }

    public function create()
    {
        return view('admin.galeria.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'file_path' => 'required|file|mimes:jpeg,png,jpg,mp4|max:2048',
            'type' => 'required|in:photo,video',
        ]);

        // Guarda la imagen o video en el almacenamiento
        $path = $request->file('file_path')->store('galeria', 'public');

        // Crea la entrada en la base de datos
        Galeria::create([
            'title' => $request->title,
            'description' => $request->description,
            'file_path' => $path,
            'type' => $request->type,
            'user_id' => Auth::id(),
        ]);

        return redirect()->route('galeria.index')->with('success', 'Galería creada con éxito.');
    }

    public function edit(Galeria $galeria)
    {
        return view('admin.galeria.edit', compact('galeria'));
    }

    public function update(Request $request, Galeria $galeria)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'file_path' => 'nullable|file|mimes:jpeg,png,jpg,mp4|max:2048',
            'type' => 'required|in:photo,video',
        ]);

        $galeria->title = $request->title;
        $galeria->description = $request->description;

        if ($request->hasFile('file_path')) {
            $path = $request->file('file_path')->store('galeria', 'public');
            $galeria->file_path = $path;
        }

        $galeria->type = $request->type;
        $galeria->save();

        return redirect()->route('galeria.index')->with('success', 'Galería actualizada con éxito.');
    }

    public function show(Galeria $galeria)
    {
        return view('admin.galeria.show', compact('galeria'));
    }

    public function destroy(Galeria $galeria)
    {
        $galeria->delete();
        return redirect()->route('galeria.index')->with('success', 'Galería eliminada con éxito.');
    }
}

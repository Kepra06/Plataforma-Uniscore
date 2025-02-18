@extends('layouts.app')

@section('content')
<div class="container my-5">
    <div class="text-center mb-4">
        <h1 class="display-4" style="color: #003366; font-weight: bold;">Editar Galería</h1>
        <p style="color: #666;">Actualiza la información de la galería seleccionada.</p>
    </div>

    <form action="{{ route('galeria.update', $galeria->id) }}" method="POST" enctype="multipart/form-data" class="bg-light p-5 rounded shadow-sm">
        @csrf
        @method('PUT')

        <!-- Título -->
        <div class="mb-4">
            <label for="title" class="form-label" style="color: #003366; font-weight: bold;">Título</label>
            <input 
                type="text" 
                name="title" 
                id="title" 
                class="form-control border-2" 
                value="{{ $galeria->title }}" 
                style="border-color: #006699;" 
                required>
        </div>

        <!-- Descripción -->
        <div class="mb-4">
            <label for="description" class="form-label" style="color: #003366; font-weight: bold;">Descripción</label>
            <textarea 
                name="description" 
                id="description" 
                rows="4" 
                class="form-control border-2" 
                style="border-color: #006699;">{{ $galeria->description }}</textarea>
        </div>

        <!-- Archivo Actual -->
        <div class="mb-4">
            <label class="form-label" style="color: #003366; font-weight: bold;">Archivo Actual</label>
            <p class="mt-2">
                <a 
                    href="{{ asset('storage/' . $galeria->file_path) }}" 
                    target="_blank" 
                    class="text-primary" 
                    style="font-weight: bold;">
                    Ver Archivo Actual
                </a>
            </p>
        </div>

        <!-- Nuevo Archivo -->
        <div class="mb-4">
            <label for="file_path" class="form-label" style="color: #003366; font-weight: bold;">Subir Nuevo Archivo (Opcional)</label>
            <input 
                type="file" 
                name="file_path" 
                id="file_path" 
                class="form-control border-2" 
                style="border-color: #006699;" 
                accept="image/*,video/*">
            <small class="form-text text-muted">Formatos aceptados: JPG, PNG, MP4, AVI, etc.</small>
        </div>

        <!-- Tipo -->
        <div class="mb-4">
            <label for="type" class="form-label" style="color: #003366; font-weight: bold;">Tipo</label>
            <select 
                name="type" 
                id="type" 
                class="form-control border-2" 
                style="border-color: #006699;" 
                required>
                <option value="photo" {{ $galeria->type == 'photo' ? 'selected' : '' }}>Foto</option>
                <option value="video" {{ $galeria->type == 'video' ? 'selected' : '' }}>Video</option>
            </select>
        </div>

        <!-- Botones -->
        <div class="d-flex justify-content-between align-items-center mt-4">
            <button 
                type="submit" 
                class="btn btn-success btn-lg" 
                style="background-color: #006699; border-color: #006699;">
                <i class="fas fa-save"></i> Actualizar
            </button>
            <a 
                href="{{ route('galeria.index') }}" 
                class="btn btn-secondary btn-lg">
                <i class="fas fa-arrow-left"></i> Volver
            </a>
        </div>
    </form>
</div>
@endsection

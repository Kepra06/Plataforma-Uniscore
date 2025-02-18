@extends('layouts.app')

@section('content')
<div class="container my-5">
    <div class="text-center mb-4">
        <h1 class="display-4" style="color: #003366; font-weight: bold;">Agregar Nueva Galería</h1>
        <p style="color: #666;">Crea una nueva galería con fotos o videos para enriquecer tu contenido.</p>
    </div>

    <form action="{{ route('galeria.store') }}" method="POST" enctype="multipart/form-data" class="bg-light p-5 rounded shadow-sm">
        @csrf

        <!-- Título -->
        <div class="mb-4">
            <label for="title" class="form-label" style="color: #003366; font-weight: bold;">Título</label>
            <input 
                type="text" 
                name="title" 
                id="title" 
                class="form-control border-2" 
                placeholder="Ejemplo: Evento Principal 2024" 
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
                placeholder="Describe el contenido de esta galería (opcional)" 
                style="border-color: #006699;"></textarea>
        </div>

        <!-- Archivo -->
        <div class="mb-4">
            <label for="file_path" class="form-label" style="color: #003366; font-weight: bold;">Archivo (Imagen o Video)</label>
            <input 
                type="file" 
                name="file_path" 
                id="file_path" 
                class="form-control border-2" 
                style="border-color: #006699;" 
                accept="image/*,video/*" 
                required>
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
                <option value="photo">Foto</option>
                <option value="video">Video</option>
            </select>
        </div>

        <!-- Botones -->
        <div class="d-flex justify-content-between align-items-center mt-4">
            <button 
                type="submit" 
                class="btn btn-success btn-lg" 
                style="background-color: #006699; border-color: #006699;">
                <i class="fas fa-save"></i> Crear Galería
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

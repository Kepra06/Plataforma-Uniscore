@extends('layouts.app')

@section('content')
<div class="container my-5">
    <!-- Título de la galería -->
    <div class="text-center mb-5">
        <h1 class="display-4" style="color: #003366; font-weight: bold;">{{ $galeria->title }}</h1>
    </div>

    <!-- Contenido principal -->
    <div class="card shadow-sm border-0">
        <div class="card-body">
            <!-- Mostrar imagen o video -->
            <div class="text-center mb-4">
                @if ($galeria->type === 'photo')
                    <img 
                        src="{{ asset('storage/' . $galeria->file_path) }}" 
                        class="d-block mx-auto img-fluid rounded" 
                        alt="{{ $galeria->title }}" 
                        style="max-width: 80%; max-height: 400px; object-fit: contain;">
                @elseif ($galeria->type === 'video')
                    <video 
                        class="w-100 rounded" 
                        controls 
                        style="max-height: 400px;">
                        <source src="{{ asset('storage/' . $galeria->file_path) }}" type="video/mp4">
                        Tu navegador no soporta la reproducción de video.
                    </video>
                @endif
            </div>

            <!-- Descripción -->
            <p class="text-muted" style="font-size: 1.1rem;">{{ $galeria->description }}</p>
        </div>
    </div>

    <!-- Botón de regreso -->
    <div class="mt-4 text-center">
        <a 
            href="{{ route('galeria.index') }}" 
            class="btn btn-primary btn-lg" 
            style="background-color: #006699; border-color: #006699;">
            <i class="fas fa-arrow-left"></i> Volver a la Galería
        </a>
    </div>
</div>
@endsection

@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="text-center mb-5">
        <h1 class="display-5 fw-bold text-gradient bg-gradient-to-r from-purple-600 to-blue-500" 
            style="font-family: 'Poppins', sans-serif; -webkit-background-clip: text; -webkit-text-fill-color: transparent;">
            Galería Multimedia
        </h1>
        
        @if(Auth::check() && Auth::user()->role === 'superadmin')
        <div class="mb-4">
            <a href="{{ route('galeria.create') }}" 
               class="btn btn-lg btn-gradient bg-gradient-to-r from-green-400 to-blue-500 text-white shadow-lg rounded-pill px-4 py-2 hover:scale-105 transition-transform">
               <i class="fas fa-plus-circle me-2"></i>Nueva Galería
            </a>
        </div>
        @endif
    </div>

    <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4">
        @foreach ($galerias as $galeria)
            <div class="col">
                <div class="card h-100 border-0 shadow-lg hover-shadow-xl transition-all">
                    <div class="card-img-top overflow-hidden position-relative" style="height: 220px;">
                        <img src="{{ asset('storage/' . $galeria->file_path) }}" 
                             alt="{{ $galeria->title }}" 
                             class="img-fluid h-100 w-100 object-fit-cover zoom-effect">
                        <div class="image-overlay bg-gradient-to-t from-dark opacity-0 hover-opacity-80 transition-all"></div>
                    </div>
                    
                    <div class="card-body position-relative bg-light-gradient">
                        <h5 class="card-title fw-semibold text-dark mb-2">{{ $galeria->title }}</h5>
                        <p class="card-text text-muted small mb-4">{{ $galeria->description }}</p>
                        
                        <div class="d-flex justify-content-center gap-2 action-buttons">
                            <a href="{{ route('galeria.show', $galeria->id) }}" 
                               class="btn btn-sm btn-info text-white rounded-pill px-3 py-1 hover-scale"
                               data-bs-toggle="tooltip" 
                               title="Ver detalles">
                               <i class="fas fa-eye me-1"></i>Ver
                            </a>
                            
                            @if(Auth::check() && Auth::user()->role === 'superadmin')
                            <a href="{{ route('galeria.edit', $galeria->id) }}" 
                               class="btn btn-sm btn-primary rounded-pill px-3 py-1 hover-scale"
                               data-bs-toggle="tooltip" 
                               title="Editar contenido">
                               <i class="fas fa-edit me-1"></i>Editar
                            </a>
                            
                            <form action="{{ route('galeria.destroy', $galeria->id) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit" 
                                        class="btn btn-sm btn-danger rounded-pill px-3 py-1 hover-scale"
                                        onclick="return confirm('¿Está seguro de eliminar esta galería?')"
                                        data-bs-toggle="tooltip" 
                                        title="Eliminar permanentemente">
                                        <i class="fas fa-trash-alt me-1"></i>Eliminar
                                </button>
                            </form>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>

<style>
    .text-gradient {
        background-clip: text;
        -webkit-background-clip: text;
        color: transparent;
    }
    
    .zoom-effect {
        transition: transform 0.3s ease;
    }
    
    .card:hover .zoom-effect {
        transform: scale(1.05);
    }
    
    .image-overlay {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        transition: opacity 0.3s ease;
    }
    
    .hover-scale {
        transition: transform 0.2s ease, box-shadow 0.2s ease;
    }
    
    .hover-scale:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(0,0,0,0.1);
    }
    
    .bg-light-gradient {
        background: linear-gradient(180deg, rgba(255,255,255,0.9) 0%, rgba(245,245,245,0.9) 100%);
    }
</style>
@endsection
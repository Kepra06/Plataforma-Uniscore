@extends('layouts.app-master')

@section('content')
    <div class="container">
        <h1>Bienvenido SuperAdmin</h1>
        <a href="{{ route('users.index') }}" class="btn btn-primary">Gestionar Usuarios</a>
        <form action="{{ route('superadmin.logout') }}" method="POST">
            @csrf
            <button type="submit" class="btn btn-danger mt-4">Cerrar Sesión</button>
        </form>
    </div>
@endsection

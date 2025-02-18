@extends('layouts.auth-master')

@section('content')
    <form action="{{ route('login.perform') }}" method="POST" class="space-y-4">
        @csrf
        <h1 class="text-2xl font-bold text-center mb-6">Iniciar Sesión</h1>
        @include('layouts.partials.message')

        <div class="mb-4">
            <label for="username" class="form-label font-semibold">Nombre de usuario o Correo electrónico</label>
            <div class="flex items-center border rounded-lg overflow-hidden">
                <span class="px-3 bg-gray-200 text-gray-600"><i class="fas fa-user"></i></span>
                <input type="text" name="username" class="form-control border-none" placeholder="Ingresa tu usuario o correo" required>
            </div>
        </div>

        <div class="mb-4">
            <label for="password" class="form-label font-semibold">Contraseña</label>
            <div class="flex items-center border rounded-lg overflow-hidden">
                <span class="px-3 bg-gray-200 text-gray-600"><i class="fas fa-lock"></i></span>
                <input type="password" name="password" id="password" class="form-control border-none" placeholder="Ingresa tu contraseña" required>
                <span class="px-3 bg-gray-200 text-gray-600 cursor-pointer" onclick="togglePassword()">
                    <i class="fas fa-eye" id="togglePasswordIcon"></i>
                </span>
            </div>
        </div>

        <div class="flex items-center mb-4">
            <input type="checkbox" name="remember" id="remember">
            <label for="remember">Recordarme</label>
        </div>

        <button type="submit" class="btn btn-primary w-full">Iniciar Sesión</button>

        @if(!\App\Models\User::where('role', 'superadmin')->exists())
            <div class="mt-4 text-center">
                <a href="{{ route('register.show') }}" class="text-sm text-blue-500">Crear SuperAdmin</a>
            </div>
        @endif
    </form>

    <script>
        function togglePassword() {
            const passwordField = document.getElementById('password');
            const togglePasswordIcon = document.getElementById('togglePasswordIcon');
            const type = passwordField.getAttribute('type') === 'password' ? 'text' : 'password';
            passwordField.setAttribute('type', type);
            togglePasswordIcon.classList.toggle('fa-eye-slash');
        }
    </script>
@endsection

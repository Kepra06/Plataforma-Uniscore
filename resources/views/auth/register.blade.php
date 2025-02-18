@extends('layouts.auth-master')

@section('content')
<div class="container">
    <form method="POST" action="{{ route('register.perform') }}">
        @csrf
        <div class="mb-3">
            <label for="first_name" class="form-label">Primer Nombre</label>
            <input type="text" class="form-control" id="first_name" name="first_name" required>
        </div>
        
        <div class="mb-3">
            <label for="second_name" class="form-label">Segundo Nombre</label>
            <input type="text" class="form-control" id="second_name" name="second_name">
        </div>
        
        <div class="mb-3">
            <label for="first_lastname" class="form-label">Primer Apellido</label>
            <input type="text" class="form-control" id="first_lastname" name="first_lastname" required>
        </div>
        
        <div class="mb-3">
            <label for="second_lastname" class="form-label">Segundo Apellido</label>
            <input type="text" class="form-control" id="second_lastname" name="second_lastname">
        </div>

        <div class="mb-3">
            <label for="username" class="form-label">Nombre de Usuario</label>
            <input type="text" class="form-control" id="username" name="username" required>
        </div>

        <div class="mb-3">
            <label for="email" class="form-label">Correo Electrónico</label>
            <input type="email" class="form-control" id="email" name="email" required>
        </div>

        <div class="mb-3">
            <label for="password" class="form-label">Contraseña</label>
            <div class="flex items-center border rounded-lg overflow-hidden">
                <input type="password" class="form-control border-none" id="password" name="password" required>
                <span class="px-3 bg-gray-200 text-gray-600 cursor-pointer" onclick="togglePassword()">
                    <i class="fas fa-eye" id="togglePasswordIcon"></i>
                </span>
            </div>
        </div>

        <div class="mb-3">
            <label for="password_confirmation" class="form-label">Confirmar Contraseña</label>
            <div class="flex items-center border rounded-lg overflow-hidden">
                <input type="password" class="form-control border-none" id="password_confirmation" name="password_confirmation" required>
                <span class="px-3 bg-gray-200 text-gray-600 cursor-pointer" onclick="toggleConfirmPassword()">
                    <i class="fas fa-eye" id="toggleConfirmPasswordIcon"></i>
                </span>
            </div>
        </div>

        <button type="submit" class="btn btn-primary">Registrar SuperAdmin</button>
    </form>

    <script>
        function togglePassword() {
            const passwordField = document.getElementById('password');
            const togglePasswordIcon = document.getElementById('togglePasswordIcon');
            const type = passwordField.getAttribute('type') === 'password' ? 'text' : 'password';
            passwordField.setAttribute('type', type);
            togglePasswordIcon.classList.toggle('fa-eye-slash');
        }

        function toggleConfirmPassword() {
            const confirmPasswordField = document.getElementById('password_confirmation');
            const toggleConfirmPasswordIcon = document.getElementById('toggleConfirmPasswordIcon');
            const type = confirmPasswordField.getAttribute('type') === 'password' ? 'text' : 'password';
            confirmPasswordField.setAttribute('type', type);
            toggleConfirmPasswordIcon.classList.toggle('fa-eye-slash');
        }
    </script>
</div>
@endsection

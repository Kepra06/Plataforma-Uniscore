<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Aplicación de Autenticación</title>
    <link rel="stylesheet" href="{{ url('assets/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <script src="https://cdn.tailwindcss.com"></script>
    
    <style>
        body {
            width: 100%;
            height: 100vh;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: 'Poppins', sans-serif;
        }

        .form-container {
            width: 100%;
            max-width: 380px;
            padding: 1rem 1.5rem; /* Ajustamos el padding vertical */
            background: white;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
            border-radius: 10px;
            margin: 1rem;
        }

        h1 {
            font-size: 24px;
            font-weight: 700;
            margin-bottom: 1.5rem;
            text-align: center;
            color: #333;
        }

        button {
            background-color: #4a56e2;
            color: white;
            width: 100%;
        }

        button:hover {
            background-color: #3b49c8;
        }

        /* Ajustes para pantallas medianas (tabletas) */
        @media (min-width: 768px) {
            .form-container {
                max-width: 420px;
                padding: 1rem 2rem; /* Ajustamos el padding en tabletas */
            }
        }

        /* Ajustes para pantallas grandes (escritorio) */
        @media (min-width: 1024px) {
            .form-container {
                max-width: 480px;
                padding: 1rem 2rem; /* Menor padding vertical */
                margin: 0 auto; /* Centrado */
            }

            body {
                height: auto; /* Evitamos que ocupe todo el alto de la pantalla */
                padding: 3rem 0; /* Añadimos un poco de espacio superior e inferior */
            }
        }
    </style>
</head>
<body class="bg-gray-100">

<main class="form-container">
    @yield('content') <!-- Aquí se inyectará el contenido de las vistas que extiendan este layout -->
</main>

<script src="{{ url('assets/js/bootstrap.bundle.min.js') }}"></script>
</body>
</html>

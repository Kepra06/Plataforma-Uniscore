<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'UNISCORE')</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Tailwind CSS (si es necesario) -->
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">

    <!-- Font Awesome (última versión) -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">

    <!-- CSS Personalizado -->
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">

    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">


    <!-- JavaScript de Bootstrap -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Incluir estilos específicos de las vistas -->
    @stack('styles')

    <style>
        /* Estilo general del navbar */
        .navbar-custom {
            position: relative;
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 1rem 16px;
            background-color: #fff;
            box-shadow: 0 2px 15px rgba(0, 0, 0, 0.1);
            transition: background-color 0.6s ease, box-shadow 0.6s ease, transform 0.3s ease;
        }

        /* Efecto sticky */
        .navbar-sticky {
            background-color: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(5px);
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.2);
        }

        /* Animación en el menú al hacer hover */
        nav ul li a {
            position: relative;
            display: flex;
            align-items: center;
            padding: 10px 20px;
            text-decoration: none;
            color: #333;
            font-weight: 500;
            border-radius: 8px;
            overflow: hidden;
            transition: color 0.4s, box-shadow 0.4s, transform 0.4s;
        }

        /* Fondo animado en el hover */
        nav ul li a::before {
            content: '';
            position: absolute;
            top: 50%;
            left: 50%;
            width: 0;
            height: 0;
            background-color: rgba(0, 123, 255, 0.2);
            transition: width 0.5s ease, height 0.5s ease, top 0.5s ease, left 0.5s ease;
            border-radius: 50%;
            transform: translate(-50%, -50%);
            z-index: -1;
        }

        /* Efecto de expansión del fondo */
        nav ul li a:hover::before {
            width: 200%;
            height: 200%;
        }

        /* Cambio de color y animaciones en hover */
        nav ul li a:hover {
            color: #fff;
            transform: scale(1.05);
            box-shadow: 0 8px 20px rgba(0, 123, 255, 0.3);
        }

        /* Rotación de iconos en hover */
        nav ul li a i {
            transition: transform 0.4s ease-in-out;
        }

        nav ul li a:hover i {
            transform: rotate(360deg);
        }

        /* Botón del menú (hamburguesa) animado */
        .menu-toggle {
            display: none;
            flex-direction: column;
            cursor: pointer;
            padding: 0.5rem;
            transition: all 0.3s ease;
        }

        .menu-toggle div {
            width: 30px;
            height: 4px;
            background-color: #333;
            margin: 5px 0;
            border-radius: 2px;
            transition: all 0.4s ease;
        }

        /* Animación de la hamburguesa */
        .menu-toggle.active div:nth-child(1) {
            transform: translateY(9px) rotate(45deg);
        }

        .menu-toggle.active div:nth-child(2) {
            opacity: 0;
        }

        .menu-toggle.active div:nth-child(3) {
            transform: translateY(-9px) rotate(-45deg);
        }

        /* Mostrar menú móvil */
        nav ul {
            display: flex;
            gap: 20px;
            margin: 0;
            padding: 0;
            list-style: none;
        }

        /* Efecto menú responsive */
        @media (max-width: 1024px) {
            .menu-toggle {
                display: flex;
            }

            nav ul {
                flex-direction: column;
                position: absolute;
                top: 100%;
                left: 0;
                width: 100%;
                background-color: rgba(255, 255, 255, 0.95);
                transform: translateY(-150%);
                transition: transform 0.6s ease, opacity 0.6s;
                z-index: 9999;
                opacity: 0;
                visibility: hidden;
                box-shadow: 0 10px 25px rgba(0, 0, 0, 0.2);
            }

            nav ul.show-menu {
                transform: translateY(0);
                opacity: 1;
                visibility: visible;
            }

            nav ul li a {
                padding: 16px;
                border-bottom: 1px solid #ddd;
                text-align: center;
                transition: all 0.4s ease;
            }

            h1 {
                font-size: 1.8rem;
                text-align: center;
                flex: 1;
            }
        }

        @media (min-width: 1025px) {
            nav ul {
                flex-direction: row;
            }
        }

        /* Evitar desbordamientos */
        body {
            overflow-x: hidden;
        }

        /* Transición para el cuerpo del documento */
        body, html {
            transition: background-color 0.5s ease;
        }

        
    </style>
</head>


<body class="bg-gray-100">

    <!-- Header -->
    <header class="bg-white shadow-sm mb-1 navbar-custom" id="navbar">
        <div class="container mx-auto p-4 navbar-custom">
            <div class="flex items-center justify-between">
                <div class="flex items-center">
                    <a href="{{ route('home.index') }}">
                        <img src="{{ asset('assets/img/uniscoreicon.svg') }}" alt="Icono de Uniscore" class="h-24 w-24 mr-4">
                    </a>
                    <a href="{{ route('home.index') }}" class="text-3xl font-bold text-gradient">UNISCORE</a>
                </div>
                <div class="menu-toggle ml-4">
                    <div></div>
                    <div></div>
                    <div></div>
                </div>
            </div>
            <nav class="menu mt-4 lg:mt-0">
                <ul class="flex flex-col lg:flex-row items-center lg:items-center gap-4 lg:gap-8 lg:overflow-visible">
                    <li><a href="{{ route('public.inicio') }}" class="nav-link"><i class="bi bi-house-door-fill mr-2"></i> Inicio</a></li>
            
                    @guest
                        <!-- Enlaces para usuarios no autenticados (públicos) -->
                        <li><a href="{{ route('public.tournaments') }}" class="nav-link"><i class="bi bi-calendar mr-2"></i> Torneos</a></li>
                        <li><a href="{{ route('public.teams') }}" class="nav-link"><i class="bi bi-people-fill mr-2"></i> Equipos</a></li>
                        <li><a href="{{ route('public.matches') }}" class="nav-link"><i class="bi bi-star-fill mr-2"></i> Partidos</a></li>
                        <li><a href="{{ route('public.llaves') }}" class="nav-link"><i class="bi bi-key mr-2"></i> Llave</a>

                        <li><a href="{{ route('statistics.index') }}" class="nav-link"><i class="bi bi-star-fill mr-2"></i> Resultados</a></li>
                        <li><a href="{{ route('galeria.index') }}" class="nav-link"><i class="bi bi-image mr-2"></i> Galería</a></li>
                        </li>

            
                        <li><a href="{{ route('login') }}" class="btn btn-primary"><i class="bi bi-person-fill mr-2"></i> Iniciar Sesión</a></li>
                    @else
                        <!-- Enlaces para usuarios autenticados (admin) -->
                        <li><a href="{{ route('tournaments.index') }}" class="nav-link"><i class="bi bi-calendar mr-2"></i> Torneos</a></li>
                        <li><a href="{{ route('teams.index', ['torneo' => 1]) }}" class="nav-link"><i class="bi bi-people-fill mr-2"></i> Equipos</a></li>
                        <li><a href="{{ route('tournaments.matches.index', ['tournament' => 1]) }}" class="nav-link"><i class="bi bi-star-fill mr-2"></i> Partidos</a></li>
                        <li><a href="{{ route('public.llaves') }}" class="nav-link"><i class="bi bi-key mr-2"></i> Llave</a>

                        <li><a href="{{ route('statistics.index') }}" class="nav-link"><i class="bi bi-star-fill mr-2"></i> Resultados</a></li>
                        <li><a href="{{ route('galeria.index') }}" class="nav-link"><i class="bi bi-image mr-2"></i> Galería</a></li>

            
                        @if(Auth::user()->role === 'trainee')
                            <li><a href="#" class="nav-link"><i class="fas fa-user-graduate mr-2"></i> Perfil</a></li>
                        @elseif(Auth::user()->role === 'coach')
                            <li><a href="{{ route('coach.perfil.show', ['id' => Auth::user()->id]) }}" class="nav-link"><i class="fas fa-chalkboard-teacher mr-2"></i> Perfil Coach</a></li>
                        @elseif(Auth::user()->role === 'superadmin')
                            <li><a href="{{ route('users.index') }}" class="nav-link"><i class="fas fa-cogs mr-2"></i> Configuración</a></li>
                        @endif
            
                        <li>
                            <form id="logout-form" action="{{ route('logout.perform') }}" method="POST" class="flex items-center">
                                @csrf
                                <button type="submit" class="nav-link"><i class="fas fa-sign-out-alt mr-2"></i> Cerrar Sesión</button>
                            </form>
                        </li>
                    @endguest
                </ul>
            </nav>
                 
            
            
            
        </div>
    </header>

    <!-- Main Content -->
    <main class="container mx-auto px-4 sm:px-6 lg:px-8 py-1">
        @yield('content')
    </main>

    <!-- Footer -->
    <footer style="background-color: #343a40; color: #ffffff; margin-top: 1rem; padding-top: 1rem; padding-bottom: 1rem;">
        <div style="text-align: center;">
            <p style="margin-bottom: 0;">&copy; 2024 UNISCORE. Todos los derechos reservados.</p>
            <p style="margin-bottom: 0;">

            </p>
        </div>
    </footer>

    <!-- Bootstrap JS and dependencies -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js"></script>

    <script>
        const toggleButton = document.querySelector('.menu-toggle');
        const navMenu = document.querySelector('nav ul');
        const navbar = document.getElementById('navbar');

        toggleButton.addEventListener('click', function() {
            toggleButton.classList.toggle('active');
            navMenu.classList.toggle('show-menu');
        });

        window.addEventListener('scroll', function() {
            if (window.scrollY > 50) {
                navbar.classList.add('navbar-sticky');
            } else {
                navbar.classList.remove('navbar-sticky');
            }
        });
    </script>
</body>
</html>

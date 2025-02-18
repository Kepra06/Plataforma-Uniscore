<form id="logout-form" action="{{ route('logout.perform') }}" method="POST" style="display: none;">
  @csrf
</form>

<nav class="navbar navbar-expand-lg bg-body-tertiary">
  <div class="container-fluid">
    <a class="navbar-brand" href="#">CANAAN DOTACIONES</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <ul class="navbar-nav me-auto mb-2 mb-lg-0">
          <li class="nav-item">
            <a class="nav-link active" aria-current="page" href="{{ route('home.index') }}">INICIO</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="{{ route('logs.index') }}">LOGS</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="{{ route('factura.index') }}">FACTURA</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="{{ route('logs.index') }}">LOGS</a>
          </li>
      
      </ul>

      <!-- <form class="d-flex" role="search">
        <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search">
        <button class="btn btn-outline-success" type="submit">Search</button>
      </form>-->

      <ul class="navbar-nav me-5 mb-2 mb-lg-0">
        @auth
          <li class="nav-item dropdown">
              <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                  {{ ucfirst(auth()->user()->name ?? auth()->user()->username) }}
              </a>
              <ul class="dropdown-menu">
                  <li><a class="dropdown-item" href="#">Perfil</a></li>
                  <li><hr class="dropdown-divider"></li>
                  <!-- Formulario para cerrar sesión -->
                  <li>
                    <a class="dropdown-item" href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Cerrar Sesión</a>
                  </li>
              </ul>
          </li>
        @endauth
      </ul>
    </div>
  </div>
</nav>

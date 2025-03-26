<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistema de Administración de Restaurantes</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <style>
        .navbar-brand {
            font-weight: 700;
        }

        .navbar-custom {
            background-color: #2C3E50;
            /* Deep blue-gray that complements the page design */
            box-shadow: 0 2px 4px rgba(0, 0, 0, .1);
        }

        .header-logo {
            background-color: #E74C3C;
            /* Vibrant red that stands out */
            width: 36px;
            height: 36px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-right: 12px;
            box-shadow: 0 0 10px rgba(231, 76, 60, .5);
        }

        .logo-text {
            font-size: 1.2rem;
            font-weight: bold;
            color: white;
        }

        .nav-link {
            color: rgba(255, 255, 255, .8) !important;
            font-weight: 500;
            padding: 0.5rem 1rem;
            border-radius: 4px;
            transition: all 0.2s;
        }

        .nav-link:hover {
            color: white !important;
            background-color: rgba(255, 255, 255, .1);
        }

        .nav-link.active {
            color: white !important;
            background-color: rgba(255, 255, 255, .2);
        }

        body {
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            background-color: #f8f9fa;
        }

        .content-wrapper {
            flex: 1;
        }

        footer {
            margin-top: auto;
            padding: 1rem 0;
            background-color: #343a40;
            color: rgba(255, 255, 255, .6);
        }
    </style>
    @yield('head')
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-dark navbar-custom">
        <div class="container">
            <a class="navbar-brand d-flex align-items-center" href="/">
                <div class="header-logo">
                    <i class="bi bi-cup-hot-fill text-white"></i>
                </div>
                <span class="logo-text">Sistema de Restaurantes</span>
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link {{ request()->is('/') ? 'active' : '' }}" href="/"><i
                                class="bi bi-house me-1"></i>Inicio</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->is('web/sucursales*') ? 'active' : '' }}"
                            href="{{ route('sucursales.index') }}"><i class="bi bi-building me-1"></i>Sucursales</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->is('web/empleados*') ? 'active' : '' }}"
                            href="{{ route('empleados.index') }}"><i class="bi bi-people me-1"></i>Empleados</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->is('calendario*') ? 'active' : '' }}"
                            href="{{ route('calendario.index') }}"><i class="bi bi-calendar me-1"></i>Calendario</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->is('web/proveedores*') ? 'active' : '' }}"
                            href="{{ route('proveedores.index') }}"><i class="bi bi-truck me-1"></i>Proveedores</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->is('reportes/productos-top*') ? 'active' : '' }}"
                            href="{{ route('reportes.productos-top') }}">
                            <i class="bi bi-graph-up-arrow me-1"></i>Productos Top
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="content-wrapper">
        @yield('content')
    </div>

    <footer class="text-center py-4">
        <div class="container">
            <p class="mb-0">Sistema de Administración de Restaurantes &copy; {{ date('Y') }} | Todos los derechos
                reservados</p>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    @yield('scripts')
</body>

</html>
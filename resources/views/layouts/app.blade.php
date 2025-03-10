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
        .header-bar {
            background-color: #FF0000;
            height: 50px;
            display: flex;
            align-items: center;
            padding-left: 20px;
        }
        .header-logo {
            background-color: #FFFF00;
            width: 30px;
            height: 30px;
            border-radius: 50%;
            margin-right: 10px;
        }
        .card {
            margin-bottom: 20px;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
        }
        .branch-image {
            max-height: 100px;
            object-fit: contain;
        }
    </style>
    @yield('head')
</head>
<body>
    <div class="header-bar">
        <div class="header-logo"></div>
        <a href="/" class="text-white text-decoration-none">Sistema de Restaurantes</a>
    </div>
    
    <div class="container mt-4">
        @yield('content')
    </div>
    
    <!-- Bootstrap JS and Popper.js -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    @yield('scripts')
</body>
</html>
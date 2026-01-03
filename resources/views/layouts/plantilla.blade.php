<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>@yield('tittle', 'inicio')</title>

    {{-- Bootstrap local --}}
    <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('estilos/estilos.css') }}">
    <link rel="stylesheet" href="{{ asset('css/estilos.css') }}">
    {{-- Fontawesome local --}}
    <link rel="stylesheet" href="{{ asset('font/css/all.min.css') }}">

    {{-- ESTILOS PREMIUM DARK (Minimalista) --}}
    <style>
        /* Fondo General "Off-Black" */
        body {
            background-color: #0f1012; /* Gris casi negro */
            color: #cfd0d2; /* Blanco humo */
            font-family: system-ui, -apple-system, sans-serif;
        }

        /* Input de Búsqueda */
        .input-dark-minimal {
            background-color: #1a1c20;
            border: 1px solid #2d3035;
            color: #e0e0e0;
            border-radius: 8px;
            transition: all 0.3s ease;
        }
        .input-dark-minimal:focus {
            background-color: #22252a;
            border-color: #4a4d55;
            box-shadow: none;
            color: #fff;
        }
        .input-dark-minimal::placeholder { color: #5c6068; }

        /* Botones (Búsqueda y Nuevo) */
        .btn-dark-minimal {
            background-color: #1a1c20;
            border: 1px solid #2d3035;
            color: #7b8089;
            border-radius: 8px;
            transition: all 0.3s ease;
        }
        .btn-dark-minimal:hover {
            background-color: #25282e;
            border-color: #555;
            color: #e0e0e0;
        }

        /* Enlaces de Navegación */
        .nav-link-minimal {
            text-decoration: none;
            font-size: 0.9rem;
            letter-spacing: 0.5px;
            padding-bottom: 4px;
            transition: color 0.3s ease;
        }
        /* Estado Inactivo */
        .nav-link-muted { color: #5c6068; }
        .nav-link-muted:hover { color: #9ea3ab; }
        
        /* Estado Activo (Simulando text-primary pero elegante) */
        .nav-link-active {
            color: #e0e0e0;
            font-weight: 500;
            border-bottom: 1px solid #e0e0e0; /* Sutil línea */
        }
    </style>
</head>
<body>
    @yield('titular')

    @yield('contenido')
    
    {{-- Bootstrap local --}}
    <script src="{{ asset('js/bootstrap.bundle.min.js') }}"></script>
    <x-modal-error :mensaje="session('errorMensaje') ?? ''" :activar="session('mostrarModal') ?? false" />
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</body>
</html>
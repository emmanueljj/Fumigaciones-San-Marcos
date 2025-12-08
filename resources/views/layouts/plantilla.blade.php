<!-- filepath: resources/views/layouts/plantilla.blade.php -->
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>@yield('tittle', 'inicio')</title>
    {{-- boostrap local --}}
    <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('estilos/estilos.css') }}">
    {{-- fontawesome local --}}
    <link rel="stylesheet" href="{{ asset('font/css/all.min.css') }}">
</head>
<body>
    @yield('titular')


    @yield('contenido')
    
    {{-- boostrap local --}}
    <script src="{{ asset('js/bootstrap.bundle.min.js') }}"></script>
    <x-modal-error :mensaje="session('errorMensaje') ?? ''" :activar="session('mostrarModal') ?? false" />
</body>
</html>
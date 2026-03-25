<!DOCTYPE html>
<html lang="en" dir="ltr" class="light" data-header-styles="light" data-menu-styles="dark">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Iniciar sesión')</title>

    <link rel="icon" href="{{ asset('img/favicon-logo-el-cumbe.png') }}" type="image/x-icon">

    {{-- ICONS (si tu login usa iconos) --}}
    <link href="{{ asset('build/assets/iconfonts/icons.css') }}" rel="stylesheet">

    {{-- CSS (si tus clases box/form-control vienen del template) --}}
    @vite(['resources/sass/app.scss'])

    {{-- Estilos SOLO por página --}}
    @stack('styles')
</head>

<body class="bg-gray-50">
    @yield('content')

    {{-- JS mínimo: Alpine + utilidades (si lo usas) --}}
    @vite('resources/js/app.js')

    {{-- Scripts SOLO por página --}}
    @stack('scripts')
</body>
</html>

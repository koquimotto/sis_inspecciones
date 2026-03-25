<!DOCTYPE html>
<html lang="en" dir="ltr" data-nav-layout="vertical" data-vertical-style="overlay" class="light" data-header-styles="light" data-menu-styles="light" data-toggled="close">
    

    <head>

        <!-- META DATA -->
		<meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="Author" content="Spruko Technologies Private Limited">
        <meta name="Description" content="Ynex –Laravel Tailwind CSS Responsive Admin Web Dashboard Template">
        <meta name="keywords" content="admin panel in laravel, tailwind, tailwind template admin, laravel admin panel, tailwind css dashboard, admin dashboard template, admin template, tailwind laravel, template dashboard, admin panel tailwind, tailwind css admin template, laravel tailwind template, laravel tailwind, tailwind admin dashboard">
        
        <!-- TITLE -->
		<title> @yield('title', 'EL CUMBE EIRL')</title>

        <!-- FAVICON -->
        <link rel="icon" href="{{asset('img/favicon-logo-el-cumbe.png')}}" type="image/x-icon">

        <!-- ICONS CSS -->
        <link href="{{asset('build/assets/iconfonts/icons.css')}}" rel="stylesheet">
        
        <!-- APP SCSS -->
        @vite(['resources/sass/app.scss'])
        {{-- @vite([
          'resources/sass/app.scss',
          'resources/assets/js/authentication-main.js',
          'resources/js/app.js',
          'resources/assets/js/custom-switcher.js',
        ]) --}}


        <!-- MAIN JS -->
        {{-- <script src="{{asset('build/assets/authentication-main.js')}}"></script> --}}

        @yield('styles')

	</head>

    @yield('error-body')

        @yield('content')

        
        <!-- SCRIPTS -->

        @yield('scripts')

        <!-- END SCRIPTS -->

	</body>
</html>

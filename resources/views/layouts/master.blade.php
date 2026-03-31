<!DOCTYPE html>
<html lang="en" dir="ltr" data-nav-layout="vertical" class="light" data-header-styles="light" data-menu-styles="dark">

    <head>

        <!-- META DATA -->
		<meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="Author" content="LUIS PAREDES">
        <meta name="Description" content="EL CUMBE EIRL">
        <meta name="keywords" content="EL CUMBE EIRL">
        
        <!-- TITLE -->
		<title> @yield('title', 'EL CUMBE EIRL') </title>

        <!-- FAVICON -->
        <link rel="icon" href="{{asset('img/favicon-logo-el-cumbe.png')}}" type="image/x-icon">

        <!-- ICONS CSS -->
        <link href="{{asset('build/assets/iconfonts/icons.css')}}" rel="stylesheet">
        <script src="https://code.iconify.design/iconify-icon/2.1.0/iconify-icon.min.js"></script>
        
        <style>
            /* ✅ Por encima de tu modal (z-[9999]) */
            .swal2-container { z-index: 20000 !important; }
        </style>
        
        <!-- APP SCSS -->
        @vite(['resources/sass/app.scss'])
        

        <script src="{{ asset('highcharts/highcharts.js') }}"></script>
        <script src="{{ asset('highcharts/highcharts-more.js') }}"></script>
    
        {{-- módulos (solo los que uses) --}}
        <script src="{{ asset('highcharts/modules/exporting.js') }}"></script>
        <script src="{{ asset('highcharts/modules/export-data.js') }}"></script>
        <script src="{{ asset('highcharts/modules/accessibility.js') }}"></script>
        
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <script>
          document.addEventListener('livewire:init', () => {
            Livewire.on('swal', (e) => {
              const requireConfirm = !!e.requireConfirm;
              const asToast = !!e.toast;
              Swal.fire({
                icon: e.type ?? 'success',
                title: e.title ?? 'OK',
                text: e.text ?? '',
                toast: asToast,
                position: e.position ?? (asToast ? 'top-end' : 'center'),
                timer: requireConfirm ? undefined : (e.timer ?? 1600),
                showConfirmButton: requireConfirm ? true : !!e.showConfirmButton,
                confirmButtonText: e.confirmText ?? 'Aceptar',
                timerProgressBar: !requireConfirm,
                allowOutsideClick: !requireConfirm,
                allowEscapeKey: !requireConfirm
              });
            });
          });
        </script>


        @include('layouts.components.styles')
        
        @livewireStyles
        
        
        <!-- MAIN JS -->
        <script src="{{asset('build/assets/main.js')}}"></script>

        @yield('styles')

        
	</head>

	<body>

        <!-- SWITCHER -->

        @include('layouts.components.switcher')

        <!-- END SWITCHER -->

        <!-- LOADER -->
		<div id="loader">
			<img src="{{asset('build/assets/images/media/loader.svg')}}" alt="">
		</div>
		<!-- END LOADER -->

        <!-- PAGE -->
		<div class="page">

            <!-- HEADER -->

            @include('layouts.components.header')

            <!-- END HEADER -->

            <!-- SIDEBAR -->

            @include('layouts.components.sidebar')

            <!-- END SIDEBAR -->

            <!-- MAIN-CONTENT -->
            <div class="content">
                <div class="main-content">
            
                    @yield('content')

                </div>
            </div>

            <!-- END MAIN-CONTENT -->

            <!-- SEARCH-MODAL -->

            @include('layouts.components.search-modal')

            <!-- END SEARCH-MODAL -->

            <!-- FOOTER -->
            
            @include('layouts.components.footer')

            <!-- END FOOTER -->

		</div>
        <!-- END PAGE-->

        <!-- SCRIPTS -->

        @include('layouts.components.scripts')

        @yield('scripts')
        
        

        <!-- STICKY JS -->
		<script src="{{asset('build/assets/sticky.js')}}"></script>

        <!-- APP JS -->
		@vite('resources/js/app.js')
        
        @livewireScripts

        <!-- CUSTOM-SWITCHER JS -->
        @vite('resources/assets/js/custom-switcher.js')

        
        <!-- END SCRIPTS -->

	</body>
</html>

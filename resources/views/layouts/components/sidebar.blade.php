
            <aside class="app-sidebar" id="sidebar">

                <!-- Start::main-sidebar-header -->
                <div class="main-sidebar-header">
                    <a href="#" class="header-logo">
                        <img src="{{asset('img/desktop-logo-el-cumbe.png')}}" alt="logo" class="desktop-logo">
                        <img src="{{asset('img/toggle-logo-el-cumbe.png')}}" alt="logo" class="toggle-logo">
                        <img src="{{asset('img/desktop-logo-el-cumbe.png')}}" alt="logo" class="desktop-dark">
                        <img src="{{asset('img/toggle-logo-el-cumbe.png')}}" alt="logo" class="toggle-dark">
                        <img src="{{asset('img/desktop-logo-el-cumbe.png')}}" alt="logo" class="desktop-white">
                        <img src="{{asset('img/toggle-logo-el-cumbe.png')}}" alt="logo" class="toggle-white">
                    </a>
                </div>
                <!-- End::main-sidebar-header -->

                <!-- Start::main-sidebar -->
                <div class="main-sidebar" id="sidebar-scroll">

                    <!-- Start::nav -->
                    <nav class="main-menu-container nav nav-pills flex-column sub-open">
                        <div class="slide-left" id="slide-left"><svg xmlns="http://www.w3.org/2000/svg" fill="#7b8191" width="24"
                                height="24" viewBox="0 0 24 24">
                                <path d="M13.293 6.293 7.586 12l5.707 5.707 1.414-1.414L10.414 12l4.293-4.293z"></path>
                            </svg></div>
                        <ul class="main-menu">
                            <!-- Start::slide -->
                            <li class="slide__category"><span class="category-name">Dashboard</span></li>

                            <li class="slide">
                                <a href="{{ route('dashboard') }}" class="side-menu__item">
                                    <i class="bx bx-home side-menu__icon"></i>
                                    <span class="side-menu__label">Resumen</span>
                                </a>
                            </li>

                            <li class="slide__category"><span class="category-name">Operación</span></li>

                            <li class="slide">
                                <a href="{{ route('inspecciones.index') }}" class="side-menu__item">
                                    <i class="bx bx-task side-menu__icon"></i>
                                    <span class="side-menu__label">Inspecciones</span>
                                </a>
                            </li>
                            <li class="slide">
                                <a href="{{ route('observaciones.index') }}" class="side-menu__item">
                                    <i class="bx bx-error side-menu__icon"></i>
                                    <span class="side-menu__label">Observados</span>
                                </a>
                            </li>
                            <li class="slide">
                                <a href="{{ route('certificados.index') }}" class="side-menu__item">
                                    <i class="bx bx-medal side-menu__icon"></i>
                                    <span class="side-menu__label">Certificados</span>
                                </a>
                            </li>

                            <li class="slide__category"><span class="category-name">Equipos</span></li>

                            <li class="slide">
                                <a href="{{ route('equipos.index') }}" class="side-menu__item">
                                    <i class="bx bx-rocket side-menu__icon"></i>
                                    <span class="side-menu__label">Equipos</span>
                                </a>
                            </li>

                            <li class="slide__category"><span class="category-name">Empresas</span></li>

                            <li class="slide">
                                <a href="{{ route('empresas.index') }}" class="side-menu__item">
                                    <i class="bx bx-directions side-menu__icon"></i>
                                    <span class="side-menu__label">Empresas</span>
                                </a>
                            </li>

                            <li class="slide">
                                <a href="{{ route('servicios.index') }}" class="side-menu__item">
                                    <i class="bx bx-box side-menu__icon"></i>
                                    <span class="side-menu__label">Servicios</span>
                                </a>
                            </li>

                            <li class="slide__category"><span class="category-name">Administración</span></li>

                            <li class="slide has-sub">
                                <a href="javascript:void(0);" class="side-menu__item">
                                    <i class="bx bx-fingerprint side-menu__icon"></i>
                                    <span class="side-menu__label">Control</span>
                                    <i class="fe fe-chevron-right side-menu__angle"></i>
                                </a>
                                <ul class="slide-menu child1">
                                    <li class="slide side-menu__label1">
                                        <a href="javascript:void(0)">Control</a>
                                    </li>
                                    <li class="slide">
                                        <a href="{{ route('usuarios.index') }}" class="side-menu__item">Usuarios y roles</a>
                                    </li>
                                </ul>
                            </li>

                            <li class="slide has-sub">
                                <a href="javascript:void(0);" class="side-menu__item">
                                    <i class="bx bx-layer side-menu__icon"></i>
                                    <span class="side-menu__label">Catálogos</span>
                                    <i class="fe fe-chevron-right side-menu__angle"></i>
                                </a>
                                <ul class="slide-menu child1">
                                    <li class="slide side-menu__label1">
                                        <a href="javascript:void(0)">Catálogos</a>
                                    </li>
                                    <li class="slide">
                                        <a href="{{ route('tipos.index') }}" class="side-menu__item">Tipos</a>
                                    </li>
                                    <li class="slide">
                                        <a href="{{ route('categorias.index') }}" class="side-menu__item">Categorias</a>
                                    </li>
                                    <li class="slide">
                                        <a href="{{ route('marcas.index') }}" class="side-menu__item">Marcas</a>
                                    </li>
                                    <li class="slide">
                                        <a href="{{ route('modelos.index') }}" class="side-menu__item">Modelos</a>
                                    </li>
                                    <li class="slide">
                                        <a href="{{ route('inspecciones.catalogos') }}" class="side-menu__item">Inspección</a>
                                    </li>
                                </ul>
                            </li>
                            <!-- End::slide -->
                        </ul>
                        <div class="slide-right" id="slide-right"><svg xmlns="http://www.w3.org/2000/svg" fill="#7b8191" width="24"
                                height="24" viewBox="0 0 24 24">
                                <path d="M10.707 17.707 16.414 12l-5.707-5.707-1.414 1.414L13.586 12l-4.293 4.293z"></path>
                            </svg>
                        </div>
                    </nav>
                    <!-- End::nav -->

                </div>
                <!-- End::main-sidebar -->

            </aside>

<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Academia cisco local UFPS</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link rel="stylesheet" href="{{ asset('fontawesome-free/css/fontawesome.min.css') }}">

    <!-- Styles -->
  

    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <style>
       
        body {
            overflow-x: hidden;
            margin:0;
            padding:0;  
        }
    </style>
    <script src="{{ asset('js/jquery-3.5.1.min.js') }}"></script>

</head>

<body>
    <div id="app">
        <div class="row">

            <div class="col-12">

                <nav class="navbar navbar-expand-md navbar-dark bg-dark shadow-sm">
                    <div class="container">
                        <a class="navbar-brand"
                            href="{{ Auth::check() ? url('/inicio/' . Auth::user()->id) : url('/') }}">
                            <img src="{{ asset('img/cisco.png') }}" alt="ufps" style="width: 100px" /> Inicio
                        </a>
                        <button class="navbar-toggler" type="button" data-toggle="collapse"
                            data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                            aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                            <span class="navbar-toggler-icon"></span>
                        </button>

                        <div class="collapse navbar-collapse" id="navbarSupportedContent">
                            <!-- Left Side Of Navbar -->

                            <ul class="navbar-nav mr-auto">
                                <li>
                                    <a class="navbar-brand"
                                        href="{{ url('/certificaciones/card') }}">Certificaciones</a>
                                </li>
                                <li>
                                    <a class="navbar-brand" href="{{ url('/cursos/listcursos') }}">Cursos</a>
                                </li>
                                <li>
                                    @if (!Auth::check())
                                        <a class="navbar-brand"
                                            href="{{ url('/preinscripcion/create') }}">Preinscripcion
                                        </a>
                                    @endif
                                </li>
                                <li>
                                    <a class="navbar-brand" href="{{ url('/soporte') }}">Soporte </a>
                                </li>
                                <li>
                                    <a class="navbar-brand" href="{{ url('/nosotros') }}">Nosotros </a>
                                </li>
                            </ul>

                            <!-- Right Side Of Navbar -->
                            <ul class="navbar-nav ml-auto">
                                <!-- Authentication Links -->

                                <li class="nav-item">
                                    <div class="dropdown">
                                        <a class="nav-link dropdown-toggle" href="#" role="button"
                                            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                            CISCO
                                        </a>
                                        <div class="dropdown-menu col" aria-labelledby="dropdownMenuButton">
                                            <a class="dropdown-item" target="_blank"
                                                href="https://www.cisco.com">CISCO</a>
                                            <a class="dropdown-item" target="_blank"
                                                href="https://www.cisco.com/c/es_co/index.html">CISCO COLOMBIA</a>
                                            <a class="dropdown-item" target="_blank"
                                                href="https://www.netacad.com">NetAcad</a>
                                        </div>
                                    </div>
                                </li>

                                @guest
                                    <li class="nav-item">
                                        <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                                    </li>
                                    @if (Route::has('register'))
                                        <li class="nav-item">
                                            <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                                        </li>
                                    @endif
                                @else
                                    <li class="nav-item dropdown">
                                        <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button"
                                            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                            {{ Auth::user()->persona->nombre }}
                                        </a>

                                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                            <a class="dropdown-item" href="{{ url('/inicio/' . Auth::user()->id) }}">
                                                {{ __('Mi espacio') }}
                                            </a>
                                            <a class="dropdown-item" target="_blank" href="http://giret.ufps.edu.co/cisco/descargas/">
                                                {{ __('Descargas') }}
                                            </a>
                                            <a class="dropdown-item" href="{{ route('logout') }}"
                                                onclick="event.preventDefault();
                                                                                                                     document.getElementById('logout-form').submit();">
                                                {{ __('Logout') }}
                                            </a>

                                            <form id="logout-form" action="{{ route('logout') }}" method="POST"
                                                class="d-none">
                                                @csrf
                                            </form>
                                        </div>
                                    </li>

                                @endguest

                                <li class="nav-item">
                                    <a href="https://ww2.ufps.edu.co" target="_blank"> <img
                                            src="{{ asset('img/ufps.png') }}" alt="ufps" /> </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </nav>
            </div>
        </div>
        <main class="py-4">
            @yield('content')
        </main>
    </div>
    </div>

    <body class="d-flex flex-column min-vh-100">
        <div class="wrapper flex-grow-1"></div>
        <footer class="text-light bg-dark">
            <div class="row">
                <div class="col">
                    <ul style="list-style-type: none;">
                        <li class="text-center"> <a class="btn text-light" role="button" href="../contac"> Contacto</a>
                        </li>
                        <li class="text-center"> <a class="btn text-light" role="button" href="#"> Nosotros</a></li>
                        <li class="text-center"> <a class="btn text-light" role="button" href="#"> Eventos</a></li>
                        <li class="text-center"> <a class="btn text-light" role="button" href="../soporte"> Soporte</a>
                        </li>
                    </ul>
                </div>
                <div class="col">
                    <ul style="list-style-type: none;">
                        <li class="text-center">Avenida Gran Colombia No. 12E-96B Colsag. San Jos&eacute; de
                            C&uacute;cuta - Colombia.
                            Tel&eacute;fono (057)(7) 5776655 etx. 277 </li>
                        <li class="text-center">Contacto: <a class="btn text-light" role="button"
                                href="mailto:ciscoal@ufps.edu.co">ciscoal@ufps.edu.co</a></li>
                        <li class="text-center"> <a class="btn text-light" role="button"
                                href='http://ipv6-test.com/validate.php?url=referer' target="_blank"><img
                                    src='http://ipv6-test.com/button-ipv6-big.png' alt='ipv6 ready' title='ipv6 ready'
                                    border='0' /></a></li>
                    </ul>
                </div>
                <div class="col-12">
                    <p class="text-center">Copyright &copy; Todos los derechos reservados Terminos del Servicio UFPS.
                    </p>
                </div>
            </div>
        </footer>
    </body>

    @yield('scripts')
</body>

</html>

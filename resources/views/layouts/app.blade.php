<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name') }}</title>

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">

    <!-- Favicon -->
    <link rel="icon" href="{{ asset('images/favicon.png') }}" type="image/png">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css">
    
</head>
<body>
    <div id="app">

        <?php 
            $data = [
                ['text' => 'Viagens', 'url' => url('/viagens'), 'icon' => 'mdi-contacts'],
                ['heading' => 'Cadastros'],
                ['text' => 'Motoristas', 'url' => url('/cadastros/motoristas'), 'icon' => 'mdi-contacts'],
                ['text' => 'Veículos', 'url' => url('/cadastros/veiculos'), 'icon' => 'mdi-contacts'],
                ['text' => 'Pacientes', 'url' => url('/cadastros/pacientes'), 'icon' => 'mdi-contacts'],
                /*
                [
                    'text' => 'Viagens', 
                    'url' => url('/viagens'), 
                    'icon' => 'mdi-chevron-up',
                    'icon-alt' => 'mdi-chevron-down',
                    'model' => false,
                    'children' => [
                        ['text' => 'Filho'],
                        ['text' => 'Filho2']
                    ]
                ]
                */
            ];

        ?>

        <v-app>
            <navigation :menus="{{ htmlspecialchars(json_encode($data))}}"></navigation>  
            @yield('content')
        </v-app>

        <!--
        <nav class="navbar navbar-default navbar-static-top">
            <div class="container">
                <div class="navbar-header">

                    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#app-navbar-collapse">
                        <span class="sr-only">Toggle Navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>

                    <a class="navbar-brand" href="{{ url('/') }}">
                        {{ config('app.name', 'Laravel') }}
                    </a>
                </div>

                <div class="collapse navbar-collapse" id="app-navbar-collapse">
                    <ul class="nav navbar-nav">
                        &nbsp;
                    </ul>

                    <ul class="nav navbar-nav navbar-right">
                        @if (Auth::guest())
                            <li><a href="{{ route('login') }}">Login</a></li>
                        @else
                            <li><a href="{{ url('/cadastros/motoristas') }}">Motoristas</a></li>
                            <li><a href="{{ url('/cadastros/veiculos') }}">Veículos</a></li>
                            <li><a href="{{ url('/cadastros/pacientes') }}">Pacientes</a></li>
                            <li><a href="{{ url('/viagens') }}">Viagens</a>
                            
                            <li class="dropdown">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                                    {{ Auth::user()->name }} <span class="caret"></span>
                                </a>

                                <ul class="dropdown-menu" role="menu">
                                    <li><a href="{{ route('register') }}">Novo usuário</a></li>
                                    <li>
                                        <a href="{{ route('logout') }}"
                                            onclick="event.preventDefault();
                                                        document.getElementById('logout-form').submit();">
                                            Logout
                                        </a>

                                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                            {{ csrf_field() }}
                                        </form>
                                    </li>
                                </ul>
                            </li>
                        @endif
                    </ul>
                </div>
            </div>
        </nav>
    -->
        
    </div>

    

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>

    <div>
        @if (Session::has('success'))
            <script type="text/javascript">
                toastr.success("{{Session::get('success') }}")
            </script>
        @endif
        @if (Session::has('error'))
            <script type="text/javascript">
                toastr.error("{{Session::get('error') }}")
            </script>
        @endif
    </div>
</body>
</html>

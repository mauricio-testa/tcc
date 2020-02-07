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
                ['text' => 'Dashboard', 'url' => url('/'), 'icon' => 'mdi-monitor-dashboard'],
                ['text' => 'Viagens', 'url' => url('/viagens'), 'icon' => 'mdi-ambulance'],
                ['text' => 'Relatórios', 'url' => url('/'), 'icon' => 'mdi-file-chart'],
                ['heading' => 'Cadastros'],
                ['text' => 'Motoristas', 'url' => url('/cadastros/motoristas'), 'icon' => 'mdi-account-tie'],
                ['text' => 'Veículos', 'url' => url('/cadastros/veiculos'), 'icon' => 'mdi-car'],
                ['text' => 'Pacientes', 'url' => url('/cadastros/pacientes'), 'icon' => 'mdi-account-group'],
                ['heading' => 'Administração'],
                ['text' => 'Novo usuário', 'url' => route('register'), 'icon' => 'mdi-account-plus'],
            ];
        ?>

        <v-app>
            <navigation :menus="{{ htmlspecialchars(json_encode($data))}}" :user="{{ htmlspecialchars(json_encode(['nome' => Auth::user()->name]))}}"></navigation>  
            @yield('content')
        </v-app>

        <!-- logout -->
        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
            {{ csrf_field() }}
        </form>
        
    </div>

    

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
</body>
</html>
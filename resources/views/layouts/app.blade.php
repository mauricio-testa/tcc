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
    <link href="https://cdn.jsdelivr.net/npm/@mdi/font@4.x/css/materialdesignicons.min.css" rel="stylesheet">

    <!-- Favicon -->
    <link rel="icon" href="{{ asset('images/favicon.png') }}" type="image/png">
    
</head>
<body>

    <?php 
        $data = [
            ['text' => 'Dashboard', 'url' => url('/'), 'icon' => 'mdi-monitor-dashboard'],
            ['text' => 'Viagens', 'url' => url('/viagens'), 'icon' => 'mdi-ambulance'],
            ['text' => 'Relatórios', 'url' => url('/'), 'icon' => 'mdi-file-chart'],
            ['heading' => 'Cadastros'],
            ['text' => 'Motoristas', 'url' => url('/cadastros/motoristas'), 'icon' => 'mdi-account-tie'],
            ['text' => 'Veículos', 'url' => url('/cadastros/veiculos'), 'icon' => 'mdi-car'],
            ['text' => 'Pacientes', 'url' => url('/cadastros/pacientes'), 'icon' => 'mdi-account-group'],
            ['heading' => 'Administração', 'level' => -1],
            ['text' => 'Logs', 'url' => url('/'), 'icon' => 'mdi-format-list-bulleted-triangle', 'level' => -1],
            ['text' => 'Unidades', 'url' =>  url('/admin/unidades'), 'icon' => 'mdi-hospital-building', 'level' => -1],
        ];

        // remove menus administrativos se não for admin
        // -1 = adm geral
        // 0 = adm da unidade
        // 1 = normal
        
        if (Auth::user()->level != -1) {
            $data = array_values(array_filter($data, function($item) {
                return empty($item['level']) || $item['level'] != -1;
            }));
        }

        $routes = [
            'api' => [
                'motorista' => url('/api/motoristas'),
                'veiculo'   => url('/api/veiculos'),
                'paciente'  => url('/api/pacientes'),
                'viagem'    => url('/api/viagens'),
                'lista'     => url('/api/lista'),
                'municipio' => url('/api/municipios'),
                'unidade'   => url('/api/unidades'),
                'usuario'   => url('/api/usuarios'),
            ]
        ];
    ?>

    <script>
        window.__routes = <?= json_encode($routes)?>
    </script>

    <div id="app">

        <v-app>
            <navigation :menus="{{ htmlspecialchars(json_encode($data))}}" :user="{{ htmlspecialchars(json_encode(['nome' => Auth::user()->name]))}}"></navigation>
            <v-content>
                <v-container fluid>
                    @yield('content')
                </v-container>
            </v-content>
        </v-app>

        <!-- logout -->
        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
            {{ csrf_field() }}
        </form>
        
    </div>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}"></script>
    
</body>
</html>
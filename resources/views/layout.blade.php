<html>
<head>
    <title>um arquivo</title>
</head>
<body>
    <header>
    <a href="{{ url('/cadastros/motoristas') }}">Motoristas</a>
    <a href="{{ url('/cadastros/veiculos') }}">Veículos</a>
    </header>

    @yield('content')

    <script type="text/javascript" src="{!! asset('js/app.js') !!}"></script>
</body>
</html>
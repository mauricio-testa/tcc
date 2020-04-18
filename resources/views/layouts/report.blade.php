<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>SIMTRAP | Relatório</title>
    <link href="{{ asset('css/report.css') }}" rel="stylesheet">
    <link rel="icon" href="{{ asset('images/favicon.png') }}" type="image/png">
    <link href="https://cdn.jsdelivr.net/npm/@mdi/font@4.x/css/materialdesignicons.min.css" rel="stylesheet">
</head>
<body>
    <div class="wrapper">
        <div class="content">

            @yield('content')

            <footer>
                Gerado em <?php echo  date('d/m/Y', strtotime(date("Y-m-d")))?> a partir do sistema SIMTRAP
            </footer>

            <button onclick="javascrpit:window.print()">
                <i class="mdi mdi-printer-pos"></i>
            </button>

        </div>
    </div>
    
</body>
</html>


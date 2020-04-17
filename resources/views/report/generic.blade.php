<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SIMTRAP | Exportação de lista de viagem</title>
    <link href="{{ asset('css/report.css') }}" rel="stylesheet">
    <link rel="icon" href="{{ asset('images/favicon.png') }}" type="image/png">
    <link href="https://cdn.jsdelivr.net/npm/@mdi/font@4.x/css/materialdesignicons.min.css" rel="stylesheet">
</head>
<body>
    <div class="wrapper">
        <div class="content">

            <div class="header">
                <div>
                    <img src="{{url('/images/unidades/'.$unidade->id.'.png')}}" alt="Logo da Unidade">
                </div>
                <div>
                    <h1>{{ $title }}</h1>
                    <h2>{{ $unidade->descricao }}</h2>
                    <h2>{{ $unidade->nome}} - {{ $unidade->uf}}</h2>
                </div>
                <div>
                <img src="{{url('/images/unidades/'.$unidade->id.'.png')}}" alt="Logo da Unidade">
                </div>
            </div>

            <div class="infos">
                <ul>
                    @foreach ($infos as $info)
                    <li><span>{{ $info['label'] }}: </span>{{ $info['value'] }}</li>
                    @endforeach
                </ul>
            </div>

            <table border="1" width="100%" cellspacing=0 cellpadding=8>
                <thead>
                    @foreach ($headers as $header)
                        <td>{{$header}}</td>
                    @endforeach
                </thead>
                <tbody>
                @foreach ($data as $item)
                    <tr>
                        @foreach ($headers as $key => $header)
                            <td>{{$item[$key]}}</td>
                        @endforeach
                    </tr>
                @endforeach
                </tbody>
            </table>

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


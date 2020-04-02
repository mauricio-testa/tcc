<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link href="{{ asset('css/report.css') }}" rel="stylesheet">
</head>
<body>
    <div class="wrapper">
        <div class="content">
            <div class="header">
                <div>
                    <img src="https://estado.rs.gov.br/upload/recortes/201707/20075647_1210628_GDO.jpg" alt="">
                </div>
                <div>
                    <h1>LISTA DE VIAGEM #{{ $viagem->id }}</h1>
                    <h2>{{ $unidade->descricao }}</h2>
                    <h2>{{ $unidade->nome}}</h2>
                </div>
                <div>
                    <img src="https://estado.rs.gov.br/upload/recortes/201707/20075647_1210628_GDO.jpg" alt="">
                </div>
            </div>

            <div class="infos">
                <ul>
                    <li><span>Data: </span>{{ $viagem->data_formated }}</li>
                    <li><span>Horário de saída: </span>{{ $viagem->hora_saida }}</li>
                    <li><span>Destino: </span>{{ $viagem->municipio_nome }}</li>
                </ul>
                <ul>
                    <li><span>Motorista: </span>{{ $viagem->motorista_nome }}</li>
                    <li><span>Veículo: </span>{{ $viagem->veiculo }}</li>
                    <li><span>Passageiros: </span>{{ sizeof($lista)}} para {{ $viagem->lotacao }} lugares</li>
                </ul>
            </div>


            <table border="1" width="100%" cellspacing=0 cellpadding=8>
                <thead>
                    <th colspan="3">Detalhes do Passageiro</th>
                    <th colspan="3">Detalhes da Consulta</th>
                </thead>
                <thead>
                    <td>Nome</td>
                    <td>RG</td>
                    <td>Telefone</td>
                    <td>Local</td>
                    <td>Horário</td>
                    <td>Médico</td>
                </thead>
                <tbody>
                @foreach ($lista as $passageiro)

                    @if ($passageiro->acompanhante)
                        <tr>
                            <td>{{ $passageiro->nome }}</td>
                            <td>{{ $passageiro->rg }}</td>
                            <td colspan="4" class="acompanhante"><span>{{ $passageiro->acompanhante_desc }}</span></td>
                        </tr>
                    @else
                        <tr>
                            <td>{{ $passageiro->nome }}</td>
                            <td>{{ $passageiro->rg }}</td>
                            <td>{{ $passageiro->telefone }}</td>
                            <td>{{ $passageiro->consulta_local }}</td>
                            <td>{{ $passageiro->consulta_hora }}</td>
                            <td>{{ $passageiro->consulta_medico }}</td>
                        </tr>
                    @endif
                    
                @endforeach
                    
                </tbody>
            </table>

            <div class="observacoes">
                Observações:
                {{ $viagem->observacao }}
            </div>
        </div>
    </div>
    
</body>
</html>


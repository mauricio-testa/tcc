<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
        body {
            background: rgb(82, 86, 89);
        }
        .wrapper {
            width: 210mm;
            height: 297mm;
            margin: 24px auto;
            background: #fff;
            box-shadow: 0px 0px 4px 2px #1a1a1a9e;
        }
        .wrapper .content {
            padding: 15mm;
        }
        @media print {
            .wrapper {
                box-shadow: unset;
                
            }
            .wrapper .content {
                padding: unset;
            }
        }
    </style>
</head>
<body>
    <div class="wrapper">
        <div class="content">
            <br> === DADOS DA UNIDADE ===
            <br>Nome: {{ $unidade->descricao }}
            <br>Municipio: {{ $unidade->nome}}
            <br>
            <br>
            <br> === DADOS DA VIAGEM ===
            <br>ID viagem: {{ $viagem->id }}
            <br>Data: {{ $viagem->data_formated }}
            <br>Hora Saída: {{ $viagem->hora_saida }}
            <br>Destino: {{ $viagem->municipio_nome }}
            <br>Motorista: {{ $viagem->motorista_nome }}
            <br>Lotação: {{ $viagem->lotacao }}
            <br>Veículo: {{ $viagem->veiculo }}
            <br>Criada em: {{ $viagem->created_at }}
            <br>
            <br>

            <table border="1" width="100%" cellpadding="3" cellspacing="0">
                <thead>
                    <td>Nome</td>
                    <td>RG</td>
                    <td>Telefone</td>
                    <td>Local Consulta</td>
                    <td>Hora consulta</td>
                </thead>
                <tbody>
                @foreach ($lista as $passageiro)

                    @if ($passageiro->acompanhante)
                        <tr>
                            <td>{{ $passageiro->nome }}</td>
                            <td>{{ $passageiro->rg }}</td>
                            <td colspan="3">{{ $passageiro->acompanhante_desc }}</td>
                        </tr>
                    @else
                        <tr>
                            <td>{{ $passageiro->nome }}</td>
                            <td>{{ $passageiro->rg }}</td>
                            <td>{{ $passageiro->telefone }}</td>
                            <td>{{ $passageiro->consulta_local }}</td>
                            <td>{{ $passageiro->consulta_hora }}</td>
                        </tr>
                    @endif
                    
                @endforeach
                    
                </tbody>
            </table>
        </div>
    </div>
    
</body>
</html>


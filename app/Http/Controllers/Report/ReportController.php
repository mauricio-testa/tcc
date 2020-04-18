<?php

namespace App\Http\Controllers\Report;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\ViewLista;
use App\Viagem;
use App\Unidade;
use App\Lista;
use App\Paciente;

class ReportController extends Controller
{
    public function lista (Request $request)
    {
        $lista   = ViewLista::where('id_viagem', $request->viagem)->get();
        $viagem  = Viagem::getViagem(null, [['id', '=', $request->viagem]], true);
        $unidade = $this->getUnidadeInfos();

        // adiciona o dia da semana ao report
        $weekDay = ['Domingo', 'Segunda-feira', 'Terça-feira', 'Quarta-feira', 'Quinta-feira', 'Sexta-feira', 'Sabado'];
        $data = date($viagem->data_viagem);
        $weekDayNumber = date('w', strtotime($data));
        $viagem->data_formated = date('d/m/Y', strtotime($data)).", ".$weekDay[$weekDayNumber];

        return view('report.lista', [
            'lista'     => $lista, 
            'viagem'    => $viagem,
            'unidade'   => $unidade
        ]);
    }

    public function viagens () {
        return view('report.generic', [
            'title'     => 'RELATÓRIO DE VIAGENS',
            'unidade'   => $this->getUnidadeInfos(),
            'headers'   => ['Coluna 1', 'Coluna 2'],
            'infos'     => [
                ['label' => 'Data','value' => 'teste 2'],
                ['label' => 'Data 1','value' => 'teste 4']
            ],
            'data'  => [
                ['Valor coluna 1 linha 1', 'valor coluna 2 linha 1'],
                ['Valor coluna 1', 'valor coluna 2'],
            ]
            
        ]);
    }

    public function paciente (Request $request) {
        $query = Lista::select(
                'vw_viagem.id',
                'vw_viagem.veiculo_nome', 
                'vw_viagem.municipio_nome', 
                'vw_viagem.data_formated',
                'lista.consulta_local', 
                'lista.consulta_medico',
                'lista.consulta_hora'
            )
            ->leftJoin('pacientes', 'lista.id_paciente','=','pacientes.id')
            ->leftJoin('vw_viagem', 'vw_viagem.id', '=', 'lista.id_viagem')
            ->where('pacientes.id', $request->paciente)
            ->get();

        $paciente = Paciente::where('id', $request->paciente)->first();

        $title      = 'RELATÓRIO DE VIAGENS POR PACIENTE';
        $unidade    = $this->getUnidadeInfos();
        $headers    = ['#','Data', 'Local', 'Veículo', 'Local da Consulta', 'Médico', 'Hora'];
        $infos      = [];
        $data       = [];

        $infos = [
            ['label' => 'Paciente','value' => $paciente->nome],
            ['label' => 'ID do paciente','value' => $paciente->id],
            ['label' => 'Endereço','value' => $paciente->endereco],
            ['label' => 'RG','value' => $paciente->rg],
            ['label' => 'Telefone','value' => $paciente->telefone],
            ['label' => 'Cartão SUS','value' => $paciente->sus],

        ];

        foreach ($query as $key => $value) {
            array_push($data, [
                $value->id, 
                $value->data_formated, 
                $value->municipio_nome, 
                $value->veiculo_nome,
                $value->consulta_local,
                $value->consulta_medico,
                $value->consulta_hora,
            ]);
        }

        return view('report.generic', [
            'title'     => $title,
            'unidade'   => $unidade,
            'headers'   => $headers,
            'infos'     => $infos,
            'data'      => $data
        ]);
    }

    private function getUnidadeInfos() {
        return Unidade::where('id', Auth::user()->id_unidade)->leftJoin('municipios as m', 'unidades.id_municipio','=', 'm.codigo')->first();
    }
}

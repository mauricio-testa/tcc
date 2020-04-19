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
use App\ViewViagem;
use App\Motorista;
use App\Municipio;
use App\Veiculo;

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

    public function viagens (Request $request) {

        $title      = 'RELATÓRIO DE VIAGENS REALIZADAS';
        $unidade    = $this->getUnidadeInfos();
        $headers    = ['#','Data', 'Destino', 'Veículo', 'Motorista'];
        $infos      = [];
        $data       = [];

        $query = ViewViagem::select();

        $qs = $request->qs;
        $output = null;
        parse_str($qs, $output);

        if (count($output) != 6) {
            die('Número de parâmetros informado está errado');
        }

        $infos = [
            ['label' => 'Desde'     ,'value' => 'O Início'],
            ['label' => 'Até'       ,'value' => 'O Fim'],
            ['label' => 'Veículo'   ,'value' => 'Todos'],
            ['label' => 'Destino'   ,'value' => 'Todos'],
            ['label' => 'Motorista' ,'value' => 'Todos'],
        ];

        if ($output['start'] != 'null') {
            $query->where('data_viagem', '>=', $output['start']);
            $infos[0]['value'] = date('d/m/Y', strtotime(date($output['start'])));
        }
        if ($output['end'] != 'null') {
            $query->where('data_viagem', '<=', $output['end']);
            $infos[1]['value'] = date('d/m/Y', strtotime(date($output['end'])));
        }
        if ($output['veiculo'] != 'null') {
            $query->where('id_veiculo', $output['veiculo']);
            $infos[2]['value'] = Veiculo::where('id', $output['veiculo'])->pluck('descricao')->first();
        }
        if ($output['destino'] != 'null') {
            $query->where('cod_destino', $output['destino']);
            $infos[3]['value'] = Municipio::where('codigo', $output['destino'])->pluck('nome')->first();
        }
        if ($output['motorista'] != 'null') {
            $query->where('id_motorista', $output['motorista']);
            $infos[4]['value'] = Motorista::where('id', $output['motorista'])->pluck('nome')->first();
        }

        $query = $query->orderBy($output['order'])->get();

        foreach ($query as $key => $value) {
            array_push($data, [
                $value->id, 
                $value->data_formated, 
                $value->municipio_nome, 
                $value->veiculo,
                $value->motorista_nome,
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

    public function paciente (Request $request) {

        $title      = 'RELATÓRIO DE VIAGENS POR PACIENTE';
        $unidade    = $this->getUnidadeInfos();
        $headers    = ['#','Data', 'Local', 'Veículo', 'Local da Consulta', 'Observação', 'Hora'];
        $infos      = [];
        $data       = [];

        $query = Lista::select(
                'vw_viagem.id',
                'vw_viagem.veiculo_nome', 
                'vw_viagem.municipio_nome', 
                'vw_viagem.data_formated',
                'lista.consulta_local', 
                'lista.consulta_observacao',
                'lista.consulta_hora'
            )
            ->leftJoin('pacientes', 'lista.id_paciente','=','pacientes.id')
            ->leftJoin('vw_viagem', 'vw_viagem.id', '=', 'lista.id_viagem')
            ->where('pacientes.id', $request->paciente)
            ->get();

        $paciente = Paciente::where('id', $request->paciente)->first();

        $infos = [
            ['label' => 'Paciente'      ,'value' => $paciente->nome],
            ['label' => 'ID paciente'   ,'value' => $paciente->id],
            ['label' => 'Endereço'      ,'value' => $this->sanitize($paciente->endereco)],
            ['label' => 'RG'            ,'value' => $this->sanitize($paciente->rg)],
            ['label' => 'Telefone'      ,'value' => $this->sanitize($paciente->telefone)],
            ['label' => 'Cartão SUS'    ,'value' => $this->sanitize($paciente->sus)],

        ];

        foreach ($query as $key => $value) {
            array_push($data, [
                $value->id, 
                $value->data_formated, 
                $value->municipio_nome, 
                $value->veiculo_nome,
                $value->consulta_local,
                $value->consulta_observacao,
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

    private function getUnidadeInfos () {
        return Unidade::where('id', Auth::user()->id_unidade)
            ->leftJoin('municipios as m', 'unidades.id_municipio','=', 'm.codigo')
            ->first();
    }

    private function sanitize ($text) {
        return $text == '' ? 'Não Informado' : $text;
    }
}

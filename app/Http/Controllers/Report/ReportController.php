<?php

namespace App\Http\Controllers\Report;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\ViewLista;
use App\Viagem;
use App\Unidade;

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

    public function paciente () {
        
    }

    private function getUnidadeInfos() {
        return Unidade::where('id', Auth::user()->id_unidade)->leftJoin('municipios as m', 'unidades.id_municipio','=', 'm.codigo')->first();
    }
}

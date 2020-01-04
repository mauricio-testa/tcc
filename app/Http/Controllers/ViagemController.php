<?php

namespace App\Http\Controllers;

use App\Viagem;
use Illuminate\Support\Facades\DB;

class ViagemController extends Controller
{
    public function index() {
        // @todo alterar para pegar id_unidade do usuário logado
        // @todo criar uma constante para paginação default

        $viagens = DB::table('viagems')
            ->select('viagems.*', 
                'municipios.nome as municipio_nome', 
                'motoristas.nome as motorista_nome', 
                'veiculos.descricao as veiculo_nome', 
                'veiculos.placa as veiculo_placa',
                'municipios.nome as municipio_nome'
            )
            ->leftJoin('municipios', 'viagems.cod_destino', '=', 'municipios.codigo')
            ->leftJoin('unidades', 'viagems.id_unidade', '=', 'unidades.id')
            ->leftJoin('motoristas', 'viagems.id_motorista', '=', 'motoristas.id')
            ->leftJoin('veiculos', 'viagems.id_veiculo', '=', 'veiculos.id')
            ->where('viagems.id_unidade', '=', 1)
            ->paginate(5);
        
        //$viagens = Viagem::where('id_unidade', '=', 1)->paginate(5);
        return view('viagem\index', ['viagens' => $viagens]);
    }
}

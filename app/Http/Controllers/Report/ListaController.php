<?php

namespace App\Http\Controllers\Report;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\ViewLista;
use App\Viagem;
use App\Unidade;

class ListaController extends Controller
{
    public function index(Request $request)
    {
        $lista   = ViewLista::where('id_viagem', $request->viagem)->get();
        $viagem  = Viagem::getViagem(null, [['id', '=', $request->viagem]], true);
        $unidade = Unidade::where('id', $viagem->id_unidade)->leftJoin('municipios as m', 'unidades.id_municipio','=', 'm.codigo')->first();

        return view('report.lista', [
            'lista'     => $lista, 
            'viagem'    => $viagem,
            'unidade'   => $unidade
        ]);
    }
}

<?php

namespace App\Http\Controllers;

use App\Veiculo;

class VeiculoController extends Controller
{
    public function index() {
        // @todo alterar para pegar id_unidade do usuário logado
        // @todo criar uma constante para paginação default

        $veiculos = Veiculo::where('id_unidade', '=', 1)->paginate(5);
        return view('veiculo\index', ['veiculos' => $veiculos]);
    }
}

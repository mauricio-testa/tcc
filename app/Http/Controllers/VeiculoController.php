<?php

namespace App\Http\Controllers;

use App\Veiculo;

class VeiculoController extends Controller
{
    public function index() {
        $veiculos = Veiculo::paginate(5);
        return view('veiculo\index', ['veiculos' => $veiculos]);
    }
}

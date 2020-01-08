<?php

namespace App\Http\Controllers;

use App\Veiculo;
use Illuminate\Support\Facades\Auth;

class VeiculoController extends Controller
{
    public function index() {
        
        $veiculos = Veiculo::where('id_unidade', '=', Auth::user()->id_unidade)
            ->paginate(config('constants.default_pagination_size'));

        return view('veiculo\index', ['veiculos' => $veiculos]);
    }
}

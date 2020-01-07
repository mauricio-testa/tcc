<?php

namespace App\Http\Controllers;

use App\Motorista;
use Illuminate\Http\Request;

class MotoristaController extends Controller
{
    public function index() {
        // @todo alterar para pegar id_unidade do usuário logado
        // @todo criar uma constante para paginação default
        $motoristas = Motorista::where('id_unidade', '=', 1)->paginate(config('constants.default_pagination_size'));
        return view('motorista\index', ['motoristas' => $motoristas]);
    }

    public function toJson() {
        $data = Motorista::all();
        return response()->json($data);
    }
}

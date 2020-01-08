<?php

namespace App\Http\Controllers;

use App\Motorista;
use Illuminate\Support\Facades\Auth;

class MotoristaController extends Controller
{
    public function index() {

        $motoristas = Motorista::where('id_unidade', '=', Auth::user()->id_unidade)
            ->paginate(config('constants.default_pagination_size'));
            
        return view('motorista\index', ['motoristas' => $motoristas]);

    }

    public function toJson() {
        $data = Motorista::all();
        return response()->json($data);
    }
}

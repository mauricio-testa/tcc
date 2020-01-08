<?php

namespace App\Http\Controllers;

use App\Viagem;
use Illuminate\Support\Facades\Auth;

class ViagemController extends Controller
{
    public function index() {

        $viagens = Viagem::getViagemList(Auth::user()->id_unidade);
        return view('viagem\index', ['viagens' => $viagens]);
        
    }
}

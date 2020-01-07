<?php

namespace App\Http\Controllers;

use App\Viagem;
use Illuminate\Support\Facades\DB;

class ViagemController extends Controller
{
    public function index() {
        $viagens = Viagem::getViagemList();
        return view('viagem\index', ['viagens' => $viagens]);
    }
}

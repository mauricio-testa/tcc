<?php

namespace App\Http\Controllers\Report;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\ViewLista;
use App\Viagem;

class ListaController extends Controller
{
    public function index(Request $request)
    {
        $lista  = ViewLista::where('id_viagem', $request->viagem)->get();
        $viagem = [];

        return view('report.lista', [
            'lista' => $lista, 
            'viagem' => $viagem,
        ]);
    }
}

<?php

namespace App\Http\Controllers;

use App\Tarefas; //1 - declara a model
use Illuminate\Http\Request;

class TarefasController extends Controller
{
    public function index() {
        $tarefas = Tarefas::all(); //2 - busca no banco com ELOQUENT
        return view('tarefas', ['tarefas' => $tarefas]); //3 - envia pra view
    }

    public function toJson() {
        $dados = Tarefas::all();
        return response()->json($dados);
    }
}

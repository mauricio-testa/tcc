<?php

namespace App\Http\Controllers;

use App\Paciente;

class PacienteController extends Controller
{
    public function index() {
        // @todo alterar para pegar id_unidade do usuário logado
        // @todo criar uma constante para paginação default

        $pacientes = Paciente::where('id_unidade', '=', 1)->paginate(config('constants.default_pagination_size'));
        return view('paciente\index', ['pacientes' => $pacientes]);
    }
}

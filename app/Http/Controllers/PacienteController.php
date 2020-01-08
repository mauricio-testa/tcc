<?php

namespace App\Http\Controllers;

use App\Paciente;
use Illuminate\Support\Facades\Auth;

class PacienteController extends Controller
{
    public function index() {

        $pacientes = Paciente::where('id_unidade', '=', Auth::user()->id_unidade)
            ->paginate(config('constants.default_pagination_size'));
            
        return view('paciente\index', ['pacientes' => $pacientes]);

    }
}

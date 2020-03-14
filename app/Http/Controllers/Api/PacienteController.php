<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Paciente;
use App\Unidade;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Helpers\ErrorInterpreter;
use Illuminate\Support\Carbon;

class PacienteController extends Controller
{
    public function index(Request $request)
    {
        try {
            $query = Paciente::where('id_unidade', '=', Auth::user()->id_unidade);

            if(!empty($request->input('search')))
            $query->where('nome', 'like', '%'.$request->input('search').'%');

            return $query->paginate(config('constants.default_pagination_size'));

        } catch (\Throwable $th) {
            dd($th);
            return response()->json([
                'error' => ErrorInterpreter::getMessage($th)
            ]);
        }        
    }


    public function store(Request $request)
    {
        try {
            $municipio_unidade = Unidade::where('id', Auth::user()->id_unidade)->first();
            $paciente = $request->all();
            $paciente['id_unidade'] = Auth::user()->id_unidade;
            $paciente['codigo_municipio'] = $municipio_unidade->id_municipio;
            Paciente::create($paciente);
        } catch (\Throwable $th) {
            return response()->json([
                'error' => ErrorInterpreter::getMessage($th, ['23000' => ['1062' => 'Já existe um paciente com este RG!']])
            ]);
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $paciente = Paciente::findOrFail($id);
            $paciente->updated_at = Carbon::now();
            $paciente->update($request->all());
        } catch (\Throwable $th) {
            return response()->json([
                'error' => ErrorInterpreter::getMessage($th, ['23000' => ['1062' => 'Já existe um paciente com este RG!']])
            ]);
        }
    }

    public function destroy($id)
    {
        try {
            $paciente = Paciente::findOrFail($id);
            $paciente->delete();
        } catch (\Throwable $th) {
            return response()->json([
                'error' => ErrorInterpreter::getMessage($th, ['23000' => ['1451' => 'Você não pode deletar este paciente pois existem viagens cadastradas para ele!']])
            ]);
        }
    }
}

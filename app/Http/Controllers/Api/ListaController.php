<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Lista;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Carbon;
use App\Http\Controllers\Helpers\ErrorInterpreter;


class ListaController extends Controller
{

    public function index(Request $request)
    {
        try {
            return Lista::getViagemList($request->viagem);
        } catch (\Throwable $th) {
            return response()->json([
                'error' => ErrorInterpreter::getMessage($th)
            ]);
        }        
    }


    public function store(Request $request)
    {
        try {
            $passageiro = $request->all();
            Lista::create($passageiro);
        } catch (\Throwable $th) {
            return response()->json([
                'error' => ErrorInterpreter::getMessage($th, ['23000' => ['1062' => 'Este passageiro já está nessa lista']])
            ]);
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $data = $request->all();
            unset($data['paciente_nome']);
            $passageiro = Lista::where('id_viagem', $id)->where('id_paciente', $request->id_paciente);
            $passageiro->updated_at = Carbon::now();
            $passageiro->update($data);
        } catch (\Throwable $th) {
            return response()->json([
                'error' => ErrorInterpreter::getMessage($th)
            ]);
        }
    }

    public function destroy(Request $request, $id)
    {
        try {
            Lista::where('id_viagem', $request->viagem)->where('id_paciente', $id)->delete();
        } catch (\Throwable $th) {
            return response()->json([
                'error' => ErrorInterpreter::getMessage($th)
            ]);
        }
    }
}

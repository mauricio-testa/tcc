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
            return Lista::getViagemList(2);
        } catch (\Throwable $th) {
            return response()->json([
                'error' => ErrorInterpreter::getMessage($th)
            ]);
        }        
    }

/*
    public function store(Request $request)
    {
        try {
            $veiculo = $request->all();
            $veiculo['id_unidade'] = Auth::user()->id_unidade;
            Veiculo::create($veiculo);
        } catch (\Throwable $th) {
            return response()->json([
                'error' => ErrorInterpreter::getMessage($th)
            ]);
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $veiculo = Veiculo::findOrFail($id);
            $veiculo->updated_at = Carbon::now();
            $veiculo->update($request->all());
        } catch (\Throwable $th) {
            return response()->json([
                'error' => ErrorInterpreter::getMessage($th, ['23000' => ['1062' => 'Já existe um veículo cadastrado com essa placa!']])
            ]);
        }
    }
*/
    public function destroy($id)
    {
        dd($id);
    }
}

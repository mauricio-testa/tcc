<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Viagem;
use App\Http\Controllers\Helpers\ErrorInterpreter;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Carbon;

class ViagemController extends Controller
{

    public function index()
    {
        try {
            return Viagem::getViagemList(Auth::user()->id_unidade);
        } catch (\Throwable $th) {
            return response()->json([
                'error' => ErrorInterpreter::getMessage($th)
            ]);
        }  
    }

    public function store(Request $request)
    {
        try {
            $viagem = $request->all();
            $viagem['id_unidade'] = Auth::user()->id_unidade;
            $last_id = Viagem::insertGetId($viagem);
            return response()->json(['id' => $last_id]);
        } catch (\Throwable $th) {
            return response()->json([
                'error' => ErrorInterpreter::getMessage($th)
            ]);
        }
    }


    public function update(Request $request, $id)
    {
        try {
            $viagem = Viagem::findOrFail($id);
            $viagem->updated_at = Carbon::now();
            $viagem->update($request->all());
        } catch (\Throwable $th) {
            return response()->json([
                'error' => ErrorInterpreter::getMessage($th)
            ]);
        }
    }

    public function destroy($id)
    {
        try {
            $motorista = Viagem::findOrFail($id);
            $motorista->delete();
        } catch (\Throwable $th) {
            return response()->json([
                'error' => ErrorInterpreter::getMessage($th)
            ]);
        }
    }
}

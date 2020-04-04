<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Motorista;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Carbon;
use App\Http\Controllers\Helpers\ErrorInterpreter;


class MotoristaController extends Controller
{

    public function index(Request $request)
    {
        try {
            
            $query = Motorista::where('id_unidade', '=', Auth::user()->id_unidade);
            $limit = config('constants.default_pagination_size');

            if(!empty($request->search))
            $query->where('nome', 'like', '%'.$request->search.'%');

            if(!empty($request->limit))
            $limit = $request->limit;

            return $query->paginate($limit);

        } catch (\Throwable $th) {
            return response()->json([
                'error' => ErrorInterpreter::getMessage($th)
            ]);
        }        
    }


    public function store(Request $request)
    {
        try {
            $motorista = $request->all();
            $motorista['id_unidade'] = Auth::user()->id_unidade;
            Motorista::create($motorista);
        } catch (\Throwable $th) {
            return response()->json([
                'error' => ErrorInterpreter::getMessage($th)
            ]);
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $motorista = Motorista::findOrFail($id);
            $motorista->updated_at = Carbon::now();
            $motorista->update($request->all());
        } catch (\Throwable $th) {
            return response()->json([
                'error' => ErrorInterpreter::getMessage($th)
            ]);
        }
    }

    public function destroy($id)
    {
        try {
            $motorista = Motorista::findOrFail($id);
            $motorista->delete();
        } catch (\Throwable $th) {
            return response()->json([
                'error' => ErrorInterpreter::getMessage($th, ['23000' => ['1451' => 'Você não pode deletar este motorista pois existem viagens cadastradas para ele']])
            ]);
        }
    }
}

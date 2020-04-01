<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Helpers\ErrorInterpreter;
use App\Municipio;

class MunicipioController extends Controller
{

    public function index()
    {
        try {
            return Municipio::where('uf', '=', 'RS')->paginate(500);
            
            // 500 é o número máximo de município que os 3 estados do sul tem
            // Se o sistema for pra fora do RS, basta alterar RS pela UF da unidade

        } catch (\Throwable $th) {
            return response()->json([
                'error' => ErrorInterpreter::getMessage($th)
            ]);
        }    
    }
}

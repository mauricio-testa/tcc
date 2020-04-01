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
            return Municipio::paginate(1000);
        } catch (\Throwable $th) {
            return response()->json([
                'error' => ErrorInterpreter::getMessage($th)
            ]);
        }    
    }
}

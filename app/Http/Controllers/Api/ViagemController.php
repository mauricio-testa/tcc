<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Viagem;
use App\Http\Controllers\Helpers\ErrorInterpreter;
use Illuminate\Support\Facades\Auth;

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

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        //
    }

    public function show($id)
    {
        //
    }

    public function update(Request $request, $id)
    {
        //
    }

    public function destroy($id)
    {
        //
    }
}

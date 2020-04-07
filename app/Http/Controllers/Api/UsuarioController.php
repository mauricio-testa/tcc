<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use App\Http\Controllers\Helpers\ErrorInterpreter;
use Illuminate\Support\Facades\Auth;


class UsuarioController extends Controller
{

    public function index(Request $request)
    {
        try {
            return User::where('id_unidade', $request->unidade)->get();
        } catch (\Throwable $th) {
            return response()->json([
                'error' => ErrorInterpreter::getMessage($th)
            ]);
        }        
    }


    public function store(Request $request)
    {
        try {
            $usuario = $request->all();
            $usuario['password'] = bcrypt($usuario['password']);
            User::create($usuario);
        } catch (\Throwable $th) {
            return response()->json([
                'error' => ErrorInterpreter::getMessage($th)
            ]);
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $unidade = User::findOrFail($id);
            $unidade->update($request->all());
        } catch (\Throwable $th) {
            return response()->json([
                'error' => ErrorInterpreter::getMessage($th)
            ]);
        }
    }

    public function destroy($id)
    {
        try {
            if ($id == Auth::user()->id_unidade){
                throw new \Exception("Você não pode se deletar né");
            }
            $unidade = User::findOrFail($id);
            $unidade->delete();
        } catch (\Throwable $th) {
            return response()->json([
                'error' => ErrorInterpreter::getMessage($th)
            ]);
        }
    }
}

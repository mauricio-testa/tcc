<?php

namespace App\Http\Controllers;

use App\Motorista;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class MotoristaController extends Controller
{
    public function index() {

        $motoristas = Motorista::where('id_unidade', '=', Auth::user()->id_unidade)
            ->get();
            
        return view('motorista\index', ['motoristas' => $motoristas]);

    }

    public function delete(Request $request) {

        $motorista  = Motorista::find($request['id']);
        
        try {
            $motorista->delete();
            $status     = 'success';
            $message    = $motorista->nome. ' deletado com sucesso!';

        } catch (\Throwable $th) {
            $status     = 'error';
            $message    = 'Erro ao deletar motorista: '.$th->getMessage();
        }

        return redirect()->back()->with($status, $message);

    }

    public function edit() {
        dd('edit');
    }

    public function toJson() {
        $data = Motorista::all();
        return response()->json($data);
    }
}

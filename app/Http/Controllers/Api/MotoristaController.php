<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Motorista;

class MotoristaController extends Controller
{

    public function index()
    {
        return Motorista::all();
    }

    public function store(Request $request)
    {
        try {
            $motorista = $request->all();
            $motorista['id_unidade'] = '1';
            Motorista::create($motorista);
        } catch (\Throwable $th) {
            return response()->json([
                'error' => $th->getMessage()
            ]);
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $motorista = Motorista::findOrFail($id);
            $motorista->update($request->all());
        } catch (\Throwable $th) {
            return response()->json([
                'error' => $th->getMessage()
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
                'error' => $th->getMessage()
            ]);
        }
    }
}

<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Motorista;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Carbon;


class MotoristaController extends Controller
{

    public function index()
    {
        return Motorista::where('id_unidade', Auth::user()->id_unidade)->get();
    }

    public function store(Request $request)
    {
        try {
            $motorista = $request->all();
            $motorista['id_unidade'] = Auth::user()->id_unidade;
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
            $motorista->updated_at = Carbon::now();
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

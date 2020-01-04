<?php

namespace App\Http\Controllers;

use App\Motorista;
use Illuminate\Http\Request;

class MotoristaController extends Controller
{
    public function index() {
        $motoristas = Motorista::paginate(5);
        return view('motorista\index', ['motoristas' => $motoristas]);
    }

    public function toJson() {
        $data = Motorista::all();
        return response()->json($data);
    }
}

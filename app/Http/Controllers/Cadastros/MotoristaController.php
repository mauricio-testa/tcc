<?php

namespace App\Http\Controllers;

use App\Motorista;

class MotoristaController extends Controller
{
    public function index() {
        $motoristas = Motorista::paginate(5);
        return view('motorista\index', ['motoristas' => $motoristas]);
    }
}

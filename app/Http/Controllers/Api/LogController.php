<?php

namespace App\Http\Controllers\Api;

use App\Log;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class LogController extends Controller
{
    public function index(Request $request)
    {
        $query = Log::whereNotNull('id');

        //if(!empty($request->search))
        //$query->where('descricao', 'like', '%'.$request->search.'%');

        return $query->paginate(config('constants.PAGINATION_SIZE'));
    }
}

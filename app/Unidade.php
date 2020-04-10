<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Unidade extends Model
{
    protected $fillable = [
        'descricao', 'id_municipio', 'status', 'avatar'
    ];

    public static function UnidadeIsActiveByUserEmail($email) {
        
        $select = DB::table('unidades')
            ->select('unidades.status')
            ->join('users', 'users.id_unidade', '=','unidades.id')
            ->where('users.email', $email)
            ->first();

        return $select->status;
    }
}

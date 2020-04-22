<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Motorista extends Model
{
    public $timestamps = false;
    
    protected $fillable = [
        'nome', 'telefone', 'id_unidade', 'access_key',
    ];
}

<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Motorista extends Model
{
    protected $fillable = [
        'nome', 'telefone', 'id_unidade',
    ];
}

<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Paciente extends Model
{
    public $timestamps = false;
    
    protected $fillable = [
        'rg', 'nome', 'telefone', 'endereco', 'id_unidade', 'codigo_municipio', 'sus', 'status'
    ];
}

<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Veiculo extends Model
{
    public $timestamps = false;
    
    protected $fillable = [
        'descricao', 'placa', 'id_unidade', 'lotacao', 'tipo', 'ano_modelo', 'marca_modelo'
    ];
}

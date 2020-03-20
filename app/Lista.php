<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Lista extends Model
{
    protected $fillable = [
        'id_paciente', 'acompanhante_rg', 'acompanhante_nome', 'consulta_local', 'consulta_medico'
    ];
}

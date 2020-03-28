<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Lista extends Model
{
    protected $table = 'lista';
    protected $fillable = [
        'id_paciente', 'acompanhante_rg', 'acompanhante_nome', 'consulta_local', 'consulta_medico'
    ];

    public static function getViagemList($id_viagem) {
        return self::select ('lista.*', 'pa.nome as paciente_nome')
            ->leftJoin('pacientes as pa', 'pa.id', '=','lista.id_paciente')            
            ->where('lista.id_viagem', '=', $id_viagem)
            ->get();
    }
}

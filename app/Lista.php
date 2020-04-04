<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\ViewLista;

class Lista extends Model
{
    protected $table = 'lista';

    protected $fillable = [
        'id_paciente','id_viagem', 'acompanhante_rg', 'acompanhante_nome', 'consulta_local', 'consulta_medico', 'consulta_hora'
    ];

    public static function getViagemList($id_viagem) {
        return self::select ('lista.*', 'pa.nome as paciente_nome')
            ->leftJoin('pacientes as pa', 'pa.id', '=','lista.id_paciente')            
            ->where('lista.id_viagem', $id_viagem)
            ->get();
    }
}

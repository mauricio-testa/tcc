<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\ViewViagem;

class Viagem extends Model
{
    protected $table = 'viagens';

    protected $fillable = [
        'id_veiculo', 'id_motorista', 'cod_destino', 'data_viagem', 'hora_saida', 'observacao', 'id_unidade'
    ];

    protected $casts = [
        'data_viagem' => 'datetime:d-m-Y',
    ];

    public static function getViagem ($id_unidade = null, $wheres = [], $onlyFirst = false) {

        // initialize query
        $query = ViewViagem::whereNotNull('id');

        // parametro id unidade
        if (!is_null($id_unidade)) {
            $query->where('id_unidade', $id_unidade);
        }

        // query dinamica and
        foreach ($wheres as $where) {
            $query->where($where[0], $where[1], $where[2]);
        }

        // retorna objeto ou array
        if ($onlyFirst) {
            return $query->first();
        } else {
            return $query->paginate(config('constants.default_pagination_size'));
        }
    }
}

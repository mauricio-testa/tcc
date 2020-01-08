<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Viagem extends Model
{
    public static function getViagemList($id_unidade) {
        return self::select('viagems.*', 
                'mu.nome        as municipio_nome', 
                'mo.nome        as motorista_nome', 
                've.descricao   as veiculo_nome', 
                've.placa       as veiculo_placa',
                'mu.nome        as municipio_nome'
            )
            ->leftJoin('municipios as mu'   , 'viagems.cod_destino',    '=', 'mu.codigo')
            ->leftJoin('unidades as un'     , 'viagems.id_unidade',     '=', 'un.id')
            ->leftJoin('motoristas as mo'   , 'viagems.id_motorista',   '=', 'mo.id')
            ->leftJoin('veiculos as ve'     , 'viagems.id_veiculo',     '=', 've.id')
            
            ->where('viagems.id_unidade'    , '=', $id_unidade)
            ->paginate(config('constants.default_pagination_size'));
    }
}

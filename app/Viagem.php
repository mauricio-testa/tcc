<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Viagem extends Model
{
    protected $table = 'viagens';

    protected $fillable = [
        'id_veiculo', 'id_motorista', 'cod_destino', 'data_viagem', 'hora_saida', 'observacoes', 'id_unidade'
    ];

    protected $casts = [
        'data_viagem' => 'datetime:d-m-Y',
    ];

    public static function getViagemList($id_unidade) {
        return self::select('viagens.*', 
                'mu.nome as municipio_nome', 
                'mo.nome as motorista_nome', 
                DB::raw("DATE_FORMAT(viagens.data_viagem,'%d/%m/%Y')    as data_formated"),
                DB::raw("CONCAT(ve.descricao,' (',ve.placa,')')         as veiculo")
            )
            ->leftJoin('municipios as mu'   , 'viagens.cod_destino',    '=', 'mu.codigo')
            ->leftJoin('unidades as un'     , 'viagens.id_unidade',     '=', 'un.id')
            ->leftJoin('motoristas as mo'   , 'viagens.id_motorista',   '=', 'mo.id')
            ->leftJoin('veiculos as ve'     , 'viagens.id_veiculo',     '=', 've.id')
            
            ->where('viagens.id_unidade'    , '=', $id_unidade)
            ->orderBy('viagens.id', 'desc')
            ->paginate(config('constants.default_pagination_size'));
    }
}

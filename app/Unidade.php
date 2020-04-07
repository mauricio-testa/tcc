<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Unidade extends Model
{
    protected $fillable = [
        'descricao', 'id_municipio', 'status', 'avatar'
    ];
}

<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Fuga extends Model
{
    protected $table = 'fugas';
    protected $fillable = ['id', 'tipo', 'descricaofuga', 'datafuga', 'datarecaptura'
        , 'descricaorecaptura', 'user_id', 'apenado_id', 'processo_id', 'movimentacao_id'
    ];
}

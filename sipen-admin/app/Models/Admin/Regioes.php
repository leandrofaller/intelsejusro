<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Model;

class Regioes extends Model
{
    protected $table = 'producao_regioes';
    protected $fillable = ['id', 'nomeregiao', 'status'];

    //MOSTRA NOME UNIDADE
    public static function nomeRegiao($id)
    {
        $mostra = Regioes::find($id);
        if(empty($mostra->nomeregiao))
        {
            return '';
        }else{
            return $mostra->nomeregiao;
        }
    }
}

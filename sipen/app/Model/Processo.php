<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use App\Model\Apenado;

class Processo extends Model
{
    protected $table = 'processos';
    protected $fillable = [
        'id',
        'numeroprocesso',
        'vara',
        'tipificacao',
        'artigos',
        'datacondenacao',
        'tempodepena',
        'dataprisao',
        'principal',
        'databeneficio',
        'apenado_id'
    ];

   

    public function apenado()
    { 
         return $this->hasMany('App\Model\Apenado', 'apenado_id', 'id');
    }



}

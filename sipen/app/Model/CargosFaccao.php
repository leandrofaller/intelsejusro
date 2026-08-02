<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class CargosFaccao extends Model
{
    protected $table = 'cargos_faccoes';
    protected $fillable = ['id', 'nomecargo', 'descricao', 'nivel', 'faccao_id'];

    public function faccoes()
    {
        return $this->belongsTo('App\Model\Faccao', 'faccao_id', 'id');
    }


    //AUXILIARES
    public static $niveis = [
        'Nivel 1' => 'Nivel 1',
        'Nivel 2' => 'Nivel 2',
        'Nivel 3' => 'Nivel 3',
        'Nivel 4' => 'Nivel 4',
    ];

}

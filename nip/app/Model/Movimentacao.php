<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Movimentacao extends Model
{
    protected $table = 'movimentacoes';
    protected $fillable = [
        'id',
        'regime',
        'dataentrada',
        'oficioentrada',
        'presooriundo',
        'situacao',
        'monitorado',
        'datasaida',
        'oficiosaida',
        'motivosaida',
        'unidadedestino',
        'unidadeorigem',
        'classificacao_id',
        'processo_id',
        'unidade_id',
        'cela_id',
        'triagem_baixa',
        'triagem_inicio',
        'triagem_fim',
    ];

    public function processos()
    {
        return $this->belongsTo('App\Model\Processo', 'processo_id', 'id');
    }
    public function unidades()
    {
        return $this->belongsTo('App\Model\Unidade', 'unidade_id', 'id');
    }
    public function celas()
    {
        return $this->belongsTo('App\Model\Cela', 'cela_id', 'id');
    }


}

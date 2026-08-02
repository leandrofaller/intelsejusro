<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Pad extends Model
{
    protected $table = 'pad';
    protected $fillable = [
        'id',
        'numeropad',
        'descricaopad',
        'datainiciopad',
        'dataconclusaopad',
        'situacaopad',
        'tipofato',
        'tipofalta',
        'numerorelatorioseguranca',
        'apenado_id',
        'processo_id',
        'movimentacao_id',
        'user_id',
        'unidade_id',
    ];



    public function apenado()
    {
        return $this->hasMany('App\Model\Apenado', 'apenado_id', 'id');
    }



    //AUXILIARES
    public static $situacao = [
        '' => '',
        'Condenado' => 'Condenado',
        'Absolvido' => 'Absolvido',
        'Cancelado' => 'Cancelado',
    ];

    //AUXILIARES
    public static $fato = [
        '' => '',
        'Drogas' => 'Drogas',
        'Brigas' => 'Brigas',
        'Celular' => 'Celular',
        'Desobediência' => 'Desobediência',
        'Outros' => 'Outros'
    ];

    //AUXILIARES
    public static $tipofalta = [
        '' => '',
        'Leve' => 'Leve',
        'Média' => 'Média',
        'Grave' => 'Grave'
    ];


}

<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use DB;
class Temporaria extends Model
{
    protected $table = 'temporarias';
    protected $fillable = [
        'id',
        'tipo',
        'motivo',
        'descricao',
        'datasaida',
        'dataretorno',
        'descricaoretorno',
        'motivo',
        'documento',
        'escolta',
        'horasaida',
        'horaretorno',
        'apenado_id',
        'processo_id',
        'movimentacao_id',
        'unidade_id',
        'user_id'
    ];


    //AUXILIARES
    public static $tipo = [
        '' => '',
        '1' => 'PERMISSÃO DE SAÍDA',
        '2' => 'SAÍDA TEMPORÁRIA',
    ];

    public static $escolta = [
        'NÃO' => 'NÃO',
        'SEJUS' => 'SEJUS',
        'POLÍCIA MILITAR' => 'POLÍCIA MILITAR',
        'POLÍCIA CIVIL' => 'POLÍCIA CIVIL',
        'POLÍCIA FEDERAL' => 'POLÍCIA FEDERAL',
    ];



    public function apenados()
    {
        return $this->belongsTo('App\Model\Apenado', 'apenado_id', 'id');
    }

    public function movimentacoes()
    {
        return $this->belongsTo('App\Model\Movimentacao', 'movimentacao_id', 'id');
    }

    public function celas()
    {
        return $this->belongsTo('App\Model\Cela', 'cela_id', 'id');
    }

    public function unidades()
    {
        return $this->belongsTo('App\Model\Unidade', 'unidade_id', 'id');
    }


    //MOSTRA TEMPORÁRIAS NA LISTAGEM GERAL
    public static function mostraTemporaria($idApen)
    {
         $result = DB::table('temporarias as t')
            ->Where('t.dataretorno', NULL)
            ->Where('t.apenado_id', $idApen)
            ->select('t.motivo')
            ->first();

        if (empty($result))
            return '';
        else {
            return $result->motivo;

        }
    }


    //VERIFICA SE O APENADO POSSUI ALGUMA TEMPORÁRIA REGISTRADA
    public static function verificaTemporaria($idApen)
    {
        $result = DB::table('temporarias as t')
            ->Where('t.dataretorno', NULL)
            ->Where('t.apenado_id', $idApen)
            ->get();
        if (count($result) > 0){
            return 't';
        }else{
            return '';
        }
    }


}

<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use DB;
class Regioes extends Model
{
    protected $table = 'producao_regioes';
    protected $fillable = ['id', 'nomeregiao', 'status'];

    //CONTA QUANTIDADE DE CELAS NA UNIDADE
    public static function contaQtdUnidades($id)
    {
        return $conta = DB::table('unidades as a')
            ->Where('regiao_id', $id)
            ->select(DB::raw("COUNT(regiao_id) as total"))
            ->pluck('total')[0];
    }


    public static function UnidadesRegiao($id)
    {
        return $conta = DB::table('unidades as a')
            ->Where('regiao_id', $id)
            ->select('nomeunidade')
            ->get();
    }


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
